
// When the DOM is ready
$(document).ready(function() {
	// ----
	// When all items are selected, with the "select all" checkbox:
	$('.list').bind('List_SelectAll', function($event, $checkboxAll) {
		// Show loading state:
		showListLoadingState(true);
		
		// Load the contextual menu:
		$.ajax({
			// We compose the URL for the AJAX call:
			url : jQueryBaseHref + '/ai/grid/select-all-context-menu/' + AiListDefinition.definitionId,
			// Note that we also send query variables to maintain filter values:
			data : getDataForAjaxCheckboxes(),
			// Expected data type of the response
			dataType : 'json',
			// When loaded:
			success : function(data) {
				// Remove loading state:
				showListLoadingState(false);
				
				// If a contextual menu is to be shown:
				// (the response will also inform us about that)
				if(data.showContextualMenu) {
					// Show the contextual menu for the checkbox:
					$checkboxAll.Ai_ContextWindow({
						// The contextual menu:
						'onGetElement' : function() {
							return $(data.html);
						},
						// When the contextual menu is being shown:
						'onShow' : initSelectAllContextualMenu,
						// Set the behavior of the contextual menu with some additional
						// properties. We set some hiding flags:
						'hideOnScroll' : false,
						'hideOnClickOutside' : true,
						'hideForOtherWindows' : true,
						'hideOnWindowResize' : false,
						'hideOnClick' : false,
						// We animate the contextual menu into view:
						'position' : {
							'positionX' : ['left', 'right'],
							'positionY' : ['alignCenters'],
							'animate' : {
								'easing' : 'easeOutElastic',
								'duration' : 600,
								'properties' : {moveX : 50, moveY : 50},
								'callback' : function() {
								}
							},
							'positionClasses'  : {
								'top'    : 'bottom',
								'right'  : 'right',
								'bottom' : 'top',
								'left'   : 'left'
							}
						}
					});
				}
			}
		});
	});

	// ----
	// When all items are unselected, with the "select all" checkbox:
	$('.list').bind('List_UnselectAll', function($event, $checkboxAll) {
		// Undo the selection made with the context menu
		undoSelectionByContextMenu(true, true);
	});

	// ----
	// When the list is updated:
	$('.list').bind('List_Update', function($event, $addedHtml, ajaxResponse) {
		// Initiate the list view with checkboxes, in the added HTML:
		initListWithDefinitionAndCheckboxes($addedHtml);
	});
	
	// ----
	// When filters are about to be applied to the list:
	$('.filters').bind('Ai_FilterInterface_Apply', function($event, options, data) {
		// Then, items are unselected:
		undoSelectionByContextMenu(true, true);
	});

	// ----
	// Initiate the list interface with checkboxes:
	initListWithDefinitionAndCheckboxes($('.list'));
});

// Global working variables
selectedAllWithContextMenu = false;

/**
 * Respond to contextual menu
 * 
 * This function will be registered as the 'onShow' callback of the contextual
 * menu, which is shown for the "select all" checkbox.
 * 
 * @access public
 * @param $(matchedElement) $checkboxAll
 * @param $(matchedElement) $contextWindow
 * @param stdObject options
 * @return void
 */
function initSelectAllContextualMenu($checkboxAll, $contextWindow, options) {
	// Override the behavior of the button "Select all" in the
	// contextual menu, so it is performed via AJAX:
	$('a[href*="ai/grid/select-all/"]', $contextWindow).click(function($event) {
		// Hide the contextual menu:
		hideSelectAllContextMenu();
		
		// Show loading state:
		showListLoadingState(true);
		
		// Perform the AJAX call:
		$.ajax({
			url : $(this).attr('href'),
			data : $('.filters').Ai_FilterInterfaceQueryVariables(),
			dataType : 'json',
			success : function(data) {
				// When the AJAX call is complete, we should have received 
				// information about the selected items. We show this info now,
				// by appending the HTML provided in the response to the list:
				var $html = $(data.html);
				$('.list table').before($html);
				
				// Select all checkboxes:
				setCheckboxesState(true);
				
				// Set the global boolean of "selecting all?" to TRUE:
				selectedAllWithContextMenu = true;

				// Again, we want the "undo selection" button in the appended 
				// HTML to run via AJAX. So, we overwrite the click handler:
				$('a[href*="ai/grid/unselect-all"]', $html).click(function($event) {
					// When clicked, undo the selection that was made with the
					// contextual menu:
					dispatchCheckboxAll(false, $('.list input[type="checkbox"][name="all"]'));

					// Prevent default handling of the click event (Undo button)
					$event.preventDefault();
				});

				// Remove loading state:
				showListLoadingState(false);
			}
		});

		// Prevent default handling of the click event (Select All button)
		$event.preventDefault();
	});
}

