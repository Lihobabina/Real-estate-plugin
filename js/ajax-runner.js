jQuery(document).ready(function ($) {
    const $runImportButton = $('#reh_run_import');
    const $importResultDiv = $('#reh_import_result');

    function runParser(offset = 0) {
        $runImportButton.prop('disabled', true).text('Importing...'); 
        $importResultDiv.html('<strong>Import Log:</strong><br>Running... Current offset: ' + offset + '<br>'); 

        $.post(reh_ajax_object.ajax_url, {
            action: 'reh_run_parser',
            nonce: reh_ajax_object.nonce,
            offset: offset
        }, function (response) {
            if (response.success) {
                $importResultDiv.append('<span>' + response.data.message + '</span><br>');
                $importResultDiv.scrollTop($importResultDiv[0].scrollHeight); 

                if (response.data.next_offset !== undefined && response.data.next_offset < response.data.total) {
                    runParser(response.data.next_offset); 
                } else {
                    $importResultDiv.append('<br><strong>Import complete. All houses processed.</strong>');
                    $runImportButton.prop('disabled', false).text('Run Import'); 
                }
            } else {
                $importResultDiv.append('<br><strong style="color: red;">Error: ' + response.data + '</strong>');
                $runImportButton.prop('disabled', false).text('Run Import'); 
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $importResultDiv.append('<br><strong style="color: red;">AJAX request failed: ' + textStatus + ' - ' + errorThrown + '</strong>');
            $runImportButton.prop('disabled', false).text('Run Import'); 
        });
    }

    $runImportButton.on('click', function () {
        runParser(0); 
    });
});