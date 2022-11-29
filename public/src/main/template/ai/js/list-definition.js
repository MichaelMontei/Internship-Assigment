
// When the DOM is ready
$(document).ready(function() {
	// ----
	// When filters have been applied to the list
	$('.filters').bind('Ai_FilterInterface_Applied', function($event, options, data) {
		// Prepare the HTML to be added:
		var $html = $(data.html);
		
		// We update the list:
		$('.list table tbody').html($html);
		
		// Dispatch an event, to notify about an update in the list view:
		dispatchListUpdate($html, data);
	});
	
	// ----
	// Whenever the list is updated:
	$('.list').bind('List_Update', function($event, $html, ajaxResponse) {
		// Initiate the list definition view, in the added HTML:
		initListWithDefinition($html);
		
		// Update the pagejumper info in the interface:
		$('.pagejumper-total').html(ajaxResponse.pagejumper.totalLabel);
		$('.pagejumper-range').html(ajaxResponse.pagejumper.rangeLabel);
		
		// Show new description of applied filters?
		var fd = (typeof ajaxResponse.filters != 'undefined');
		fd = (fd && typeof ajaxResponse.filters.count != 'undefined');
		fd = (fd && typeof ajaxResponse.filters.description != 'undefined');
		fd = (fd && ajaxResponse.filters.count > 0);
		
		$('.filters-description').html(fd ? ajaxResponse.filters.description : '');
	});

	// ----
	// Initiate the list interface:
	initListWithDefinition($('.list'));
});

/**
 * Initiate list interface
 * 
 * @access public
 * @param jQuery $addedHtml
 * @return void
 */
function initListWithDefinition($addedHtml) {
	// ----
	// Toggle buttons
	$('.toggle').click(function($event) {
		// Set the state of the clicked link to "loading"
		var $t = $(this);
		$t.Ai_ShowLoading({ loading : true });
		
		// Run the AJAX call to toggle the value:
		$.ajax({
			// With the URL of the link
			url      : $(this).attr('href'),
			dataType : 'json',
			// When done loading
			success  : function(data) {
				// Remove loading state of the clicked toggle button
				$t.Ai_ShowLoading({ loading : false, loadingClass : 'loading' });
				
				// And, update the label of the button:
				$t.html('<i class="icon icon-dot toggle-' + data.toggleState + '"></i>' + data.toggleLabel);
			}
		});
		
		// Override the default behavior of the button
		$event.preventDefault();
	});
	
	// ----
	// When the user clicks on "load more" or "load previous"
	$('.load-more, .load-previous', $addedHtml).click(function($event) {
		// If the list definition has not been provided:
		if(typeof AiListDefinition == 'undefined') {
			// Then, we stop here. In this case, the actions of the button are
			// not overridden, and the traditional page jumper will be used 
			// instead, loading in a page per load...
			return true;
		}
		
		// We compose the URL for an AJAX call, to load more items into the list:
		var u = jQueryBaseHref + '/ai/grid/instances/' + AiListDefinition.definitionId;
		
		// We extract additional query variables from the clicked button:
		var h = $(this).attr('href');
		var p = h.indexOf('?');
		var q = p != -1 ? h.substring(p, h.length) : '';
		
		// Get the button's class
		var c = $(this).attr('class');
		
		// We show a loading state, in the button:
		$(this).Ai_ShowLoading({
			// Show as loading
			loading : true,
			// CSS Classes to be used for indicating loading state:
			loadingClass : c + '-loading',
			idleClass : c
		});
		
		// Create a reference to the clicked button, for use in callback functions
		var $t = $(this);
		
		// We perform the AJAX call:
		$.ajax({
			// With the URL:
			url : u + q,
			// We expect JSON to be returned by the call:
			dataType : 'json',
			// When done:
			success : function(data) {
				// Prepare the HTML to be added:
				var $html = $(data.html);
				
				// If PREVIOUS items have been loaded:
				if(c == 'load-previous') {
					// Since the AJAX has been used to load previous items, we
					// remove the button to load more items in the newly added HTML.
					// This button would load in instances that are already showing:
					$('.load-more', $html).remove();
					
					// Then, we prepend the items:
					$('.list table tbody').prepend($html);
				}
				// If MORE items have been loaded
				else if(c == 'load-more') {
					// Since the AJAX has been used to load more items, we
					// remove the button to load previous items in the newly added 
					// HTML. This button would load in instances that are already 
					// showing:
					$('.load-previous', $html).remove();
					
					// Then, we append the items:
					$('.list table tbody').append($html);
				}
				
				// We remove the loading state from the button:
				$t.Ai_ShowLoading({
					loading : false,
					loadingClass : c + '-loading',
					idleClass : c
				});
				
				// We remove the clicked button:
				$t.parent().remove();
				
				// Dispatch an event, to notify about an update in the list view:
				dispatchListUpdate($html, data);
			}
		});
		
		// We override the default behavior of the button
		return $event.preventDefault();
	});
}