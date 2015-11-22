'use strict';

var tsModules = tsModules || {};

tsModules.TimeSlots = (function() {

  return {

    init: function() {
      var $addButton = $('button#add-time');

      var that = this;

      $addButton.click(function() {
        that.validate($(this));
      });
    },

    validate: function(el) {
      var panel = el.parentsUntil('.panel');
      console.log(panel);

      return true;
    }
  };
})();