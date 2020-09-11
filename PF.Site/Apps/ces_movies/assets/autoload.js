$Ready(function() {
    $('.view-more').click(function() {
        var t = $(this);
        $.ajax({
            url: t.data('url'),
            success: function(e) {
                $('#viewmore').html(e);
            }
        });
        return false;
    });
});

$Ready(function() {
    $('.ratings').click(function() {
        var t = $(this);
        $.ajax({
            url: t.data('url'),
            success: function(e) {
                $('#ratings').html(e);
            }
        });
        return false;
    });
});

