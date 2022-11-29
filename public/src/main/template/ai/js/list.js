
/**
 * Notify about list update
 * 
 * This function can be used to dispatch an event, to notify about an update in
 * the list view.
 * 
 * @access public
 * @param jQuery $newHtml
 * @param stdObject ajaxResponse
 * @return void
 */
function dispatchListUpdate($newHtml, ajaxResponse) {
	// Dispatch the event:
	$('.list').trigger('List_Update', [$newHtml, ajaxResponse]);
}

/**
 * Notify about (un)select all
 * 
 * This function can be used to dispatch an event, to notify about all listed
 * items being selected or unselected
 * 
 * @access public
 * @param bool selected
 * @return void
 */
function dispatchCheckboxAll(selected, $checkboxAll) {
	// Dispatch the event:
	$('.list').trigger(selected ? 'List_SelectAll' : 'List_UnselectAll', [$checkboxAll]);
}

/**
 * Show/hide loading state in list
 * 
 * @access public
 * @param bool loading
 * @return void
 */
function showListLoadingState(loading) {
	if(loading) {
		$(window).Ai_ShowLoading({
			loading      : true,
			forceOverlay : true,
			message      : '<div class="spinning"><i class="icon icon-spinner"></i></div>'
		});
	} else {
		$(window).Ai_ShowLoading({
			loading      : false,
			forceOverlay : true
		});
	}
}

// When the DOM is ready
$(document).ready(function() {
	// ----
	// We set the actions for the link that initiates the filter interface. When
	// that link is clicked:
	$('.filters-init').click(function($event) {
		// If the filter interface is not showing:
		if(! $('.filters-wrap').is(':animated')) {
			// Then, we change the styling of the clicked link. Instead of showing 
			// the search icon, it will now show an arrow pointing upwards. This 
			// serves to indicate that another click will hide the filter interface.
			$(this).hide();
			$('#filters-hide').removeClass('hidden').show();
			
			// We show the filter interface:
			$('.filters-wrap').stop().removeClass('hidden').slideDown(125, function() {
				// If no filter bars have been added to the interface yet, then
				// we add a bar now:
				if($('.filter', $(this)).length == 0) {
					// Add a bar. We do so by triggering a click on the "add filter"
					// button in the interface:
					$('#filter-add').click();
				}
			});
		}
		
		// We are overriding the default behavior of the link:
		$event.preventDefault();
	});

	// ----
	// We set the actions for the link that hides the filter interface. When
	// that link is clicked:
	$('#filters-hide').click(function($event) {
		// If the filter interface is showing:
		if(! $('.filters-wrap').is(':animated')) {
			// Then, we change the styling of the clicked link. Instead of showing 
			// the arrow pointing upwards, we go back to showing the search icon. 
			// This serves to indicate that another click will show the filter 
			// interface again.
			$(this).hide();
			$('.filters-init').removeClass('hidden').show();
			
			// We show the filter interface:
			$('.filters-wrap').slideUp(125);
		}
		
		// We are overriding the default behavior of the link:
		$event.preventDefault();
	});
	
	// ---- If initialized with filter values:
	$('.filters').bind('Ai_FilterInterface_InitValue', function() {
		// Hide the filter to show filters:
		$('.filters-init').hide();
	});

	// ----
	// Checkbox to (un)select all
	$('input[type="checkbox"][name="all"]').click(function() {
		// Get the current state of the checkbox:
		var c = $(this).is(':checked');
		
		// For each checkbox in the list:
		$('input[type="checkbox"][name!="all"]').each(function() {
			// If the state of the current checkbox does not match with the 
			// checkbox that (un)selects all checkboxes:
			if($(this).prop('checked') != c) {
				// Then, click the checkbox to switch states in the interface:
				$(this).click();
			}
		});
		
		// Dispatch an event, to notify about the items selected:
		dispatchCheckboxAll(c, $(this));
	});

	// ----
	// When filters are being applied to the list:
	$('.filters').bind('Ai_FilterInterface_Apply', function($event, values) {
		// If all filters have been removed from the filter interface:
		if(values.length == 0) {
			// Then, we hide the filter interface:
			$('#filters-hide').click();
		}
		
		// Apply loading state to the list:
		showListLoadingState(true);
	});
	
	// ----
	// When filters have been applied to the list
	$('.filters').bind('Ai_FilterInterface_Applied', function($event, options, data) {
		// Remove loading state to the list:
		showListLoadingState(false);
	});
	
	// ----
	// Whenever the list is updated:
	$('.list').bind('List_Update', function($event, $html, ajaxResponse) {
		// Initiate the list view, in the added HTML:
		initList($html);
	});
	
	// ----
	// When all are unselected:
	$('.list').bind('List_UnselectAll', function($event, $checkboxAll) {
		// Then, hide the list options:
		$('.list-options').slideUp(100);
		$checkboxAll.prop('checked', false);
	});

	// ----
	// Initiate the list interface:
	initList($('.list'));
});

