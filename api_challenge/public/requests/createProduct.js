const createProduct = async (data) => {
  const payload = JSON.stringify(data);
  return fetch("http://localhost:80/challenge/api_challenge/product", {
    method: "POST",
    body: payload,
  }).then((response) => response.json());
};
