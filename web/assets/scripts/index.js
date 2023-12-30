import AOS from "aos";
import { languagesSelect, nationalitySelect, submitForm } from "./user-form";

document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    const preloader = document.querySelector(".loading");
    preloader.style.display = "none";
  }, 5);

  nationalitySelect();
  languagesSelect();
  void submitForm("form-1");

  // addBubbles();
});

AOS.init();

// function randomAddLiElements() {
//     const winWidth = window.innerWidth;
//     const winHeight = window.innerHeight;
//
//     document.querySelectorAll('.drag-texts').forEach((list) => {
//         // shortcut! the current div in the list
//
//         // get random numbers for each element
//        const randomTop = getRandomNumber(0, winHeight);
//        const randomLeft = getRandomNumber(0, winWidth);
//
//         // update top and left position
//         list.style.top = randomTop +"px";
//         list.style.left = randomLeft +"px";
//     })
//
//     function getRandomNumber(min, max) {
//
//         return Math.random() * (max - min) + min;
//
//     }
// }
