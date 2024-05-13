const checkoutProduct = async (data) => {
  const payload = JSON.stringify(data);
  return fetch("http://localhost:80/challenge/api_challenge/checkout", {
    method: "POST",
    body: payload,
  })
    .then((response) => response.json())
    .then((res) => window.location.replace(res.url));
};
