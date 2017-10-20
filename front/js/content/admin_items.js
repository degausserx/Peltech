var form = $("#admin_form");

$(document).on('click', '#admin_action_delete', function(e) {
	e.preventDefault();
	form.attr('action', form.attr('action') + '/items/delete').submit();
});