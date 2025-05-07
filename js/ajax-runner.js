jQuery(document).ready(function ($) {
    $('#reh_run_import').on('click', function () {
        $('#reh_import_result').text('Running...');
        $.post(ajaxurl, {
            action: 'reh_run_parser',
            nonce: reh_ajax_object.nonce
        }, function (response) {
            if (response.success) {
                $('#reh_import_result').text(response.data);
            } else {
                $('#reh_import_result').text('Error: ' + response.data);
            }
        }).fail(function () {
            $('#reh_import_result').text('AJAX request failed.');
        });
    });
});
