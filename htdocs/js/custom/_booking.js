'use strict';

var tsModules = tsModules || {};

tsModules.Booking = (function() {

  return {

    init: function() {
      var $bookButtons = $('button.btn-book');

      $bookButtons.each(function() {
        $(this).click(function(e) {
          e.preventDefault();

          var method = ($(this).hasClass('btn-book-book')) ? 'book' : 'unbook';
          var token = $(this).closest('form').find('input[name="_token"]').val();
          var selected = $(this).closest('form').find('input:checked').val();
          var $overlay = $(this).closest('.panel').find('.overlay');

          $overlay.fadeTo(300, 0.92);
          setTimeout(function(){
            $overlay.find('.booking-progress').fadeIn(500);
          }, 300);


          // TODO:
          // Send AJAX request
          $.ajax({
            type: 'POST',
            cache: false,
            url : selected + '/' + method,
            data: {
              _token: token,
              _method: 'PATCH',
              timeslot: selected
            },
            success: function(data) {
              // var obj = $.parseJSON(data);
              console.log(data);
            }
          })
          .done(function(data) {
              console.log('done: ' + data);
          })
          .fail(function(jqXHR, ajaxOptions, thrownError) {
              console.log('No response from server');
          });

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
