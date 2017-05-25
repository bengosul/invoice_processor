
$(function() {
	var oTable = $('#datatable').DataTable({
		"oLanguage": {
			"sSearch": "Filter Data"
		},
		"iDisplayLength": -1,
		"sPaginationType": "full_numbers",

	});




	$("#datepicker_from").datepicker({
		showOn: "button",
		buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
		buttonImageOnly: false,
		"onSelect": function(date) {
			minDateFilter = new Date(date).getTime();
			oTable.fnDraw();
		}
	}).keyup(function() {
		minDateFilter = new Date(this.value).getTime();
		oTable.fnDraw();
	});

	$("#datepicker_to").datepicker({
		showOn: "button",
		buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
		buttonImageOnly: false,
		"onSelect": function(date) {
			maxDateFilter = new Date(date).getTime();
			oTable.fnDraw();
		}
	}).keyup(function() {
		maxDateFilter = new Date(this.value).getTime();
		oTable.fnDraw();
	});

});


//Date Range Filter
minDateFilter = "";
maxDateFilter = "";

$.fn.dataTableExt.afnFiltering.push(
		function(oSettings, aData, iDataIndex) {
			if (typeof aData._date == 'undefined') {
				aData._date = new Date(aData[0]).getTime();
			}

			if (minDateFilter && !isNaN(minDateFilter)) {
				if (aData._date < minDateFilter) {
					return false;
				}
			}

			if (maxDateFilter && !isNaN(maxDateFilter)) {
				if (aData._date > maxDateFilter) {
					return false;
				}
			}

			return true;
		}
		);


//Success Filter
/*
success_selection = $("#success_filter_value").val();


$.fn.dataTableExt.afnFiltering.push(
		function(oSettings, aData, iDataIndex) {
			if (typeof aData._succ == 'undefined') {
				aData._succ = aData[1];
			}

			if (aData._succ=='Maybe' && success_selection==true) {
					return true;
			}
			
			return false;
		}
		);
*/


