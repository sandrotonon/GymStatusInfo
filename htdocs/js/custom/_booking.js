'use strict';

var tsModules = tsModules || {};

tsModules.Booking = (function() {

  return {

    init: function() {
      var $bookButtons = $('button.btn-book');

      var that = this;

      $bookButtons.each(function() {
        $(this).click(function(e) {
          ($(this).hasClass('btn-book-book')) ? $method = 'book' : $method = 'unbook';
          $overlay = $(this).closest('.panel').find('.overlay');

          $overlay.fadeTo(300, 0.92);
          setTimeout(function(){
            $overlay.find('.booking-progress').fadeIn(500);
          }, 300);


          // TODO:
          // Send AJAX request

          // success
          setTimeout(function(){
            $overlay.find('.booking-progress').fadeOut(500);
          }, 1600);

          setTimeout(function(){
            $overlay.find('.booking-progress-success').fadeIn(500);
          }, 1800);

          // failure


          setTimeout(function(){
            $overlay.fadeOut(500);
            $overlay.find('.booking-progress-success').fadeOut(0);
          }, 3300);

          return false;
        });
      });
    }
  };
})();
