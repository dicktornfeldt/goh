import $ from "jquery";
import "jquery-serializejson";

export default {
  init() {
    /**
     * Toggle application form
     */
    $(".js-show-form").on("click", function(e) {
      e.preventDefault();
      $(this)
        .next(".Form")
        .toggleClass("show");
    });

    /**
     * Submit application form
     */
    $(".ajax-send-application").on("submit", function(e) {
      e.preventDefault();
      var form = $(this);
      var data = form.serializeJSON();

      $.ajax({
        method: "post",
        url: ajaxurl,
        data: data,
        beforeSend: function() {
          $("body").addClass("Loading");
        },
        success: function(response) {
          $(form).removeClass("show");
          $("body").removeClass("Loading");
          if (response.message == "app_exists") {
            alert("Vi har redan tagit emot en ansökan från dig.");
          }
          if (response.message == "success") {
            alert("Tack för din ansökan, vi har av oss!");
          }
        },
        error: function() {
          $("body").removeClass("Loading");
          alert("Hopssan, nåt gick fel.");
        }
      });
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  }
};
