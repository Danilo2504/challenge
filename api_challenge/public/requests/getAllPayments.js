const getAllPayments = async () => {
  return fetch("http://api.test:80/payments").then((response) =>
    response.json()
  );
};
