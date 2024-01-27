import AOS from "aos";
import {
  formOne,
  formTwo,
  languagesSelect,
  nationalitySelect,
} from "./user-form";
import { Loading } from "./loading";

const loading = new Loading();

document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    loading.hide();
  }, 500);

  nationalitySelect();
  languagesSelect();

  void formOne();
  void formTwo();

  document.querySelector(".logout-button").addEventListener("click", () => {
    localStorage.clear();
    window.location.reload();
  });

  document.querySelector(".initial-loading").remove();
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
