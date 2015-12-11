'use strict';

var tsModules = tsModules || {};

tsModules.Booking = (function() {

  return {

    globals: {
      $overlay: null
    },

    init: function() {
      var $bookButtons = $('button.btn-book');
      var form, method, token;
      var that = this;

      $bookButtons.each(function() {
        $(this).click(function(e) {
          e.preventDefault();

          that.globals.$overlay = $(this).closest('.panel').find('.overlay');

          form = $(this).closest('form');
          token = form.find('input[name="_token"]').val();
          method = ($(this).hasClass('btn-book-book')) ? 'book' : 'unbook';
          var message = (method === 'book') ? 'Wird reserviert...' : 'Reservierung wird gelöscht...' ;
          var location = form.attr('data-location');
          var responseStatus = 'error', responseText;

          var timeslots = [];
          form.find('input:checked').each(function() {
            timeslots.push($(this).val());
          });

          that.globals.$overlay.find('.booking-progress p').text(message);
          that.globals.$overlay.fadeTo(300, 0.92);
          setTimeout(function(){
            that.globals.$overlay.find('.booking-progress').fadeIn(500);
          }, 300);

          if (method === 'book' && timeslots.length === 0) {
            setTimeout(function(){
              that.hideOverlay('error', 'Bitte einen Platz auswählen!');
            }, 500);

            return;
          }

          // Send AJAX request
          $.ajax({
            type: 'POST',
            cache: false,
            url : 'location/' + location + '/' + method,
            data: {
              _token: token,
              _method: 'PATCH',
              timeslots: timeslots
            }
          })
          .done(function(data) {
            // Serverantwort bekommen
            if (data.status === 'success') {
              responseStatus = data.status;

              if (method === 'book') {
                that.changeToBooked(form, timeslots);
              } else {
                that.changeToAvailable(form);
              }
            }
            responseText = data.message;
          })
          .fail(function(jqXHR, ajaxOptions, thrownError) {
            // Server sendet keine Antwort
            responseText = 'Der Server antwortet nicht, bitte versuchen Sie es später noch einmal!';
          })
          .always(function() {
            that.hideOverlay(responseStatus, responseText);
          });

          // Masonry reload
          $('.grid').masonry('reloadItems');
          $('.grid').masonry();

          return false;
        });
      });
    },

    changeToBooked: function(form, timeslots) {
      var $timepanels = form.find('.panel-body .panel');

      $timepanels.each(function(index, $timepanel) {
        var $row = $($timepanel).find('.input-row');
        var $tds = $row.find('td');
        var timeBooked = false;

        $tds.each(function() {
          if ($.inArray($(this).attr('data-timeslot-id'), timeslots) !== -1) {
            timeBooked = true;
            // Change input field to icon check
            $(this).attr('data-available', 0);
            $(this).attr('data-booked-by-user', 1);
          }
        });
        $tds.each(function() {
          if ($(this).attr('data-booked-by-user') === '1') {
            $(this).html('<i class="fa fa-check"></i><span class="sr-only">Platz belegt</span>');

          } else if (timeBooked && $(this).attr('data-available') == '0') {
            // Change input to booked field
            $(this).html('<span class="sr-only">Platz belegt</span>');

          } else if (timeBooked && $(this).attr('data-available') == '1') {
            // Change input to available field
            $(this).html('<span class="sr-only">Platz noch nicht belegt</span>');
          }
        });
      });

      // Change button
      form.find('button').removeClass('btn-book-book btn-primary').addClass('btn-book-unbook btn-danger').html('<i class="fa fa-times"></i> Reservierung löschen');

      this.calculateFreeSlots(form, 'decrease', timeslots.length);
    },

    changeToAvailable: function(form) {
      var $tds = form.find('td');
      var timeslots = [];
      $tds.each(function() {
        if ($(this).attr('data-booked-by-user') === '1') {
          timeslots.push($(this).attr('data-timeslot-id'));
        }
      });
      var $timepanels = form.find('.panel-body .panel');

      $timepanels.each(function(index, $timepanel) {
        var time = $(this).attr('data-time');
        var $row = $($timepanel).find('.input-row');
        var $tds = $row.find('td');

        $tds.each(function() {
          if ($.inArray($(this).attr('data-timeslot-id'), timeslots) !== -1 || $(this).attr('data-available') === '1') {
            // Change icon check field to input
            $(this).attr('data-available', 1);
            $(this).attr('data-booked-by-user', 0);
            $(this).html('<input type="radio" name="timeslot-' + time + '" value="' + $(this).attr('data-timeslot-id') + '"></input>');
          }
        });
      });

      // Change button
      form.find('button').removeClass('btn-book-unbook btn-danger').addClass('btn-book-book btn-primary').html('<i class="fa fa-check"></i> Reservierung speichern');

      this.calculateFreeSlots(form, 'increase', timeslots.length);
    },

    hideOverlay: function(responseStatus, responseText) {
      var $overlay = this.globals.$overlay;
      // Hide spinner
      $overlay.find('.booking-progress').fadeOut(500);

      // Display booking-process response
      setTimeout(function(){
        $overlay.find('.booking-' + responseStatus).find('.response').text(responseText);
        $overlay.find('.booking-' + responseStatus).fadeIn(500);
      }, 300);

      // Hide overlay
      setTimeout(function(){
        $overlay.find('.booking-' + responseStatus).fadeOut(0);
        $overlay.fadeOut(500);
      }, 2000);
    },

    calculateFreeSlots: function(form, method, count) {
      // Recalculate freeslots at the top of the location
      var $locationHeading = form.children('.panel-heading');
      var totalFreeSlots = parseInt($locationHeading.attr('data-free-slots'));
      if (method === 'decrease') {
        totalFreeSlots -= count;
      } else {
        totalFreeSlots = totalFreeSlots + count;
      }

      var totalFreeslotsSuffix = (totalFreeSlots === 0 || totalFreeSlots > 1) ? ' Freie Plätze' : ' Freier Platz';
      $locationHeading.attr('data-free-slots', totalFreeSlots).find('.count-all').text('(' + totalFreeSlots + totalFreeslotsSuffix + ')');

      // Calculate color of time-panels
      var $timepanels = form.find('.panel-body .panel');
      $timepanels.each(function() {
        var freeSlots = $(this).attr('data-free-slots');
        var totalSlots = $(this).attr('data-total-slots');
        var panelStatus = 'panel-success';

        if (method === 'increase') {
          freeSlots++;
        } else {
          freeSlots--;
        }

        if (freeSlots === 0) {
            panelStatus = 'panel-danger';
        } else if (freeSlots / totalSlots * 100 <= 50) {
            panelStatus = 'panel-warning';
        }

        $(this).removeClass().addClass('panel ' + panelStatus).attr('data-free-slots', freeSlots);
      });
    },
  };
})();
