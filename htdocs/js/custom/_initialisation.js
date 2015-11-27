'use strict';

var tsModules = tsModules || {};

tsModules.Initialisation = (function() {

  return {

    init: function() {
      // Init tooltips
      $('[data-toggle="tooltip"], [data-toggle="confirmation tooltip"]').tooltip({
        trigger: 'hover focus click'
      });

      // Init masonry
      $('.grid').masonry({
        itemSelector: '.location'
      });

      // Init confirmation bags
      $('[data-toggle="confirmation tooltip"]').confirmation({
        title: 'Sporthalle wirklich löschen?',
        placement: 'left',
        btnOkLabel: 'Löschen',
        btnCancelLabel: 'Abbrechen',
        btnCancelClass: 'btn btn-sm btn-default pull-right',
        onCancel: function() {
          return false;
        },
        onConfirm: function(event, element) {
          event.preventDefault();
          element.closest('form').submit();
        }
      });
    }
  };
})();
