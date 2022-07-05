function message(type, text) {
	var n = noty({
		text        : text,
		type        : type,
		dismissQueue: true,
		layout      : 'topCenter',
		closeWith   : ['click'],
		theme       : 'relax',
		maxVisible  : 10,
		timeout     : 10000,
		scrollX     : "200px",
		scrollCollapse: true,
		paging:         false,
		animation   : {
			open  : 'animated bounceInDown',
			close : 'animated bounceOutUp',
			easing: 'swing',
			speed : 500
		}
	});
}

$.fn.ftDatePicker = function(){
	this.datepicker({
    	format: 'yyyy/mm/dd'
	});
};

$.fn.ftTimePicker = function(){
	this.timepicker({
        template: false,
        showInputs: false,
        minuteStep: 5
    });
}
