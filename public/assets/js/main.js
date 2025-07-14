(function ($) {
  "use strict";

  // Sticky Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 150) {
      $(".nav-bar").addClass("nav-sticky");
    } else {
      $(".nav-bar").removeClass("nav-sticky");
    }
  });

  // Dropdown on mouse hover
  $(document).ready(function () {
    function toggleNavbarMethod() {
      if ($(window).width() > 768) {
        $(".navbar .dropdown")
          .on("mouseover", function () {
            $(".dropdown-toggle", this).trigger("click");
          })
          .on("mouseout", function () {
            $(".dropdown-toggle", this).trigger("click").blur();
          });
      } else {
        $(".navbar .dropdown").off("mouseover").off("mouseout");
      }
    }
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Top News Slider
  $(".tn-slider").slick({
    autoplay: true,
    infinite: true,
    dots: false,
    slidesToShow: 1,
    slidesToScroll: 1,
  });

  // Dynamic Category News Sliders
  $(".cn-slider").each(function (index) {
    const $slider = $(this);
    $slider.addClass(`cn-slider-${index}`); // إضافة class فريد لكل سلايدر

    $slider.slick({
      autoplay: false,
      infinite: true,
      dots: false,
      slidesToShow: 2,
      slidesToScroll: 1,
      responsive: [
        { breakpoint: 1200, settings: { slidesToShow: 2 } },
        { breakpoint: 992, settings: { slidesToShow: 1 } },
        { breakpoint: 768, settings: { slidesToShow: 2 } },
        { breakpoint: 576, settings: { slidesToShow: 1 } },
      ],
    });

    $(`.cn-prev-${index}`).click(function () {
      $slider.slick("slickPrev");
    });

    $(`.cn-next-${index}`).click(function () {
      $slider.slick("slickNext");
    });
  });

  // Related News Slider
  $(".sn-slider").slick({
    autoplay: false,
    infinite: true,
    dots: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      { breakpoint: 1200, settings: { slidesToShow: 2 } },
      { breakpoint: 768, settings: { slidesToShow: 1 } },
    ],
  });

  $(".sn-prev").click(function () {
    $(".sn-slider").slick("slickPrev");
  });

  $(".sn-next").click(function () {
    $(".sn-slider").slick("slickNext");
  });
})(jQuery);
