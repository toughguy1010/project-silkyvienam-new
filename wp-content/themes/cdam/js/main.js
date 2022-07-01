jQuery(function($) {

  if ($('#back-home').length > 0) {

    if ($(window).width() < 1280) {


      if ($('#Rectangle_1706').length > 0) {

        // var position = document.getElementById('back-home').getBoundingClientRect();
        // var top = position.top;
        // var bottom = position.top + position.height;

        // var shop_ui = document.getElementById('Path_4910').getBoundingClientRect();
        // var about_ui = document.getElementById('Rectangle_1746').getBoundingClientRect();
        // var collection_ui = document.getElementById('Rectangle_1699').getBoundingClientRect();
        // var stockist_ui = document.getElementById('Path_5284').getBoundingClientRect();
        // var contact_ui = document.getElementById('Path_5284').getBoundingClientRect();

        var position = $('#back-home').offset();
        var back_home_w = $('#back-home').width();
        var shop_ui = $('#Path_4910');
        var shop_ui_offset = $('#Path_4910').offset();
        var about_ui = $('#Rectangle_1746');
        var about_ui_offset = $('#Rectangle_1746').offset();
        var collection_ui = $('#Group_1212');
        var collection_ui_offset = $('#Group_1212').offset();
        var stockist_ui = $('#Path_5284');
        var stockist_ui_offset = $('#Path_5284').offset();
        var contact_ui = $('#Rectangle_1692');
        var contact_ui_offset = $('#Rectangle_1692').offset();
        var magazine_ui = $('#Path_4651');
        var magazine_ui_offset = $('#Path_4651').offset();

        $('#home-menu-shop').css({
          'top': shop_ui_offset.top,
          'left': back_home_w + position.left - ($('#home-menu-shop').width() / 2) + 20
        });
        $('#home-menu-about').css({
          'top': about_ui_offset.top + (about_ui.height() / 2),
          'left': back_home_w + position.left - ($('#home-menu-shop').width() / 2) + 20
        });

        $('#home-menu-collection').css({
          'top': collection_ui_offset.top,
          'left': position.left - ($('#home-menu-collection').width() / 2) - 20
        });
        $('#home-menu-stockist').css({
          'top': stockist_ui_offset.top - ($('#home-menu-stockist').height() * 2),
          'left': position.left - ($('#home-menu-collection').width() / 2) - 20
        });
        $('#home-menu-contact').css({
          'top': contact_ui_offset.top + contact_ui.height(),
          'left': position.left - ($('#home-menu-collection').width() / 2) - 20
        });
        $('#home-menu-magazine').css({
          'top': magazine_ui_offset.top + magazine_ui.height(),
          'left': back_home_w + position.left - ($('#home-menu-magazine').width() / 2) + 20
        });
      }

    }
  }

  window.menu_position = function menu_position() {
    $(document).find('#main-home').find('.home-menu').each(function(index) {
      if ($('#' + $(this).data('position')).length > 0) {
        var position = $('#' + $(this).data('position'));
        var position_offset = $('#' + $(this).data('position')).offset();
        var position_bound = document.getElementById($(this).data('position')).getBoundingClientRect();

        if ($(this).data('position') == 'home-shop') {
          $(this).css({
            top: position_offset.top,
            left: position_offset.left + position_bound.width
          });
        } else if ($(this).data('position') == 'home-collection') {
          $(this).css({
            top: position_offset.top,
            left: position_offset.left + position_bound.width
          });
        } else {
          $(this).css({
            top: '-200vh',
            left: '-200vw'
          });
        }
      }
    });
  }

  menu_position();

  $(window).resize(function(e) {
    menu_position();
  });

  window.onorientationchange = function(event) {
    location.reload();
  };

  $(document).find('#main-home').find('.fixed-menu').on('click', function() {
    if ($(this).data('url') != '#') {
      window.location.href = $(this).data('url');
    }
  });

  $(document).find('#main-home').find('.fixed-menu').hover(
    function() {
      $('#' + $(this).data('subcat')).addClass('show');
    },
    function() {
      $('#' + $(this).data('subcat')).removeClass('show');
    }
  );

  $(document).find('#main-home').find('.home-menu').hover(
    function() {
      $(this).addClass('show');
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('.fixed-menu').css({
        fill: '#000',
        stroke: '#000',
      });
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('text').css({
        stroke: '#fff',
        fill: '#fff',
      });
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('.home-line').css({
        stroke: '#000',
        opacity: '1',
      });
    },
    function() {
      $(this).removeClass('show');
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('.fixed-menu').css({
        fill: '#fff',
        stroke: '#000',
      });
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('text').css({
        stroke: '#000',
        fill: '#000',
      });
      $(document).find('#main-home').find('#' + $(this).data('position')).parent().find('.home-line').css({
        stroke: '#fff',
        opacity: '0',
      });
    }
  );
  // $(document).find('#main-home').find('*[id^="home-wrap-"]').hover(
  //   function() {
  //     $(this).addClass('hover');
  //   },
  //   function() {
  //     $(this).removeClass('hover');
  //   }
  // );

  if ($(window).width() < 769) {
    if ($('.zwc-product-recommended').length > 0) {
      $('.zwc-product-recommended').find('.products').not('.slick-initialized').slick({
        infinite: false,
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        centerMode: false,
        // centerPadding: "60px",
        autoplayspeed: 1000,
        // variableWidth: true,
        // initialSlide: 1,
        vertical: false, //* trượt dọc *//
      });
    }

    if ($('.zwc-custom-thumbnail').length > 0) {
      $('.zwc-custom-thumbnail').not('.slick-initialized').slick({
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        centerMode: false,
        // centerPadding: "60px",
        autoplayspeed: 1000,
        // variableWidth: true,
        // initialSlide: 1,
        vertical: false, //* trượt dọc *//
      });
    }
  }

  function menu_click() {
    $(document).find('#btnz').on('click', function() {
      if (!$(document).find('#btnz').hasClass('change')) {
        $('#btnz').addClass('change');
        $('.nav-menu').addClass('open');
      } else {
        $('#btnz').removeClass('change');
        $('.nav-menu').removeClass('open');
      }
    });
  }

  $(document).mouseup(function(e) {
    var container = $(".nav-menu");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $('#btnz').removeClass('change');
      $('.nav-menu').removeClass('open');
    }

    var container2 = $("#cart-popup");
    if (!container2.is(e.target) && container2.has(e.target).length === 0) {
      $('#cart-popup').removeClass('show');
    }

    var container3 = $("#menu-search");
    if (!container3.is(e.target) && container3.has(e.target).length === 0) {
      $('#menu-search').removeClass('show');
    }
  });

  $(document).find('#btnz').on('click', function() {
    if (!$(document).find('#btnz').hasClass('change')) {
      $('#btnz').addClass('change');
      $('.nav-menu').addClass('open');
      menu_click();
    } else {
      $('#btnz').removeClass('change');
      $('.nav-menu').removeClass('open');
      menu_click();
    }
  });

  if ($('.zwc-custom-thumbnail').length > 0) {
    $(document).find('.zwc-custom-thumbnail').on('click', '.zoom-img', function() {
      $(this).parent().toggleClass('fullscreen');
    });

    $(document).find('.zwc-custom-thumbnail').next().next('.zoom-back').on('click', function() {
      $(this).prev().prev().toggleClass('fullscreen');
    });

    $(window).scroll(function() {
      var point = $(document).find('.zwc-custom-thumbnail').height();
      var pos = $(document).find('.zwc-custom-thumbnail').offset().top;
      if ($(this).scrollTop() > pos) {
        $(document).find('.zwc-custom-thumbnail').next('img.scroll').addClass('miss')
      } else {
        $(document).find('.zwc-custom-thumbnail').next('img.scroll').removeClass('miss')
      }
    });

  }

  // if ($(window).width() < 1024) {
  var lastScrollTop = 0;
  window.addEventListener("scroll", function() {
    var st = window.pageYOffset || document.documentElement.scrollTop;
    if (st > lastScrollTop) {
      $('#masthead').css({
        'top': '-200px'
      });
    } else {
      $('#masthead').css({
        'top': '0'
      });
    }
    if (st == 0) {
      $('#masthead').removeClass('back-white');
    } else {
      $('#masthead').addClass('back-white');
    }
    lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
  }, false);
  // }

  $(document).find(".languages").hover(
    function() {
      $(this).addClass("extend");
    },
    function() {
      $(this).removeClass("extend");
    }
  );

  $(document).find(".extend-menu").on('click', function() {
    $(this).parent().find('.home-sub-item-menu').toggle('fast');
    $(this).toggleClass('extend');
  });

  $(document).find(".nav-menu-nav, .nav-menu-meta").find('.has-child > a').on('click', function() {
    $(this).parent().find('.home-sub-item-menu').toggle('fast');
    $(this).parent().find('.extend-menu').toggleClass('extend');
  });

  $(document).find(".size-chart").on('click', function() {
    $('#size-chart').addClass('show');
    $(document).find('.zwc-custom-thumbnail').addClass('customize');
  });

  $(document).find("#size-chart").on('click', '.close', function() {
    $('#size-chart').removeClass('show');
    $(document).find('.zwc-custom-thumbnail').removeClass('customize');
  });

  $(document).find("#masthead").on('click', '.menu-search', function() {
    $('#menu-search').addClass("show");
  });

  $(document).find("#menu-search").on('click', '.close', function() {
    $('#menu-search').removeClass('show');
  });

  // $(window).bind('load',function(){
  // $('#loading-image-category').addClass('show');
  //
  // setInterval(function() {
  //   $('#loading-image-category').removeClass('show');
  // }, 3000);

  // });

  $(".product").hover(
    function() {
      $(this).addClass("hover");
    },
    function() {
      $(this).removeClass("hover");
    }
  );

  $('.btn-scroll-top').on('click', function() {
    $('html, body').animate({
      scrollTop: 0
    }, 1000);
  });

  function show_date_select() {
    var d = new Date();
    var n = d.getFullYear();
    selectBirthday("#signup-year", "#signup-month", "#signup-day", {
      month: 1,
      day: 1,
      yearRange: 200,
      endYear: n
    });
  }

  if ($('#wrap-brithday').length > 0) {
    var cnt = 0;
    document.getElementById('wrap-brithday').addEventListener('click', function() {
      if (cnt < 1) {
        show_date_select();
      }
      cnt++;
    });
  }

  $(document).find('.magazine-hover').on('mouseover',function(){
    $(document).find('.show-magazine-hover').find('img').attr('src',$(this).data('fetimage'));
  });

  $(document).find('.home-sub-item-menu-item').each(function(index) {
    if ($(this).hasClass('active')) {
      $(this).parent().parent().addClass('active');
    }
  });

  Fancybox.bind("[data-fancybox]", {
    Html: {
      video: {
        autoplay: false,
        ratio: 16 / 9,
      },
    },
  });

});
