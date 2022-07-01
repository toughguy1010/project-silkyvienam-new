// A $( document ).ready() block.
jQuery(document).ready(function() {
    console.log("ready!");
    // cartToggleMenu
    var openCartMenu = document.querySelector('.cart-btn')
    var cartMenu = document.querySelector('.xoo-wsc-modal')

    console.log(openCartMenu)
    openCartMenu.addEventListener('click', openMenu)

    function openMenu() {
        cartMenu.classList.toggle("xoo-wsc-cart-active")
            // console.log(cartMenu)
    }
    var activeFilterBtn = document.querySelector('#activefilterbtn')
    console.log(activeFilterBtn);
    var filterContainer = document.querySelector("#filter-section")
    console.log(filterContainer);
    activeFilterBtn.addEventListener('click', activeFilterContent)

    function activeFilterContent() {
        filterContainer.classList.toggle("filter-section-active")
    }
    activeFilterBtn.addEventListener('click', activeArrowdirection)
    var activeFilterArrowBtn = document.querySelector('.filter_arrow_btn')

    function activeArrowdirection() {
        activeFilterArrowBtn.classList.toggle("active_filter_arrow_btn")
    }
});


// console.log(wcsContainer)