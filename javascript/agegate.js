var $win = $(window);

$(document).ready(function() {

	var age = 21;

	// Change Focus from one Entered Field to Another
	$("#Form_AgeGateForm_Month").focus(function() {
		if ($(this).val() == 'MM') {
			$(this).val('');
		}
	});

	$("#Form_AgeGateForm_Day").focus(function() {
		if ($(this).val() == 'DD') {
			$(this).val('');
		}
	});

	$("#Form_AgeGateForm_Year").focus(function() {
		if ($(this).val() == 'YYYY') {
			$(this).val('');
		}
	});

	// End Change Focus from one Entered Field to Another
	$("#Form_AgeGateForm_action_EnterAgeGate").click(function(e) {
		e.preventDefault();
		var day = $("#Form_AgeGateForm_Day").val();
		var month = $("#Form_AgeGateForm_Month").val();
		var year = $("#Form_AgeGateForm_Year").val();
		var itWillBecomeAMemory = $("#Form_AgeGateForm_itWillBecomeAMemory").prop('checked');

		mydate = new Date();
		dob_status = false;

		mydate.setFullYear(year, month - 1, day);

		currdate = new Date();
		currdate.setFullYear(currdate.getFullYear() - age);

		if ((month != "MM") && (day != "DD") && (year != "YYYY")) {
			if ((currdate - mydate) < 0) {
				alert("Sorry you must be 21 or older to view this site.");
			} else {
				if ((month < 13) && (day < 32) && (year > 1890)) {
					if (itWillBecomeAMemory) {
						$.cookie('bmonth', month, {
							path : '/',
							expires : 30
						});
						$.cookie('bday', day, {
							path : '/',
							expires : 30
						});
						$.cookie('byear', year, {
							path : '/',
							expires : 30
						});
					} else {
						$.cookie('bmonth', month, {
							path : '/'
						});
						$.cookie('bday', day, {
							path : '/'
						});
						$.cookie('byear', year, {
							path : '/'
						});
					}

					window.location = "/";

				} else {
					alert("Please enter a valid date.");

				}
			}
		}// end
		else {
			alert("Please enter a valid date.");
		}
	});
});
