document.addEventListener("DOMContentLoaded", function () {
  fetch("/server/index.php/api/get/books")
    .then((res) => res.json())
    .then((resData) => {
      flushBooks(resData);
    });
});

document.getElementById("search").addEventListener("click", function (e) {
  const searchVal = document.getElementById("searchVal").value;
  if (searchVal.trim() === "") {
    fetch("/server/index.php/api/get/books")
      .then((res) => res.json())
      .then((resData) => {
        flushBooks(resData);
      });
  } else {
    fetch(`/server/index.php/api/get/books/searchVal/${searchVal}`, {
      method: "GET",
      header: { "Content-Type": "application/json" },
    })
      .then((res) => res.json())
      .then((resData) => {
        flushBooks(resData);
      });
  }
});

const addbookModalElement = document.getElementById("addbookModal");
const addbookModal = new bootstrap.Modal(addbookModalElement);

const modifybookModalElement = document.getElementById("modifybookModal");
const modifybookModal = new bootstrap.Modal(modifybookModalElement);

document
  .getElementById("addbook-form")
  .addEventListener("submit", function (e) {
    // prevent default flush page
    e.preventDefault();

    // get data from form
    let jsonData = getJson(new FormData(this));

    fetch("/server/index.php/api/post/books", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: jsonData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.resCode === 0) {
          alert("Add successfully!");
          addbookModal.hide();
          fetch("/server/index.php/api/get/books")
            .then((res) => res.json())
            .then((resData) => {
              flushBooks(resData);
            });
        } else {
          alert(data.resMsg);
        }
      })
      .catch((err) => console.error("Error: ", err));
  });

document.getElementById("logout").addEventListener("click", function (e) {
  e.preventDefault();

  fetch("/server/index.php/api/logout")
    .then((res) => res.json())
    .then((resData) => {
      if (resData.resCode === 0) {
        alert("Logout successfully!");
      } else {
        alert(resData.resMsg);
      }
      window.location.href = "http://localhost";
      console.log(resData);
    });
});

document
  .getElementById("modifybook-form")
  .addEventListener("submit", function (e) {
    // prevent default flush page
    e.preventDefault();

    // get data from form
    let jsonData = getJson(new FormData(this));
    console.log(jsonData);
    fetch("/server/index.php/api/put/books", {
      method: "PUT",
      headers: {
        "Content-type": "application/json",
      },
      body: jsonData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.resCode === 0) {
          alert("Modify successfully!");
          modifybookModal.hide();
          fetch("/server/index.php/api/get/books")
            .then((res) => res.json())
            .then((resData) => {
              flushBooks(resData);
            });
        } else {
          alert(data.resMsg);
        }
      })
      .catch((err) => console.error("Error: ", err));
  });

function flushBooks(resData) {
  const data = resData.rows;
  document.querySelector("#username").innerHTML = resData.username;
  //console.log(resData);
  document.querySelector("#book-data tbody").innerHTML = "";
  //console.log(data);
  if (resData.resCode === 0) {
    const itemsPerPage = 10;
    const pageCount = Math.ceil(data.length / itemsPerPage);

    function renderPage(page) {
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const pageData = data.slice(start, end);

      const tbody = document.querySelector("#book-data tbody");
      tbody.innerHTML = "";
      pageData.forEach((item) => {
        const row = tbody.insertRow();
        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);
        const cell4 = row.insertCell(3);
        const cell5 = row.insertCell(4);
        const cell6 = row.insertCell(5);
        const cell7 = row.insertCell(6);
        const cell8 = row.insertCell(7);
        const cell9 = row.insertCell(8);
        const cell10 = row.insertCell(9);
        const cell11 = row.insertCell(10);
        cell1.innerHTML = item.id;
        const addr = "/pages/bookdetail.html?id=" + item.id;
        cell2.innerHTML = `<a target='_blank' href=${addr}>
          ${item.title}
          </a>
          `;
        cell3.innerHTML = item.author;
        cell4.innerHTML = item.isbn;
        cell5.innerHTML = item.genre;
        cell6.innerHTML = item.publish_date;
        cell7.innerHTML = item.score;
        cell8.innerHTML = item.description.length>80?item.description.substring(0,80)+'...':item.description;
        cell9.setAttribute("data-id", item.id);
        cell10.innerHTML = `<a href="#" class='btn btn-outline-info' data-bs-toggle="modal" data-bs-target="#modifybookModal" data-id=${item.id}>Update</a>`;
        cell11.innerHTML = `<a href="#" class='btn btn-outline-danger' data-id=${item.id}>Delete</a>`;
      });
    }

    function setupPagination(pageCount) {
      const pagination = document.querySelector(".pagination");
      pagination.innerHTML = "";
      for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement("li");
        li.className = "page-item";
        const a = document.createElement("a");
        a.className = "page-link";
        a.href = "#";
        a.innerText = i;
        a.addEventListener("click", function (e) {
          e.preventDefault();
          renderPage(i);
        });
        li.appendChild(a);
        pagination.appendChild(li);
      }
    }
    setupPagination(pageCount);
    renderPage(1);
  }
}

function getJson(formData) {
  let obj = {};
  formData.forEach((value, key) => (obj[key] = value));
  return JSON.stringify(obj);
}

document.getElementById("book-data").addEventListener("click", function (e) {
  e.preventDefault();
  if (e.target.tagName === "A" && e.target.textContent === "Delete") {
    var confirmAction = confirm("Are you sure delete this book?");

    if (confirmAction) {
      var clickedLink = e.target;

      const bookid = clickedLink.getAttribute("data-id");
      let obj = {};
      obj["bookid"] = bookid;
      fetch("/server/index.php/api/delete/books", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(obj),
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.resCode === 0) {
            fetch("/server/index.php/api/get/books")
              .then((res) => res.json())
              .then((resData) => {
                flushBooks(resData);
              });
          } else {
            alert(res.resMsg);
          }
        })
        .catch((err) => {
          console.error("Error:", err);
        });
    }
  } else if (e.target.tagName === "A" && e.target.textContent === "Update") {
    var clickedLink = e.target;

    const bookid = clickedLink.getAttribute("data-id");
    let obj = {};
    obj["bookid"] = bookid;
    fetch(`/server/index.php/api/get/books/${bookid}`, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    })
      .then((res) => res.json())
      .then((resData) => {
        bindDataToForm("modifybook-form", resData.rows[0]);
      })
      .catch((err) => {
        console.error("Error:", err);
      });
  } else if (e.target.tagName === "A") {
    window.open(e.target.href, "_blank");

    //window.open('http://www.example.com', '_blank');
  }
});

function bindDataToForm(formId, data) {
  const form = document.getElementById(formId);
  if (!form) {
    console.error("Form not found");
    return;
  }
  Array.from(form.elements).forEach((e) => {
    if (data.hasOwnProperty(e.name)) {
      e.value = data[e.name];
    }
  });
}
