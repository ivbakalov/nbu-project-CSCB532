import AOS from "aos";
import {
  formOne,
  formTwo,
  languagesSelect,
  nationalitySelect,
} from "./user-form";
import { Loading } from "./loading";
import {getReferrer} from "./referrer";

const loading = new Loading();

document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    loading.hide();
  }, 500);

  nationalitySelect();
  languagesSelect();
  getReferrer();

  void formOne();
  void formTwo();

  document.querySelector(".logout-button").addEventListener("click", () => {
    localStorage.clear();
    window.location.reload();
  });


  document.querySelector(".initial-loading").remove();
});

AOS.init();
