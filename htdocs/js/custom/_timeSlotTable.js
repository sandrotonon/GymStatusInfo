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

            if (timeSlotJson.length > 0)
                timeSlot.id = timeSlotJson[0].id;
            else
                timeSlot.id = 0;

            timeSlotJson.push(timeSlot);
            hiddenField.val(JSON.stringify(timeSlotJson));
        },

        deleteJson: function (element) {

            var row = element.closest('tr');

            var date = row.find('td:eq(0)').text();
            var time = row.find('td:eq(1)').text();
            var places = row.find('td:eq(2)').text();
            var currentIndex = -1;

            var hiddenField = $('#timeSlotDates');
            var timeSlotJson = JSON.parse(hiddenField.val());

            for (var index = 0; index < timeSlotJson.length; index++) {

                if (timeSlotJson[index].date == date &&
                    timeSlotJson[index].time == time &&
                    timeSlotJson[index].places == places) {

                    currentIndex = index;
                    break;
                }

                currentIndex++;
            }

            if (currentIndex > -1)
                timeSlotJson.splice(currentIndex, 1);

            hiddenField.val(JSON.stringify(timeSlotJson));
        }
    };
})();