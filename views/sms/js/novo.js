function multiselect_selected($el) {
    var ret = true;
    $('option', $el).each(function(element) {
        if (!!!$(this).prop('selected')) {
            ret = false;
        }
    });
    return ret;
}

/**
 * Selects all the options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_selectAll($el) {
    $('option', $el).each(function(element) {
        $el.multiselect('select', $(this).val());
    });
}
/**
 * Deselects all the options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_deselectAll($el) {
    $('option', $el).each(function(element) {
        $el.multiselect('deselect', $(this).val());
    });
}

/**
 * Clears all the selected options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_toggle($el, $btn) {
    if (multiselect_selected($el)) {
        multiselect_deselectAll($el);
        $btn.text("Select All");
    }
    else {
        multiselect_selectAll($el);
        $btn.text("Deselect All");
    }
}

$(document).ready(function() {
    $('#example21').multiselect();
    $("#example21-toggle").click(function(e) {
        e.preventDefault();
        multiselect_toggle($("#example21"), $(this));
    });
});