document.querySelector("#login").addEventListener("click", function () {
  var authModal = new bootstrap.Modal(document.getElementById("authModal"));
  authModal.show();
});

document.getElementById("loginForm").addEventListener("submit", function (e) {
  // prevent default flush page
  e.preventDefault();

  // get data from form
  let jsonData = getJson(new FormData(this));

  // use 'fetch' api to send POST request
  fetch("/server/index.php/api/login", {
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
    body: jsonData,
  })
    .then((res) => res.json())
    .then((data) => {
      // test response data
      //console.log(data);
      //console.log(data.resCode);
      if (data.resCode === 0) {
        window.location.href = "/pages/home.html";
      } else {
        alert(data.resMsg);
      }
    })
    .catch((err) => console.error("Error: ", err));
});

document
  .getElementById("registerForm")
  .addEventListener("submit", function (e) {
    // prevent default flush page
    e.preventDefault();

    // get data from form
    let jsonData = getJson(new FormData(this));

    // use 'fetch' api to send POST request
    fetch("/server/index.php/api/register", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: jsonData,
    })
      .then((res) => res.json()) // get response
      .then((data) => {
        // test response data
        console.log(data);
        if (data.resCode === 0) {
          alert('register success!');
          window.location.href = "/pages/home.html";
        } else {
          alert(data.resMsg);
        }
      })
      .catch((err) => console.error("Error: ", err));
  });

function getJson(formData) {
  let obj = {};
  formData.forEach((value, key) => (obj[key] = value));
  return JSON.stringify(obj);
}
