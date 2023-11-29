import languages from "./languages.json";
import countries from "./countries.json";
import {nextSlide} from "./utilities";

export function submitFormOne() {
    let formOne = document.getElementById('form-1');
    formOne.addEventListener('submit', (event) => {
        event.preventDefault();
        formOne.dataset.isValid = true;
        document.querySelectorAll('input').forEach((input) => {
            document.querySelector(`.validation`).style.display = 'none';

            if (input.classList.contains('invalid')) {
                document.querySelector(`.${input.type}-validation`).style.display = 'block';
                console.log(document.querySelector(`.${input.type}-validation`));
                formOne.dataset.isValid = false;
            }
        })
        if (formOne.dataset.isValid === 'true') {
            nextSlide();
        }
    })
}

export function submitFormTwo() {
    let formTwo = document.getElementById('form-2');

    formTwo.addEventListener('submit', (event) => {
        event.preventDefault();

        formTwo.dataset.isValid = true;

        if (formTwo.dataset.isValid === 'true') {
            nextSlide();
        }
    })
}

export function languagesSelect() {
    const option = document.createElement('option');
    option.value = ""
    option.textContent = "Native language"
    const select =  document.querySelector('.languages-select')
    select.append(option);

    JSON.parse(languages).forEach((language) => {
        const option = document.createElement('option');
        option.value = language.code;
        option.textContent = language.name;
        select.append(option);
    });

    m4q(select).select()
}

export function nationalitySelect() {
    const option = document.createElement('option');
    option.value = ""
    option.textContent = "Country of origin"
    const select =  document.querySelector('.nationality-select')
    select.append(option);
    JSON.parse(countries).forEach((country) => {
        const option = document.createElement('option');
        option.dataset.template = `<span class='icons ${country[1].toLowerCase()}'></span> $1`;
        option.value = country[1];
        option.textContent = country[0];
        select.append(option);
    });

    m4q(select).select()
}