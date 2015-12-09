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
                    alert("Datum fehlt");
                    return;
                }

                if (!time) {
                    alert("Zeit fehlt");
                    return;
                }

                if (!places) {
                    alert("Plätze fehlen");
                    return;
                }

                var tdDate = "<td>" + date + "</td>";
                var tdTime = "<td>" + time + "</td>";
                var tdPlaces = "<td>" + places + "</td>";

                var tdDeleteButton = "<td class='text-right'><a href='#' class='btn btn-xs btn-link deleteRow' data-toggle='tooltip' data-placement='top' title='Termin löschen'><i class='fa fa-trash'></i></a></td>";

                $('#timeSlotTable tbody').append('<tr>' + tdDate + tdTime + tdPlaces + tdDeleteButton + '</tr>');

                $('#date').val(null);
                $('#time').val(null);
                $('#places').val(null);

                that.addJson(date, time, places);
            });
        },

        addJson: function (date, time, places) {

            var hiddenField = $('#timeSlotDates');
            var timeSlotJson = JSON.parse(hiddenField.val());
            var timeSlot = new Object();
            
            timeSlot.date = date;
            timeSlot.time = time;
            timeSlot.places = places;
            timeSlot.dbState = 1;
            timeSlot.id = 0;

            timeSlotJson.push(timeSlot);
            hiddenField.val(JSON.stringify(timeSlotJson));
        },

        deleteJson: function (element) {

            var row = element.closest('tr');

            var dateParts = row.find('td:eq(0)').text().split(".");
            var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
            var time = new Date().setHours(
                row.find('td:eq(1)').text().split(':')[0],
                row.find('td:eq(1)').text().split(':')[1],
                0,
                0);
            var places = row.find('td:eq(2)').text();

            var hiddenField = $('#timeSlotDates');
            var timeSlotJson = JSON.parse(hiddenField.val());
            var index = 0;

            timeSlotJson.forEach(function (timeSlot) {
                var timeSlotDate = new Date(timeSlot.date);
                var timeSlotTime = new Date().setHours(
                    timeSlot.time.split(':')[0],
                    timeSlot.time.split(':')[1],
                    0,
                    0);

                if (timeSlotDate.getDate() == date.getDate() &&
                    timeSlotTime == time &&
                    timeSlot.places == places) {

                    timeSlot.dbState = 2;
                }
                index++;
            }, this);

            hiddenField.val(JSON.stringify(timeSlotJson));
        }
    };
})();