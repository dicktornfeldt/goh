import $ from "jquery";
import "jquery-serializejson";

export default {
  init() {
    /**
     * Toggle raid attendance
     */
    $(".js-show-attendance").on("click", function(e) {
      e.preventDefault();
      console.log("test");

      $(this)
        .parent()
        .find(".RaidCard__roster")
        .toggleClass("show");
    });

    /**
     * Set raid attendance
     */
    $(".ajax-set-attendance").on("change", function(e) {
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
          if (response.message == "already_signed") {
            alert(
              "Hur horde är du egentligen!? Du har redan sagt att du kommer till denna raid!"
            );
          }
          if (response.message == "signed") {
            alert("Börja göra dig horde, vi väntar!");
          }
          if (response.message == "not_signed") {
            alert("Okej okej, kanske nästa raid?");
          }
          if (response.message == "removed") {
            alert("Okej okej, kanske nästa raid?");
          }
          window.location.reload();
        },
        error: function() {
          $("body").removeClass("Loading");
          alert("Hoppsan, nåt gick fel, säg till D.");
        }
      });
    });
  },
  finalize() {
    // JavaScript to be fired on the about page, after the init JS
  }
};
