$(document).ready(function() {
    // We set the width of each td explicit for correct UX
    $('#sortable td').each(function() {
        $(this).width($(this).width());
    });

    // Create sortable table:
    $("#sortable tbody").sortable({ axis: "y" });

    // Move one up:
    $('.move-up').click(function() {
        var $node = $(this).closest('tr');
        if($node.prev().length) {
            $node.fadeOut('fast', function() {
                $node.prev().before($node);
                $node.fadeIn('fast');
            });
        }
        return false;
    });

    // Move one down:
    $('.move-down').click(function() {
        var $node = $(this).closest('tr');
        if($node.next().length) {
            $node.fadeOut('fast', function() {
                $node.next().after($node);
                $node.fadeIn('fast');
            });
        }
        return false;
    });

    // Move to top:
    $('.move-top').click(function() {
        var $node = $(this).closest('tr');
        if($node.siblings(":first").length) {
            $node.fadeOut('fast', function() {
                $node.siblings(":first").before($node);
                $node.fadeIn('fast');
            });
        }
        return false;
    });

    // Move to bottom:
    $('.move-bottom').click(function() {
        var $node = $(this).closest('tr');
        if($node.siblings(":last").length) {
            $node.fadeOut('fast', function() {
                $node.siblings(":last").after($node);
                $node.fadeIn('fast');
            });
        }
        return false;
    });

    // When clicking save:
    $('#sortable-save').click(function() {
        $('span', this).html('Even geduld...');

        // Create an order array:
        var order = Array();
        $('#sortable tr').each(function() {
            order.push($(this).attr('data-id'));
        });
        console.log(order);

        // Send the order via AJAX to the server:
        $.ajax({
            url: $('#sortable').attr('data-ajax'),
            dataType: 'json',
            type: 'POST',
            data: { order : order },
            success: function() {
                // Redirect back to the window:
                window.location = $('#sortable').attr('data-redirect');
            },
            error: function() {
                alert('Oops, er ging iets mis! Probeer later nogmaals');
            }
        });
        return false;
    });

});