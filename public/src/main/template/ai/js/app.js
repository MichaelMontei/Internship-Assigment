/**
 * Enable Confirm Dialogs
 * 
 * This function will enable confirm dialogs, on UI elements with a given css
 * class. When it finds such elements, it will also look for the data-confirm
 * attribute, in order to fetch the text for display in the confirm dialog.
 * 
 * @access public
 * @param jQuery $container
 * @returns void
 */
function enableConfirmDialogs($container) {
    // When an element with class "confirm" is clicked
    $('.confirm', $container).click(function($event) {
        // Get the text for the confirm dialog
        var txt = $(this).attr('data-confirm');
        
        // Default the text, if not provided
        if(! txt) {
            // We should try to avoid this technical and generic phrase. So,
            // please make sure to configure a text for the confirm dialog! :)
            txt = 'Ben je zeker dat je deze operatie wenst uit te voeren op je selectie?'
        }
        
        // Get the confirm dialog's outcome
        // If cancelled:
        if(! confirm(txt)) {
            // Override default behavior
            $event.preventDefault();
            return false;
        }
    });
}

/**
 * Enable Autocomplete Controls
 * 
 * @access public
 * @param jQuery $container
 * @returns void
 */
function enableAutocompleteControls($container) {
     // For each of the Autocomplete Controls encountered in the container:
    $('.autocomplete', $container).each(function(i) {
        
    });
}

// When the DOM is ready
$(document).ready(function() {
    // Enable Confirm Dialogs
    enableConfirmDialogs();
    
    // Enable Autocomplete Controls:
    enableAutocompleteControls();
    
    // Whenever the list is updated:
    $('.list').bind('List_Update', function($event, $html, ajaxResponse) {
		// Enable Confirm Dialogs there too:
		enableConfirmDialogs($html);
	});
});