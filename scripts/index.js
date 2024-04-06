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
    if(validate()) {
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
  }});

function getJson(formData) {
  let obj = {};
  formData.forEach((value, key) => (obj[key] = value));
  return JSON.stringify(obj);
}

//validate register email
let registerEmail = document.getElementById('registerEmail');
let emailerror = document.getElementById('emailerror');

function validateEmail(email) {
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email.value)) {
      emailerror.innerText = '* Email address should be non-empty with the format xyz@xyz.xyz.';
      email.style.border = '2px solid red';
      return false;
  } else {
      emailerror.innerText = '';
      email.style.border = '1px solid black';
      return true;
  }
}

registerEmail.addEventListener('input', function() {
  validateEmail(registerEmail);
})

//validate register password
let pass = document.getElementById('registerPassword');
let pass2 = document.getElementById('registerPassword2');
let passerror = document.getElementById('passerror');
let pass2error = document.getElementById('pass2error');

function validatePass(password) {
  if (password.value.length < 8) {
      passerror.innerText = '* Password should be at least 8 characters long.';
      password.style.border = '2px solid red';
      return false;
  } else {
      passerror.innerText = '';
      password.style.border = '1px solid black';
      return true;
  }
}

function validatePass2(password1, password2) {
  if (password1.value !== password2.value) {
      pass2error.innerText = '* Please retype password.';
      pass2.style.border = '2px solid red';
      return false;
  } else {
      pass2error.innerText = '';
      password2.style.border = '1px solid black';
      return true;
  }
}
pass.addEventListener('input', function() {
  validatePass(pass);
})

pass2.addEventListener('input', function() {
  validatePass2(pass, pass2);
})

function validate() {
  return validateEmail(registerEmail) && validatePass(pass) && validatePass2(pass, pass2);
}