document.addEventListener("DOMContentLoaded", function () {
  // Select the form
  const newsletterForm = document.getElementById("mc-newsletter");
  const ajaxurl = born_data.admin_ajax;

  if (!newsletterForm) {
    return;
  }

  // Add a submit event listener to the form
  newsletterForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "mc_subscribe",
        data: {
          email: jQuery("#email").val(),
        },
      },
      success: function (msg) {
        jQuery("#mc-newsletter").addClass("is-success");

        jQuery("#email").val("");
        jQuery(".mc-success").show();
      },
      error: function (msg) {
        console.log("err");
      },
    });
  });
});
