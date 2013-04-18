$(document).ready(function() {
	/* Demo Start */
	
	/* jQuery-UI Widgets */
	
	$(".mws-accordion").accordion();
	
	$(".mws-tabs").tabs();
	
	$(".mws-datepicker").datepicker({showOtherMonths:true});
	
	$(".mws-datepicker-wk").datepicker({showOtherMonths:true, showWeek:true});
	
	$(".mws-datepicker-mm").datepicker({showOtherMonths:true, numberOfMonths:3});
	
	$(".mws-datepicker-btn").datepicker({showOtherMonths:true, showButtonPanel: true});
	
	$(".mws-slider").slider({range: "min"});
	
	$(".mws-progressbar").progressbar({value: 37});
	
	$(".mws-range-slider").slider({range: true, min:0, max: 500, values: [75, 300]});

	$(".mws-slider-vertical").slider({
		orientation: "vertical", 
		range: "min",
		min: 0,
		max: 100,
		value: 60
	});
	
	
	/* Data Tables */
	
	$(".mws-datatable").dataTable();
	$(".mws-datatable-fn").dataTable({sPaginationType: "full_numbers"});
	
	/* Full Calendar */
	
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();


	/* Enable edit and delete links */
	var url = 'http://' + window.location.hostname + window.location.pathname;
	$('.idSwitcher').each(function(element, index) {
		var id = $(this).attr('rel');
		$(this).click(function(){
			$('#editLink').css({ display : "block"});
			$('#deleteLink').css({ display : "block"});
			$('#editLink').attr('href', url + '/edit/' + id);
			$('#deleteLink').attr('href', url + '/delete/' + id);
		});
	});
	
	/* Easy Navigation with arrow keys */
	
	// Down Key
	$(document).keydown(function(e){
	    if (e.keyCode == 40) { 
	        var index = $("input:focus").parent().index();
	        var mainTr = $("input:focus").parent().parent();
	        mainTr.next().children("td:eq(" + index + ")").children("input[type=text]").focus();
	        return false;
	    }
	});
	
	// Up Key
	$(document).keydown(function(e){
	    if (e.keyCode == 38) { 
	    	var index = $("input:focus").parent().index();
	        var mainTr = $("input:focus").parent().parent();
	        mainTr.prev().children("td:eq(" + index + ")").children("input[type=text]").focus();
	        return false;
	    }
	});
	
	// Right Key
	$(document).keydown(function(e){
	    if (e.keyCode == 39) { 
	       var mainTr = $("input:focus").parent();
	       mainTr.next().children("input[type=text]").focus();
	       return false;
	    }
	});
	
	// Left Key
	$(document).keydown(function(e){
	    if (e.keyCode == 37) { 
	       var mainTr = $("input:focus").parent();
	       mainTr.prev().children("input[type=text]").focus();
	       return false;
	    }
	});
});