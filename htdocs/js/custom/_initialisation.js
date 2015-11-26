'use strict';

var tsModules = tsModules || {};

tsModules.Initialisation = (function() {

  return {

    init: function() {
      // Init tooltips
      $('[data-toggle="tooltip"]').tooltip();

      // Init masonry
      $('.grid').masonry({
        itemSelector: '.location'
      });
    }
  };
})();
