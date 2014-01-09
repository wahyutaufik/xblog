(function($) {
    "use strict";

    $('select[name="tags"]').change(function() {
        var html = '<input type="text" placeholder="New Tags" name="newTags" value="">';
        if ($(this).val() == 'create') {
            $('.tags').append(html);
        } else {
            $('input[name="newTags"]').remove();
        }
    });
})($);
