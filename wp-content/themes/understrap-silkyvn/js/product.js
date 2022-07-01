var activeBtnPaginations = document.querySelectorAll(' #pagination-btn')
console.log(activeBtnPaginations)

for (var paginationBtn = 0; paginationBtn < activeBtnPaginations.length; paginationBtn++) {
    activeBtnPaginations[paginationBtn].addEventListener("click", function() {
        var currentActiveBtn = document.getElementsByClassName('active-pagination');
        currentActiveBtn[0].className = currentActiveBtn[0].className.replace('active-pagination', '');
        this.className += "active-pagination"
    })
}

var activeButtonSizes = document.querySelectorAll('.variable-item-span-button')
console.log(activeButtonSizes)

for (let buttonSize = 0; buttonSize < activeButtonSizes.length; buttonSize++) {
    activeButtonSizes[buttonSize].addEventListener('click', function() {
        for (let i = 0; i < activeButtonSizes.length; i++) {
            activeButtonSizes[i].classList.remove("variable-item-span-button-active")
        }
        this.classList.add("variable-item-span-button-active")
    })
}

var activeShippingButtton = document.querySelector('#ship-to-different-address-checkbox')

var shippingContainer = document.querySelector('.shipping_address')
console.log(shippingContainer)
activeShippingButtton.addEventListener('click', openShippingContainer)

function openShippingContainer() {
    shippingContainer.classList.toggle("active_shipping_address")
}