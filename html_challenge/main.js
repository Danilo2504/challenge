window.onload = () => {
  renderCards();
  handleReviewsCarousel(0);
  handleFooterCarousel(0);
};

const menuButton = document.getElementsByClassName("menu-button");
const closeButton = document.getElementById("close-menu-button");
const menuView = document.getElementById("menu-view");

const HIDE_MENU = "container-fluid custom-hide-menu";
const SHOW_MENU = "container-fluid custom-show-menu";
menuButton[0].addEventListener("click", function () {
  menuView.className = SHOW_MENU;
});
menuButton[1].addEventListener("click", function () {
  menuView.className = SHOW_MENU;
});

closeButton.addEventListener("click", function () {
  menuView.className = HIDE_MENU;
});

// REVIEW CARD
const REVIEWS = [
  {
    name: "Giuseppe Cuttone",
    publish_data: "1 mese fa SU",
    comment:
      "Conosco Luigi Rosso da anni, ho conosciuto tanti professionisti del settore, ma Rosso è un professionista",
  },
  {
    name: "Loenardo Da Vinci",
    publish_data: "1 mese fa SU",
    comment:
      "Conosco Luigi Rosso da anni, ho conosciuto tanti professionisti del settore, ma Rosso è un professionista",
  },
  {
    name: "Cesare",
    publish_data: "1 mese fa SU",
    comment:
      "Conosco Luigi Rosso da anni, ho conosciuto tanti professionisti del settore, ma Rosso è un professionista",
  },
  {
    name: "Giuseppe Cuttone",
    publish_data: "1 mese fa SU",
    comment:
      "Conosco Luigi Rosso da anni, ho conosciuto tanti professionisti del settore, ma Rosso è un professionista",
  },
];

const createReviewCard = (review, container) => {
  const reviewCard = document.createElement("div");
  reviewCard.innerHTML = `
    <div class="d-flex flex-row">
    <img
       src="./assets/default_image.jpg"
       class="rounded-circle ratio-1x1"
       height="40"
       width="40"
       style="margin-right: 14px"
       />
    <div class="d-flex flex-column justify-content-between">
       <p class="m-0 arial-bold">${review.name}</p>
       <p class="raleway-regular text-grey m-0" style="font-size: 12px">
          ${review.publish_data}
          <span
             ><img
             src="./assets/google_logo_small.png"
             height="18"
             width="54"
             style="margin-left: 4px"
             /></span>
       </p>
    </div>
 </div>
 <img
    src="./assets/stars.png"
    style="aspect-ratio: 90/17; width: 90px; margin-top: 16px"
    class="h-auto object-fit-cover"
    />
 <p
    class="arial-regular"
    style="font-size: 14px; margin-top: 8px; margin-bottom: 8px"
    >
    ${review.comment}
 </p>
 <a class="text-grey raleway-regular" style="font-size: 16px">
 Leggi di più
 </a>
  `;
  reviewCard.className = "custom-review-card";

  container.appendChild(reviewCard);
};

const renderCards = () => {
  const reviewsContainer = document.getElementById("reviewsContainer");
  REVIEWS.map((review) => createReviewCard(review, reviewsContainer));
};

// REVIEWS CAROUSEL
const controllers = document.getElementsByClassName("custom-carousel-dot");

for (let i = 0; i < controllers.length; i++) {
  controllers[i].addEventListener("click", () => {
    handleReviewsCarousel(i);
  });
}

const handleReviewsCarousel = (n) => {
  const carouselReviewsContainer = document.getElementById(
    "carouselReviewsContainer"
  );

  for (let i = 0; i < controllers.length; i++) {
    controllers[i].className = controllers[i].className.replace(
      "custom-active",
      ""
    );
  }

  controllers[n].className += " custom-active";
  carouselReviewsContainer.innerHTML = "";
  createReviewCard(REVIEWS[n], carouselReviewsContainer);
};

// FOOTER CAROUSEL

const footerControllers = document.getElementsByClassName(
  "custom-footer-carousel-dot"
);

for (let i = 0; i < footerControllers.length; i++) {
  footerControllers[i].addEventListener("click", () => {
    handleFooterCarousel(i);
  });
}

const handleFooterCarousel = (n) => {
  const columns = document.getElementsByClassName("footer-column");

  for (let i = 0; i < footerControllers.length; i++) {
    footerControllers[i].className = footerControllers[i].className.replace(
      "custom-active",
      ""
    );
  }
  for (let i = 0; i < columns.length; i++) {
    columns[i].style.display = "none";
  }

  footerControllers[n].className += " custom-active";
  columns[n].style.display = "flex";
};
