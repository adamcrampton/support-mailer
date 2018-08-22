// Helper functions for the admin front end.
$(document).ready(function() {

	// Update the hidden "something_name" by listening and combining values from first_name and last_name fields.
	var hiddenFieldUpdater = {
		
		prefixes : ['staff', 'user'],

		init: function() {
			this.setUpEventListeners();
		},

		setUpEventListeners: function() {
			for (index in this.prefixes) {

				// Set up variables.
				var $name = $('#add_form #' + this.prefixes[index] + '_name');
				var $first_name = $('#add_form #' + this.prefixes[index] + '_first_name');
				var $last_name = $('#add_form #' + this.prefixes[index] + '_last_name');

				// For insert fields.
				$first_name.on('change paste keyup', { name:$name, first_name:$first_name, last_name:$last_name }, function(e) {
					e.data.name.val($(this).val() + ' ' + e.data.last_name.val());
				});

				$last_name.on('change paste keyup', { name:$name, first_name:$first_name, last_name:$last_name }, function(e) {
					e.data.name.val(e.data.first_name.val() + ' ' + $(this).val());
				});

				// For update matrix.
				$('#update_form input.form-control').on('change paste keyup', function() {
					var $container = $(this).closest('tr');
					var $name_field = $container.find('.name');
					var first_name_value = $container.find('.first_name').val();
					var last_name_value = $container.find('.last_name').val();

					$name_field.val(first_name_value + ' ' + last_name_value);
				});
			}	
		}
	}

	hiddenFieldUpdater.init();
});

	

