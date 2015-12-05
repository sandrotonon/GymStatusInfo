'use strict';

function addRow() {

	var date = document.getElementById('date').value;
    var time = document.getElementById('time').value;
    var places = document.getElementById('places').value;

    // TODO: Validation!
    if(!date) {
    	alert("Datum fehlt");
    	return;
    }

    if(!time) {
    	alert("Zeit fehlt");
    	return;
    }

    if(!places) {
    	alert("Plätze fehlen");
    	return;
    }

    // Add new row to table -> Assume this could be handled nicer
    var table = document.getElementById('timeSlotTable');
    var rows = table.rows.length;

    var row = table.insertRow(rows);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = date;
    cell2.innerHTML = time + " Uhr";
    cell3.innerHTML = places;
    cell4.innerHTML = "<a href='javascript:void(0);' onClick='deleteRow(this);'; class='btn btn-xs btn-link' data-toggle='tooltip' data-placement='top' title='Termin löschen'><i class='fa fa-trash'></i></a>";
    cell4.className = "text-right";

    // Clear inputs
    document.getElementById('date').value = null;
    document.getElementById('time').value = null;
    document.getElementById('places').value = null;
}

function getRowIndex( el ) {
    while( (el = el.parentNode) && el.nodeName.toLowerCase() !== 'tr' );

    if( el ) 
        return el.rowIndex;
}

function deleteRow(button) {
	var index = getRowIndex(button);
	document.getElementById("timeSlotTable").deleteRow(index);
}