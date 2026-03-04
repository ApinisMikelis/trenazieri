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
          slideBy: 1,
          autoplay: false,
          controls: true,
          controlsPosition: "top",
          nav: false,
          autoWidth: true,
          mouseDrag: false,
        });
      });
  }

  if (jQuery(".tre-brands-slider").length) {
    function showBrandsSlider() {
      jQuery(".tre-brands-slider").addClass("is-visible");
    }

    document
      .querySelectorAll(".tre-brands-slider .slider")
      .forEach((slider) => {
        tns({
          mode: "carousel",
          loop: true,
          speed: 850,
          container: slider,
          items: 1,
          slideBy: 1,
          autoplay: true,
          autoplayTimeout: 3000,
          controls: false,
          nav: false,
          onInit: showBrandsSlider, // FIXED: Removed parentheses
        });
      });
  }
});

// Parallax & Scroll
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
      bg.css({ transform: "translateY(" + speed + "px)" });
    }
  });
}

jQuery(window).on("load scroll", function () {
  winScrollTop = jQuery(window).scrollTop();
  parallax();
});

// Menu hover delay
jQuery(document).ready(function () {
  var menuTimeout; // FIXED: Declared locally
  jQuery(".tre-header .inner > .menu ul > li").hover(
    function () {
      var $this = jQuery(this);
      menuTimeout = setTimeout(function () {
        $this.addClass("has-hover");
      }, 200);
    },
    function () {
      clearTimeout(menuTimeout);
      jQuery(this).removeClass("has-hover");
    },
  );
});

// Header search
jQuery(document).ready(function () {
  // Desktop search
  jQuery(".tre-header .top-bar .inner .search .icon").on("click", function (e) {
    e.preventDefault();
    jQuery(".tre-header .top-bar .inner .search").addClass(
      "is-visible has-full-width",
    );
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

  // Mobile search
  jQuery(".tre-header-mobile .search .icon").on("click", function (e) {
    e.preventDefault();
    jQuery(".tre-header-mobile .search").addClass("is-visible has-full-width");
  });

  jQuery(".tre-header-mobile .search .dropdown button.is-close").on(
    "click",
    function (e) {
      e.preventDefault();
      jQuery(".tre-header-mobile .search").removeClass("is-visible");
      setTimeout(function () {
        jQuery(".tre-header-mobile .search").removeClass("has-full-width");
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
      jQuery(".tre-header-mobile .search").removeClass("is-visible");
      setTimeout(function () {
        jQuery(".tre-header-mobile .search").removeClass("has-full-width");
      }, 150);
    }
  });
});

// Mobile menu
jQuery(document).ready(function () {
  jQuery(".tre-mobile-menu-trigger").on("click", function (e) {
    e.preventDefault();
    jQuery("body").toggleClass("is-menu-visible");
  });
});

// Accordions
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

  jQuery(".tre-accordion").on("click", function (e) {
    var $this = jQuery(this);
    $this.siblings().find(".accordion-trigger").removeClass("is-open");
    $this.siblings().find(".accordion-content").removeAttr("style");
  });
});

// WooCommerce Logic: Variations & Quantity
jQuery(document).ready(function ($) {
  function initVariationsSelect2() {
    $(".variations select").each(function () {
      // FIXED: Only initialize if it's not already Select2
      if (!$(this).hasClass("select2-hidden-accessible")) {
        $(this).select2({
          minimumResultsForSearch: Infinity,
          width: "100%",
        });
      }
    });
  }

  // Fix for Select2 closing immediately on mouseup
  $(document).on("mousedown", ".select2-selection", function (e) {
    // This prevents the theme/WooCommerce from seeing the click
    // and triggering a "blur" or "close" action.
    e.stopPropagation();
  });

  // Force Select2 to stay open by preventing the 'blur' event
  // from being triggered by parent containers
  $(document).on("select2:opening", function (e) {
    var $select = $(e.target);
    if ($select.parents(".variations").length) {
      // Specifically for your variation dropdowns
      console.log("Opening variation dropdown...");
    }
  });

  function setupQuantityNav() {
    $(".tre-quantity").each(function () {
      var $container = $(this);
      var $input = $container.find("input.qty");

      // Handle hidden inputs (stock = 1)
      if ($input.attr("type") === "hidden" || $input.attr("max") == 1) {
        $container.find(".quantity-nav").remove();
        return;
      }

      if ($container.find(".quantity-nav").length === 0) {
        $(
          '<div class="quantity-nav"><div class="quantity-button quantity-up"></div><div class="quantity-button quantity-down"></div></div>',
        ).insertAfter($input);
      }

      var $btnUp = $container.find(".quantity-up");
      var $btnDown = $container.find(".quantity-down");
      var min = parseFloat($input.attr("min")) || 1;
      var max = parseFloat($input.attr("max")) || 999;

      $btnUp.off("click").on("click", function () {
        var oldValue = parseFloat($input.val()) || 0;
        var newVal = oldValue >= max ? oldValue : oldValue + 1;
        $input.val(newVal).trigger("change");
      });

      $btnDown.off("click").on("click", function () {
        var oldValue = parseFloat($input.val()) || 0;
        var newVal = oldValue <= min ? oldValue : oldValue - 1;
        $input.val(newVal).trigger("change");
      });
    });
  }

  initVariationsSelect2();
  setupQuantityNav();

  $(document.body).on(
    "woocommerce_variation_has_changed updated_wc_div",
    function () {
      initVariationsSelect2();
      setupQuantityNav();
    },
  );
});

// Table Wrappers
jQuery(window).on("load", function () {
  jQuery(
    ".tre-main > .inner > table, figure table, .wp-block-table table",
  ).wrap(
    "<div class='tre-table-wrapper'><div class='inner-wrapper'></div></div>",
  );
});
