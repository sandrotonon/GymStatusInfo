'use strict';

var tsModules = tsModules || {};

tsModules.Booking = (function() {

  return {

    globals: {
      $overlay: null
    },

    init: function() {
      var $bookButtons = $('button.btn-book');
      var form, method;
      var that = this;

      $bookButtons.each(function() {
        $(this).click(function(e) {
          e.preventDefault();

          that.globals.$overlay = $(this).closest('.panel').find('.overlay');

          method = ($(this).hasClass('btn-book-book')) ? 'book' : 'unbook';
          form = $(this).closest('form');
          var message = (method === 'book') ? 'Wird reserviert...' : 'Reservierung wird gelöscht...' ;
          var token = form.find('input[name="_token"]').val();
          var timeslot = (form.find('input:checked').length !== 0) ? form.find('input:checked').val() : form.find('td[data-booked-by-user="1"]').attr('data-timeslot-id');
          var responseStatus, responseText;

          that.globals.$overlay.find('.booking-progress p').text(message);

          that.globals.$overlay.fadeTo(300, 0.92);
          setTimeout(function(){
            that.globals.$overlay.find('.booking-progress').fadeIn(500);
          }, 300);

          if (timeslot === undefined) {
            setTimeout(function(){
              that.hideOverlay('error', 'Bitte einen Platz auswählen!');
            }, 500);

            return;
          }

          // Send AJAX request
          $.ajax({
            type: 'POST',
            cache: false,
            url : 'timeslot/' + timeslot + '/' + method,
            data: {
              _token: token,
              _method: 'PATCH',
              timeslot: timeslot
            }
          })
          .done(function(data) {
            // Serverantwort bekommen
            if (data.status === 'success') {
              responseStatus = 'success';
              if (method === 'book') {
                that.changeToBooked(e.target, form.find('input:checked').closest('td'), timeslot);
              } else {
                that.changeToAvailable(e.target, form.find('td[data-booked-by-user="1"]').closest('td'));
              }
            }
            responseText = data.message;
          })
          .fail(function(jqXHR, ajaxOptions, thrownError) {
            // Server sendet keine Antwort
            responseStatus = 'error';
            responseText = 'Der Server antwortet nicht, bitte versuchen Sie es später noch einmal!';
          })
          .always(function() {
            that.hideOverlay(responseStatus, responseText);
          });

          return false;
        });
      });
    },

    changeToBooked: function(button, $field, timeslot) {
      var $timepanels = $field.closest('form').find('.panel-body .panel');
      var that = this;

      $timepanels.each(function(index, $timepanel) {
        if ($timepanel == $field.closest('.panel')[0]) {
          return;
        }
        if ($($timepanel).attr('data-free-slots') > 0) {
          var $inputRow = $($timepanel).find('.input-row');
          var $noBookings = $($timepanel).find('.no-bookings');
          $inputRow.addClass('hidden');

          if ($($timepanel).attr('data-free-slots') == $($timepanel).attr('data-total-slots')) {
            $noBookings.removeClass('hidden');
            that.calculateColspan($($timepanel), 1);
          }
        }
      });

      var $row = $field.closest('tr');

      // Change radios to empty fields and booked field
      $row.find('td').each(function(index, element) {
        if ($(element).attr('data-timeslot-id') == timeslot) {

          // Change input field to icon check
          $field.attr('data-available', 0);
          $field.attr('data-booked-by-user', 1);
          $(element).html('<i class="fa fa-check"></i><span class="sr-only">Platz belegt</span>');

        } else if ($(element).attr('data-available') == '0') {
          // Change input to empty field
          $(element).html('<span class="sr-only">Platz belegt</span>');
        } else if ($(element).attr('data-available') == '1') {
          // Change input to booked field
          $(element).html('<span class="sr-only">Platz noch nicht belegt</span>');
        }
      });

      // Change button
      $(button).removeClass('btn-book-book btn-primary').addClass('btn-book-unbook btn-danger').html('<i class="fa fa-times"></i> Reservierung löschen');

      this.calculateFreeSlots(button, $field, 'decrease');

      // Masonry reload
      $('.grid').masonry('reloadItems');
      $('.grid').masonry();
    },

    changeToAvailable: function(button, $field) {
      var $timepanels = $field.closest('form').find('.panel-body .panel');
      var that = this;

      $timepanels.each(function(index, $timepanel) {

        if ($timepanel == $field.closest('.panel')[0]) {
          return;
        }
        if ($($timepanel).attr('data-free-slots') > 0) {
          var $inputRow = $($timepanel).find('.input-row');
          var $noBookings = $($timepanel).find('.no-bookings');
          $inputRow.removeClass('hidden');

          if (!$noBookings.hasClass('hidden')) {
            $noBookings.addClass('hidden');
            var count = $($timepanel).find('.input-row td').length;
            that.calculateColspan($($timepanel), count);
          }
        }
      });

      var $row = $field.closest('tr');

      $row.find('td').each(function(index, element) {
        if ($(element).attr('data-booked-by-user') == '1' || $(element).attr('data-available') == '1') {

          // Change icon checked to input
          $field.attr('data-available', 1);
          $field.attr('data-booked-by-user', 0);
          $(element).html('<input type="radio" name="timeslot" value="' + $(element).attr('data-timeslot-id') + '"></input>');

        }
      });

      // Change button
      $(button).removeClass('btn-book-unbook btn-danger').addClass('btn-book-book btn-primary').html('<i class="fa fa-check"></i> Reservierung speichern');

      this.calculateFreeSlots(button, $field, 'increase');

      // Masonry reload
      $('.grid').masonry('reloadItems');
      $('.grid').masonry();
    },

    hideOverlay: function(responseStatus, responseText) {
      var $overlay = this.globals.$overlay;
      // Spinner ausblenden
      $overlay.find('.booking-progress').fadeOut(500);

      // Reservierungsprozess-Antwort anzeigen
      setTimeout(function(){
        $overlay.find('.booking-' + responseStatus).find('.response').text(responseText);
        $overlay.find('.booking-' + responseStatus).fadeIn(500);
      }, 300);

      // Overlay ausblenden
      setTimeout(function(){
        $overlay.find('.booking-' + responseStatus).fadeOut(0);
        $overlay.fadeOut(500);
      }, 2000);
    },

    calculateFreeSlots: function(button, $field, method) {
      // TODO
      var $locationHeading = $(button).closest('.panel').find('> .panel-heading');
      var $timePanel = $field.closest('.panel');

      // Calculate total free slots
      var totalFreeSlots = $locationHeading.attr('data-free-slots');
      if (method === 'increase') {
        totalFreeSlots++;
      } else {
        totalFreeSlots--;
      }
      var totalFreeslotsSuffix = (totalFreeSlots === 0 || totalFreeSlots > 1) ? ' Freie Plätze' : ' Freier Platz';

      $locationHeading.attr('data-free-slots', totalFreeSlots).find('.count-all').text(totalFreeSlots + totalFreeslotsSuffix);

      // Calculate color of time-panel
      var freeSlots = $timePanel.attr('data-free-slots');
      var totalSlots = $timePanel.attr('data-total-slots');
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

      $timePanel.removeClass().addClass('panel ' + panelStatus).attr('data-free-slots', freeSlots);
    },

    calculateColspan: function($panel, colspan) {
      var $th = $panel.find('thead').first().find('th').last();

      $th.attr('colspan', colspan);
    },
  };
})();