/**
 * Remove selection info
 * 
 * This function is used to remove the information about the current selection,
 * and to undo the "select all" operation that has been completed with the
 * contextual menu.
 * 
 * @access public
 * @param boolean unselectAll 
 * @return void
 */
function undoSelectionByContextMenu(unselectAll, hideContextMenu) {
	// If all have been selected with the contextual menu, via AJAX
	if(selectedAllWithContextMenu) {
		// Show loading state:
		showListLoadingState(true);
		
		// Perform the AJAX call to unselect all
		$.ajax({
			url      : jQueryBaseHref + '/ai/grid/unselect-all/' + AiListDefinition.definitionId,
			data     : $('.filters').Ai_FilterInterfaceQueryVariables(),
			dataType : 'json',
			success  : function(data) {
				// When done, remove the info about "selected all":
				$('.select-all-ok').remove();
	
				// Restore the global boolean of "selecting all?" to FALSE again:
				selectedAllWithContextMenu = false;
				
				// If all checkboxes should be unselected:
				if(unselectAll) {
					// Then, do so:
					setCheckboxesState(false);
				}

				// Remove loading state:
				showListLoadingState(false);
			}
		});
	}
	
	// Hide context menu to select all?
	if(hideContextMenu) {
		// Then, do so:
		hideSelectAllContextMenu();
	}
}

/**
 * Hide the contextual menu to select all
 * 
 * @access public
 * @return void
 */
function hideSelectAllContextMenu() {
	$('input[type="checkbox"][name="all"]').Ai_ContextWindowHide();
}

/**
 * Select/Select all checkboxes
 * 
 * @access public
 * @return void
 */
function setCheckboxesState(newState) {
	// For each of the checkboxes in the page:
	$('.list input[type="checkbox"][name!="all"]').each(function() {
		// If the current checkbox' state does not match the target state
		if($(this).is(':checked') != newState) {
			// Then, simulate a click
			// (We simulate a click in order to highlight the corresponding row 
			// in the list view)
			$(this).click();
		}
	});
}

/**
 * Get number of selected checkboxes
 * 
 * @access public
 * @return integer
 */
function getNumberOfCheckedCheckboxes() {
	return $('.list input[type="checkbox"][name!="all"]:checked').length;
}

/**
 * Get data for AJAX calls in checkbox-enabled lists
 * 
 * @access public
 * @return StdObject
 */
function getDataForAjaxCheckboxes() {
	// We'll always send the current selection of filters in AJAX requests. This
	// is important to get the correct number of items in the list.
	var o = $('.filters').Ai_FilterInterfaceQueryVariables();
	
	// We add the number of selected items to the data:
	o['selected'] = getNumberOfCheckedCheckboxes();
	
	// Return the data:
	return o;
}

/**
 * Initiate list interface
 * 
 * @access public
 * @param jQuery $addedHtml
 * @return void
 */
function initListWithDefinitionAndCheckboxes($addedHtml) {
	// Get the checkboxes in the added HTML:
	var $checkboxes = $('input[type="checkbox"][name!="all"]', $addedHtml);
	
	// If all items have been selected, with the context menu:
	if(selectedAllWithContextMenu) {
		// Then, we select all the checkboxes in the HTML that has been added
		// to the list view. When more items are loaded into the list, we want
		// them to appear as selected
		$checkboxes.click();
	}
	
	// When checkboxes are clicked:
	$checkboxes.bind('click', function() {
		// If ALL items have been selected with the contextual menu, and the
		// checkbox has been unselected:
		if(! $(this).is(':checked')) {
			// Then, we undo the selection made with the context menu:
			undoSelectionByContextMenu(false, true);
		}
	});
}