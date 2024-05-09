const checkoutProduct = async (data) => {
  const payload = JSON.stringify(data);
  console.log(data);
  return fetch("http://api.test:80/checkout", {
    method: "POST",
    body: payload,
  })
    .then((response) => response.json())
    .then((res) => window.location.replace(res.url));
};
