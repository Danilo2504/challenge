<?php

require __DIR__ . '/../../vendor/autoload.php';
require_once  __DIR__ . "/../models/checkout.php";

class StripeController
{
  private $api_key;
  private $endpoint_secret;

  public function __construct()
  {
    $this->api_key = $_ENV['STRIPE_API_KEY_TEST'];
    $this->endpoint_secret = $_ENV['STRIPE_ENDPOINT_SECRET'];
  }
  public function webhook()
  {
    \Stripe\Stripe::setApiKey($this->api_key);
    $payload = @file_get_contents('php://input');
    $event = null;
    try {
      $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
      );
    } catch (\UnexpectedValueException $e) {
      echo '⚠️  Webhook error while parsing basic request.';
      http_response_code(400);
      exit();
    }

    if ($this->endpoint_secret) {
      $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
      try {
        $event = \Stripe\Webhook::constructEvent(
          $payload,
          $sig_header,
          $this->endpoint_secret
        );
      } catch (\Stripe\Exception\SignatureVerificationException $e) {
        echo '⚠️  Webhook error while validating signature.';
        http_response_code(400);
        exit();
      }
    }

    function createOrder($session)
    {
      $checkout_data = [
        "id" => $session->id,
        "name" => $session->customer_details->name,
        "email" => $session->customer_details->email,
        "phone" => $session->customer_details->phone,
        "payment_status" => $session->payment_status,
        "payment_intent" => $session->payment_intent,
        "amount_total" => intval($session->amount_total / 100),
        "date" => date('y-m-d')
      ];

      $model = new ModelsCheckout();
      $model->createCheckout($checkout_data);
    }

    switch ($event->type) {
      case 'checkout.session.completed':
        $session = $event->data->object;
        createOrder($session);
        break;
      default:
        error_log('Received unknown event type ' . $event->type);
    }

    http_response_code(200);
  }

  public function checkout()
  {
    \Stripe\Stripe::setApiKey($this->api_key);
    $product = json_decode(file_get_contents('php://input'), true);

    $name = $product['name'];
    $quantity = $product['quantity'];
    $price = intval($product['price']) * 100;

    $YOUR_DOMAIN = $_ENV['API_URL'];

    $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        'quantity' => $quantity,
        'price_data' => [
          'currency' => 'eur',
          'unit_amount' => $price,
          'product_data' => [
            'name' => $name,
          ]
        ]
      ]],
      'mode' => 'payment',
      'success_url' => $YOUR_DOMAIN . '/public/success.html',
      'cancel_url' => $YOUR_DOMAIN . '/public/cancel.html',
    ]);

    http_response_code(200);
    echo json_encode($checkout_session);
  }
}
