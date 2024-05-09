const getAllProducts = async () => {
  return fetch("http://api.test:80/products").then((response) =>
    response.json()
  );
};
