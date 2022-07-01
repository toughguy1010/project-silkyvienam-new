var activeBtnPaginations = document.querySelectorAll(' #pagination-btn')
console.log(activeBtnPaginations)

for (var paginationBtn = 0; paginationBtn < activeBtnPaginations.length; paginationBtn++) {
    activeBtnPaginations[paginationBtn].addEventListener("click", function() {
        var currentActiveBtn = document.getElementsByClassName('active-pagination');
        currentActiveBtn[0].className = currentActiveBtn[0].className.replace('active-pagination', '');
        this.className += "active-pagination"
    })
}