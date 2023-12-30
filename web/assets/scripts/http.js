import Toastify from "toastify-js";

const baseURl = "https://api.cscb532.pwpwebhosting.com/";

export const http = async (url, method = "GET", body = null, alert = true) => {
  const options = {
    method,
    headers: {
      "Content-Type": "application/json",
    },
  };

  if (body) {
    options.body = JSON.stringify(body);
  }

  try {
    const beginFetch = await fetch(baseURl + url, options);
    const response = await beginFetch.json();

    if (beginFetch.status === 200 || beginFetch.status === 201) return response;

      if (alert) {
          switch (beginFetch.status) {
              case 400:
                  tostify("Bad request");
                  break;
              case 401:
                  tostify("Unauthorized");
                  break;
              case 404:
                  tostify("The requested resource was not found");
                  break;
              case 500:
                  tostify(response.message);
                  break;
              default:
                  tostify("Something went wrong");
                  break;
          }
      }

    return Promise.reject(response);
  } catch (error) {
    if (alert) {
      tostify("Something went wrong");
    }
    return Promise.reject(error);
  }

  function tostify(msg, color = "var(--error-color)") {
    Toastify({
      text: msg,
      duration: 3000,
      newWindow: true,
      close: true,
      gravity: "top", // `top` or `bottom`
      position: "right", // `left`, `center` or `right`
      stopOnFocus: true, // Prevents dismissing of toast on hover
      style: {
        background: color,
      },
      onClick: function () {}, // Callback after click
    }).showToast();
  }
};
