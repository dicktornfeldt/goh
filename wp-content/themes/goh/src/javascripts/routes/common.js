import $ from "jquery";

export default {
  init() {
    $(".js-anchorlink").click(function() {
      var aid = $(this).attr("href");
      $("html,body").animate({ scrollTop: $(aid).offset().top }, "slow");
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
