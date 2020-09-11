$Ready(function() {
    $('.ce-videos').click(function() {
        var t = $(this);
        $.ajax({
            url: t.data('url'),
            success: function(e) {
                $('#ce-all-videos').html(e);
            }
        });
        return false;
    });
});