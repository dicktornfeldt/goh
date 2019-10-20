import $ from "jquery";

export default {
  init() {
    $(".js-anchorlink").click(function(e) {
      var aid = $(this).attr("href");
      if (window.location.pathname == "/") {
        e.preventDefault();
        aid = aid.replace(/\//g, "");
      }
      $("html,body").animate({ scrollTop: $(aid).offset().top }, "slow");
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
          alert("Hoppsan, nåt gick fel, säg till D.");
        }
      });
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
