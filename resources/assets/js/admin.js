// Helper functions for the admin front end.
$(document).ready(function() {
	// Listen for changes to 'first_name' and 'last_name' type fields.
	// Populate the hidden 'name' fields with updated values on change.
	var $staff_name = $('#staff_name');
	var $staff_first_name = $('#staff_first_name');
	var $staff_last_name = $('#staff_last_name');

	$staff_first_name.on('change paste keyup', function() {
		$staff_name.val($(this).val() + ' ' + $staff_last_name.val());
	});

	$staff_last_name.on('change paste keyup', function() {
		$staff_name.val($staff_first_name.val() + ' ' + $(this).val());
	});

	$('input[data-update-row]').on('change paste keyup', function() {
		var row_to_find = $(this).attr('data-update-row');
		if ($(this).attr('data-input-type') === 'staff_first_name') {
			$('input[data-update-row=' + row_to_find + '][data-input-type=staff_name]').val($(this).val() + ' ' + $('input[data-update-row=' + row_to_find + '][data-input-type=staff_last_name]').val());
		} else {
			$('input[data-update-row=' + row_to_find + '][data-input-type=staff_name]').val($('input[data-update-row=' + row_to_find + '][data-input-type=staff_first_name]').val() + ' ' + $(this).val());
		}
	});
});