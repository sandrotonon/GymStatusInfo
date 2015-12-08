'use strict';

var tsModules = tsModules || {};

tsModules.TimeSlotTable = (function () {

    return {

        init: function () {
            var deleteButtons = $('.deleteRow');
            var addButton = $('.addRow');

            $('#timeSlotTable tbody').on('click', 'a', function (e) {
                e.preventDefault();
                $(this).closest('tr').remove();
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

                var tdDeleteButton = "<td class='text-right'><a href='#' class='btn btn-xs btn-link myClass' data-toggle='tooltip' data-placement='top' title='Termin löschen'><i class='fa fa-trash'></i></a></td>";

                $('#timeSlotTable tbody').append('<tr>' + tdDate + tdTime + tdPlaces + tdDeleteButton + '</tr>');

                $('#date').val(null);
                $('#time').val(null);
                $('#places').val(null);
                
                // Add to JSON
            });
        },
    };
})();