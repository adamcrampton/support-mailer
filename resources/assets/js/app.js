// Helper functions for the public front end.
$(document).ready(function() {
	// Show phone number field and set as required if contact method is specified as phone.
	$('#preferred_contact').on('change', function(e) {
		if ($(this).val() === 'phone') {
			$('#phone_number_row').slideDown();
			$('#phone_number_row').addClass('required');
			$('#phone_number').prop('required', true);
		} else {
			$('#phone_number_row').slideUp();
			$('#phone_number_row').removeClass('required');
			$('#phone_number').prop('required', false);
		}
	})
});