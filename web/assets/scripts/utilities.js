let slide = 1;

const colorsArray = ["#009688", "#2e5493", "#d45500", "#009688"];
export function nextSlide() {
  const section1 = document.querySelector(`.section-${slide}`);
  const section2 = document.querySelector(`.section-${slide + 1}`);

  section1.classList.add("animation-hide");
  section2.classList.add("animation-show");

  slide++;

  setTimeout(() => {
    changeCSSVariable("--main-bg-color", colorsArray[slide - 1]);
  }, 400);

  return slide;
}

export function changeCSSVariable(variableName, newValue) {
  document.documentElement.style.setProperty(variableName, newValue);
}
