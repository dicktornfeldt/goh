import $ from "jquery";
import List from "list.js";

export default {
  init() {
    var options = {
      valueNames: ["nick", "race", "class"]
    };

    // Init list
    var contactList = new List("roster", options);
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  }
};
