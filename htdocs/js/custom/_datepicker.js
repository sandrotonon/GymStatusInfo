'use strict';

var tsModules = tsModules || {};

tsModules.Datepicker = (function() {

  return {

    init: function() {
      // Init datepicker
      $('#hallen .input-group.date').datepicker({
        // defaultViewDate: { year: 1977, month: 04, day: 25 }
        language: 'de-DE',
        orientation: 'bottom'
      });
    }
  };
})();
