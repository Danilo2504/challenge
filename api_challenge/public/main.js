window.onload = getAllProducts().then((data) => cardProduct(data));
window.onload = getAllCheckouts().then((data) => cardCheckout(data));

const cardProduct = (products) => {
  const response = document.getElementById("response");
  response.innerHTML = "";
  products.map((product) => {
    const cardWrapper = document.createElement("div");
    const cardName = document.createElement("p");
    const cardPrice = document.createElement("p");
    const cardStock = document.createElement("p");
    const cardButton = document.createElement("button");
    const cardInput = document.createElement("input");
    const buttonContainer = document.createElement("div");

    cardInput.type = "number";
    cardInput.min = 1;
    cardInput.max = product.stock;
    cardInput.value = 1;

    cardWrapper.className = "card-wrapper";
    cardButton.addEventListener("click", () =>
      handleBuy({ ...product, quantity: cardInput.value })
    );

    cardName.textContent = `Nome: ${product.name}`;
    cardPrice.textContent = `Prezio: € ${product.price}`;
    cardStock.textContent = `Stock: ${product.stock}`;
    cardButton.textContent = "COMPRA";

    buttonContainer.appendChild(cardButton);
    buttonContainer.appendChild(cardInput);
    buttonContainer.className = "btn-container";

    cardWrapper.appendChild(cardName);
    cardWrapper.appendChild(cardPrice);
    cardWrapper.appendChild(cardStock);
    cardWrapper.appendChild(buttonContainer);

    response.appendChild(cardWrapper);
  });
};

const cardCheckout = (checkouts) => {
  const checkoutsResponse = document.getElementById("checkouts");
  checkoutsResponse.innerHTML = "";
  checkouts.map((checkout) => {
    const cardContainer = document.createElement("div");
    const cardName = document.createElement("p");
    const cardEmail = document.createElement("p");
    const cardPhone = document.createElement("p");
    const cardStatus = document.createElement("p");
    const cardDate = document.createElement("p");
    const cardAmount = document.createElement("p");

    cardContainer.className = "payment-card";

    cardName.textContent = `Customer Name: ${checkout.name}`;
    cardEmail.textContent = `Customer Email: ${checkout.email}`;
    cardPhone.textContent = `Customer Phone: ${checkout.phone}`;
    cardStatus.textContent = `Payment Status: ${checkout.payment_status}`;
    cardAmount.textContent = `Amount: € ${checkout.amount}`;
    cardDate.textContent = `Buy Date: ${checkout.date}`;

    cardContainer.appendChild(cardName);
    cardContainer.appendChild(cardEmail);
    cardContainer.appendChild(cardPhone);
    cardContainer.appendChild(cardStatus);
    cardContainer.appendChild(cardAmount);
    cardContainer.appendChild(cardDate);

    checkoutsResponse.appendChild(cardContainer);
  });
};

const setMessage = (text, interval = 3000) => {
  const msg = document.getElementById("message");
  msg.innerText = text;
  msg.className = "animation-fade";
  setTimeout(() => {
    msg.className = "animation-fade-out";
    setTimeout(() => {
      msg.innerText = "";
    }, 1000);
  }, interval);
};

const handleBuy = (data) => {
  const body = {
    id: data.id,
    quantity: data.quantity,
    name: data.name,
    price: data.price,
  };
  checkoutProduct(body);
};

const handleSubmit = (event) => {
  event.preventDefault();
  const name = document.getElementById("name");
  const price = document.getElementById("price");
  const stock = document.getElementById("stock");

  const priceNumber = parseInt(price.value, 10);

  if (!name.value || isNaN(priceNumber) || priceNumber <= 0 || !stock.value) {
    setMessage(
      "Completa i valori o inserisci un prezzo valido maggiore di zero"
    );
  } else {
    const payload = {
      name: name.value,
      price: price.value,
      stock: stock.value,
    };
    createProduct(payload).then((data) => {
      if (data) {
        getAllProducts().then((data) => cardProduct(data));
        name.value = "";
        price.value = "";
        stock.value = "";
      } else {
        setMessage("Qualcosa non va bene");
      }
    });
  }
};

const formValues = document.getElementById("form");

formValues.addEventListener("submit", (event) => handleSubmit(event));
