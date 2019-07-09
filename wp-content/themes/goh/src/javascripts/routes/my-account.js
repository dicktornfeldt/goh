import $ from "jquery";
import "jquery-serializejson";

export default {
  init() {
    /**
     * Update user account
     */
    $(".ajax-update-user").on("submit", function(e) {
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
          window.location.reload();
        },
        error: function() {
          $("body").removeClass("Loading");
          alert("Hopssan, nåt gick fel.");
        }
      });
    });
  },
  finalize() {
    // JavaScript to be fired on the about page, after the init JS
    console.log("about finalize");
  }
};
