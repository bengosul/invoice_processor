
$(function() {
	var oTable = $('#datatable').DataTable({
		"oLanguage": {
			"sSearch": "Filter Data"
		},
		"iDisplayLength": 12,
		"sPaginationType": "full_numbers"
	//	,
// "bPaginate" : false
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







	$("#success_filter_value").click(function() {
		success_selection = $("#success_filter_value").val();
	//	alert (success_selection );
		oTable.fnDraw();
	});





				     
				     $("#btnExport").click(function(e) 
						     {
//	$('#datatable').DataTable.iDisplayLength=1000;
// oTable.bPaginate=false;		

//	$('#datatable').DataTable.bPaginate=false;

//	e.preventDefault();
										        window.open('data:application/vnd.ms-excel,' + 
													        	encodeURIComponent(oTable[0].outerHTML));
												    });







});


//Date Range Filter
minDateFilter = "";
maxDateFilter = "";

success_selection = "";

$.fn.dataTableExt.afnFiltering.push(
		function(oSettings, aData, iDataIndex) {
 			
		//	$('td', nRow).css('background-color', 'Red');
			
			$('td').css('background-color', '#111111');
 			if (typeof aData._date == 'undefined') {
				aData._date = new Date(aData[0]).getTime();
			}

			if (minDateFilter && !isNaN(minDateFilter)) {
				if (aData._date < minDateFilter) {
					return false;
				}
			}

			if (maxDateFilter && !isNaN(maxDateFilter)) {
//	alert('doo pula');
				if (aData._date > maxDateFilter) {
					return false;
				}
			}


//alert(!success_selection && success_selection!=="");
//alert( success_selection!=="");
//alert(success_selection );
//alert(!success_selection );


			if (success_selection=="false") {
				if (aData[2]) {
			return false;
				}
			}


			if (success_selection=="true") {
				if (!aData[2]) {
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


 $(function () 
		 {
			     var tab = $('#datatable').dataTable();
				     
				     $("#btnExport").click(function(e) 
						     {
								     	e.preventDefault();
										        window.open('data:application/vnd.ms-excel,' + 
													        	encodeURIComponent(tab[0].outerHTML));
												    });
		 });
 
*/ 
