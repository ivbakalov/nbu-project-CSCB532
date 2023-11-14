
// import {userForm} from "./forms/user-form";
// import $ from "jquery";
// import fullpage from "fullpage.js/dist/fullpage"
// import metro from "metro4/build"

// function blq(event) {
//     event.preventDefault();
//     console.log('blq');
// }



document.addEventListener('DOMContentLoaded', () => {

    setTimeout(() => {
        const preloader = document.querySelector('.loading');
        preloader.style.display = 'none';
    }, 2000)

    const section1 = document.querySelector('.section-one');
    const section2 = document.querySelector('.section-two');

    section2.style.display = 'none';




    let form = document.getElementById('form');

    form.addEventListener('submit', (event) => {
        section1.style.display = 'none';
        section2.style.display = 'flex';

    })

});