/**
 * Initiate list interface
 * 
 * This function is called whenever the list is updated. Among others, it will 
 * enable row options (suckerfish) in the added HTML, change the behavior of
 * page jumper buttons, etc.
 * 
 * @access public
 * @param jQuery $addedHtml
 * @return void
 */
function initList($addedHtml) {
	// Prepare a variable to contain the added rows:
	var $tr;
	
	// If the provided HTML is a collection of rows:
	if($addedHtml.is('tr')) {
		// Then, we fetch the rows as such:
		$tr = $addedHtml.filter('tr[class!="nopadding"]');
	}
	// If the provided HTML is the wrapper of the list:
	else {
		$tr = $('tr[class!="nopadding"]', $addedHtml);
	}
	
	// ----
	// For each row in the list, we set the actions for rollover:
	$tr.hover(function() {
		// When rolled over, we add the class "hover" to the row:
		$(this).addClass('hover');
		
	// We also set actions for rollout:
	}, function() {
		// When rolled out of the row, we remove the "hover" class:
		$(this).removeClass('hover');
	});

	// ----
	// We activate the suckerfish menu's in the list:
	$tr.find('a.with-sf').Ai_Suckerfish({
		// We open the menu when the trigger element is clicked (not hovered)
		trigger    : 'click',
		// The callback menu that provides with the menu:
		onGetMenu  : function($trigger) {
			// We lookup the menu for the trigger element. The menu has the same
			// ID, with the string "-sf" appended to it:
			return $('#' + $trigger.attr('id') + '-sf').show();
		},
		// Callback function when the menu is shown:
		onShow     : function($trigger, $menu) {
			// When the menu is shown, we set the corresponding row to "selected"
			$trigger.parent().parent().removeClass('hover').addClass('active');
		},
		// When hidden:
		onHide     : function($trigger, $menu) {
			// When the menu is hidden, we remove the "selected" state from the
			// corresponding row in the list:
			var $row = $trigger.parent().parent().removeClass('active');
		},
		// We define the positioning for the suckerfish menu. Note that all options
		// for the S_Tooltip plugin are available here. In the list view, we align
		// the menu's right edges with the right edges of the table grid.
		position   : {
			positionX : [ 'alignRightEdges' ],
			positionY : [ 'bottom', 'top' ],
			margin : {
				top : 0,
				bottom: 0,
				left : 0,
				right : 0
			}
		}
	});

	// ----
	// If no checkboxes have been checked so far:
	if($('input[type="checkbox"][name!="all"]:checked').length == 0) {
		// Then, hide the list options:
		$('.list-options').hide();
	}

	// ----
	// Checkboxes:
	$('input[type="checkbox"][name!="all"]', $addedHtml).Ai_Selectables({
		// Return the highlighted element, when selected:
		'getHighlighted' : function($trigger, options) {
			// Return the row (TR)
			return $trigger.parent().parent();
		},
		// When selected:
		'onSelect' : function($trigger, $highlightedElement) {
			// Remove the hover class from the row:
			$highlightedElement.removeClass('hover');
			
			// Show the list options:
			$('.list-options').slideDown(100);
		},
		// When unselected:
		'onUnselect' : function($trigger, $highlightedElement) {
			// If no checkboxes are selected anymore:
			if($('input[type="checkbox"][name!="all"]:checked').length == 0) {
				// Hide the list options:
				$('.list-options').slideUp(100);
			}
		}
	});
}