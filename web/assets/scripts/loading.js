export class Loading {
  constructor() {
    this.show();
  }

  #loadingElement = null;

  show() {
    this.#loadingElement = document.createElement("div");
    this.#loadingElement.classList.add("loading");
    const span = document.createElement("span");
    span.classList.add("mif-spinner2", "ani-pulse");
    this.#loadingElement.append(span);
    document.body.append(this.#loadingElement);
  }

  hide() {
    this.#loadingElement.remove();
  }
}
