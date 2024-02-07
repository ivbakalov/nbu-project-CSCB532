import languages from "./languages.json";
import countries from "./countries.json";
import { nextSlide } from "./utilities";
import { http } from "./http";
import { User } from "./user";
import { survey } from "./survey";
import { Loading } from "./loading";

export async function formOne() {
  let form = document.getElementById("form-1");

  if (
    localStorage.getItem("email") &&
    (await getUser(localStorage.getItem("email")))
  ) {
    nextSlide();
    nextSlide();
  }

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    form.dataset.isValid = "true";

    const email =
      document.querySelector("[data-form-name='email']").value ||
      localStorage.getItem("email");

    if (validateForm(form) === "true") {
      nextSlide();

      if (await getUser(email)) {
        nextSlide();
      }
    }
  });
}

export async function formTwo() {
  let form = document.getElementById("form-2");

  document
    .querySelectorAll(".languages-select .option-list li")
    .forEach((li) => {
      li.addEventListener("click", (event) => {
        setTimeout(() => {
          validateSelect(form);
        });
      });
    });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    form.dataset.isValid = "true";

    if (validateForm(form) === "true" && validateSelect(form) === "true") {
      registerUser();
    }
  });
}

export function validateSelect(form) {
  if (
    document.querySelector(".languages-select option:checked").innerHTML ===
    "Native language"
  ) {
    document.querySelector(".languages-validation").style.display = "block";
    form.dataset.isValid = "false";
  } else {
    document.querySelector(".languages-validation").style.display = "none";
    form.dataset.isValid = "true";
  }

  return form.dataset.isValid;
}

export function languagesSelect() {
  const option = document.createElement("option");
  option.value = "";
  option.textContent = "Native language";
  const select = document.querySelector(".languages-select");
  select.append(option);

  JSON.parse(languages).forEach((language) => {
    const option = document.createElement("option");
    option.value = language.code;
    option.textContent = language.name;
    select.append(option);
  });

  m4q(select).select();
}

export function nationalitySelect() {
  const option = document.createElement("option");
  option.value = "";
  option.textContent = "Country of origin";
  const select = document.querySelector(".nationality-select");
  select.append(option);
  JSON.parse(countries).forEach((country) => {
    const option = document.createElement("option");
    option.dataset.template = `<span class='icons ${country[1].toLowerCase()}'></span> $1`;
    option.value = country[1];
    option.textContent = country[0];
    select.append(option);
  });

  m4q(select).select();
}

function convertToProperTypes(data) {
  return {
    country: data?.toString(),
    education: data?.toString(),
    email: data?.toString(),
    englishLevel: Number(data),
    gender: Number(data),
    nativeLanguage: data?.toString(),
    interestedInMoreInfo: true,
  };
}

function registerUser() {
  const loading = new Loading();
  const referrer = sessionStorage.getItem("referrer");

  let data = {
    ...(referrer ? { referrer } : ""),
  };

  document.querySelectorAll("[data-form-name]").forEach((element) => {
    const { formName, index } = element.dataset;

    if (element.type === "radio" || element.type === "checkbox") {
      if (element.checked) {
        console.log(formName, element);
        data = { ...data, [formName]: convertToProperTypes(index)[formName] };
      }
    } else {
      const convertedData = convertToProperTypes(element.value)[formName];

      if (convertedData !== "" && convertedData !== undefined) {
        data = {
          ...data,
          [formName]: convertedData,
        };
      }
    }
  });

  http(`user`, "POST", data)
    .then((response) => {
      if (response) {
        localStorage.setItem("email", response.email);

        User.instance.set(response);
        nextSlide();
        void survey();
      }
    })
    .catch((error) => {
      localStorage.removeItem("email");
      User.instance.set({});
      console.log(error);
    })
    .finally(() => {
      sessionStorage.removeItem("referrer");

      setTimeout(() => {
        loading.hide();
      }, 500);
    });
}

async function getUser(email) {
  const loading = new Loading();

  let userResponse = {};

  try {
    userResponse = await http(`user/${email}`, "GET", "", false);

    if (userResponse) {
      sessionStorage.removeItem("referrer");
      localStorage.setItem("email", email);
      User.instance.set(userResponse);
      void survey();
    }

    return true;
  } catch (error) {
    localStorage.removeItem("email");

    return false;
  } finally {
    setTimeout(() => {
      loading.hide();
    }, 500);
  }
}

function validateForm(form) {
  form.dataset.isValid = "true";

  form.querySelectorAll(`input`).forEach((input) => {
    if (input.closest(".validation")) {
      input.closest(".validation").style.display = "none";
    }

    if (input.classList.contains("invalid")) {
      form.querySelector(`.${input.type}-validation`).style.display = "block";

      form.dataset.isValid = "false";
    }
  });

  return form.dataset.isValid;
}
