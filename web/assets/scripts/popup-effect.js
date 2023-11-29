export const addBubbles = () => {
    const TRIES_PER_BOX = 50;
    const randUint = range => Math.random() * range | 0;
    const placing  = [...document.querySelectorAll(".bubble")].map(el => Bounds(el, 5));
    const fitted = [];
    const areaToFit = Bounds(document.querySelector(".bubble-boundary"));
    let maxTries = TRIES_PER_BOX * placing.length;



    loopAndPlaceElement(placing, maxTries, fitted, randUint, areaToFit);


    function Bounds(el, pad = 0) {
        const box = el?.getBoundingClientRect() ?? {
            left: 0, top: 0,
            right: innerWidth, bottom: innerHeight,
            width: innerWidth, height: innerHeight
        };
        return {
            l: box.left - pad,
            t: box.top - pad,
            r: box.right + pad,
            b: box.bottom + pad,
            w: box.width + pad * 2,
            h: box.height + pad * 2,
            overlaps(bounds) {
                return !(
                    this.l > bounds.r ||
                    this.r < bounds.l ||
                    this.t > bounds.b ||
                    this.b < bounds.t
                );
            },
            moveTo(x, y) {
                this.r = (this.l = x) + this.w;
                this.b = (this.t = y) + this.h;
                return this;
            },
            placeElement() {
                if (el) {
                    el.style.top = (this.t + pad) + "px";
                    el.style.left = (this.l + pad) + "px";
                    el.classList.add("placed");
                }
                return this;
            }
        };
    }
}


const loopAndPlaceElement = (placing, maxTries, fitted, randUint, areaToFit) => {
    let arrayOfNotPassed = [];

    console.log(placing.length, maxTries)
    while (placing.length && maxTries > 0) {
        let i = 0;
        placing.forEach((box, i) => {
            box.moveTo(randUint(areaToFit.w - box.w), randUint(areaToFit.h - box.h));
            if (fitted.every(placed => !placed.overlaps(box))) {
                fitted.push(placing.splice(i--, 1)[0].placeElement());
            } else {
                arrayOfNotPassed.push(placing);

                console.log(45545)
                maxTries--
            }

            if (arrayOfNotPassed.length > 0) {
                console.log(arrayOfNotPassed)
                // loopAndPlaceElement(arrayOfNotPassed, maxTries, fitted, randUint, areaToFit)
            }



        })
    }
}



// export function addBubbles() {
//     const bubbles = document.querySelectorAll('.bubble');
//
//     bubbles.forEach((bubble) => {
//
//         const bubbleWidth = bubble.offsetWidth;
//         const bubbleHeight = bubble.offsetHeight;
//
//         const bubbleTop = randomInt(0, vh - bubbleHeight);
//         const bubbleLeft = randomInt(0, vw - bubbleWidth);
//
//         bubble.style.top = bubbleTop + 'px';
//         bubble.style.left = bubbleLeft + 'px';
//         bubble.style.opacity = 1;
//     });
// }
