// A $( document ).ready() block.


jQuery(document).ready(function() {





    console.log("ready!");
    // cartToggleMenu
    var openCartMenu = document.querySelector('.cart-btn')
    var cartMenu = document.querySelector('.xoo-wsc-modal')
    var closeCartMenu = document.querySelector('.xoo-wsch-top .cart-toggle-btn')
        // var btnSubmitCart = document.querySelector('.single_add_to_cart_button ')
        // btnSubmitCart.addEventListener('click', openMenu)
        // console.log(openCartMenu)
    openCartMenu.addEventListener('click', openMenu)

    function openMenu() {
        cartMenu.classList.add("xoo-wsc-cart-active")
            // console.log(cartMenu)
    }
    // closeCartMenu.addEventListener("click", closeSideCartMenu)


    // cartToggleMenuMobile



    // activeFilterBtn.removeEventListener("click", activeFilterContent)
    // activeFilterBtn.addEventListener("click", removeshowautoform)

    var activeFilterBtn = document.querySelector('#activefilterbtn')
        // console.log(activeFilterBtn);

    // console.log(filterContainer);
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
    // function removeshowautoform() {
    //     activeFilterBtn.classList.remove("woof_hide_auto_form")
    // }


    // woof sorting 
    $("#admin_cal_list option").click(function() {
        var selText = $(this).text();
        console.log(selText);
        $(this).parents('.dropdown').find('.dropdown-toggle').val(selText);
        $(this).closest('form').trigger('submit');

    });

    $("#admin_cal_list option").click(function() {
        /* woo3.3 */

        if (!jQuery("#is_woo_shortcode").length) {
            woof_current_values.orderby = jQuery(this).val();
            woof_ajax_page_num = 1;
            woof_submit_link(woof_get_submit_link(), 0);
            return false;
        }
        /* +++ */
    });
    // woof sorting 



    var sortingFields = document.querySelector(".sorting-btn ");
    var sortingBtn = document.querySelector(".sorting-btn");
    var sortingInput = document.querySelector(".dropdown-toggle");
    var sortingMenu = document.querySelector("#admin_cal_list");
    // console.log(sortingMenu)
    var sortingArrow = document.querySelector(".sorting-arrow-btn")
    sortingFields.addEventListener('click', showSortingContent);

    function showSortingContent() {
        // sortingFields.classList.toggle("show");
        // sortingMenu.classList.toggle("show");
    }



    var sortingArrow = document.querySelector(".sorting-arrow-btn")
        // console.log(sortingArrow);

    sortingBtn.addEventListener('click', openSortMenu)
    sortingInput.addEventListener('click', openSortMenu)
    sortingArrow.addEventListener('click', openSortMenu)

    function openSortMenu() {

        sortingFields.classList.toggle("show");
        // console.log(sortingArrow);
        sortingMenu.classList.toggle("show");
        sortingArrow.classList.toggle("sorting-arrow-btn-active")

    }



    // $(window).bind('scroll', function() {
    //     if ($(window).scrollTop() > 500) {
    //         $('.header-section').addClass('nav-down');
    //     }
    // });

    // // Hide Header on on scroll down
    // var didScroll;
    // var lastScrollTop = 0;
    // var delta = 5;
    // var navbarHeight = $('.header-section').outerHeight();

    // $(window).scroll(function(event) {
    //     didScroll = true;
    // });

    // setInterval(function() {
    //     if (didScroll) {
    //         hasScrolled();
    //         didScroll = false;
    //     }
    // }, 500);

    // function hasScrolled() {
    //     var st = $(this).scrollTop();

    //     // Make sure they scroll more than delta
    //     if (Math.abs(lastScrollTop - st) <= delta)
    //         return;

    //     // If they scrolled down and are past the navbar, add class .nav-up.
    //     // This is necessary so you never see what is "behind" the navbar.
    //     if (st > lastScrollTop && st > navbarHeight) {
    //         // Scroll Down
    //         $('.header-section').removeClass('nav-down').addClass('nav-up');
    //     } else {
    //         // Scroll Up
    //         if (st + $(window).height() < $(document).height()) {
    //             $('.header-section').removeClass('nav-up');
    //         }
    //     }

    //     lastScrollTop = st;
    // }


    // var subMenuConent = document.querySelector(".sub-menu")

    // var openSubMenu = document.querySelector(".parent-1")

});

