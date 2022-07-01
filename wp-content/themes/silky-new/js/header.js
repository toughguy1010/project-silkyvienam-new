// cartToggleMenu
var openCartMenu = document.querySelector('.cart-btn')
var cartMenu = document.querySelector('.xoo-wsc-modal')

console.log(openCartMenu)
openCartMenu.addEventListener('click', openMenu)

function openMenu() {
    cartMenu.classList.toggle("xoo-wsc-cart-active")
        // console.log(cartMenu)
}



// console.log(wcsContainer)