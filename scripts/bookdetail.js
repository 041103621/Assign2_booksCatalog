document.addEventListener("DOMContentLoaded", function (e) {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
  fetch(`/server/index.php/api/get/books/${id}`)
    .then((res) => res.json())
    .then((data) => {
      const row = data.rows[0];
      //console.log(row);
      const bookImg = document.querySelector("#book-img");
      bookImg.setAttribute("src", row.img);
      const bookId = document.querySelector("#bookid");
      bookId.setAttribute("data-id", row.id);
      document.querySelector("#userid").innerHTML = data.userid;
      document.querySelector("#username").innerHTML = data.username;
      document.querySelector("#book-author").innerHTML = row.author;
      document.querySelector("#book-title").innerHTML = row.title;
      document.querySelector("#book-genre").innerHTML = row.genre;
      document.querySelector("#book-score").innerHTML = row.score;
      document.querySelector("#book-publish-date").innerHTML = row.publish_date;
      document.querySelector("#book-isbn").innerHTML = row.isbn;
      document.querySelector("#book-description").innerHTML = row.description;

      return row.id;
    })
    .then((bookId) => getBookComments(bookId))
    .catch((err) => console.error("Error: ", err));
});

document
  .getElementById("add-favourite")
  .addEventListener("click", function (e) {
    e.preventDefault();
    const bookId = document.getElementById("bookid").dataset.id;
    const userId = document.getElementById("userid").textContent;
    let obj = {};
    obj["bookid"] = bookId;
    obj["userid"] = userId;

    fetch("/server/index.php/api/post/userbook", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(obj),
    })
      .then((res) => res.json())
      .then((data) => {
        // alert(data);
        console.log(data);
        if (data.resCode === 0) {
          alert("Add successfully!");
          window.location.href = "/pages/bookshelf.html";
        } else {
          alert("Error:" + data.resMsg);
        }
      });
  });

const commentModalElement = document.getElementById("commentModal");
const commentModal = new bootstrap.Modal(commentModalElement);
if (commentModalElement) {
  commentModalElement.addEventListener("show.bs.modal", (event) => {});
}

document
  .getElementById("submit-comment")
  .addEventListener("click", function (e) {
    const bookId = document.getElementById("bookid").dataset.id;
    const userId = document.getElementById("userid").textContent;
    const comments = document.getElementById("comment-text").value;
    let obj = {};
    obj["bookid"] = bookId;
    obj["userid"] = userId;
    obj["comments"] = comments;

    fetch("/server/index.php/api/post/bookcomment", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(obj),
    })
      .then((res) => res.json())
      .then((data) => {
        //console.log(data);
        if (data.resCode === 0) {
          alert("Add successfully!");
          commentModal.hide();
          // flush comments
          getBookComments(bookId);
        } else {
          alert("Error:" + data.resMsg);
        }
      });
  });

function getBookComments(bookIdInput) {
  let bookId = document.getElementById("bookid").dataset.id;
  //console.log(bookId);
  if (bookIdInput !== "") {
    bookId = bookIdInput;
  }
  fetch(`/server/index.php/api/get/bookcomment/${bookId}`)
    .then((res) => res.json())
    .then((data) => {
      //console.log(data);
      let commentsAccordion = document.getElementById("accordionFlush");
      commentsAccordion.textContent = "";
      if (data.rows !== undefined) {
        data.rows.forEach(function (row, index) {
          //console.log(row.bookid, row.userid, row.username,row.comments,index);
          var accordionItemHTML = `<div class="accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapse${index}"
                aria-expanded="false"
                aria-controls="flush-collapse${index}"
              >
                ${row.username} ${row.created_at}
              </button>
            </h2>
            <div
              id="flush-collapse${index}"
              class="accordion-collapse collapse"
              data-bs-parent="#accordionFlush"
            >
              <div class="accordion-body">
                ${row.comments}
              </div>
            </div>
          </div>`;
          commentsAccordion.insertAdjacentHTML("beforeend", accordionItemHTML);
        });
      }
    })
    .catch((err) => {
      console.error("Error:", err);
    });
}

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