// sub menu parent 1 
const subMenuConent1 = document.querySelector(".menu-mobile-list .sub-menu")
const openSubMenu1 = document.querySelector(".menu-mobile-list .parent-1")

const closeSubMenu = document.querySelector(".back-menu-btn-1")

openSubMenu1.addEventListener('click', openSubMenuAction);

function openSubMenuAction() {
    subMenuConent1.classList.add("sub-menu-active")
    closeSubMenu.classList.add("back-menu-btn-active")
}
closeSubMenu.addEventListener("click", closeSubMenuAction);


function closeSubMenuAction() {
    subMenuConent1.classList.remove("sub-menu-active")
    closeSubMenu.classList.remove("back-menu-btn-active")

}

// sub menu child 1
const subMenuChild1 = document.querySelector(".menu-mobile-list .parent-sub-menu-1 .sub-menu")
const openSubMenuChild1 = document.querySelector(".menu-mobile-list .parent-sub-menu-1")
openSubMenuChild1.addEventListener('click', openSubMenuActionChild1)
const closeSubMenuChild1 = document.querySelector(".back-menu-btn-2")
closeSubMenuChild1.addEventListener("click", closeSubMenuActionChild1);
// console.log(openSubMenuChild1)

function openSubMenuActionChild1() {
    closeSubMenu.classList.add("remove-back-menu-btn") //display none back btn 1
    subMenuChild1.classList.add("sub-child-menu-active") // show sub menu child 1
    closeSubMenuChild1.classList.add("back-menu-btn-active") // show back btn 2

}

function closeSubMenuActionChild1() {
    closeSubMenuChild1.classList.remove("back-menu-btn-active")
    closeSubMenu.classList.remove("remove-back-menu-btn") //display block back btn 1
    subMenuChild1.classList.remove("sub-child-menu-active")
}

// sub menu child 2

// const subMenuChild2 = document.querySelector(".menu-mobile-list .parent-sub-menu-2 .sub-menu")
// const openSubMenuChild2 = document.querySelector(".menu-mobile-list .parent-sub-menu-2")
// openSubMenuChild2.addEventListener("click", openSubMenuActionChild2)
// const closeSubMenuChild2 = document.querySelector(".back-menu-btn-2")
// closeSubMenuChild2.addEventListener('click', closeSubMenuActionChild2)

// function openSubMenuActionChild2() {
//     closeSubMenu.classList.add("remove-back-menu-btn") //display none back btn 1
//     subMenuChild2.classList.add("sub-child-menu-active") // show sub menu child 2
//     closeSubMenuChild2.classList.add("back-menu-btn-active") // show back btn 2

// }


// function closeSubMenuActionChild2() {
//     closeSubMenuChild2.classList.remove("back-menu-btn-active")
//     closeSubMenu.classList.remove("remove-back-menu-btn") //display block back btn 1
//     subMenuChild2.classList.remove("sub-child-menu-active")
// }

// sub menu child 3

const subMenuChild3 = document.querySelector(".menu-mobile-list .parent-sub-menu-3 .sub-menu")
const openSubMenuChild3 = document.querySelector(".menu-mobile-list .parent-sub-menu-3")
openSubMenuChild3.addEventListener("click", openSubMenuActionChild3)
const closeSubMenuChild3 = document.querySelector(".back-menu-btn-2")
closeSubMenuChild3.addEventListener('click', closeSubMenuActionChild3)

function openSubMenuActionChild3() {
    closeSubMenu.classList.add("remove-back-menu-btn") //display none back btn 1
    subMenuChild3.classList.add("sub-child-menu-active") // show sub menu child 2
    closeSubMenuChild3.classList.add("back-menu-btn-active") // show back btn 2

}


function closeSubMenuActionChild3() {
    closeSubMenuChild3.classList.remove("back-menu-btn-active")
    closeSubMenu.classList.remove("remove-back-menu-btn") //display block back btn 1
    subMenuChild3.classList.remove("sub-child-menu-active")
}
// sub menu child 4

