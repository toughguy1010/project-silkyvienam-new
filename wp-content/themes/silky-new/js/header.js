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

    console.log(filterContainer);
    activeFilterBtn.addEventListener('click', activeFilterContent)

    function activeFilterContent() {
        filterContainer.classList.toggle("filter-section-active")
        woofAutoShowContainer.classList.toggle("woof-active");
        woofAutoShowContainer.classList.toggle("woof_overflow_hidden");
        woofAutoShowIndentContainer.classList.toggle("woof_overflow_hidden");
    }
    activeFilterBtn.addEventListener('click', activeArrowdirection)
    var activeFilterArrowBtn = document.querySelector('.filter_arrow_btn')

    function activeArrowdirection() {
        activeFilterArrowBtn.classList.toggle("active_filter_arrow_btn")

    }
    var filterContainer = document.querySelector("#filter-section")
    filterContainer.addEventListener('click', showWoofOverflow)
    var woofAutoShowContainer = document.querySelector('.woof_auto_show')
    var woofAutoShowIndentContainer = document.querySelector('.woof_auto_show_indent')
    console.log(woofAutoShowIndentContainer)

    function showWoofOverflow() {
        woofAutoShowContainer.classList.toggle("woof-active");
        filterContainer.classList.toggle("filter-section-active")
        activeFilterArrowBtn.classList.toggle("active_filter_arrow_btn")
        woofAutoShowContainer.classList.toggle("woof_overflow_hidden");
        woofAutoShowIndentContainer.classList.toggle("woof_overflow_hidden");


    }



});


// console.log(wcsContainer)