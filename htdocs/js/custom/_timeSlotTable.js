'use strict';

var tsModules = tsModules || {};

tsModules.TimeSlotTable = (function () {

    return {

        init: function () {

            var addButton = $('.addRow');
            var that = this;

            $('#timeSlotTable tbody').on('click', 'a', function (e) {
                e.preventDefault();

                $(this).confirmation({
                    placement: 'left',
                    btnOkLabel: 'Löschen',
                    btnCancelLabel: 'Abbrechen',
                    btnCancelClass: 'btn btn-sm btn-default pull-right',
                    onCancel: function () {
                        return false;
                    },
                    onConfirm: function (event, element) {
                        event.preventDefault();
                        that.deleteJson(element);
                        element.closest('tr').remove();
                    }
                });

                $(this).confirmation('show');
            });

            addButton.click(function (e) {
                e.preventDefault();

                var date = $('#date').val();
                var time = $('#time').val();
                var places = $('#places').val();

                // TODO: Validation!
                if (!date) {
                    alert('Datum fehlt');
                    return;
                }

                if (moment(date, 'YYYY-MM-DD').isBefore(moment())) {
                    alert('Das Datum muss in der Zukunft liegen!');
                    return;
                }

                if (!time) {
                    alert('Zeit fehlt');
                    return;
                }

                if (!places) {
                    alert('Plätze fehlen');
                    return;
                }

                var datetime = moment(date + 'T' + time, 'YYYY-MM-DDThh:mm');

                var tdDate = '<td>' + datetime.format('DD.MM.YYYY') + '</td>';
                var tdTime = '<td>' + datetime.format('hh:mm') + '</td>';
                var tdPlaces = '<td>' + places + '</td>';

                var tdDeleteButton = "<td class='text-right'><a href='#' class='btn btn-xs btn-link deleteRow' data-toggle='tooltip' data-placement='top' title='Termin löschen'><i class='fa fa-trash'></i></a></td>";

                $('#timeSlotTable tbody').append('<tr>' + tdDate + tdTime + tdPlaces + tdDeleteButton + '</tr>');

                $('#date').val(null);
                $('#time').val(null);
                $('#places').val(null);

                that.addJson(datetime, places);
            });
        },

        addJson: function (datetime, places) {

            var hiddenField = $('#timeSlotDates');
            var timeSlotJson = JSON.parse(hiddenField.val());
            var timeSlot = {};

            timeSlot.date = datetime.format('YYYY-MM-DD');
            timeSlot.time = datetime.format('hh:mm');
            timeSlot.places = places;
            timeSlot.dbState = 1;
            timeSlot.id = 0;

            timeSlotJson.push(timeSlot);
            hiddenField.val(JSON.stringify(timeSlotJson));
        },

        deleteJson: function (element) {

            var row = element.closest('tr');
            var dateString = row.find('td:eq(0)').text();
            var timeString = row.find('td:eq(1)').text();
            var places = row.find('td:eq(2)').text();

            var date = moment(dateString + 'T' + timeString, 'DD.MM.YYYYThh:mm');

            var hiddenField = $('#timeSlotDates');
            var timeSlotJson = JSON.parse(hiddenField.val());

            timeSlotJson.forEach(function (timeSlot) {

                var timeSlotDateTime = moment(timeSlot.date + 'T' + timeSlot.time, 'YYYY-MM-DDThh:mm');

                if (timeSlotDateTime.isSame(date) && timeSlot.places == places) {
                    timeSlot.dbState = 2;
                }

            }, this);

            hiddenField.val(JSON.stringify(timeSlotJson));
        }
    };
})();