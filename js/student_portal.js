// student_portal.js

document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".nav__item");
  const sections = document.querySelectorAll(".content__section");

  buttons.forEach(button => {
    button.addEventListener("click", () => {
      // remove active from all buttons
      buttons.forEach(btn => btn.classList.remove("is-active"));
      button.classList.add("is-active");

      // hide all sections
      sections.forEach(section => section.classList.remove("is-visible"));

      // show selected section
      const target = button.getAttribute("data-section");
      document.getElementById(target).classList.add("is-visible");
    });
  });
});
