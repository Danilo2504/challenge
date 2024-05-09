<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once  __DIR__ . "/../models/payment.php";

class StripeController
{
  private $stripeClient;
  private $endpoint_secret;
  private $stripeSetKey;

  public function __construct()
  {
    $this->stripeClient = new \Stripe\StripeClient('sk_test_51PDpB92NDGTflUbUo2GtlYf7DT96gZWFLedlycX88ip1msXg0Z6wzKBOVC060MzfOTF6UcdsRic1dxINIFlq1kvZ003BVyTsHw');

    $this->endpoint_secret = 'whsec_eecab87728070c395bd9bfa3155f6eae1da76c606d907f64b639a988391f472d';

    $this->stripeSetKey = \Stripe\Stripe::setApiKey('sk_test_51PDpB92NDGTflUbUo2GtlYf7DT96gZWFLedlycX88ip1msXg0Z6wzKBOVC060MzfOTF6UcdsRic1dxINIFlq1kvZ003BVyTsHw');
  }
  public function webhook()
  {
    $this->stripeClient;
    $payload = file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $this->endpoint_secret
      );
    } catch (\UnexpectedValueException $e) {
      http_response_code(400);
      echo json_encode('Unexpected Value Exception');
      exit();
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      http_response_code(400);
      echo json_encode('Signature Verification Exception');
      exit();
    }

    function handlePaymentSucceeded($paymentIntent)
    {
      $paymentData = [
        "id" => $paymentIntent->id,
        "buy_date" => date('y-m-d'),
        "payment_method" => $paymentIntent->payment_method,
        "amount" => intval($paymentIntent->amount_received / 100),
        "payment_status" => $paymentIntent->status
      ];

      $model = new ModelsPayment();
      $model->createPayment($paymentData);
    };

    if ($event->type === 'payment_intent.succeeded') {
      $paymentIntent = $event->data->object;
      handlePaymentSucceeded($paymentIntent);
    } else {
      http_response_code(400);
      echo json_encode('Received unknown event type ' . $event->type);
    }

    http_response_code(200);
    echo json_encode(true);
  }

  public function checkout()
  {
    $this->stripeSetKey;
    $product = json_decode(file_get_contents('php://input'), true);

    $name = $product['name'];
    $quantity = $product['quantity'];
    $price = intval($product['price']) * 100;

    $YOUR_DOMAIN = 'http://api.test:80';

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
