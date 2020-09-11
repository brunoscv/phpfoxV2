
$Ready(function() {
	$('.active-all').click(function() {
		var t = $(this);

		$.ajax({
			url: t.data('url'),
			success: function(e) {
				$('#show-all').html(e);
			}
		});

		return false;
	});
});