const subMenuChild4 = document.querySelector(".menu-mobile-list .parent-sub-menu-4 .sub-menu")
const openSubMenuChild4 = document.querySelector(".menu-mobile-list .parent-sub-menu-4")
openSubMenuChild4.addEventListener("click", openSubMenuActionChild4)
const closeSubMenuChild4 = document.querySelector(".back-menu-btn-2")
closeSubMenuChild4.addEventListener('click', closeSubMenuActionChild4)

function openSubMenuActionChild4() {
    closeSubMenu.classList.add("remove-back-menu-btn") //display none back btn 1
    subMenuChild4.classList.add("sub-child-menu-active") // show sub menu child 2
    closeSubMenuChild4.classList.add("back-menu-btn-active") // show back btn 2

}


function closeSubMenuActionChild4() {
    closeSubMenuChild4.classList.remove("back-menu-btn-active")
    closeSubMenu.classList.remove("remove-back-menu-btn") //display block back btn 1
    subMenuChild4.classList.remove("sub-child-menu-active")
}


// sub menu parent 2
const subMenuConent2 = document.querySelector(".menu-mobile-list .parent-2 .sub-menu")
const openSubMenu2 = document.querySelector(".menu-mobile-list .parent-2")


openSubMenu2.addEventListener('click', openSubMenuAction2);

function openSubMenuAction2() {
    subMenuConent2.classList.add("sub-menu-active")
    closeSubMenu.classList.add("back-menu-btn-active")
}
const closeSubMenu2 = document.querySelector(".back-menu-btn-1")
closeSubMenu2.addEventListener("click", closeSubMenuAction2);


function closeSubMenuAction2() {
    subMenuConent2.classList.remove("sub-menu-active")
    closeSubMenu.classList.remove("back-menu-btn-active")

}



// sub menu parent 3
const subMenuConent3 = document.querySelector(".menu-mobile-list .parent-3 .sub-menu")
const openSubMenu3 = document.querySelector(".menu-mobile-list .parent-3")


openSubMenu3.addEventListener('click', openSubMenuAction3);

function openSubMenuAction3() {
    subMenuConent3.classList.add("sub-menu-active")
    closeSubMenu.classList.add("back-menu-btn-active")
}
const closeSubMenu3 = document.querySelector(".back-menu-btn-1")
closeSubMenu3.addEventListener("click", closeSubMenuAction3);


function closeSubMenuAction3() {
    subMenuConent3.classList.remove("sub-menu-active")
    closeSubMenu.classList.remove("back-menu-btn-active")

}






// header-desktop scroll up and down

var lastScrollTop = 0;

window.addEventListener("scroll", function() {
    var st = window.pageYOffset || document.documentElement.scrollTop;
    if (st > lastScrollTop) {
        document.querySelector(".header-desktop").style.top = "-100px";
    } else {
        document.querySelector(".header-desktop").style.top = "0%";
    }
    lastScrollTop = st;
}, false);

var lastScrollTopMobile = 0;
// header-mobile scroll up and down


window.addEventListener("scroll", function() {
    var st = window.pageYOffset || document.documentElement.scrollTop;
    if (st > lastScrollTopMobile) {
        document.querySelector(".header-mobile").style.top = "-100px";
    } else {
        document.querySelector(".header-mobile").style.top = "0%";
    }
    lastScrollTopMobile = st;
}, false);




var menuContent = document.querySelector(".menu-mobile-content")

var openMenuContent = document.querySelector(".menu-mobile-btn")
openMenuContent.addEventListener("click", openMenuContentAction)

function openMenuContentAction() {
    menuContent.classList.add("menu-mobile-content-active")
}

var closeMenuContent = document.querySelector(".close-menu-btn")
closeMenuContent.addEventListener("click", closeMenuContentAction)

function closeMenuContentAction() {
    menuContent.classList.remove("menu-mobile-content-active")

}





var openCartMenuMobile = document.querySelector('.header-mobile .cart-btn')
var cartMenu = document.querySelector('.xoo-wsc-modal')

console.log(openCartMenuMobile)
openCartMenuMobile.addEventListener('click', openMenuMobile)

function openMenuMobile() {
    cartMenu.classList.toggle("xoo-wsc-cart-active")
        // console.log(cartMenu)
}