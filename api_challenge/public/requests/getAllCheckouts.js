const getAllCheckouts = async () => {
  return fetch("http://localhost:80/challenge/api_challenge/checkouts").then(
    (response) => response.json()
  );
};
