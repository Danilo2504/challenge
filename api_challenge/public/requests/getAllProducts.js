const getAllProducts = async () => {
  return fetch("http://localhost:80/challenge/api_challenge/products").then(
    (response) => response.json()
  );
};
