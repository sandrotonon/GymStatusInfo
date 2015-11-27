'use strict';

var tsModules = tsModules || {};

tsModules.Datepicker = (function() {

  return {

    init: function() {
      // Init datepicker
      var availableDates = $('#hallen .date input').data('available-dates');
      var startdate;

      if (availableDates) {
        startdate = (availableDates.length !== 0) ? availableDates[0] : null;
      }

      $('#hallen .input-group.date').datepicker({
        beforeShowDay: function (date) {
          var day = ('0' + date.getDate()).slice(-2);
          var month = ('0' + (date.getMonth() + 1)).slice(-2);
          var year = date.getFullYear();
          var dateString = day + '.' + month + '.' + year;

          if ($.inArray(dateString, availableDates) > -1) {
            return true;
          }
          return false;
        },
        language: 'de-DE',
        orientation: 'bottom',
        autoclose: true,
        todayHighlight: true,
        startDate: startdate,
      });
    }
  };
})();
