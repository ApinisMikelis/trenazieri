// Single product promo video

function playSingleProductVideo(videoId, thumbnailId) {
  var iframe = document.getElementById(videoId);
  var thumbnail = document.getElementById(thumbnailId);
  var src = iframe.src;

  thumbnail.style.display = "none";
  iframe.style.display = "block";

  if (!src.includes("autoplay=1")) {
    iframe.src = src += "?autoplay=1";
  }
}

// Sliders

jQuery(window).on("load", function () {
  if (jQuery(".tre-products-slider").length) {
    document
      .querySelectorAll(".tre-products-slider .slider")
      .forEach((slider) => {
        tns({
          mode: "carousel",
          loop: false,
          rewind: false,
          speed: 350,
          container: slider,
          // items: 6,
          slideBy: 1,
          autoplay: false,
          autoplayHoverPause: false,
          autoplayButtonOutput: false,
          autoplayTimeout: 4000,
          controls: true,
          controlsPosition: "top",
          nav: false,
          navAsThumbnails: false,
          autoHeight: false,
          autoWidth: true,
          preventActionWhenRunning: false,
          mouseDrag: false,
          lazyload: false,
        });
      });
  }

  if (jQuery(".tre-brands-slider").length) {
    document
      .querySelectorAll(".tre-brands-slider .slider")
      .forEach((slider) => {
        tns({
          mode: "carousel",
          loop: true,
          rewind: false,
          speed: 850,
          container: slider,
          items: 1,
          slideBy: 1,
          autoplay: true,
          autoplayHoverPause: true,
          autoplayButtonOutput: false,
          autoplayTimeout: 3000,
          controls: false,
          controlsPosition: "top",
          nav: false,
          navAsThumbnails: false,
          autoHeight: false,
          autoWidth: false,
          preventActionWhenRunning: false,
          mouseDrag: false,
          lazyload: false,
          onInit: showBrandsSlider(),
        });
      });

    function showBrandsSlider() {
      jQuery(".tre-brands-slider").addClass("is-visible");
    }
  }
});

jQuery(window).on("load scroll", function () {
  winScrollTop = jQuery(window).scrollTop();
  parallax();
});

var winScrollTop = 0;

jQuery.fn.isInViewport = function () {
  var elementTop = jQuery(this).offset().top;
  var elementBottom = elementTop + jQuery(this).outerHeight();
  var viewportTop = jQuery(window).scrollTop();
  var viewportBottom = viewportTop + jQuery(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};

function parallax() {
  jQuery(".tre-shortcuts").each(function () {
    if (jQuery(this).isInViewport()) {
      var firstTop = jQuery(this).offset().top;
      var bg = jQuery(this).find(".bg");
      var speed = (firstTop - winScrollTop) * 0.08;
      bg.css({
        transform: "translateY(" + speed + "px)",
      });
    }
  });
}

// Menu hover delay

jQuery(document).ready(function () {
  jQuery(".tre-header .inner > .menu ul > li").hover(
    function () {
      var $this = jQuery(this);
      timeout = setTimeout(function () {
        $this.addClass("has-hover");
      }, 200);
    },
    function () {
      clearTimeout(timeout);
      jQuery(this).removeClass("has-hover");
    },
  );
});

// Header search

jQuery(document).ready(function () {
  jQuery(
    ".tre-header .top-bar .inner .search .icon, .tre-header .top-bar .inner .search .dropdown button.is-close",
  ).on("click", function (e) {
    e.preventDefault();
    jQuery(".tre-header .top-bar .inner .search").addClass("is-visible");
    jQuery(".tre-header .top-bar .inner .search").addClass("has-full-width");
  });

  jQuery(".tre-header .top-bar .inner .search .dropdown button.is-close").on(
    "click",
    function (e) {
      e.preventDefault();
      jQuery(".tre-header .top-bar .inner .search").removeClass("is-visible");
      setTimeout(function () {
        jQuery(".tre-header .top-bar .inner .search").removeClass(
          "has-full-width",
        );
      }, 150);
    },
  );

  jQuery(document).on("keydown", function (event) {
    if (event.key == "Escape") {
      jQuery(".tre-header .top-bar .inner .search").removeClass("is-visible");
      setTimeout(function () {
        jQuery(".tre-header .top-bar .inner .search").removeClass(
          "has-full-width",
        );
      }, 150);
    }
  });
});

jQuery(document).ready(function () {
  var accordions = document.getElementsByClassName("accordion-trigger");

  for (var i = 0; i < accordions.length; i++) {
    accordions[i].onclick = function () {
      this.classList.toggle("is-open");

      var content = this.nextElementSibling;

      if (content.style.maxHeight) {
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      }
    };
  }

  var accordionsList = jQuery(".tre-accordion");

  accordionsList.each(function () {
    jQuery(this).on("click", function (e) {
      e.preventDefault();

      var $this = jQuery(this);

      $this.siblings().find(".accordion-trigger").removeClass("is-open");
      $this.siblings().find(".accordion-content").removeAttr("style");
    });
  });
});

jQuery(window).on("load", function () {
  jQuery(
    '<div class="quantity-nav"><div class="quantity-button quantity-up"></div><div class="quantity-button quantity-down"></div></div>',
  ).insertAfter(".tre-quantity input");

  jQuery(".tre-quantity").each(function () {
    var spinner = jQuery(this),
      input = spinner.find('input[type="number"]'),
      btnUp = spinner.find(".quantity-up"),
      btnDown = spinner.find(".quantity-down"),
      min = input.attr("min"),
      max = input.attr("max");

    if (max === "") {
      max = 999;
    }

    btnUp.click(function () {
      if (input.val() === "") {
        var oldValue = 0;
      } else {
        var oldValue = parseFloat(input.val());
      }

      if (oldValue >= max) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue + 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });

    btnDown.click(function () {
      var oldValue = parseFloat(input.val());
      if (oldValue <= min) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue - 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });
  });
});

jQuery(window).on("load", function () {
  jQuery(
    ".tre-main > .inner > table, figure table, .wp-block-table table",
  ).wrap(
    "<div class='tre-table-wrapper'><div class='inner-wrapper'></div></div>",
  );
});
