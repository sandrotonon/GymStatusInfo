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
          var responseStatus = 'success';

          $overlay.fadeTo(300, 0.92);
          setTimeout(function(){
            $overlay.find('.booking-progress').fadeIn(500);
          }, 300);

          // Send AJAX request
          $.ajax({
            type: 'POST',
            cache: false,
            url : 'timeslot/' + selected + '/' + method,
            data: {
              _token: token,
              _method: 'PATCH',
              timeslot: selected
            }
          })
          .done(function(data) {
            // Serverantwort bekommen

            // TODO
            if (data.status === 'error') {
              responseStatus = 'error';
              console.log('error');
            }
          })
          .fail(function(jqXHR, ajaxOptions, thrownError) {
            // Server sendet keine Antwort
              responseStatus = 'error';
          })
          .always(function() {
            // Spinner ausblenden
            setTimeout(function(){
              $overlay.find('.booking-progress').fadeOut(500);
            }, 600);

            // Reservierungsprozess-Antwort anzeigen
            setTimeout(function(){
              $overlay.find('.booking-progress-' + responseStatus).fadeIn(500);
            }, 800);

            // Reservierungsprozess-Antwort ausblenden
            setTimeout(function(){
              $overlay.find('.booking-progress-' + responseStatus).fadeOut(0);
            }, 2100);

            // Overlay ausblenden
            setTimeout(function(){
              $overlay.fadeOut(500);
            }, 2100);
          });

          return false;
        });
      });
    }
  };
})();
