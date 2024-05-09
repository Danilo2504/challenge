const createProduct = async (data) => {
  const payload = JSON.stringify(data);
  return fetch("http://api.test:80/product", {
    method: "POST",
    body: payload,
  }).then((response) => response.json());
};
