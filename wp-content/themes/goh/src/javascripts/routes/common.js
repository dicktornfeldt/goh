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
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
