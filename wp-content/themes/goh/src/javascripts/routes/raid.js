import $ from "jquery";
import "jquery-serializejson";

export default {
  init() {
    /**
     * Toggle raid attendance
     */
    $(".js-show-attendance").on("click", function(e) {
      e.preventDefault();
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
          var alerted = false;
          if (response.message == "signed") {
            alerted = true;
            alert("Börja göra dig horde, vi väntar!");
            window.location.reload();
          }
          if (response.message == "removed") {
            alerted = true;
            alert("Okej okej, kanske nästa raid?");
            window.location.reload();
          }
          if (!alerted) {
            alert("Du har uppdaterat din närvaro");
            window.location.reload();
          }
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
