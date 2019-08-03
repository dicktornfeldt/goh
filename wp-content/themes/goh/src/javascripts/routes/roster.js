import $ from "jquery";
import List from "list.js";

export default {
  init() {
    var options = {
      valueNames: ["raiders", "nick", "rank", "race", "class", "role"]
    };

    // Init list
    var rosterList = new List("roster", options);

    rosterList.sort("class", {
      order: "asc"
    });

    // checkbox filter
    var activeFilters = [];

    //filter
    $(".js-filter-member").change(function() {
      var value = $(this).val();

      if (value === "raiders") {
        //  add to list of active filters
        activeFilters.push(value);
      } else {
        // remove from active filters
        activeFilters.splice(activeFilters.indexOf(value), 1);
      }

      rosterList.filter(function(item) {
        if (activeFilters.length > 0) {
          return activeFilters.indexOf(item.values().raiders) > -1;
        }
        return true;
      });
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  }
};
