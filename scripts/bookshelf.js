document.addEventListener("DOMContentLoaded", function (e) {
  flushBooks();
  batchBindClick();
});

function flushBooks() {
  fetch("/server/index.php/api/get/userbooks")
    .then((res) => res.json())
    .then((resData) => {
      const bookShelf = document.getElementById("bookshelf");
      bookShelf.innerHTML = "";
      if(resData.rows===undefined) return;
      resData.rows.forEach((r) => {
        let template = `<div class="card m-5" style="width: 60rem; border-color: white">
          <div class="row g-0 p-4">
            <div class="col-md-4">
              <img id="book-img" class="img-fluid rounded-start" src="${r.img}" alt="img" />
              <div class="star-rating">
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star"></span>
                <span class="fas fa-star-half-alt"></span>
                <span id="book-score" class="rating-number">${r.score}</span>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Title:<span id="book-title">${r.title}</span></h5>
                <span id="bookid" style="display: none"></span>
                <span>Author:<span id="book-author">${r.author}</span></span>
                <br />
                <span>Genre:<span id="book-genre">${r.genre}</span></span>
                <br />
                <span>Publish Date:<span id="book-publish-date">${r.publish_date}</span></span>
                <br />
                <span>ISBN:<span id="book-isbn">${r.isbn}</span></span>
                <br />
                <br />
                <h6>Description:</h6>
                <p id="book-description" class="card-text">${r.description}</p>
                <a href="#" data-book-id=${r.bookid} data-user-id=${r.userid} class="add-favourite btn btn-outline-danger">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-trash"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"
                      />
                      <path
                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"
                      />
                    </svg>
                    Remove</a
                  >
              </div>
            </div>
          </div>
        </div>`;
        bookShelf.insertAdjacentHTML("beforeend", template);
      });
      batchBindClick();
    })
    .catch((err) => console.error("Error: ", err));
}

function batchBindClick() {
  const linksContainer = document.getElementById("bookshelf");

  linksContainer.addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("add-favourite")) {
      e.preventDefault();

      const bookId = e.target.getAttribute("data-book-id");
      const userId = e.target.getAttribute("data-user-id");

      //console.log(`Book ID: ${bookId}, User ID: ${userId}`);
      let obj={};
      obj['bookid']=bookId;
      obj['userid']=userId;
      fetch('/server/index.php/api/delete/userbook',{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(obj)
      })
      .then(res=>res.json())
      .then((resData)=>{
        console.log(resData);
        flushBooks();
      })
      .catch(err=>{
        console.error("Error:",err);
      })
    }
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