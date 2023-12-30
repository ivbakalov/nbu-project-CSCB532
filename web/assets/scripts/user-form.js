import languages from "./languages.json";
import countries from "./countries.json";
import { nextSlide } from "./utilities";
import { http } from "./http";
import { User } from "./user";
import { survey } from "./survey";

export async function submitForm(id) {
  let form = document.getElementById(id);

  if (form) {
    await getUser();

    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      form.dataset.isValid = "true";
      if (id === "form-2") {
        validateSelect(form);
      }

      document.querySelectorAll("input").forEach((input) => {
        if (input.closest(".validation")) {
          input.closest(".validation").style.display = "none";
        }

        if (input.classList.contains("invalid")) {
          document.querySelector(`.${input.type}-validation`).style.display =
            "block";

          form.dataset.isValid = "false";
        }
      });

      if (form.dataset.isValid === "true") {
        await getUser();

        if (id === "form-2") {
          registerUser();
        }
      }
    });

    if (id === "form-2") {
      document
        .querySelectorAll(".languages-select .option-list li")
        .forEach((li) => {
          li.addEventListener("click", (event) => {
            setTimeout(() => {
              validateSelect(form);
            });
          });
        });
    }
  }

  if (id === "form-3") {
    survey();
  }
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
    country: data.toString(),
    education: data.toString(),
    email: data.toString(),
    englishLevel: Number(data),
    gender: Number(data),
    nativeLanguage: data.toString(),
  };
}

function registerUser() {
  let data = {};

  document.querySelectorAll("[data-form-name]").forEach((element) => {
    const { formName, index } = element.dataset;

    if (element.type === "checkbox") {
    } else if (element.type === "radio") {
      if (element.checked) {
        data = { ...data, [formName]: convertToProperTypes(index)[formName] };
      }
    } else {
      data = {
        ...data,
        [formName]: convertToProperTypes(element.value)[formName],
      };
    }
  });

  http(`user`, "POST", data)
    .then((response) => {
      if (response) {
        console.log(response);
        localStorage.setItem("email", response.email);
        User.instance.set(response);
        void submitForm(`form-${nextSlide()}`);

        console.log(User.instance.value);
      }
    })
    .catch((error) => {
      localStorage.removeItem("email");
      User.instance.set({});
      console.log(error);
    });
}

async function getUser() {
  const email =
    document.querySelector("[data-form-name='email']").value ||
    localStorage.getItem("email");

  if (email && !User.instance.value.email) {
    return http(`user/${email}`, "GET", "", false)
      .then((response) => {
        if (response) {
          localStorage.setItem("email", email);
          User.instance.set(response);
          submitForm(`form-${nextSlide()}`);
        }
      })
      .catch(() => {
        User.instance.set({ email });
        localStorage.removeItem("email");
        submitForm(`form-${nextSlide()}`);
      });
  } else if (User.instance.value.email && localStorage.getItem("email")) {
    void submitForm(`form-${nextSlide()}`);
  }
}
