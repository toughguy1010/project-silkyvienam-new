// A $( document ).ready() block.
jQuery(document).ready(function() {
    console.log("ready!");
    // cartToggleMenu
    var openCartMenu = document.querySelector('.cart-btn')
    var cartMenu = document.querySelector('.xoo-wsc-modal')

    // console.log(openCartMenu)
    openCartMenu.addEventListener('click', openMenu)

    function openMenu() {
        cartMenu.classList.toggle("xoo-wsc-cart-active")
            // console.log(cartMenu)
    }
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
        // console.log(woofAutoShowIndentContainer)

    function showWoofOverflow() {
        woofAutoShowContainer.classList.toggle("woof-active");
        filterContainer.classList.toggle("filter-section-active")
        activeFilterArrowBtn.classList.toggle("active_filter_arrow_btn")
        woofAutoShowContainer.classList.toggle("woof_overflow_hidden");
        woofAutoShowIndentContainer.classList.toggle("woof_overflow_hidden");


    }
    // activeFilterBtn.removeEventListener("click", activeFilterContent)
    // activeFilterBtn.addEventListener("click", removeshowautoform)

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
    var sortingBtn = document.querySelector(".dropdown-toggle");
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

    function openSortMenu() {

        sortingFields.classList.toggle("show");
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
jQuery(document).ready(function() {

    const subMenuConent = document.querySelector(".menu-mobile-list .sub-menu")
    const openSubMenu = document.querySelector(".menu-mobile-list .parent-1")


    openSubMenu.addEventListener('click', openSubMenuAction);

    function openSubMenuAction() {
        subMenuConent.classList.add("sub-menu-active")

    }

    var closeSubMenu = document.querySelector(".back-menu-btn")
    closeSubMenu.addEventListener("click", closeSubMenuAction);

    function closeSubMenuAction() {
        subMenuConent.classList.remove("sub-menu-active")
    }

});

// $(document).ready(function() {
//     console.log(3)




//     if (openSubMenu) {
//         openSubMenu.addEventListener('click', openSubMenuAction);

//         function openSubMenuAction() {

//             subMenuConent.classList.add("sub-menu-active")

//         }
//         console.log(2)
//     }

//     var closeSubMenu = document.querySelector(".back-menu-btn")
//     closeSubMenu.addEventListener("click", closeSubMenuAction);

//     function closeSubMenuAction() {
//         subMenuConent.classList.remove("sub-menu-active")
//     }
//     console.log(openSubMenu)
//     console.log(subMenuConent)
// });
// var prevScrollpos = window.pageYOffset;
// window.onscroll = function() {
//     var currentScrollpos = window.pageYOffset;
//     if (prevScrollpos > currentScrollpos) {
//         document.querySelector(".header-section").style.top = "0px";
//     } else {
//         document.querySelector(".header-section").style.top = "-100px";
//     }
//     prevScrollpos = currentScrollPos;
// }

// console.log(document.querySelector(".header-section"))


var lastScrollTop = 0;

window.addEventListener("scroll", function() {
    var st = window.pageYOffset || document.documentElement.scrollTop;
    if (st > lastScrollTop) {
        document.querySelector(".header-section").style.top = "-100px";
    } else {
        document.querySelector(".header-section").style.top = "0%";
    }
    lastScrollTop = st;
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


// submenu-action

var subMenuConent = document.querySelector(".sub-menu")

var openSubMenu = document.querySelector(".parent-1")


if (openSubMenu) {
    openSubMenu.addEventListener('click', openSubMenuAction);

    function openSubMenuAction() {

        subMenuConent.classList.add("sub-menu-active")
        console.log(22)

    }
    console.log(2)
}

var closeSubMenu = document.querySelector(".back-menu-btn")
closeSubMenu.addEventListener("click", closeSubMenuAction);

function closeSubMenuAction() {
    subMenuConent.classList.remove("sub-menu-active")
}
// console.log(openSubMenu)
// console.log(subMenuConent)




// submenu-action