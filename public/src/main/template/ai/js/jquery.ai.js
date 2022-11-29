// Create closure for plugins, with a self-executing function that takes jQuery
// as an argument. This way, we avoid collisions with other libraries. Another
// advantage is that, any function declared inside the closure, is private and
// accessible only to the plugin function.
(function($) {
	/**
	 * Registry
	 * 
	 * We add a registry with global variables, for use by the plugin functions
	 * below.
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.Ai_Registry = {};
	
	/**
	 * Get translated text
	 * 
	 * Will return a translated text in javascript. The translations are handled
	 * by the application's Locale Message Catalog.
	 * 
	 * @access public
	 * @return void
	 */
	$.Ai_TranslatedString = function(string) {
		// Please use the locale-js module
        return string;
		if(typeof t == 'function') { 
			return t(string);
		}
		$.Ai_Console('Please install the locale-js module to translate strings in the Ai-module');
		return string;
	}
	
	/**
	 * Write to console
	 * 
	 * A function that allows to release debugging information via the Firebug 
	 * console, or via other browser-enabled consoles. This is a handy replacer
	 * of the alert() function, since it does not get in the way while testing the
	 * application.
	 * 
	 * @access public
	 * @param mixed arg
	 *		The variable to be dumped to the console window of the browser
	 * @return void
	 */
	$.Ai_Console = function(arg) {
		// Is a console window available?
		if(window.console && window.console.log) {
			// If so, go ahead and throw the debugging information at it:
			window.console.log(arg);
		}
	};
	
	/**
	 * Assign ID
	 * 
	 * Will make sure that each of the matched elements gets assigned a unique 
	 * ID. If an element already had an ID, then it will be left unaffected.
	 * 
	 * @access public
	 * @return $(matchedElements)
	 */
	$.fn.Ai_AssignId = function() {
		// This function maintains an incremental counter, in order to generate
		// unique ID's for elements on the page. If this counter has not yet been
		// initiated:
		if(typeof $.Ai_Registry.AssignIdCounter == 'undefined') {
			// Then, we initiate it now:
			$.Ai_Registry.AssignIdCounter = 0;
		}
		
		// For each of the matched elements:
		this.each(function() {
			// Get the currently assigned ID
			var i = $(this).attr('id');
			
			// If no ID has been assigned at all
			if(! i) {
				// Then, we assign it now:
				$(this).attr('id', 'Auto-ID-' + (++ $.Ai_Registry.AssignIdCounter));
			}
		});
		
		// Return the matched elements
		return this;
	};
	
	/**
	 * Cookies
	 *
	 * With this plugin function, you can easily create cookies on the client's
	 * computer.
	 * 
	 * Write a cookie:
	 * $.Ai_Cookie('my-cookie', 'my-value', { expireString : '1 year' });
	 * 
	 * Read a cookie:
	 * $.Ai_Cookie('my-cookie');
	 * 
	 * Delete a cookie:
	 * $.Ai_Cookie('my-cookie', null);
	 * $.Ai_Cookie.remove('my-cookie');
	 * 
	 * @access public
	 * @param string name
	 * @param string value
	 * @param StdObject options
	 * @return void
	 */
	$.Ai_Cookie = function(name, value, options) {
		// If both a name and a value has been given
		if(arguments.length > 1 && typeof value != "object") {
			// Merge the provided options with the default ones:
			options = $.extend({}, $.Ai_Cookie.defaults, options);
			
			// If the value NULL or UNDEFINED has been provided, then we delete
			// the cookie:
			if(value === null || value === undefined) {
				// A cookie is deleted by setting the expiration date to a date
				// in the past. We simply set the date to -1:
				options.expires = -1;
			}
			// If not, we look at the expiration date:
			else {
				// If the expiration date has been provided as a string description
				var temp = $.trim(options.expireString);
				if(temp) {
					// We explode the description into an array:
					var parts = temp.split(' ');

					// We expect exactly 2 parts in the provided string: a number, 
					// and a date part string:
					if(parts.length == 2) {
						// Get the number. Note that a description such as 'an hour'
						// may be used also. That is always converted to the number 1:
						var n = (parts[0] == 'a' || parts[0] == 'an') ? 1 : parseInt(parts[0]);

						// If so, we convert the provided number into a number seconds.
						// How many seconds, that depends on the provided date part:
						switch(parts[1].toString().toLowerCase()) {
							case 'second':
							case 'seconds':
								n *= 1000;
								break;
							
							case 'minute':
							case 'minutes':
								n *= 60000;
								break;
							
							case 'hour':
							case 'hours':
								n *= 3600000;
								break;
							
							case 'day':
							case 'days':
								n *= 86400000;
								break;

							case 'week': 
							case 'weeks':
								n *= 604800000;
								break;

							case 'month': 
							case 'months':
								n *= 2629744000;
								break;

							case 'year': 
							case 'years':
								n *= 31556926000;
								break;
						}

						// Compose the final expiration date:
						options.expires = new Date();
						options.expires.setTime(options.expires.getTime() + n);
					}
				}
			}
			
			// Cast the value to a string:
			value = String(value);
			
			// Finally, set the cookie:
			document.cookie = [
				// With the provided name:
				encodeURIComponent(name), '=',
				// Raw value?
				options.raw     ? value : encodeURIComponent(value),
				// Expiration date (if any):
				options.expires ? '; expires=' + options.expires.toUTCString() : '',
				// Cookie path:
				options.path    ? '; path=' + options.path : '',
				// Cookie domain:
				options.domain  ? '; domain=' + options.domain : '',
				// Secure cookie?
				options.secure  ? '; secure' : ''
			].join('');
		}
		// If only a name has been provided as an argument to this function, 
		// maybe with options:
		else {
			// Merge the provided options with the default ones:
			options = $.extend({}, $.Ai_Cookie.defaults, value);
			
			// Return the value:
			var result, decode = options.raw ? function (s) {return s;} : decodeURIComponent;
			return (result = new RegExp('(?:^|; )' + encodeURIComponent(name) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
		}
	};
	
	/**
	 * Delete a cookie
	 * 
	 * @access public
	 * @param string name
	 * @return void
	 */
	$.Ai_Cookie.remove = function(name) {
		// We remove a cookie, by setting the value to NULL or undefined
		$.Ai_Cookie(name, null);
	};
	
	/**
	 * Cookie, default options
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.Ai_Cookie.defaults = {
		// The date at which the cookie value should expire. If you want the
		// cookie to expire after the current session, you should not provide
		// a date at all. In any other case, you should provide with an instance
		// of Date()
		'expires'       : null,
		// If you prefer to describe the expiration date as a string, you can
		// do so by providing a value for this option. The idea is that you
		// provide a description with a number, and a date part. Accepted 
		// values would include e.g. '1 second', 'a minute', 'an hour', '2 hours',
		// '1 day', '7 days', 'a week', '2 weeks', 'a month', '3 months', 
		// '1 year', '20 years', etc.
		// NOTE: If a value is provided here, then the date provided in the
		// 'expire' option will be ignored!
		'expireString'  : '',
		// The path at which you want to create the cookie. Again, this value
		// is optional.
		'path'          : null,
		// The domain
		'domain'        : null,
		// If you whish to create a secure cookie, you should set this option
		// to TRUE. Note that, in order to create a secure cookie, the connection
		// must be established via https://
		'secure'        : false,
		// Store as raw data?
		'raw'           : false

	};
	
	/**
	 * Selectables
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_Selectables = function(options) {
		// Merge the provided options with the default ones:
		options = $.extend({}, $.fn.Ai_Selectables.defaults, options);
		
		// Set the actions for a click on the selectable:
		$(this).click(function($event) {
			// Get the element to be highlighted:
			var $highlight = options.getHighlighted($(this), options);
			
			// If the highlighted element has not been found:
			if(! $highlight || ($highlight && $highlight.length == 0)) {
				// Then, we stop here.
				return true;
			}
			
			// The new selectable state.
			var state;
			
			// When clicked, we get the current selectable state of the clicked
			// item. If the item is a checkbox:
			/* if($(this).is('input[type="checkbox"]')) {
				// Then, we determine the selected state of the selectable by
				// reading the "checked" property of the checkbox:
				state = $(this).is(':checked');
				
				// Set the new state of the checkbox:
				$(this).prop('checked', state);
			}
			// If the item is not a checkbox:
			else { */
			
				// Then, we read the selected state by checking whether or not
				// the highlighted element has the highlighted css class:
				state = ! $highlight.hasClass(options.highlightedClass) ? true : false;
			
			/* } */
			
			// Now, we change the selectable state to its contrary state. This 
			// causes each click to select/unselect the items. If now selected:
			if(state) {
				// Then, add the css class:
				$highlight.addClass(options.highlightedClass);
				
				// Dispatch a call to the callback function
				options.onSelect($(this), $highlight, options);
			}
			// If now unselected
			else {
				// Then, remove the class
				$highlight.removeClass(options.highlightedClass);
				
				// Dispatch a call to the callback function
				options.onUnselect($(this), $highlight, options);
			}
		});
		
		// Return matched elements:
		return this;
	}
	
	/**
	 * Selectables, default options
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_Selectables.defaults = {
		// The element to be highlighted, when selected. In many cases the matched
		// elements are the triggers, but not the highlighted elements. The 
		// highlighted element is often the parent of the element. Here, you can
		// specify a callback function that provides with the highlighted element.
		// By default, this option returns the trigger element.
		'getHighlighted'      : function($trigger, options) {
			return $trigger;
		},
		// The CSS class to be used in order to highlight an element in the 
		// interface, when selected:
		'highlightedClass'    : 'selected',
		// When item is selected
		'onSelect' : function($trigger, $highlightedElement) {},
		// When item is unselected
		'onUnselect' : function($trigger, $highlightedElement) {}
	};
	
	/**
	 * Filter interface
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_FilterInterface = function(options) {
		// Merge the provided options with the default ones:
		options = $.extend({}, $.fn.Ai_FilterInterface.defaults, options);
		
		// Store some additional information in the provided object of options:
		options.filterInterfaceContainer = this;
		
		// If a button has been provided, for creating more filter bars:
		if(options.addButton) {
			// Get that button
			var $add = $(options.addButton);

			// If that button has been found in the page:
			if($add.length > 0) {
				// Then, we set the actions for that button. When the button 
				// is clicked:
				$add.click(function($event) {
					// We add a new filter bar:
					_addFilterBar(options);

					// We override the default behavior of the button:
					$event.preventDefault();
				});
			}
		}
		
		// If a button has been provided, for applying the filter values:
		if(options.applyButton) {
			// Get that button:
			var $apply = $(options.applyButton);
			
			// If that button has been found in the page:
			if($apply.length > 0) {
				// Then, we set the actions for that button. When the button 
				// is clicked:
				$apply.click(function($event) {
					// We apply the filters:
					_applyFilterValues(_getFilterValues(options), options);

					// We override the default behavior of the button:
					$event.preventDefault();
				});
			}
		}
		
		// Temporary working variables
		var i, j, $bar;
		
		// For each initial filter bar provided in the filter interface:
		for(i in options.initValues) {
			// We add a new filter bar:
			// (note that we disable animation, for the filter bars that are 
			// added to the page immediately)
			$bar = _addFilterBar(options, false);
			
			// Set the selected filter:
			_setFieldValue($bar, 0, options.initValues[i][0], options);
			
			// Notify about value initialization:
			_dispatchUpdate(options, $bar, 0, 'InitValue', false);
			
			// For each value provided in the current filter bar:
			for(j = 1; j < options.initValues[i].length; j ++) {
				// Prepare the field for the corresponding step in the filter bar:
				var $field = options.onGetField(parseInt(_getFilterValue($bar, 0, options)), j, _getFilterValue($bar, j - 1, options), _getFilterValues(options));
				
				// If a field has been provided:
				if($field) {
					// We insert the corresponding field into the filter step:
					_setFilterStepHtml($bar, j, $field, options);
					
					// We set the field's initial value:
					_setFieldValue($bar, j, options.initValues[i][j], options);
					
					// We set the new field's actions:
					_setFieldActions($bar, j, options);
			
					// Notify about value initialization:
					_dispatchUpdate(options, $bar, j, 'InitValue', false);
				}
			}
		}
		
		// Set current filter values, so they become available with Ai_FilterInterfaceValues
		$(this).data('Ai_FilterInterfaceValues', _getFilterValues(options));
		
		// Notify about value initialization:
		_dispatchUpdate(options, $bar, 0, 'InitValues', false);
		
		// Return the matched elements:
		return this;
	}
	
	/**
	 * Filter Interface: get values
	 * 
	 * @access public
	 * @return Array
	 */
	$.fn.Ai_FilterInterfaceValues = function() {
		// Get the values
		var values = $(this).data('Ai_FilterInterfaceValues');
		
		// Return them:
		if(! values) {
			return [];
		} else {
			return values;
		}
	}
	
	/**
	 * Filter Interface: get query variables for updating list
	 * 
	 * @access public
	 * @return Array
	 */
	$.fn.Ai_FilterInterfaceQueryVariables = function() {
		return _getQueryVariablesFromValues($(this).Ai_FilterInterfaceValues());
	}
	
	/**
	 * Filter interface, default options
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_FilterInterface.defaults = {
		// The maximum number of filters that may be applied to the list:
		'maximumFilters'       : null,
		// The available filters. This property is an object/collection with the 
		// titles of the filters to be made available in the interface.
		'filters'              : [],
		// Enable animations in the filter bar? (when adding a new filter bar,
		// removing a filter bar from the interface, etc.)
		'animate'              : true,
		// Easing, for the animation of the progress bar
		'easing'               : null,
		// Duration of the animation
		'duration'             : 200,
		// The CSS class to be used for each filter bar in the interface:
		'filterBarClass'       : 'filter',
		// The CSS class to be used for each ODD filter bar in the interface
		'filterBarClassOdd'    : 'odd',
		// The CSS class to be used for each EVEN filter bar in the interface
		'filterBarClassEven'   : 'even',
		// The DOM element that is used as a button to add new filter bars to 
		// the filter interface:
		'addButton'            : null,
		// A filter may require multiple steps in order to provide with a complete
		// filter value. Once a filter is selected, this callback function is 
		// called to retrieve the field (input control) for the next step. When
		// a value is introduced in that field, the function will be called again
		// in order to populate the next input control. This structure keeps 
		// repeating itself, until no field is returned by this callback function.
		// This callback function is provided with three arguments. The first one
		// informs about the selected filter, the second one indicates the index
		// number of the step for which a field is being requested. Finally, the
		// third argument provides with the previous value, and the fourth with
		// all values.
		'onGetField'           : function(filterIndex, stepIndex, previousValue, values) {
			// By default, no additional steps are created:
			return null;
		},
		// Callback for when a step/field is shown, in the filter interface:
		'onShowField'          : function() {
		},
		// Callback for when a new filter bar is shown:
		'onShowFilterBar'      : function($filterBar) {
		},
		// Whenever a new filter value is created, an existing filter value is
		// updated, or a filter is deleted, this callback function is called. 
		// Typically, this function will be used to update the list of instances
		// for the current selection of filters. Therefore, this function is
		// supplied with an array that contains the currently introduced filter 
		// values.
		'onUpdate'             : function(allValues, filterBarValues, $filterBar, stepIndex) {
		},
		// When filters are initiated - with the initValues property - this
		// callback function will be called. Typically, this function will be used
		// to respond to the filter interface being initialized:
		'onInitValue'          : function(allValues, filterBarValues, $filterBar, stepIndex) {
		},
		// Whenever a value is changed in a filter bar, this callback function 
		// will be called.
		'onChangeValue'        : function(allValues, filterBarValues, $filterBar, stepIndex) {
		},
		// When filters are initiated - with the initValues property - this
		// callback function will be called. Typically, this function will be used
		// to respond to the filter interface being initialized:
		'onRemove'             : function(allValues) {
		},
		// When the user interacts with the filter interface, this callback
		// function is called. Note that an interaction is not necessarily an 
		// update of the filter values. For example, the user may select another
		// value in a previous step of a filter, which starts up the process of
		// composing a new filter value. Only when the final value - in the last 
		// step of a filter - is introduced, the onUpdate() callback is called.
		// All previous steps will cause the onInteraction() to be called.
		'onInteraction'        : function() {},
		// The Update URI:
		'updateURL'            : '',
		'updateURLDataType'    : 'json',
		'updateLive'           : false,
		'updateOnEnterKey'     : true,
		'updateOnRemoveFilter' : false,
		'updateButton'         : null,
		// The URI for validations of filter fields, via AJAX:
		'validateURL'          : '',
		'validateURLDataType'  : 'json',
		// Whenever the filter values are applied, this function will be called.
		// In order to apply filter values, an AJAX call is performed. This function
		// will be called when initiating that call. Also, this function receives
		// the values that are being applied to the list:
		'onApply'              : function(values) {},
		// In order to apply filter values, an AJAX call is performed. This function
		// will be called when we get a response from that call.
		'onApplied'            : function(data) {},
		// The initial selection of filters. Each filter is an entry in the array,
		// which in turn are other arrays, containing the filter's index number 
		// at element 0 and the values for each step.
		'initValues'           : []
	};
	
	function _getNewFilterBar(options) {
		// The output variable:
		var out = '';
		
		// Temporary working variables:
		var c;
		var i = 0;
		
		// Add the HTML for the wrapper of the filter bar:
		out += '<div class="'+ options.filterBarClass +'">';
		
		// We add a button to remove the current filter bar
		out +=    '<a href="javascript:return;" class="remove">';
		out +=       '<i class="fa fa-minus-circle fa-lg"></i>';
//		out +=       $.Ai_TranslatedString('Verwijder');
		out +=    '</a>';
		
		// We add a container of the first step (containing the available filters)
		out +=    '<div class="filter-step step-0">';
		
		// Start the HTML of the field with filters
		// (This field is a select field that allows the user to pick a filter)
		out +=       '<select class="field-select form-control" size="0">';
		
		// Add an empty option 
		out +=          '<option value="-">';
		out +=             $.Ai_TranslatedString('Kies een filter');
		out +=          '</option>';
		
		// For each of the filters available:
		for(c in options.filters) {
			// Add the filter to the field:
			out +=       '<option value="'+ (i ++) +'">';
			out +=          options.filters[c];
			out +=       '</option>';
		}
		
		// Finish the field with filters:
		out +=       '</select>';
		
		// Close the container of the first step:
		out +=    '</div>';
		
		// Close the wrapper of the filter bar:
		out +=    '<div class="clear clearfix"><!-- --></div>';
		out += '</div>';
		
		// Return the filter bar:
		return $(out);
	}
	
	function _setFilterBarActions($filterBar, options) {
		// Get the delete button, and set the (click) actions for that button:
		$('.remove', $filterBar).click(function($event) {
			// When clicked, remove the filter bar:
			_removeFilterBar($filterBar, options);
			
			// We prevent the default behavior of the button:
			$event.preventDefault();
		});
	}
	
	function _getField($filterBar, stepIndex, options) {
		// Get the container of the requested step:
		var $step = $('.step-' + stepIndex, $filterBar);
		
		// If not found
		if($step.length < 1) {
			// Then, we return an empty result
			return null;
		}
		
		// Output variable
		var $field;
		
		// If the field is to be looked up in the first step of the filter 
		// interface
		if(stepIndex == 0) {
			// Then the field will be a SELECT. This field allows the user to 
			// pick one of the available filters. Since this field is rendered by
			// this very jQuery plugin, we know that it is a SELECT, and we will 
			// only accept that type of field!
			$field = $('select', $step);
		}
		// If the field is to be looked up in an 'additional' step
		else {
			// In that case, the field may be of many types:
			$field = $('input[type="text"], input[type="checkbox"], select', $step);
		}
		
		// If no field could have been found at all:
		if($field.length < 1) {
			// Then, we return an empty result
			return null;
		}
		
		// Return the field:
		return $field;
	}
	
	function _setFieldActions($filterBar, stepIndex, options) {
		// Get the field:
		var $field = _getField($filterBar, stepIndex, options);
		
		// If no field has been selected:
		if(! $field) {
			// Then, we stop here:
			return;
		}
		
		// If the field is in the first step of the filter interface,
		if(stepIndex == 0) {
			// Then the field will be a SELECT. This field allows the user to 
			// pick one of the available filters. Since this field is rendered by
			// this very jQuery plugin, we know that it is a SELECT, and we will 
			// only accept that type of field!
			// So, we'll respond to the change() event
			$field.change(function() {
				// Each time the user selects a option that is different from the
				// current one, this will represent a choice being made in the 
				// field, and will cause the interface to jump to the next step:
				_applyFilterStep($filterBar, stepIndex, options, 'FilterSelect');
			});
		}
		// If the field is an input control
		else if($field.is('input')) {
			// If the field is a text field:
			if($field.attr('type') == 'text') {
				// Then, we'll listen to a key stroke on the <Enter> key:
				$field.Ai_KeyCombo(['enter'], function($event) {
					// When the <Enter> key is hit, we'll go to the next step
					// in the filter interface. We interpret the <Enter> key as
					// the key that finishes a text value.
					_applyFilterStep($filterBar, stepIndex, options, 'EnterKey');
					
					// We prevent the page from submitting the wrapping form,
					// when the Enter key is hit:
					$event.preventDefault();
					return false;
				});
				
				// When the user types in the field:
				$field.keypress(function() {
					// Then, we hide contextual menu's:
					// (e.g. error messages of the filters)
					$.Ai_ContextWindowEachActive(function($trigger) {
						$trigger.Ai_ContextWindowHide();
					})
				});
			}
			// If the field is a checkbox field:
			else if($field.attr('type') == 'checkbox') {
				// In that case, we'll respond to the checkbox being clicked. 
				$field.click(function() {
					// Each click will change the state of the checkbox, and 
					// therefore will show the next step of the filter:
					_applyFilterStep($filterBar, stepIndex, options, 'CheckboxClick');
				});
			}
			// If any other type of field:
			else {
				// We'll respond to the change() event
				$field.change(function() {
					// Each change in the field's value will represent a decision
					// made in the field, and will cause the interface to jump to 
					// the next step:
					_applyFilterStep($filterBar, stepIndex, options, 'Change');
				});
			}
		}
		// If the field is a select field
		else if($field.is('select')) {
			// We'll respond to the change() event
			$field.change(function() {
				// Each time the user selects a option that is different from the
				// current one, this will represent a choice being made in the 
				// field, and will cause the interface to jump to the next step:
				_applyFilterStep($filterBar, stepIndex, options, 'Change');
			});
		}
	}
	
	function _setFieldValue($filterBar, stepIndex, value, options) {
		// Get the field in the requested step:
		var $field = _getField($filterBar, stepIndex, options);
		
		// If the field has been found:
		if($field) {
			// Then, set its value:
			$field.val(value);
		}
	}
	
	function _applyFilterStep($filterBar, stepIndex, options, eventString) {
		// Get the filter's value in the provided step:
		var tmp = _getFilterValue($filterBar, stepIndex, options);
		
		// If the filter value is empty:
		if(! tmp) {
			// Then, we stop here:
			return;
		}
			
		// Dispatch a change of values in the filter interface
		// (Note that we do not apply the filter values just yet. First, we'll
		// check if a next field is available in the interface)
		_dispatchUpdate(options, $filterBar, stepIndex, 'ChangeValue', false);
		
		// Get the index of the next step:
		var nextStepIndex = stepIndex + 1;
		
		// Get the current field value, in the next step, before we remove that
		// field from the interface
		var nextField = _getField($filterBar, nextStepIndex, options);
		var nextFieldValue = nextField && nextField.is('input[type="text"]') ? nextField.val() : null;
		
		// We remove the field that is showing now:
		_clearFilterStepHtml($filterBar, nextStepIndex, options);
		
		// We get the field that is to be shown now. In order to do so, we dispatch
		// a call to the callback function that provides us with the field for
		// the next step:
		var $field = options.onGetField(parseInt(_getFilterValue($filterBar, 0, options)), nextStepIndex, _getFilterValue($filterBar, stepIndex, options), _getFilterValues(options));
		
		// If a field has been provided:
		if($field) {
			// We insert the new field into the filter step:
			_setFilterStepHtml($filterBar, nextStepIndex, $field, options, nextFieldValue);
			
			// We set the new field's actions:
			_setFieldActions($filterBar, nextStepIndex, options);
			
			// If we have recovered a value from the field, prior to updating
			// the interface:
			if(nextFieldValue) {
				// Get the new field:
				var $temp = _getField($filterBar, nextStepIndex, options);

				// If a field is found
				if($temp) {
					// Then, set the field's value to the one we fetched from the
					// field prior to updating the interface.
					$temp.val(nextFieldValue);
				}
			}
			
			// We apply the new step in the filter bar. This is done because the
			// field may allow to skip to the next step in the filter directly.
			// However, if the selected/introduced value in the new step is empty,
			// then the _applyFilterStep() function will stop.
			_applyFilterStep($filterBar, nextStepIndex, options, eventString);
		}
		// If no field has been provided for the next step, then the filter is
		// complete (all values have been inserted). In this case, we dispatch
		// an event to notify about an update in the filter interface:
		else {
			// Apply the filters, after having dispatched the update?
			var applyFilters = (options.updateLive || (typeof options['updateOn' + eventString] != 'undefined' && options['updateOn' + eventString]));
			
			// Dispatch the update:
			_dispatchUpdate(options, $filterBar, stepIndex, 'Update', applyFilters);
		}
	}
	
	// Converts the selected values to a set of query variables, for URL's
	function _getQueryVariablesFromValues(values, options) {
		var out = {};
		var n = 0;
		var i, temp;
		for(i in values) {
			out['f' + n] = values[i][0];
			if(values[i].length > 1) {
				out['v' + n] = {};
				for(temp = 1; temp < values[i].length; temp ++) {
					out['v' + n][temp - 1] = values[i][temp];
				}
			}
			else {
				out['v' + n] = '';
			}
			n ++;
		}
		return out;
	}
	
	// IMPORTANT NOTE:
	// Should return NULL if the value is considered empty!
	function _getFilterValue($filterBar, stepIndex, options) {
		// Get the field in the requested step:
		var $field = _getField($filterBar, stepIndex, options);
		
		// If the field has been found:
		if($field) {
			// Then, get its value:
			var $val = $field.val();
			
			// Return the value:
			return (stepIndex == 0 && $val == '-' ? null : $val);
		}
		
		// If not found, then we return NULL instead:
		return null;
	}
	
	function _getFilterValues(options) {
		// If the container of the filter interface is not known:
		if(typeof options.filterInterfaceContainer == 'undefined') {
			// Then, we return an empty array:
			return new Array();
		}
		
		// Output collection of values:
		var out = new Array();
		
		// For each filter bar that is showing:
		$('.' + options.filterBarClass, $(options.filterInterfaceContainer)).each(function() {
			// Initiate an entry for the current filter:
			var temp = new Array();
			
			// We'll collect the values for each step in the current filter bar.
			// We start with the value in step 0, and continue fetching values
			// while the result is not NULL:
			var j = 0;
			var v = _getFilterValue($(this), j, options);
			while(v != null) {
				// Add the value to the output:
				temp[j] = v;
				
				// Get the next value in the filter bar:
				v = _getFilterValue($(this), ++ j, options);
			}
			
			// If values have been collected for the current filter:
			if(temp.length > 0) {
				// Then, add it to the output:
				out[out.length] = temp;
			}
		});
		
		// Return the values:
		return out;
	}
	
	function _getIndexOfFilterBar($filterBar, options) {
		// If the container of the filter interface is not known:
		if(typeof options.filterInterfaceContainer == 'undefined') {
			// Then, we return NULL
			return;
		}
		
		// Get the index, and return:
		return $('.filter').index($filterBar);
	}
	
	function _setFilterStepHtml($filterBar, stepIndex, $html, options) {
		// Add the container of the requested step:
		$('div.step-' + (stepIndex - 1), $filterBar).after('<div class="filter-step step-'+ stepIndex +'"></div>');
		
		// Get the container of the requested step:
		var $step = $('.step-' + stepIndex, $filterBar);
		
		// Insert the HTML (hidden):
		$step.html($html.hide());
		
		// Dispatch an event, to notify about the new field having been inserted
		// in the filter interface:
		$(options.filterInterfaceContainer).trigger('Ai_FilterInterface_Field', [options, $html, $filterBar, stepIndex]);
		
		// If animation has been enabled:
		if(options.animate) {
			// Then, we'll fade the inserted elements into view:
			$html.stop().fadeTo(options.duration, 1, options.easing, function() {});
		}
		// If animation is disabled:
		else {
			// Then, we simply show the elements:
			$html.show();
		}
	}
	
	function _clearFilterStepHtml($filterBar, stepIndex, options) {
		// Get the container of the requested step:
		var $step = $('.step-' + stepIndex, $filterBar);
		
		// While this container is found in the page:
		while($step.length > 0) {
			// Remove it:
			$step.remove();
			
			// Get the next container:
			$step = $('.step-' + (++ stepIndex), $filterBar);
		}
	}
	
	function _addFilterBar(options, doAnimation) {
		// If the container of the filter interface is not known:
		if(typeof options.filterInterfaceContainer == 'undefined') {
			// Then, we stop here;
			return;
		}
		
		// Create a new filter bar:
		var $bar = _getNewFilterBar(options);
		
		// Append that new filter bar to the interface:
		$(options.filterInterfaceContainer).append($bar.hide());
		
		// Show/Hide the "Add filter" button
		_toggleAddButton(options);
		
		// Set the actions for the first field, in the filter bar:
		_setFieldActions($bar, 0, options);
		
		// Set the actions for additional elements in the filter bar:
		_setFilterBarActions($bar, options);
		
		// Add the ODD/EVEN class (css) to the filter bar:
		$bar.addClass((_getIndexOfFilterBar($bar, options) % 2 == 0 ? options.filterBarClassOdd : options.filterBarClassEven));
		
		// If animation is to be activated in the filter interface:
		// (animation can be blocked with the additional function argument "doAnimation")
		if(options.animate && ! (typeof doAnimation != 'undefined' && doAnimation == false)) {
			// Then, slide down of view:
			$bar.stop().slideDown(options.duration, options.easing);
		}
		// If no animation is required:
		else {
			// Then, simply show the filter bar:
			$bar.show();
		}
		
		// Return the new filter bar:
		return $bar;
	}
	
	function _removeFilterBar($filterBar, options) {
		// We'll execute this temporary function, to completely remove the 
		// filter bar:
		var c = function() {
			// When clicked, we remove the filter bar:
			$filterBar.remove();
			
			// Apply the filters, after having dispatched an event that notifies
			// about the update in the interface?
			var applyFilters = (options.updateLive || options.updateOnRemoveFilter);
			
			// We'll dispatch an event, notifying about an update in the filter
			// interface:
			_dispatchUpdate(options, null, null, 'Remove', applyFilters);
		
			// Show/Hide the "Add filter" button
			_toggleAddButton(options);
		};
		
		// If animation is to be activated in the filter interface:
		if(options.animate) {
			// Then, slide out of view:
			$filterBar.slideUp(options.duration, function() {
				// When done, remove the filter bar
				c();
				
			// Animation's easing:
			}, options.easing ? options.easing : null);
		}
		// If no animation is required:
		else {
			// Then, simply remove the filter bar:
			c();
		}
	}
	
	function _toggleAddButton(options) {
		// Get the current number of filter bars. If we have reached the maximum
		// number of filters applicable:
		if(options.maximumFilters && $('.' + options.filterBarClass, $(options.filterInterfaceContainer)).length == options.maximumFilters) {
			// Hide the "add filter" button:
			$(options.addButton).hide();
		}
		// If not:
		else {
			$(options.addButton).show();
		}
	}
	
	function _dispatchUpdate(options, $filterBar, stepIndex, eventString, doApplyFiltersAfterDispatch) {
		// Get the selected values:
		var allValues = _getFilterValues(options);
		var values = [];
		
		// If a filter bar has been provided:
		if(typeof $filterBar != 'undefined') {
			// Then, we get the index of the filter bar:
			var i = _getIndexOfFilterBar($filterBar, options);
			
			// And, we check if values have been collected for this filter bar,
			// with the index number we have retrieved:
			if(typeof allValues[i] != 'undefined') {
				// If so, we set the values:
				values = allValues[i];
			}
		}
		
		// Compose the name of the callback function:
		var callbackId = 'on' + eventString;
		
		// If the callback function exists:
		if(typeof options[callbackId] == 'function') {
			// Get the callback function
			var callbackFunction = options[callbackId];
			
			// Call the callback, in order to dispatch an update:
			callbackFunction(allValues, values, $filterBar, stepIndex);
		}
		
		// Dispatch an event, to notify about an update in the filter interface:
		$(options.filterInterfaceContainer).trigger('Ai_FilterInterface_' + eventString, [options, allValues, values, $filterBar, stepIndex]);
		
		// If the filters are to be applied, after dispatching the event
		if(doApplyFiltersAfterDispatch) {
			// Then, we apply the filters to the list:
			_applyFilterValues(allValues, options);
		}
	}
	
	function _doFiltersValidation(values, options, callbackOnSuccess, callbackOnFailure) {
		// Initiate an AJAX Call for validation:
		$.ajax({
			// With the URL for validations
			url      : options.validateURL,
			// With the Query Variables that represent the current selection of
			// filters.
			data     : _getQueryVariablesFromValues(values),
			// The expected data type returned by the AJAX Call:
			dataType : options.validateURLDataType,
			// When we receive a response:
			success  : function(data) {
				// Temporary working variables:
				var $filterBar;
				var $field;
				
				// Number of fields with invalid input:
				var invalidCount = 0;
				
				// For each of the validation outcomes the AJAX Response 
				// provides us with:
				for(var i in data.validations) {
					// If the current validation indicates a FAILURE:
					if(! data.validations[i].outcome) {
						// Then, increment the number of failures encountered:
						invalidCount += 1;
						
						// Also, we'll show an error message for the corresponding
						// field (with a contextual window). So, get the filter
						// bar to which the error message applies:
						$filterBar = $('.' + options.filterBarClass + ':eq('+ data.validations[i].indexInSelection +')', $(options.filterInterfaceContainer));
						
						// If found:
						if($filterBar) {
							// Get the field, in the filter bar, for which the
							// error message is to be shown:
							$field = _getField($filterBar, parseInt(data.validations[i].step) + 1, options);
							
							// If the field is found:
							if($field.length > 0) {
								// Then, we show a contextual window with the
								// error message:
								$field.Ai_ContextWindow({
									// The contextual menu:
									'onGetElement' : function() {
										var h = '';
										h += '<div class="popover">';
										h +=    '<div class="arrow"></div>';
										h +=    '<div class="popover-content">';
										h +=  data.validations[i].error;
										h +=    '</div>';
										h += '</div>';
										return $(h);
									},
									// Set the behavior of the contextual menu with some additional
									// properties. We set some hiding flags:
									'hideOnScroll' : true,
									'hideOnClickOutside' : true,
									'hideForOtherWindows' : true,
									'hideOnWindowResize' : true,
									'hideOnClick' : true,
									// We animate the contextual menu into view:
									'position' : {
										'positionY' : ['top', 'bottom', 'alignCenters'],
										'animate' : {
											'easing' : 'easeOutElastic',
											'duration' : 600,
											'properties' : {moveX : 50, moveY : 50},
											'callback' : function() {
											}
										},
                                        'positionClasses'  : {
                                            'top'    : 'top',
                                            'right'  : 'right',
                                            'bottom' : 'bottom',
                                            'left'   : 'left'
                                        }
									}
								});
								
								// We only show one error message at a time
								break;
							}
						}
					}
				}
				
				// If failures have been encountered:
				if(invalidCount > 0) {
					// Then, we run the callbackOnFailure function, if any:
					if(typeof callbackOnFailure == 'function') {
						callbackOnFailure();
					}
				}
				// If no errors occured during validation:
				else {
					// Then, we run the callbackOnSuccess function:
					if(typeof callbackOnSuccess == 'function') {
						callbackOnSuccess();
					}
				}
			}
		});
	}
	
	function _applyFilterValues(values, options) {
		// The function that applies filter values:
		var c = function() {
			// Run the callback when initiating the AJAX call:
			options.onApply(values);

			// Dispatch an event, to notify about filters being applied:
			$(options.filterInterfaceContainer).trigger('Ai_FilterInterface_Apply', [values]);

			// Set new filter values, so they become available with Ai_FilterInterfaceValues
			$(options.filterInterfaceContainer).data('Ai_FilterInterfaceValues', values);

			// Then, we initiate an AJAX Call:
			$.ajax({
				// With the Update URL
				url      : options.updateURL,
				// With the Query Variables that represent the current selection of
				// filters.
				data     : _getQueryVariablesFromValues(values),
				// The expected data type returned by the AJAX Call:
				dataType : options.updateURLDataType,
				// When we receive a response:
				success  : function(data) {
					// Run the callback, to process the response:
					options.onApplied(data);

					// Dispatch an event, to notify about filters having been applied:
					$(options.filterInterfaceContainer).trigger('Ai_FilterInterface_Applied', [options, data]);
				}
			});
		}
		
		// If validation has been activated for the filter interface
		if(options.validateURL) {
			// Then, perform validation of the filters:
			_doFiltersValidation(values, options, function() {
				// If validated successfully, apply filters:
				c();
			});
		}
		// If no validation is to be performed:
		else {
			// Then, simply apply the filters:
			c();
		}
	}
	
	/**
	 * Input hint
	 * 
	 * This plugin function allows for hints to be shown on input controls in 
	 * the current page. Such a hint is shown in the field, when no data has been
	 * introduced (yet).
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_InputHint = function(options) {
		// Merge the provided options with the default ones:
		options = $.extend({}, $.fn.Ai_InputHint.defaults, options);
		
		// Note that, first, we filter out the elements that do not have a hint
		// available. We use a assertion function for each of the matched elements
		// to do so. For each of the elements in the selection:
		$(this).filter(function() {
			// Try to get the hint:
			var hint = $(this).attr(options.hintAttribute);
			
			// Is a hint available for the current input control?
			return (typeof hint != 'undefined' && jQuery.trim(hint) != '');
		
		// For each of the input controls that remain:
		}).each(function() {
			// We set the actions for the blur() event:
			$(this).blur(function() {
				// Show the hint:
				_showHint($(this), options);
			});
			
			// If the option 'clearHintOnFocus' has been disabled, we will 
			// respond to a different events. Instead of removing the hint 
			// when focussing the field with the mouse cursor, we'll remove 
			// the hint when a value is typed into the field. So, in that case, 
			// we add a handler function for the keydown() event:
			$(this).bind(! options.clearHintOnFocus ? 'keydown' : 'focus', function() {
				// Remove the hint:
				_removeHint($(this), options);
			});
			
			// Initiate, by showing the hint in the input control:
			_showHint($(this), options);
			
			// When the form is submitted:
			var $this = $(this);
			$(this.form).submit(function() {
				// Then, we remove the hint first:
				_removeHint($this, options);
			});
		})
		
		// Return the matched elements
		// (first, end the most recent filtering operation in the current chain 
		// and return the set of matched elements to its previous state)
		return this.end();
	}
	
	/**
	 * Input hint, default options
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_InputHint.defaults = {
		// The css class for an input control (field) that is showing the hint.
		// This is applied to input controls into which no value has been 
		// introduced yet, by the user.
		'hintClass'        : 'hint',
		// The HTML attribute (of the input control) that is to be used to get 
		// the hint text. By default, we use the 'title' attribute to get hints
		'hintAttribute'    : 'title',
		// Flag: clear hint on focus? If set to true, the hint will be removed
		// from the field when setting the focus of the cursor to the input control.
		// If not, the hint will remain until a value is introduced/typed by the
		// user. Changing this value will affect the HTML elements that are created
		// by the plugin function. If the hint remains when focussing the field,
		// then the hint is shown with an auxiliary tag, immediately after the
		// input control.
		'clearHintOnFocus' : false
	};
	
	/**
	 * Get hint
	 * 
	 * A private function, used by the $.fn.Ai_InputHint() plugin, to get the
	 * hint for a given input control.
	 * 
	 * @access private
	 * @param $() $element
	 * @param StdOptions options
	 * @return String
	 */
	function _getHint($element, options) {
		return $element.attr(options.hintAttribute);
	}
	
	/**
	 * Show hint
	 * 
	 * A private function, used by the $.fn.Ai_InputHint() plugin, in order to 
	 * show the hint in an input control.
	 * 
	 * @access private
	 * @param $() $element
	 * @param StdOptions options
	 * @return void
	 */
	function _showHint($element, options) {
		// If the input control is currently empty:
		if($element.val() == '') {
			// If the option 'clearHintOnFocus' has been disabled:
			if(! options.clearHintOnFocus) {
				// Get the hint that may be showing at the moment, and remove it:
				$('.' + options.hintClass, $element.parent()).remove();
				
				// Then, we render the HTML that shows the hint in a different
				// way. Instead of using the field's value, we'll append a new
				// tag, immediately after the input control:
				$element.after('<div class="'+ options.hintClass +'">' + _getHint($element, options) + '</div>');
			}
			// if enabled:
			else {
				// Then, we apply the css class to the input control and we show 
				// the hint, by setting it as the value of the input control:
				$element.addClass(options.hintClass).val(_getHint($element, options));
			}
		}
	}
	
	/**
	 * Remove hint
	 * 
	 * A private function, used by the $.fn.Ai_InputHint() plugin, in order to 
	 * remove the hint from an input control.
	 * 
	 * @access private
	 * @param $() $element
	 * @param StdOptions options
	 * @return void
	 */
	function _removeHint($element, options) {
		// If the option 'clearHintOnFocus' has been disabled:
		if(! options.clearHintOnFocus) {
			// Get the hint that is being shown at the moment:
			var $tmp = $('.' + options.hintClass, $element.parent());
			
			// If found:
			if($tmp.length > 0) {
				// Then, animte the hint out of view:
				$tmp.stop().fadeTo(150, 0, function() {
					// And remove it:
					$(this).remove();
				});
			}
		}
		// if 'clearHintOnFocus' has been enabled:
		else {
			// Then, we can tell if the hint is showing, by checking whether or 
			// not the hint class has been applied to the input control:
			if($element.hasClass(options.hintClass)) {
				// If so, we remove the css class from the input control. Then, 
				// we remove the hint, by emptying the value of the input control:
				$element.removeClass(options.hintClass).val('');
			}
		}
	}
	
	/**
	 * Set caret position
	 * 
	 * If providing only a start position for the cursor, you move the cursor
	 * to a new position. If you also provide with an end position, then you will
	 * select the portion of text that is defined by the delimiting start and 
	 * end position.
	 * 
	 * @access public
	 * @param integer startPosition
	 * @param integer endPosition
	 * @return void
	 */
	$.fn.Ai_CaretPosition = function(startPosition, endPosition) {
		// Focus the cursor in the field:
		this.focus();
		
		// Get the clean DOM element:
		var elm = $(this)[0];
		
		// If the end position has not been provided
		if(typeof endPosition == 'undefined') {
			// we default it to the provided start position:
			endPosition = startPosition;
		}
		
		// IE
		if(elm.createTextRange) {
			var range = elm.createTextRange();
			range.collapse(true);
			range.move("character", startPosition);
			range.moveEnd('character', startPosition);
			range.moveStart('character', endPosition);
			range.select();
		}
		// Real browsers:
		else if(elm.setSelectionRange) {
			elm.setSelectionRange(startPosition, endPosition);
		}
		
		// Return matched elements:
		return this;
	}
	
	/**
	 * Input mask
	 * 
	 * This plugin function will allow you to define a mask for an the matched 
	 * input controls/fields. While validating the data that is being typed into 
	 * the field, this function will also format the data nicely. Typically,
	 * such a mask would be enabled to help with introducing a credit card number,
	 * a phone number, etc.
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_InputMask = function(options) {
		// Merge the provided options with the default ones:
		options = $.extend({}, $.fn.Ai_InputMask.defaults, options);
		
		// Add the rules for numbers. Note that rules in the provided options 
		// can never overwrite the predefined number rules.
		options.rules = $.extend({}, options.rules, {
			'0' : /[0]/,
			'1' : /[0-1]/,
			'2' : /[0-2]/,
			'3' : /[0-3]/,
			'4' : /[0-4]/,
			'5' : /[0-5]/,
			'6' : /[0-6]/,
			'7' : /[0-7]/,
			'8' : /[0-8]/,
			'9' : /[0-9]/
		});
		
		// When data is introduced in the input field, by typing
		$(this).keyup(function() {
			// Get masked value
			var tmp = _getMaskedValue($(this).val(), options);
			
			// Update the masked value in the input field:
			$(this).val(tmp[1]);
			$(this).Ai_CaretPosition(tmp[0]);
		});
		
		// When data is introduced in the input field, by pasting text:
		$(this).bind('paste', function(event) {
			// Mask the pasted text, and set the new value:
			// $(this).val(_getMaskedValue($(el).val(), options));
//			console.log(event)
		});
		
		// Show placeholders
		var tmp = _getMaskedValue('', options);
		$(this).val(tmp[1]);
	};
	
	/**
	 * Mask a value
	 * 
	 * This private function will take a string value, and fit it into the 
	 * provided mask. The result of this method is an array that contains:
	 * 
	 * - the position of the cursor, at index 0
	 * - the masked text value, at index 1
	 * 
	 * @access private
	 * @param String value
	 * @param StdObject options
	 * @return Array
	 */
	function _getMaskedValue(value, options) {
		// The output:
		// (An array with the start position of the selection at index 0, the
		// end position of the selection at index 1, and the masked value at 
		// index 2
		var out = [-1, ''];
		
		// Working variables
		var i, j, n, valueChar, maskChar, isRule;
		
		// For each of the characters in the mask:
		for(i = 0, j = 0, n = options.mask.length; i < n; i ++) {
			// Get the current character, from the mask
			maskChar = options.mask.charAt(i);
			
			// Is the character a rule, representing a regular expression?
			isRule = (typeof options.rules[maskChar] != 'undefined');
			
			// Get the corresponding character, from the input control's value
			valueChar = value.charAt(j);
			
			// If no character has been found in the value, at the current 
			// position
			if(! valueChar) {
				// If the current character in the mask is a rule:
				if(isRule) {
					// Then, we add a placeholder
					out[1] += options.placeholder;
					
					// If the position of the cursor has not yet been set before:
					if(out[0] == -1) {
						// Then, we set it now:
						out[0] = i;
					}
				}
				// If a fixed character:
				else {
					// Then, we add that character to the output string
					out[1] += maskChar;
				}
			}
			// If a character has been found in the value
			else {
				// If the current character in the mask is representing a regular
				// expression
				if(isRule) {
					// If the value's character is matching the character we expect
					// at the same position in the mask.
					if(options.rules[maskChar].test(valueChar)) {
						// If we've got a match, we add the character to the 
						// output
						out[1] += valueChar;

						// Move to the next character in the value:
						j ++;
					}
					// If the current character does not match with the expression,
					// then it can only be valid if it is the placeholder character.
					else if(options.showPlaceholders && valueChar == options.placeholder) {
						// Add the placeholder:
						out[1] += options.placeholder;
					
						// If the position of the cursor has not yet been set 
						// before:
						if(out[0] == -1) {
							// Then, we set it now:
							out[0] = i;
						}
					}
					// Invalid character:
					else {
						// Then, the character is invalid. We call the callback
						// for invalid characters:
						//options.onInvalidCharacter()
						$.Ai_Console('invalid character');
					}
				}
				// If the current character is in the mask is not an expression,
				// then it is a "fixed" character.
				else {
					// We add the fixed character to the output:
					out[1] += maskChar;
					
					// If the corresponding character in the value matches the
					// one in the mask:
					if(valueChar == maskChar) {
						// Then, we move to the next character in the value
						j ++;
					}
				}
			}
		}
		
		// If the position of the cursor has not yet been set before:
		if(out[0] == -1) {
			// Then, we set it now:
			out[0] = i;
		}
		
		// Return the output
		return out;
	}
	
	/**
	 * Input mask, default options
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_InputMask.defaults = {
		// The mask:
		'mask'             : null,
		// Map characters in your mask string, to regular expressions. Each 
		// character introduced by the user will be tested against the corresponding
		// regular expression.
		'rules'            : {
			'z' : /[a-z]/,
			'Z' : /[A-Z]/,
			'a' : /[a-zA-Z]/,
			'*' : /[0-9a-zA-Z]/
		},
		// Use placeholder values, until final characters are introduced?
		'showPlaceholders' : true,
		// The placeholder character:
		'placeholder'      : '_',
		// Tab to the next input field, when the user has introduced a value that
		// is considered complete?
		'autoTab'          : true
	};
	
	/**
	 * Bind an event handler to a keyboard combination
	 * 
	 * This plugin function allows to set event handlers, that respond to a 
	 * specific combination of keys being stroked on the keyboard.
	 * 
	 * Example code
	 * <code>
	 *    $(document).Ai_KeyCombo(['Ctrl', 'Up'], function(event) {
	 *    });
	 * </code>
	 * 
	 * @access public
	 * @param Array keys
	 * @param function eventHandler
	 * @return $(matchedElements)
	 */
	$.fn.Ai_KeyCombo = function(keys, eventHandler) {
		// If an empty combination has been provided
		if(keys.length == 0) {
			// We do nothing:
			return this;
		}
		
		// For each of the matched elements:
		$(this).each(function() {
			// Get the current collection of key combos assigned to the element:
			var combos = _getKeyCombos($(this));
			
			// If combo's were not registered for this element until now:
			if(combos.length == 0) {
				// We bind the 'keypress' event to the element. Important: this
				// must be the keypress event for disabling submission of a form
				// with the enter key:
				$(this).keypress(function(event) {
					// Get the registered key combinations for this element:
					var combos = _getKeyCombos($(this));

					// Get the key codes to match the catched key code against:
					var codes  = $.fn.Ai_KeyCombo.keycodes();

					// Prepare a boolean, that tells us whether or not keys match:
					var hit    = true;

					// Working variables:
					var i, j;

					// For each of the combos:
					for(i = 0; i < combos.length; i ++) {
						// If the current combination contains only one key:
						if(combos[i][0].length == 1) {
							// Match the key code:
							hit = (typeof codes[combos[i][0][0]] != 'undefined' && codes[combos[i][0][0]] == event.keyCode);
						}
						// If the combination contains multiple keys, then it is
						// probably a combination with a key such as Ctrl or Shift.
						else {
							// For each of the keys in the combination:
							for(j = 0; j < combos[i][0].length; j ++) {
								// Is the current key the CTRL key?
								if(combos[i][0][j] == 'ctrl') {
									// Then, check if the CTRL key is being pressed:
									hit = (hit && event.ctrlKey);
								}
								// Is the current key the SHIFT key?
								else if(combos[i][0][j] == 'shift') {
									// Then, check if the SHIFT key is being pressed:
									hit = (hit && event.shiftKey);
								}
								// Is the current key the ALT key?
								else if(combos[i][0][j] == 'alt') {
									// Then, check if the ALT key is being pressed:
									hit = (hit && event.altKey);
								}
								// Any other key is compared to the event's captured 
								// key code:
								else {
									// Match the key code:
									hit = (hit && typeof codes[combos[i][0][j]] != 'undefined' && codes[combos[i][0][j]] == event.keyCode);
								}
							}
						}

						// Do we have a match?
						if(hit) {
							// Yes: Call the event handler!
							combos[i][1](event, $(this));
						}
					}
				});
			}
			
			// Add the current combination of keys:
			combos.push([keys, eventHandler]);
			
			// Remember the collection of combinations:
			_setKeyCombos($(this), combos);
		});
		
		// Return matched elements
		return this;
	};
	
	/**
	 * Get key codes
	 * 
	 * Will return an object, containing the event key codes that are recognized 
	 * by $.fn.Ai_KeyCombo(). The result of this function may or may not depend on 
	 * browser and OS of the client machine.
	 * 
	 * @access public
	 * @return void
	 */
	$.fn.Ai_KeyCombo.keycodes = function() {
		return {
			'backspace' : 8,
			'tab'       : 9,
			'enter'     : 13,
			'shift'     : 16,
			'ctrl'      : 17,
			'alt'       : 18,
			// 'Option' is an alternative for 'Alt':
			'option'    : 18,
			'escape'    : 27,
			'page up'   : 33,
			'page down' : 34,
			'end'       : 35,
			'home'      : 36,
			'left'      : 37,
			'up'        : 38,
			'right'     : 39,
			'down'      : 40,
			'delete'    : 46,
			// We only enable numpad keys.
			'numpad 0'  : 96,
			'numpad 1'  : 97,
			'numpad 2'  : 98,
			'numpad 3'  : 99,
			'numpad 4'  : 100,
			'numpad 5'  : 101,
			'numpad 6'  : 102,
			'numpad 7'  : 103,
			'numpad 8'  : 104,
			'numpad 9'  : 105,
			// Multiply may be described by more than one string
			'*'         : 106,
			'multiply'  : 106,
			// Add may be described by more than one string
			'+'         : 107,
			'add'       : 107,
			// Subtract may be described by more than one string
			'-'         : 109,
			'subtract'  : 109,
			// Decimal point may be described by more than one string
			'.'         : 110,
			'decimal'   : 110,
			// Divide may be described by more than one string
			'/'         : 111,
			'divide'    : 111,
			'f1'        : 112,
			'f2'        : 113,
			'f3'        : 114,
			'f4'        : 115,
			'f5'        : 116,
			'f6'        : 117,
			'f7'        : 118,
			'f8'        : 119,
			'f9'        : 120,
			'f10'       : 121,
			'f11'       : 122,
			'f12'       : 123,
			'semicolon' : 186,
			// Equal may be described by more than one string
			'='         : 187,
			'equals'    : 187,
			// Comma may be described by more than one string
			','         : 188,
			'comma'     : 188,
			// Dash may be described by more than one string
			'-'         : 189,
			'dash'      : 189,
			// Period may be described by more than one string
			'.'         : 190,
			'period'    : 190,
			// Slash may be described by more than one string
			'/'         : 191,
			'slash'     : 191,
			'backslash' : 220,
			// Bear in mind, the codes below are KEY codes, not CHAR codes:
			'a'         : 65,
			'b'         : 66,
			'c'         : 67,
			'd'         : 68,
			'e'         : 69,
			'f'         : 70,
			'g'         : 71,
			'h'         : 72,
			'i'         : 73,
			'j'         : 74,
			'k'         : 75,
			'l'         : 76,
			'm'         : 77,
			'n'         : 78,
			'o'         : 79,
			'p'         : 80,
			'q'         : 81,
			'r'         : 82,
			's'         : 83,
			't'         : 84,
			'u'         : 85,
			'v'         : 86,
			'w'         : 87,
			'x'         : 88,
			'y'         : 89,
			'z'         : 90
		};
	}
	
	/**
	 * Get registered key combos for element
	 * 
	 * This private function is used by $.fn.Ai_KeyCombo() to get the collection
	 * of registered key combinations for a given element in the DOM
	 * 
	 * @access private
	 * @return Array
	 */
	function _getKeyCombos($element) {
		var tmp = $element.data();
		return typeof tmp.M_KeyCombos != 'object' ? new Array() : tmp.M_KeyCombos;
	}
	
	/**
	 * Set key combos for element
	 * 
	 * This private function is used by $.fn.Ai_KeyCombo() to set the collection
	 * of key combinations for a given element in the DOM
	 * 
	 * @access private
	 * @return Array
	 */
	function _setKeyCombos($element, combos) {
		$element.data('M_KeyCombos', combos);
	}
	
	/**
	 * Show a context window
	 * 
	 * @access public
	 * @return $(matchedElements)
	 */
	$.fn.Ai_ContextWindow = function(options) {
		// Merge the provided options with the default ones:
		options = $.extend({}, $.fn.Ai_ContextWindow.defaults, options);
		
		// If already showing a contextual window:
		if($(this).Ai_ContextWindowIsActive()) {
			// Then, stop here
			return this;
		}
		
		// If this element is already showing a contextual menu, we hide it now:
		$(this).Ai_ContextWindowHide(false);
		
		// We are about to show a new context window. So, first we loop all of 
		// the active context windows and we check if they need to be hidden when
		// new windows are shown. So, for each of the windows:
		$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
			// If the current context window is to be hidden for new ones:
			if(currentOptions.hideForOtherWindows) {
				// Then, hide the window now:
				$trigger.Ai_ContextWindowHide();
			}
		});
		
		// Get the element to be shown. Note that we use the callback function 
		// to do so:
		var $element = options.onGetElement($(this));
		
		// If the window has been created by selecting an already existing element
		// in the page, we do not need to append it to the page. If the window
		// is a new element though:
		if(! $element.selector) {
			// Then, we append it to the page now. Note that, initially, we
			// hide the new element:
			$('body').append($element.hide());
			
			// We also remember that this element was not yet appended to the 
			// page. When we hide the element, we'll remove it in order to return
			// the page to its original state
			options.removeOnHide = true;
		}
		// If the element is not new to the page:
		else {
			// We remember about that:
			options.removeOnHide = false;
		}

		// If an element has been provided by the callback function:
		if($element.length > 0) {
			// Set the z-Index of the appended element:
			$element.css({
				'z-index' : options.zIndex,
				'opacity' : 1 // to undo the fade out when hidden
			});
			
			// If the element is to be hidden when it is clicked:
			if(options.hideOnClick) {
				// Get a reference to the matched elements:
				var $this = $(this);
				
				// Then, we add an event listener that will respond to the 
				// element being clicked:
				$element.Ai_BindOnce('click', function() {
					// Hide the window:
					$this.Ai_ContextWindowHide();
				});
			}

			// We position the element, relative to the trigger element. We use 
			// the Ai_TooltipPosition() plugin to do so. Note that we will always
			// overwrite the "relativeTo" value in the positioning options.
			$element.Ai_TooltipPosition($.extend({}, options.position, {
				relativeTo : $(this)
			}));
			
			// Show the element:
			$element.show();
			
			// When shown, run the callback of the element. That is, of course, 
			// if the callback has been defined:
			if(typeof options.onShow == 'function') {
				// Run:
				options.onShow($(this), $element, options);
			}
		}
		
		// We also store a the window in the registry of ContextWindows. This way,
		// can loop through all context windows in the page, and show/hide them
		// whenever required, with the $.Ai_ContextWindowEach() function. First, 
		// we make sure the registry of context menu's has been initiated
		if(typeof $.Ai_Registry.ContextWindowRegistry == 'undefined') {
			// If not, we initiate now:
			$.Ai_Registry.ContextWindowRegistry = {};
			
			// If we needed to initiate the registry, it means that this is the
			// first run of this plugin function. In that case, we create the
			// event listeners that repond to certain events in the page. The
			// first one responds to the window being resized:
			// - When the window is resized:
			$(window).Ai_BindOnce('resize', function() {
				// Then, we go through each of the active context windows:
				$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
					// If the current context window is to be hidden when the 
					// window is resized:
					if(currentOptions.hideOnWindowResize) {
						// Then, hide the window now:
						$trigger.Ai_ContextWindowHide();
					}
					// If the current window is not hidden when the window is
					// resized, then we need to reposition the window to its
					// trigger element (because the window is positioned absolute)
					else {
						// Position the window:
						$window.Ai_TooltipPosition($.extend({}, currentOptions.position, {
							relativeTo : $trigger,
							animate : false
						}));
					}
				});
			});
			
			// - When the end-user scrolls
			$(window).Ai_BindOnce('scroll', function() {
				// Then, we go through each of the active context windows:
				$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
					// If the current context window is to be hidden when the 
					// document is scrolled in:
					if(currentOptions.hideOnScroll) {
						// Then, hide the contextual window now:
						$trigger.Ai_ContextWindowHide();
					}
					// If the window is to be repositioned, when scrolling the
					// window:
					else if(currentOptions.positionOnScroll) {
						// Reposition the window:
						$window.Ai_TooltipPosition($.extend({}, currentOptions.position, {
							relativeTo : $trigger,
							animate : false
						}));
					}
				});
			});
			
			// - When a click is detected anywhere in the document
			$(document).Ai_BindOnce('mousedown', function($event) {
				// Then, we go through each of the active context windows:
				$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
					// Should we hide the current window? We prepare a boolean
					// that tells us so:
					var hideWindow = false;
					
					// If the current context window is to be hidden when a click
					// is detected outside of the window:
					if(currentOptions.hideOnClickOutside && ! $window.Ai_HitTestXY($event.pageX, $event.pageY)) {
						// However, if the contextual window is not to be
						// hidden when the trigger element is clicked, and
						// the click is hitting precisely that element:
						if(! currentOptions.hideOnClickTrigger && $trigger.Ai_HitTestXY($event.pageX, $event.pageY)) {
							// Then, we will not hide the window:
						}
						// In any other case:
						else {
							// We hide the contextual window:
							hideWindow = true;
						}
					}
					
					// If the window is not to be hidden:
					if(! hideWindow) {
						// If the current window is to be hidden when a click is
						// detected on the trigger:
						if(currentOptions.hideOnClickTrigger && $trigger.Ai_HitTestXY($event.pageX, $event.pageY)) {
							// Then, we hide the contextual window:
							hideWindow = true;
						}
					}
					
					// If to be hidden:
					if(hideWindow) {
						// We hide the contextual window:
						$trigger.Ai_ContextWindowHide();
					}
				});
			});
			
			// - When a key is pressed on the keyboard
			$(document).Ai_BindOnce('keypress', function($event) {
				// Then, we go through each of the active context windows:
				$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
					// If the current context window is to be hidden when a key
					// press is detected:
					if(currentOptions.hideOnKeyPress) {
						// We hide the contextual window:
						$trigger.Ai_ContextWindowHide();
					}
				});
			});
		}
		
		// Store a reference to the context window. This way, we tie the trigger
		// element and its contextual window together and make it available for
		// use in other functions.
		options.contextWindowElement = $element.Ai_AssignId().attr('id');
		
		// Remember about the ContextWindow options, by storing it as data in 
		// the trigger element:
		$(this).data('Ai_ContextWindowOptions', options);
		
		// Finally, add the new context window to the registry. We use the trigger 
		// element's ID as the key in the registry, while we store the context 
		// window's ID as the corresponding value.
		$.Ai_Registry.ContextWindowRegistry[$(this).Ai_AssignId().attr('id')] = $element.attr('id');
		
		// Return matched elements:
		return this;
	}
	
	/**
	 * Update the contexts of the context window
	 *
	 * @access public
	 * @param $ $html
	 * @return $(matchedElements)
	 */
	$.fn.Ai_ContextWindowUpdateContents = function($html) {
		
	}
	
	/**
	 * Hide the context window
	 * 
	 * @access public
	 * @param bool animate
	 * @return $(matchedElements)
	 */
	$.fn.Ai_ContextWindowHide = function(animate) {
		// The hiding of a context window is always done by matching the element
		// for which the contextual window is being shown. In this element, we
		// should have stored the ContextWindow options:
		var options = $(this).data('Ai_ContextWindowOptions');
		
		// If we cannot find the options
		if(! options) {
			// Then, this element does not have a context window. In this case, 
			// we stop here by returning the matched elements (for chaining):
			return this;
		}
		
		// Get the context window:
		var $win = $('#' + options.contextWindowElement);
		
		// If not found:
		if($win.length == 0) {
			// Then, remove the context window's data:
			_deleteContextWindowData($(this));
		}
		
		// The following function is executed, when the window has been hidden:
		var h = function($trigger, $window, options) {
			// When hidden, run the callback of the element. That is, of course, 
			// if the callback has been defined:
			if(typeof options.onHide == 'function') {
				// Run:
				options.onHide($trigger, $window, options);
			}
			
			// If the context window was new to the page, it has been marked for
			// deletion when the window is hidden. In this case, we remove the
			// window completely from the page:
			if(options.removeOnHide) {
				// Remove:
				$window.remove();
			}
			// If not to be deleted:
			else {
				// Then, we simply hide the element. If we don't do this, the 
				// clickable areas - such as buttons - in the window remain 
				// active in the page:
				$window.hide();
			}
			
			// Then, remove the context window's data, now that it is hidden. 
			// This way, it is no longer taken into account by event listeners:
			_deleteContextWindowData($trigger);
		}
		
		// TEMPORARY:
		// Until an option is added to the Ai_ContextWindow() plugin function,
		// we completely disable animations!
		if(false) {
		// if(typeof animate == 'undefined' || animate == true) {
		
			// The animation used for hiding is currently not available as an option,
			// we simply fade out the window:
			var $this = $(this);
			$win.fadeTo(250, 0, function() {
				// When done, hide the window:
				h($this, $(this), options);
			});
		}
		// If animation has not been enabled:
		else {
			// Then, simply hide the window:
			h($(this), $win, options);
		}
		
		// Return the matched element
		return this;
	};
	
	/**
	 * Is contextual window active for the matched element?
	 * 
	 * @uses $.Ai_ContextWindowEachActive()
	 * @access public
	 * @return boolean
	 */
	$.fn.Ai_ContextWindowIsActive = function() {
		// Output
		var output = false;
		 
		// Get the matched element:
		var $this = $(this);
		
		// For each of the active context windows:
		$.Ai_ContextWindowEach(function($trigger, $window, currentOptions) {
			// If the current window is being shown for the matched element:
			if(! output && $trigger.Ai_Equals($this)) {
				// Then, return TRUE
				output = true;
			}
		});
		
		// Return output
		return output;
	}
	
	/**
	 * Loop through all context windows
	 * 
	 * @access public
	 * @param function callback
	 * @return void
	 */
	$.Ai_ContextWindowEach = function(callback) {
		// If the registry of context windows has not yet been created:
		if(typeof $.Ai_Registry.ContextWindowRegistry == 'undefined') {
			// Then, we do not need to loop anything. We stop here, by returning
			// a NULL value:
			return;
		}
		
		// For each registered context window:
		for(var i in $.Ai_Registry.ContextWindowRegistry) {
			// Get the trigger element and the context window for the current
			// iteration:
			var $t = $('#' + i);
			var $c = $('#' + $.Ai_Registry.ContextWindowRegistry[i]);
			
			// If the trigger element is no longer present on the page, but the
			// context window is OR if the trigger element is present, but the
			// corresponding window is not:
			if($t.length == 0 || $c.length == 0) {
				// Then, we remove the context window from the page:
				$c.remove();
				
				// If the trigger element is known:
				if($t.length > 0) {
					// Then, we use the internal function to delete all context
					// window data. This way, this element is no longer taken 
					// into account.
					_deleteContextWindowData($t);
				}
				// If the trigger element cannot be found:
				else {
					// We remove the current entry from the registry, so it is 
					// no longer taken into account:
					delete $.Ai_Registry.ContextWindowRegistry[i];
				}
			}
			// if both elements are present:
			else {
				// Then, we get the options of the current context window, and
				// we run the callback function on the current item:
				callback($t, $c, $t.data('Ai_ContextWindowOptions'));
			}
		}
	}
	
	/**
	 * Get currently active context window(s)
	 * 
	 * @uses $.Ai_ContextWindowEach()
	 * @access public
	 * @param function callback
	 * @return Array
	 */
	$.Ai_ContextWindowEachActive = function(callback) {
		// If the registry of context windows has not yet been created:
		if(typeof $.Ai_Registry.ContextWindowRegistry == 'undefined') {
			// Then, we do not need to loop anything. We stop here, by returning
			// a NULL value:
			return;
		}
		
		// For each registered context window:
		$.Ai_ContextWindowEach(function($trigger, $contextWindow, contextWindowOptions) {
			// If the current window is active (visible):
			if($contextWindow.is(':visible')) {
				// Then, run the callback:
				callback($trigger, $contextWindow, contextWindowOptions);
			}
		});
	}
	
	/**
	 * Get number of currently active context window(s)
	 * 
	 * @uses $.Ai_ContextWindowEachActive()
	 * @access public
	 * @return integer
	 */
	$.Ai_ContextWindowActiveCount = function() {
		// Output number
		var out = 0;
		
		// For each active context window:
		$.Ai_ContextWindowEachActive(function() {
			// Increment the output number:
			out ++;
		});
		
		// Return the output number:
		return out;
	}
	
	/**
	 * Float element, default options
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_ContextWindow.defaults = {
		// Get the element. With this callback function, you can provide with
		// the element (the context window) to be shown.
		'onGetElement'        : function($for) {
			return $('<div>float element</div>');
		},
		// Hide the element, when the window/viewport is resized?
		'hideOnWindowResize'  : true,
		// Hide this element, when another context window is shown in the interface?
		// In many cases, if the context window is a menu, it should be hidden
		// when new context window is shown - such as another contextual menu.
		'hideForOtherWindows' : true,
		// Hide the context window when it is clicked?
		'hideOnClick'         : true,
		// Hide the context window when the user clicks away from the window?
		'hideOnClickOutside'  : true,
		// Hide the context window when the user clicks on the trigger element?
		// (if 'hideOnClickOutside' is enabled, it will be ignored if the click
		//  was registered on the trigger)
		'hideOnClickTrigger'  : true,
		// Hide the context window when the user moves away the mouse cursor from
		// the context window, or from the element for which the contextual window
		// is being shown?
		// (CURRENTLY NOT YET IMPLEMENTED)
		'hideOnMouseOut'      : true,
		// Hide the context window when the page is scrolled?
		'hideOnScroll'        : true,
		// Hide when typing?
		'hideOnKeyPress'      : true,
		// Hide after a predefined period of time? (expressed in milliseconds)
		// (CURRENTLY NOT YET IMPLEMENTED)
		'hideOnTimeout'       : null,
		// Reposition the context window when the page is scrolled? When scrolling,
		// the context window might need to be repositioned in order to keep it
		// visible. Set this property to true, to force repositioning when scrolling:
		'positionOnScroll'    : true,
		// Respond to the context window being shown:
		'onShow'              : function($trigger, $contextWindow, options) {
		},
		// Respond to the element being hidden:
		'onHide'              : function($trigger, $contextWindow, options) {
		},
		// Note that you can define the z-index that is to be applied to the
		// suckerfish menu. This may be necessary in some cases, in order to
		// make sure that the element appears on top of other elements on the
		// page.
		'zIndex'              : 10001,
		// The tooltip menu is positioned with the $.Ai_TooltipPosition()
		// plugin function. You can provide options for positioning with the
		// 'position' object. For more info about available options, please
		// see $.Ai_TooltipPosition()
		'position' : {
			// We set some defaults:
			'positionX'     : ['alignCenters'],
			'positionY'     : ['top', 'bottom'],
			'margin'        : {
				'top'       : 10,
				'right'     : 0,
				'bottom'    : 10,
				'left'      : 0
			}
		}
	};
	
	/**
	 * Remove context window
	 * 
	 * This private function is used to remove the data of a context window in
	 * the page. It will remove the entry from the registry, and it will make
	 * the trigger element forget about the ContextWindow options.
	 * 
	 * @acces private
	 * @param $ $trigger
	 * @return void
	 */
	function _deleteContextWindowData($trigger) {
		// If the registry of context windows has been initiated:
		if(typeof $.Ai_Registry.ContextWindowRegistry != 'undefined') {
			// And, if the provided trigger has an ID:
			var id = $trigger.attr('id');
			if(id) {
				// Then, we remove the entry from the registry
				delete $.Ai_Registry.ContextWindowRegistry[id];
			}
		}
		
		// Finally, we remove the ContextWindow options from the element:
		$trigger.removeData('Ai_ContextWindowOptions');
	}
	
	/**
	 * Position an element on the page (absolute position)
	 * 
	 * This plugin function will position an element in the DOM, relative to another
	 * element, and inside a given container element. This function is used by
	 * other plugins to position elements such as menu's, tooltips, etc.
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_TooltipPosition = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({
			// The container in which the function should check for available 
			// space, and decide whether or not the item should be placed on 
			// top, bottom, etc.
			'container'        : $(window),
			// You can specify the margins you whish to maintain, from the borders
			// of the container:
			'containerPadding' : {
				'top'    : 10,
				'right'  : 10,
				'bottom' : 10,
				'left'   : 10
			},
			// The element to which the space should be compared.
			'relativeTo'       : $(this).prev(),
			// The vertical positions that may be used by the tooltip element. At 
			// the same  time, you define the order of preference in which 
			// positions are to be used. For example, if you only want top and 
			// bottom, and you prefer top to bottom, you should provide 
			// ['top', 'bottom'] here.
			// Accepted values : ['bottom', 'top', 'alignCenters']
			'positionY'        : ['bottom', 'top', 'alignCenters'],
			// The horizontal positions that may be used by the tooltip element. At 
			// the same  time, you define the order of preference in which 
			// positions are to be used. For example, if you only want right and 
			// left, and you prefer right to left, you should provide 
			// ['right', 'left'] here.
			// Accepted values : ['alignCenters', 'right', 'left', 'alignLeftEdges', 'alignRightEdges']
			'positionX'        : ['alignCenters', 'right', 'left', 'alignLeftEdges', 'alignRightEdges'],
			// Depending on the final position of the (tooltip) element, the 
			// following css classes will be removed/added to the element:
			'positionClasses'  : {
				// Note that the default classes reverse the naming from e.g. top
				// to bottom, because an arrow will always be positioned in the 
				// opposite direction:
				'top'              : 'position-bottom',
				'right'            : 'position-left',
				'bottom'           : 'position-top',
				'left'             : 'position-right',
				'alignTopEdges'    : 'position-top-edge',
				'alignBottomEdges' : 'position-bottom-edge',
				'alignLeftEdges'   : 'position-left-edge',
				'alignRightEdges'  : 'position-right-edge'
			},
			// Allow the tooltip to overlap the 'relativeTo' element:
			'allowOverlap' : true,
			// You can specify the margins you whish to maintain for the tooltip
			'margin'      : {
				'top'    : 10,
				'right'  : 10,
				'bottom' : 10,
				'left'   : 10
			},
			// Animation into the target position:
			'animate' : false
//			'animate' : {
				// A string naming an easing function to use for animating into 
				// view. Easing options can be extended with the jquery.easing 
				// plugin
//				'easing' : 'easeOutElastic',
				// Durations are given in milliseconds; higher values indicate 
				// slower animations, not faster ones. The strings 'fast' and 
				// 'slow' can be supplied to indicate durations of 200 and 600 
				// milliseconds, respectively.
//				'duration' : 1000,
				// The properties for animation. Note that you can use the 
				// properties moveX and moveY to animate the position of the
				// tooltip, relative to the target position. For example, you
				// might want to move the tooltip for 10 pixels during animation.
				// In that case, you'd provide { moveX : 10 } as an extra 
				// property.
//				'properties' : { moveX : 20, moveY : 20 },
				// Callback function, for when animation has completed:
//				'callback' : null
//			}
			
		}, options);
		
		// Working variables
		var isOkayX = false;
		var isOkayY = false;
		var posX    = 0;
		var posY    = 0;
		var cssX    = null;
		var cssY    = null;
		var animX   = 0;
		var animY   = 0;
		var i       = 0;
		
		// Get the element we're positioning the the tooltip to:
		var $rel = $(options.relativeTo);
		
		// If we cannot find that offset, we cannot position the tooltip!
		if($rel.length == 0) {
			// So, in that case, we stop here:
			return this;
		}
		
		// Get the offset of the element we're positioning the tooltip to:
		var relOffset = $rel.Ai_Offset();
		
		// If we cannot find that offset, we cannot position!
		if(! relOffset) {
			// So, in that case, we stop here:
			return this;
		}
		
		// For each of the spaces on the Y-Axis:
		for(i = 0; i < options.positionY.length && ! isOkayY; i ++) {
			// We check whether or not room is available in the current space.
			// The algorithm used in order to determine this, depends on which 
			// space we're evaluating:
			switch(options.positionY[i]) {
				// To the top of the element
				case 'top':
					cssY    = options.positionClasses.top;
					posY    = relOffset.top - $(this).outerHeight(false) - options.margin.bottom;
					isOkayY = (posY > (options.container.scrollTop() + options.containerPadding.top));
					animY   = 1;
					break;
				
				// To the bottom
				case 'bottom':
					cssY    = options.positionClasses.bottom;
					posY    = (relOffset.top + $rel.outerHeight(false) + options.margin.top);
					isOkayY = ((posY + $(this).outerHeight(false)) < (options.container.height() + options.container.scrollTop() - options.containerPadding.bottom));
					animY   = -1;
					break;
				
				// Align vertical centers
				case 'alignCenters':
					cssY    = options.positionClasses.yCenter;
					posY    = relOffset.top + Math.round(($rel.outerHeight(false) - $(this).outerHeight(false)) / 2);
					isOkayY = true;
					animY   = 0;
					break;
				
				// Align top edges
				case 'alignTopEdges':
					cssY    = options.positionClasses.alignTopEdges;
					posY    = relOffset.top + options.margin.top;
					isOkayY = ((posY + $(this).outerHeight(false)) < (options.container.height() + options.container.scrollTop() - options.containerPadding.bottom));
					isOkayY = (isOkayY && (posY > (options.container.scrollTop() + options.containerPadding.top)));
					animY   = 0;
					break;
				
				// Align bottom edges
				case 'alignBottomEdges':
					cssY    = options.positionClasses.alignBottomEdges;
					posY    = relOffset.top + $rel.outerWidth(false) - $(this).outerWidth(false) - options.margin.bottom;
					isOkayY = ((posY + $(this).outerHeight(false)) < (options.container.height() + options.container.scrollTop() - options.containerPadding.bottom));
					isOkayY = (isOkayY && (posY > (options.container.scrollTop() + options.containerPadding.top)));
					animY   = 0;
					break;
			}
			
			// If the current Y-position is considered okay, and if overlapping
			// of the tooltip with the 'relativeTo' element is NOT allowed:
			if(isOkayY && ! options.allowOverlap) {
				// Then, we make sure the elements do not overlap! If they overlap
				if($(this).Ai_IsOverlapping($rel, {positionY : posY})) {
					// Then, we state that the current position is NOT okay. This
					// will cause the loop to try the next Y-position available:
					isOkayY = false;
				}
			}
		}
		
		// For each of the spaces on the X-Axis:
		for(i = 0; i < options.positionX.length && ! isOkayX; i ++) {
			// We check whether or not room is available in the current space.
			// The algorithm used in order to determine this, depends on which 
			// space we're evaluating:
			switch(options.positionX[i]) {
				// Left hand side:
				case 'left':
					cssX    = options.positionClasses.left;
					posX    = relOffset.left - $(this).outerWidth(false) - options.margin.right;
					isOkayX = (posX > (options.container.scrollLeft() + options.containerPadding.left));
					animX   = -1;
					break;
				
				// Right hand side:
				case 'right':
					cssX    = options.positionClasses.right;
					posX    = (relOffset.left + $rel.outerWidth(false) + options.margin.left);
					isOkayX = ((posX + $(this).outerWidth(false)) < (options.container.width() + options.container.scrollLeft() - options.containerPadding.right));
					animX   = 1;
					break;
				
				// Align horizontal centers
				case 'alignCenters':
					cssX    = options.positionClasses.xCenter;
					posX    = relOffset.left + Math.round(($rel.outerWidth(false) - $(this).outerWidth(false)) / 2);
					isOkayX = ((posX + $(this).outerWidth(false)) < (options.container.width() + options.container.scrollLeft() - options.containerPadding.right));
					isOkayX = (isOkayX && (posX > (options.container.scrollLeft() + options.containerPadding.left)));
					animX   = 0;
					break;
				
				// Align left edges
				case 'alignLeftEdges':
					cssX    = options.positionClasses.alignLeftEdges;
					posX    = relOffset.left + options.margin.left;
					isOkayX = ((posX + $(this).outerWidth(false)) < (options.container.width() + options.container.scrollLeft() - options.containerPadding.right));
					animX   = 0;
					break;
				
				// Align right edges
				case 'alignRightEdges':
					cssX    = options.positionClasses.alignRightEdges;
					posX    = relOffset.left + $rel.outerWidth(false) - $(this).outerWidth(false) - options.margin.right;
					isOkayX = (posX > (options.container.scrollLeft() + options.containerPadding.left));
					animX   = 0;
					break;
			}
			
			// If the current X-position is considered okay, and if overlapping
			// of the tooltip with the 'relativeTo' element is NOT allowed:
			if(isOkayX && ! options.allowOverlap) {
				// Then, we make sure the elements do not overlap! If they overlap:
				// (Note that, here, we take into account both the x and y coords
				//  calculated for the position)
				if($(this).Ai_IsOverlapping($rel, {positionX : posX, positionY : posY})) {
					// Then, we state that the current position is NOT okay. This
					// will cause the loop to try the next X-position available:
					isOkayX = false;
				}
			}
		}
		
		// For each of the position classes:
		for(i in options.positionClasses) {
			// If the current position class is not to be applied:
			if(options.positionClasses[i] != cssX && options.positionClasses[i] != cssY) {
				// Then, we remove it:
				$(this).removeClass(options.positionClasses[i]);
			}
			// If the class should be applied:
			else {
				// Then, add it:
				$(this).addClass(options.positionClasses[i]);
			}
		}
		
		// If animation should be enabled to the new position:
		if(options.animate) {
			// Additional animation properties can be provided, for this plugin: 
			// moveX and moveY. These properties are converted to their equivalents 
			// in css properties "top" and "left".
			if(typeof options.animate.properties == 'object') {
				// If moveX has been provided as a property for animation, and 
				// animation on the X-Axis makes sense:
				if(typeof options.animate.properties.moveX != undefined && animX != 0) {
					// The target position for animation:
					options.animate.properties.left = posX;
					
					// Then, we'll apply the animX factor we have prepared earlier
					// to the moveX property, and we'll add the resulting number 
					// to the current left in order to get the starting position 
					// for animation on the X-Axis:
					posX += (options.animate.properties.moveX * animX);
				}
				
				// If moveY has been provided as a property for animation, and 
				// animation on the Y-Axis makes sense:
				if(typeof options.animate.properties.moveY != undefined && animY != 0) {
					// The target position for animation:
					options.animate.properties.top = posY;
					
					// Then, we'll apply the animY factor we have prepared earlier
					// to the moveY property, and we'll add the resulting number 
					// to the current top in order to get the starting position 
					// for animation on the Y-Axis:
					posY += (options.animate.properties.moveY * animY);
				}
			}
		}
		
		// Apply position to the tooltip:
		$(this).css({
			'position' : 'absolute',
			'left'     : posX + 'px',
			'top'      : posY + 'px'
		});
		
		// If animation should be enabled:
		if(options.animate) {
			// Animate the element into view:
			$(this).animate(options.animate.properties, options.animate.duration, options.animate.easing, function() {
				// When done, check if a callback function has been provided:
				if(typeof options.animate.callback == 'function') {
					// If so, we run the function:
					options.animate.callback();
				}
			});
		}
		
		// Return the matched elements
		return this;
	};
	
	/**
	 * Get flag: Is positioned with a styling?
	 * 
	 * This plugin function will check whether or not the matched element is 
	 * positioned with the provided style. 
	 * 
	 * Note that you can also check the parents of the element, by setting the 
	 * second argument to (boolean) TRUE. In that case, this function will 
	 * recursively loop through the parents of the element, until an element is 
	 * found with a matching style for positioning.
	 * 
	 * @access public
	 * @param string positionStyle
	 * @param bool doRecursiveCheck
	 * @return bool 
	 */
	$.fn.Ai_IsPositionedWithStyle = function(positionStyle, doRecursiveCheck) {
		// If the element has a 'position' property, and it matches the provided
		// style for positioning:
		if($(this).css('position') == positionStyle) {
			// Then, we return TRUE
			return true;
		}
		
		// If a recursive check is to be done:
		if(doRecursiveCheck) {
			// Prepare working variables to loop through the parents:
			var $parent = $(this).parent();
			
			// While a parent can be found:
			while($parent && $parent.length > 0) {
				// We stop searching at the <BODY> tag:
				if(typeof $parent.get(0).tagName == 'undefined' || $parent.get(0).tagName.toString().toUpperCase() == 'BODY') {
					// If we have reached that tag, we return FALSE as result.
					return false;
				}
				
				// If still here, then we have not yet reached the <BODY> tag.
				// In that case, we check if the parent has the requested position
				// style:
				if($parent.css('position') == positionStyle) {
					// Then, we return TRUE
					// (we stop looping through parents)
					return true;
				}
				
				// Prepare for next loop:
				$parent = $parent.parent();
			}
		}
		
		// If we're still here, then we did not find a match. In that case, we
		// return (boolean) FALSE instead
		return false;
	};
	
	/**
	 * Get Offset
	 * 
	 * This plugin function will return the offset of an element, just like the
	 * function $.fn.offset() would. However, this function has been added to the
	 * collection of plugins, for elements that are being positioned "fixed". For
	 * elements with a fixed position, the scroll is not to be taken into account
	 * in the offset.
	 * 
	 * NOTE:
	 * If the offset of the element cannot be determined, this function will
	 * return NULL instead!
	 * 
	 * @access public
	 * @return stdObj
	 */
	$.fn.Ai_Offset = function() {
		// Get the offset of the element:
		var o = $(this).offset();
		
		// If the offset cannot be determined:
		if(! o) {
			// Then, we return NULL instead:
			return null;
		}
		
		// First, we check if the user has scrolled the current page. We do this
		// check first, because in most cases that will be more performant than
		// starting the recursive search of position styles right away.
		var s = $(document).scrollTop();
		
		// So, if not scrolled:
		if(! s) {
			// Then, we simply return the offset as-is
			return o;
		}
		
		// If the element (or its parent) is positioned as FIXED on the page:
		// (we also check the element's parents recursively)
		if($(this).Ai_IsPositionedWithStyle('fixed', true)) {
			// Then, we do not take into account the scrolling:
			o.top  -= s;
			o.left -= $(document).scrollLeft();
		}
		
		// Return the offset:
		return o;
	}
	
	/**
	 * Get canvas
	 * 
	 * Will return the paper on which we draw all objects. This method will 
	 * construct the canvas paper once, and return the same paper after the first 
	 * call. You can however delete a canvas, causing a new instance to be returned
	 * on the next call, by calling $.Ai_CanvasRemove()
	 * 
	 * @access public
	 * @return Raphael.paper()
	 */
	$.Ai_Canvas = function() {
		// If the paper has not yet been constructed:
		if(! $.Ai_Registry.paper) {
			// Then we create a canvas, at x,y (0,0), with the current window's 
			// width and height:
			$.Ai_Registry.paper = Raphael(0, 0, $(window).width(), $(document).height());
			$('svg:last').css({'z-index' : 20050});
			
			// Also, we add an event listener in order to maintain the canvas'
			// width and height. We listen to the window.resize event:
			$(window).bind('resize', _onWindowResizePaper);
		}
		
		// Return the paper:
		return $.Ai_Registry.paper;
	};
	
	/**
	 * Clear/Remove canvas
	 * 
	 * Will remove the drawing paper returned by $.Ai_Canvas(). Also, all event 
	 * handlers created by $.Ai_Canvas() will be removed.
	 * 
	 * @access public
	 * @return Raphael.paper()
	 */
	$.Ai_CanvasRemove = function() {
		// If the paper has been constructed:
		if($.Ai_Registry.paper) {
			// Then, send the remove() command to the paper. This will remove 
			// the DOM element from the page:
			$.Ai_Registry.paper.remove();
			
			// Forget about the drawing paper:
			$.Ai_Registry.paper = null;
			
			// Also, we add an event listener in order to maintain the canvas'
			// width and height. We listen to the window.resize event:
			$(window).unbind('resize', _onWindowResizePaper);
		}
	};
	
	/**
	 * Event handler: window resize
	 * 
	 * This private function will respond to the window being resized. It will 
	 * resize the drawing paper, to match the new window size.
	 * 
	 * @access private
	 * @return void
	 */
	function _onWindowResizePaper() {
		// If the canvas/paper is active:
		if($.Ai_Registry.paper) {
			// When resized, we apply the window's current width and height 
			// to the drawing canvas:
			$.Ai_Registry.paper.setSize($(window).width(), $(document).height());
		}
	};
	
	/**
	 * Bind an event (only once)
	 * 
	 * @access public
	 * @param string type
	 *		The type of event
	 * @param function handler
	 *		The event listener function, that responds to the DOM event being 
	 *		triggered
	 * @return $(matchedElements)
	 */
	$.fn.Ai_BindOnce = function(type, handler) {
		// Get the functions that have been bound to the DOM element:
		var events = $(this).data('events');
		
		// If an event handler, or multiple event handlers, of the requested type 
		// has already been bound to the element:
		if(events && typeof events[type] != 'undefined') {
			// Then, for each of the handlers:
			jQuery.each(events[type], function(i, handlerObj) {
				// We compare the current event handler to the one that has been
				// provided to this function
				if(handlerObj.handler.toString() == handler.toString()) {
					// Then, we unbind the handler. We will bind again with the
					// new handler. This is done to make sure that the handler
					// will keep working with new variable values.
					$(this).unbind(type, handlerObj.handler);
				}
			});
		}
		
		// Bind the event handler now:
		$(this).bind(type, handler);
		
		// Return the matched elements
		return this;
	};
	
	/**
	 * Highlight DOM Element
	 *
	 * Will highlight an element in the DOM, by adding an overlay to the body. The
	 * bounding box of the DOM element will be cut out of the overlay, creating a
	 * visual effect that highlights the selected DOM element against the overlay.
	 * 
	 * NOTE: Requires Raphael JS
	 * 
	 * @access public
	 * @param StdObject options
	 *		The options for the highlighting of the element. For a complete list
	 *		of available options, please check $.fn.Ai_Highlight.defaults
	 * @return $(matchedElements)
	 */
	$.fn.Ai_Highlight = function(options) {
		// Merge the provided options with the default ones:
		var o = $.extend({}, $.fn.Ai_Highlight.defaults, options);

		// Also set default paddings:
		o.padding = $.extend({}, $.fn.Ai_Highlight.defaults.padding, o.padding);
		
		// If the highlighted element is not inside the viewport
		if(! $(this).Ai_IsInsideViewport({complete : true, margin : [100, 100, 100, 100]})) {
			// Scroll to the highlighted element:
			var thisOffset = $(this).Ai_Offset();
			
			// If the offset is known:
			if(thisOffset) {
				// Then, scroll in order to vertically center the element
				// inside the current viewport:
				$(window).scrollTop(thisOffset.top - $(window).height() / 2 - $(this).height() / 2);
			}
		}
		
		// We disable scrolling in the window:
		$('body').css('overflow', 'hidden').attr('scroll', 'no');
		$('html').css('overflow', 'hidden');
		
		// Compose the path for the overlay:
		var d  = _getPathOverlay();

		// Compose the path for the cutout. Note that we add extra padding to the
		// cutout shape. We do this for animation to the final shape...
		var dc = _getPathCutout($(this), o, {
			// Extra padding:
			left   : 30,
			right  : 30,
			top    : 30,
			bottom : 30
		});
		
		// Now, with the path syntaxes we have composed in string format, we draw
		// the path in the page's canvas. The following command draws both the 
		// overlay and the cutout:
		var overlay = $.Ai_Canvas().path(d + dc).attr({
			// Apply styling to the overlay:
			// - No border at all
			'stroke-width' : 0, 
			// - Filled with the color that has been requested in the options
			'fill'         : o.overlayColor,
			// - With the opacity that has been requested:
			'fill-opacity' : o.overlayOpacity
		});

		// We redraw the cutout on top. This shape is opaque (not filled), and 
		// given a border of the requested thickness and color.
		var cutout = $.Ai_Canvas().path(dc).attr({
			'stroke-width'   : o.borderThickness, 
			'stroke'         : o.borderColor, 
			'stroke-opacity' : o.borderOpacity
		});
		
		// Now, we animate the cutout to the requested padding. In order to do
		// so, we calculate the path for the final cutout. Note that, this time,
		// we are not adding extra padding:
		dc = _getPathCutout($(this), o, {});
		
		// Animate to the final shape. Note that we use the provided options to 
		// define the speed of the animation and the easing method:
		overlay.animate({path : d + dc}, o.speed, o.easing);
		cutout.animate({path : dc}, o.speed, o.easing);
		
		// Should we add a tooltip, with additional information on the highlighted
		// DOM element?
		if(o.infoTitle || o.infoHtml) {
			// We prepare a variable, in which we accumulate the HTML
			var h = '';
			
			// We start by adding the wrapper of title and description:
			h += '<div class="highlight-info" style="position: absolute; top: 0; left: 0;">';
			
			// Has a title been provided?
			if(o.infoTitle) {
				// Then, we add the HTML to include a title:
				h += '<div class="title">'+ o.infoTitle +'</div>';
			}
			
			// Has HTML been provided?
			if(o.infoHtml) {
				// Then, we add the HTML:
				h += '<div class="html">'+ o.infoHtml +'</div>';
			}
			
			// We close the wrapper:
			h += '</div>';
			
			// We append the HTML to the page:
			$('body').append(h);
			
			// We apply the best position to the info window:
			$('.highlight-info').css({'z-index' : 20051}).Ai_TooltipPosition({
				// Relative to the highlighted element:
				'relativeTo' : $(this),
				// Margin from the info window to the cutout:
				'margin'     : {
					left   : o.padding.left * 2,
					right  : o.padding.right * 2,
					top    : o.padding.top * 2,
					bottom : o.padding.bottom * 2
				},
				'containerPadding' : {
					'top'    : 80, // Temporary fix for the top bar in Guided Tours
					'right'  : 10,
					'bottom' : 10,
					'left'   : 10
				},
				'positionX' : ['alignCenters', 'left', 'right'],
				'positionY' : ['top', 'bottom', 'alignCenters']
			});
		}
		
		// When the window is resized, the overlay and the cutout need to be 
		// redrawn. First of all, we get a reference to the matched elements, so 
		// we can reuse it in anonymous event handlers:
		var $this = $(this);
		
		// We define an event handler that repositions the highlight info window.
		// This handler will be called when the window is resized, or scrolled in
		var infoWindowEventHandler = function() {
			// Get the current highlight info window:
			var $infoWindow = $('.highlight-info');
			
			// Is an info window being shown?
			if($infoWindow.length > 0) {
				// We recalculate and apply the best position to the info 
				// window:
				$infoWindow.Ai_TooltipPosition({
					// Relative to the highlighted element:
					'relativeTo' : $this,
					// Margin from the info window to the cutout:
					'margin'     : {
						left   : o.padding.left * 2,
						right  : o.padding.right * 2,
						top    : o.padding.top * 2,
						bottom : o.padding.bottom * 2
					},
					'containerPadding' : {
						'top'    : 80, // Temporary fix for the top bar in Guided Tours
						'right'  : 10,
						'bottom' : 10,
						'left'   : 10
					},
					'positionX' : ['alignCenters', 'left', 'right'],
					'positionY' : ['top', 'bottom', 'alignCenters'],
					'allowOverlap' : false
				});
			}
		}
		
		// Listen to a resize of the window:
		$(window).Ai_BindOnce('resize', function() {
			// Get the highlighted element:
			var e = $.Ai_HighlightedElement();
			
			// If available
			if(e) {
				// Calculate the new path for the cutout:
				var p = _getPathCutout($this, o);
				
				// Redraw the overlay
				overlay.attr({path : _getPathOverlay() + p});

				// Redraw the cutout
				cutout.attr({path : p});

				// Reposition the info window
				infoWindowEventHandler();
			}
		});
		
		// When scrolling in the window:
		// $(window).scroll(function() {
		$(window).Ai_BindOnce('scroll', function() {
			// Reposition the info window
			infoWindowEventHandler();
		});
		
		// We remember about the highlighted element, so we can retrieve it later 
		// on with the $.HighlightedElement() function.
		$.Ai_Registry.HighlightedElement = $(this);
		
		// Return the matched elements
		return this;
	};
	
	/**
	 * Remove Current Highlight
	 * 
	 * Will remove the highlight from the element in the DOM, that has been 
	 * added with $.fn.Ai_Highlight().
	 * 
	 * Note that you can ask this function to remove the canvas too. For more 
	 * information, read $.Ai_CanvasRemove()
	 * 
	 * @access public
	 * @return void
	 */
	$.Ai_HighlightRemove = function(removeCanvasToo) {
		// We enable scrolling again, in the window:
		$('body').css('overflow', 'inherit').removeAttr('scroll');
		$('html').css('overflow', 'inherit');
		
		// Clear all elements from the drawing sheet
		$.Ai_Canvas().clear();
		
		// Remove the highlight info window:
		$('.highlight-info').remove();
		
		// Also, forget about the highlighted element
		$.Ai_Registry.HighlightedElement = null;
		
		// Delete the canvas?
		if(removeCanvasToo) {
			// If so, then remove the canvas:
			$.Ai_CanvasRemove();
		}
	};
	
	/**
	 * Get highlighted element
	 * 
	 * @access public
	 * @return $(matchedElements)
	 */
	$.Ai_HighlightedElement = function() {
		// Return the currently highlighted element
		return $.Ai_Registry.HighlightedElement;
	};

	/**
	 * Default options for Highlighting DOM Elements
	 * 
	 * We expose the default settings for Highlighting DOM Elements. This makes it 
	 * very easy for plugin users to override/customize the default behavior of the 
	 * plugin with minimal code, while still enabling them to customize each call to
	 * the plugin function.
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_Highlight.defaults = {
		'padding'         : {
			top: 20,
			right: 20,
			bottom: 20,
			left: 20
		},
		'overlayColor'    : '#000000',
		'overlayOpacity'  : 0.75,
		'borderColor'     : '#008fd4',
		'borderThickness' : 3,
		'borderOpacity'   : 1,
		'infoTitle'       : null,
		'infoHtml'        : null,
		'infoMaxWidth'    : 500,
		'easing'          : 'easeInOutLinear',
		'speed'           : 250
	};
	
	/**
	 * Guided Tour
	 * 
	 * This plugin will use the Ai_Highlight plugin in order to create a guided 
	 * tour of elements on the page.
	 * 
	 * @access public
	 * @return $(matchedElements)
	 */
	$.fn.Ai_GuidedTour = function(options) {
		// Set the currently active frame:
		options._currentSlide = 0;
		
		// We remember about the options provided, in the element:
		$(this).data('Ai_GuidedTour_Options', options);
		
		// If the matched element is clicked, we'll start the guided tour. So,
		// respond to the click event:
		$(this).click(function($event) {
			// We start the guided tour, by showing the first frame in the guided
			// tour:
			$(this).Ai_GuidedTourShowSlide(options._currentSlide, true);
			
			// Insert the top bar with options for the guided tour. This bar 
			// contains previous/next buttons, a play/pause button, and the title
			// of the current slide. First, we compose the HTML:
			var h = '';
			h += '<div id="tour-info-bar">';
			h +=    '<a href="" id="tour-previous">';
			h +=       'Previous slide';
			h +=    '</a>';
			h +=    '<a href="" id="tour-next">';
			h +=       'Next slide';
			h +=    '</a>';
			h +=    '<a href="#" id="tour-close">';
			h +=       'Close';
			h +=    '</a>';
			h += '</div>';
			
			// Append the bar to the page:
			$('body').append(h);
			
			// Set the actions for the "previous" button:
			var $this = $(this);
			$('#tour-previous').click(function() {
				$this.Ai_GuidedTourMove(-1, false);
				return false;
			});
			
			// And for the "next" button
			$('#tour-next').click(function() {
				$this.Ai_GuidedTourMove(1, true);
				return false;
			});
			
			// And for the "close" button
			$('#tour-close').click(function() {
				$this.Ai_GuidedTourClose();
				return false;
			});
			
			// Position the bar:
			_windowResizeGuidedTourBar();
			
			// When the window is resized:
			$(window).Ai_BindOnce('resize', _windowResizeGuidedTourBar);
			$(window).Ai_BindOnce('scroll', _windowResizeGuidedTourBar);
			
			// We prevent the default handling of the click event:
			$event.preventDefault();
		});
		
		// Return the matched element
		return this;
	}
	
	$.fn.Ai_GuidedTourShowSlide = function(slideId, resumeAutoPlay) {
		// Get the interval that was set in order to show the next slide in 
		// the guided tour:
		_clearInterval();
		
		// Remove the current highlight on the page:
		// (without removing the drawing paper)
		$.Ai_HighlightRemove(false);
		
		// Get the options, and the Slide ID
		var options = _getOptions($(this));
		
		// If not found:
		if(! options) {
			// Then, stop here:
			return this;
		}
		
		// Get the slide:
		var slide = _getSlide(options, slideId);
		
		// If not found:
		if(! slide) {
			// Then, stop here
			return this;
		}
		
		// First of all, we check if a callback has been provided in the slide's
		// options, for initialization of this slide:
		if(typeof slide.onInit == 'function') {
			// If so, we call this method now:
			slide.onInit();
		}
		
		// Then, we highlight the element that has been indicated for this slide.
		// Get the element to be highlighted:
		var $elm = $(slide['highlight']);
		
		// If found:
		if($elm.length > 0) {
			// Highlight the element:
			$elm.Ai_Highlight($.extend({}, slide['highlightOptions']));
		}
		
		// If auto play is to be enabled, after showing this slide:
		if(resumeAutoPlay) {
			// Get a reference to the matched element:
			var $this = $(this);
			
			// If autoplay is enabled:
			if(options.autoPlay) {
				// Set a time out to...
				var ms = (typeof slide['slideDuration'] != 'undefined' ? parseInt(slide['slideDuration']) : options.slideDuration);
				_setInterval(ms, function() {
					// Show the next slide:
					$this.Ai_GuidedTourMove(1, true);
				});
			}
		}
		
		// If highlight options have been provided, and a title has been set for 
		// the current slide:
		if(typeof slide['highlightOptions'].infoTitle != 'undefined') {
			// Then, show the title:
			$('#tour-title').html(slide['highlightOptions'].infoTitle);
		}
		
		// Get the previous slide:
		slide = _getSlideWithDiff(options, -1);
		
		// If found:
		if(slide) {
			// If a title has been set for the previous slide:
			if(typeof slide['highlightOptions'].infoTitle != 'undefined') {
				// Then, show the title:
				$('#tour-previous').show().html(slide['highlightOptions'].infoTitle);
			}
		}
		// If not found:
		else {
			// Then, hide the previous button:
			$('#tour-previous').hide();
		}
		
		// Get the next slide:
		slide = _getSlideWithDiff(options, 1);
		
		// If found:
		if(slide) {
			// If a title has been set for the next slide:
			if(typeof slide['highlightOptions'].infoTitle != 'undefined') {
				// Then, show the title:
				$('#tour-next').show().html(slide['highlightOptions'].infoTitle);
			}
		}
		// If not found:
		else {
			// Then, hide the next button:
			$('#tour-next').hide();
		}
		
		// Return the matched elements
		return this;
	}
	
	$.fn.Ai_GuidedTourMove = function(diff, resumeAutoPlay){
		// Get the options, and the Slide ID
		var options = _getOptions($(this));
		
		// If not found:
		if(! options) {
			// Then, stop here:
			return this;
		}
		
		// Get the slide:
		var slide = _getSlideWithDiff(options, diff);
		
		// If not found:
		if(! slide) {
			// Then, stop the guided tour
			$(this).Ai_GuidedTourClose();
			return this;
		}
		
		// Show the next slide:
		options._currentSlide = slide.slideId;
		$(this).Ai_GuidedTourShowSlide(slide.slideId, resumeAutoPlay);
		
		// Return the matched elements
		return this;
	}
	
	$.fn.Ai_GuidedTourClose = function() {
		// Get the interval that was set in order to show the next slide in 
		// the guided tour:
		_clearInterval();
		
		// Get the options of the guided tour:
		var options = $(this).data('Ai_GuidedTour_Options');
		
		// If the options are not available, then the Guided Tour has not been
		// initiated on this element. In this case:
		if(typeof options == 'undefined') {
			// We stop here
			return this;
		}
		
		// Remove the current highlight on the page:
		// (also, remove the drawing paper)
		$.Ai_HighlightRemove(true);
		
		// Remove the tour's top bar:
		$('#tour-info-bar').remove();
		
		// Forget the options:
		// $(this).removeData('Ai_GuidedTour_Options');
		
		// Reset the current slide index:
		options._currentSlide = 0;
		
		// Return the matched elements
		return this;
	};
	
	function _getOptions($trigger, slideDiff) {
		// Get the options of the guided tour:
		var options = $trigger.data('Ai_GuidedTour_Options');
		
		// If the options are not available, then the Guided Tour has not been
		// initiated on this element. In this case:
		if(typeof options == 'undefined') {
			// We return null
			return null;
		}
		
		// Return the options
		return options;
	}
	
	function _getSlide(options, slideId) {
		// If no ID has been provided, 
		if(typeof slideId == 'undefined') {
			// We look for the active slide:
			slideId = options._currentSlide;
		}
		
		// We check if the requested slide can be found. If that's not the case:
		if(! (typeof options.slides != 'undefined' && typeof options.slides[slideId] != 'undefined')) {
			// We return null instead
			return null;
		}
		
		// Add the ID of the slide to the output:
		options.slides[slideId].slideId = slideId;
		
		// Return the slide:
		return options.slides[slideId];
	}
	
	function _getSlideWithDiff(options, diff) {
		// Return the requested slide:
		return _getSlide(options, options._currentSlide + parseInt(diff));
	}
	
	function _windowResizeGuidedTourBar($event) {
		// Get the guided tour's top bar:
		var $tourbar = $('#tour-info-bar');

		// If found:
		if($tourbar.length > 0) {
			// Reposition the bar:
			$tourbar.css({
				'position' : 'absolute',
				'top'      : $(window).scrollTop()  + 'px',
				'left'     : '0px',
				'width'    : $(window).width(),
				'z-index'  : 20052
			});
		}
		// If not found:
		else if(typeof $event != 'undefined') {
			// Then, unbind this function:
			$(window).unbind('resize', _windowResizeGuidedTourBar);
			$(window).unbind('scroll', _windowResizeGuidedTourBar);
		}
	}
	
	function _clearInterval() {
		// Get the interval that was set in order to show the next slide in 
		// the guided tour:
		var interval = $(this).data('Ai_GuidedTour_Interval');
		
		// If found:
		if(interval) {
			// Then, remove the interval:
			clearTimeout(interval);
			$(this).removeData('Ai_GuidedTour_Interval');
		}
	}
	
	function _setInterval(milliseconds, func) {
		// Set the interval:
		$(this).data('Ai_GuidedTour_Interval', setTimeout(func, milliseconds));
	}
	
	/**
	 * Perform hit test, with X- and Y-coordinates
	 * 
	 * This method will take two arguments, and interpret them as X- and Y-coordinates
	 * on the current page. Then, it will check if the position described by 
	 * these coordinates overlaps the matched element.
	 * 
	 * @access public
	 * @param integer x
	 * @param integer y
	 * @return bool
	 *		Returns true if a hit has been detected, false if not
	 */
	$.fn.Ai_HitTestXY = function(x, y) {
		// Prepare the output variable:
		var h = false;

		// Get the matched element's offset
		var o = $(this).Ai_Offset();

		// Perform the hit test,
		// - On the X-axis:
		h = (x >= o.left && x <= (o.left + $(this).outerWidth(false)));
		// - And on the Y-axis:
		h = (h && y >= o.top && y <= (o.top + $(this).outerHeight(false)));

		// Return the result of the hit test:
		return h;
	}
	
	/**
	 * Is in viewport?
	 * 
	 * This method will tell wether or not the matched element is inside the
	 * visible portion of a viewport. The visible portion of a viewport is defined
	 * by the width and height of its container, and the scroll position.
	 * 
	 * Typically, this function is used to check whether or not a given element
	 * is visible in the interface, not by its css display properties, but because
	 * of its current position in the page or in its container.
	 * 
	 * @access public
	 * @param StdObject options
	 * @return bool
	 *		Returns true if the element is visible, false if not
	 */
	$.fn.Ai_IsInsideViewport = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({}, $.fn.Ai_IsInsideViewport.defaults, options);
		
		// Get the bounding box of the matched element:
		var offsetE = $(this).Ai_BoundingBox({
			// With the margin of the element:
			padding : options.margin
		});
		
		// And the box of the viewport:
		var offsetV = options.viewport ? $(options.viewport).Ai_BoundingBox() : $.Ai_BoundingBoxWindowViewport();
		
		// Check if the upper left corner is inside the viewport:
		var c = true;
		c = (c && offsetE.left >= offsetV.left && offsetE.left < offsetV.right);
		c = (c && offsetE.top >= offsetV.top && offsetE.top < offsetV.bottom);
		
		// If the complete element must be visible inside the viewport:
		if(c && options.complete) {
			// Then, we make sure the lower right corner is also inside the 
			// viewport's bounding box:
			c = (c && offsetE.right >= offsetV.left && offsetE.right < offsetV.right);
			c = (c && offsetE.bottom >= offsetV.top && offsetE.bottom < offsetV.bottom);
		}
		
		// Return the result:
		return c;
	}
	
	/**
	 * Is in viewport? Default option values
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_IsInsideViewport.defaults = {
		// The viewport/container (defaults to $(window))
		viewport : null,
		// Should the matched element be entirely visible, or should the test
		// return a positive result if only a portion of the element is visible?
		complete : false,
		// If you want the element to have a margin in the viewport, then
		// set the margin here:
		margin : [0, 0, 0, 0]
	};
	
	/**
	 * Are elements overlapping?
	 * 
	 * @access public
	 * @param StdObject options
	 * @return bool
	 *		Returns true if the element is visible, false if not
	 */
	$.fn.Ai_IsOverlapping = function($element, options) {
		// Merge the provided options with the default ones:
		var options = $.extend({}, $.fn.Ai_IsOverlapping.defaults, options);
		
		// Get the bounding box of the elements:
		var boxThis = $(this).Ai_BoundingBox({padding : options.boundingBoxPadding});
		var boxElem = $element.Ai_BoundingBox();
		var posDiff = 0;
		
		// If a virtual x-position is to be applied to the element:
		if(typeof options.positionX != 'undefined') {
			// Then, calculate the difference in x-position:
			posDiff = boxThis.left - parseInt(options.positionX);
			
			// And, apply the position to the bounding box:
			boxThis.left    += posDiff;
			boxThis.right += posDiff;
		}
		
		// If a virtual y-position is to be applied to the element:
		if(typeof options.positionY != 'undefined') {
			// Then, calculate the difference in y-position:
			posDiff = boxThis.top - parseInt(options.positionY);
			
			// And, apply the position to the bounding box:
			boxThis.top  += posDiff;
			boxThis.bottom += posDiff;
		}
		
		// We rule out an overlap in some cases. For example, if the element
		// is positioned completely to the left of the other one, completely
		// to the right, to the top or the bottom...
		if(boxThis.right <= boxElem.left || boxThis.left >= boxElem.right || boxThis.bottom <= boxElem.top || boxThis.top >= boxElem.bottom) {
			// Then, the elements cannot overlap:
			return false;
		}
		
		// If we are still here, then the elements do overlap
		return true;
	}
	
	/**
	 * Are elements overlapping? Default option values
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_IsOverlapping.defaults = {
		// If you want to expand the element's bounding box while checking the
		// overlap, then set the box's padding here:
		boundingBoxPadding : [0, 0, 0, 0],
		// If you want to apply a virtual position to the element to check if
		// an overlap would be the case, you can provide the x coordinate of the
		// element's position here. The overlap is then tested with this x-
		// position:
		positionX : null,
		// If you want to apply a virtual position to the element to check if
		// an overlap would be the case, you can provide the y coordinate of the
		// element's position here. The overlap is then tested with this y-
		// position:
		positionY : null
	};
	
	/**
	 * Get bounding box of element
	 * 
	 * @access public
	 * @param StdObject options
	 * @return StdObject
	 */
	$.fn.Ai_BoundingBox = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({}, $.fn.Ai_BoundingBox.defaults, options);
		
		// Get the offset of the matched element:
		var o = $(this).Ai_Offset();
		
		// If the offset could not be determined:
		// Then, create a default object to replace the offset:
		var bbox = {
			top  : (o && ! isNaN(o.top))  ? o.top  : 0, 
			left : (o && ! isNaN(o.left)) ? o.left : 0
		};
		
		// Add width and height to offset, to create a bounding box. Also apply
		// margin:
		bbox.right  = bbox.left + parseInt($(this).outerWidth());
		bbox.bottom = bbox.top + $(this).outerHeight();
		
		// Apply margin:
		bbox.top    -= parseInt(options.padding[0]);
		bbox.right  += parseInt(options.padding[1]);
		bbox.bottom += parseInt(options.padding[2]);
		bbox.left   -= parseInt(options.padding[3]);
		
		// Return the box:
		return bbox;
	}
	
	/**
	 * Bounding Box: default option values
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_BoundingBox.defaults = {
		// Add padding to the bounding box:
		padding : [0, 0, 0, 0]
	};
	
	/**
	 * Bounding box of window/viewport
	 * 
	 * @access public
	 * @return StdObject
	 */
	$.Ai_BoundingBoxWindowViewport = function() {
		// Get current scrolling position
		var sTop = $(window).scrollTop();
		var sLeft = $(window).scrollLeft();

		// Then, default to the bounding box of the window:
		return {
			top : sTop,
			left : sLeft,
			right : $(window).width() + sLeft,
			bottom : $(window).height() + sTop
		};
	}
	
	/**
	 * Equals?
	 * 
	 * @access public
	 * @param $() $element
	 * @return bool flag
	 *		Returns TRUE if the element is the same as the matched one, FALSE if not
	 */
	$.fn.Ai_Equals = function($element) {
		return ($element.get(0) == $(this).get(0));
	}
	
	/**
	 * Set Loading State
	 *
	 * Allows for displaying a loading state after a given period of time. 
	 * Optionally, you may provide a DOM element on which the loader is to be 
	 * shown.
	 * 
	 * If the loading state is applied to a specific element, this function will
	 * be swapping css classes, or adding a given class, depending on the options
	 * that are passed in to the call.
	 *
	 * If the loading state is not applied to a specific element, then this 
	 * function will show an overlay that covers the entire page. In order to 
	 * do this, you should write $(window).Ai_ShowLoading({ 'loading' : true });
	 * 
	 * @access public
	 * @param StdObject options
	 * @return void
	 */
	$.fn.Ai_ShowLoading = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({
			// The loading state. If set to TRUE, then the state is "loading". 
			// If set to FALSE, then the state is "idle".
			'loading' : true,
			// By default, if the matched element is not the window, the 'loadingClass'
			// is added to the element. However, you can force an overlay to be 
			// shown too:
			'forceOverlay' : false,
			// The loading message to be shown:
			'message' : '',
			// Loading states are typically shown when AJAX calls are performed.
			// However, in many case, you do not want to show the loading state
			// immediately. Instead, you'll want to show it only if the call takes
			// a bit more time to complete. Here, you can define this timeout
			// interval. Note that this number is expressed in milliseconds.
			'timeout' : 200,
			// If the loading state is applied to a specific DOM element, you can
			// also choose the css class that is to be ADDED to that element, 
			// while the loading state is displayed:
			'loadingClass' : 'loading',
			// You can also define the idle class. Note that, once you define
			// this class, the idle class will be removed from the element, when
			// the loading class is added to the element. If you do not specify
			// the idle class, then the loading class will simply be added (without
			// removing other classes)
			'idleClass' : null
			
		}, options);
		
		// In order to implement the timeout for displaying of loading states,
		// we need to maintain a collection of Interval ID's. If this collection
		// has not yet been initialized:
		if(typeof $.Ai_Registry.LoadingIntervalIds == 'undefined') {
			// Then, we initialize it now:
			$.Ai_Registry.LoadingIntervalIds = new Array();
		}

		// The Interval ID for this call will be stored with a given key. We 
		// compose this key now:
		var key = _isWindow($(this)) ? '__global' : $(this).Ai_AssignId().attr('id');

		// We check if the Interval ID was created before, in a previous call:
		if(typeof $.Ai_Registry.LoadingIntervalIds[key] != 'undefined') {
			// Then, we remove the timeout. If we do not remove the timeout call
			// now, it will be executed after this call. Result: things get 
			// messy :)
			clearTimeout($.Ai_Registry.LoadingIntervalIds[key]);
		}
		
		// First of all, we get a reference to the matched elements, so we can 
		// reuse it in anonymous functions:
		var $this = $(this);
		
		// If the loading state has been set to TRUE
		if(options.loading) {
			// After the timeout (expressed in milliseconds) expires, the 
			// following will be executed:
			$.Ai_Registry.LoadingIntervalIds[key] = setTimeout(function() {
				// If a specific element on the page was selected:
				if(! _isWindow($this) && ! options.forceOverlay) {
					// Add the loading class to the element:
					$this.addClass(options.loadingClass);
					
					// If the idle class has been specified:
					if(options.idleClass) {
						// Then, we remove that idle class from the element:
						$this.removeClass(options.idleClass);
					}
				}
				// If no specific element was selected on the page, then we will
				// show the loading overlay that covers the entire page.
				else {
					// First, create the loading overlay
					var $loadingOverlay = $('<div id="loading-overlay"><div id="loading-message">'+ options.message +'</div></div>');
					
					// Prepare the properties for the overlay:
					var x, y, w, h;
					
					// If the overlay is being applied to the entire window:
					if(_isWindow($this)) {
						x = 0;
						y = 0;
						w = $(document).width();
						h = $(document).height();
					}
					// If applied to an element
					else {
						var offset = $this.Ai_Offset();
						if(offset) {
							x = offset.left;
							y = offset.top;
							w = $this.outerWidth(true); // Including padding!
							h = $this.outerHeight(true);
						}
					}
					
					// Apply CSS to the loading overlay:
					$loadingOverlay.css({
						'opacity'  : 0.7,
						'position' : 'absolute',
						'width'    : w + 'px',
						'height'   : h + 'px',
						'left'     : x + 'px',
						'top'      : y + 'px',
						'z-index'  : 10000
					});
					
					// Append the loading overlay to the body
					$('body').append($loadingOverlay);
				}
			
			// The timeout, in milliseconds:
			}, options.timeout);
		} 
		// If the loading state is set to FALSE:
		else {
			// If a specific element on the page was selected:
			if(! _isWindow($this) && ! options.forceOverlay) {
				// Remove the loading class from the element:
				$this.removeClass(options.loadingClass);

				// If an idle class has been specified, and the element is currently
				// not styled with that class:
				if(options.idleClass && ! $this.hasClass(options.idleClass)) {
					// Then, we restore that idle class on the element:
					$this.addClass(options.idleClass);
				}
			}
			// If no specific element was selected on the page, then we will
			// remove the loading overlay that covers the entire page.
			else {
				$('#loading-overlay').remove();
			}
		}
	}
	
	/**
	 * Progress bar
	 * 
	 * Will show a progress bar inside the matched element(s)
	 * 
	 * @access public
	 * @param StdObject options
	 * @return void
	 */
	$.fn.Ai_ProgressBar = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({}, $.fn.Ai_ProgressBar.defaults, options);
		
		if($('.progress-bar', $(this)).length == 0) {
			
			// We compose the HTML for the progress bar:
			var h = '';

			// If a skin has been specified
			if(options.skin) {
				// Add a wrapper, in order to apply the skin:
				h += '<div class="'+ options.skin +'">';
			}

			// Add the HTML for the progress bar:
			h +=    '<div class="progress-bar">';
			h +=       '<div class="bar">';
			h +=          '<!-- -->';
			h +=       '</div>';
			h +=    '</div>';

			// If a skin has been specified
			if(options.skin) {
				// Close the wrapper
				h += '</div>';
			}

			// We insert the progress bar in the element, and show the initial
			// percentage in the progress bar:
			$(this).html(h);
			
			$(this).Ai_ProgressBar.update(options);
		}
	}
	
	/**
	 * Update the progress bar with a new percentage
	 * 
	 * @access public
	 * @param StdObject options
	 * @return void
	 */
	$.fn.Ai_ProgressBar.update = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({}, $.fn.Ai_ProgressBar.defaults, options);
		
		// We will convert the percentage to a width, expressed in a number
		// of pixels. In order to do so, we first need to get the width of the
		// progress bar's container DIV. Using the container's width, we calculate
		// the width of the progress bar's width:
		var w = Math.floor($('.progress-bar', $(this)).width() * (options.percentage / 100));
		
		// Get the bar:
		var $bar = $('.bar', $(this));
		
		// We check whether or not the bar should be animated to its new width
		if(options.animate) {
			// If so, we animate now:
			$bar.animate({'width' : w}, options.duration, options.easing);
		}
		// If animation has been turned off:
		else {
			// Then, we simply set the new width:
			$bar.css('width', w + 'px');
		}
		
		// Should the percentage be shown as a number too?
		if(options.showPercentage) {
			// Yes! Show it now:
			$bar.html('<span class="percentage">' + options.percentage + '%' + '</span>');
		}
	}
	
	/**
	 * Progress Bar, default option values
	 * 
	 * @access public
	 * @var StdObject
	 */
	$.fn.Ai_ProgressBar.defaults = {
		// Progress bar skin. This is the name of the CSS class you want to 
		// apply to the container of the progress bar:
		'skin'           : 'progress-bar-default',
		// The initial percentage to be shown in the progress bar
		// (a numner ranging from 0 to 100 is expected here)
		'percentage'     : 0,
		// Show the percentage as a number too?
		'showPercentage' : false,
		// Animate the progress bar, when progressing?
		'animate'        : true,
		// Easing, for the animation of the progress bar
		'easing'         : null,
		// Duration of the animation
		'duration'       : 200
	}
	
	/**
	 * Suckerfish menu
	 *
	 * Will handle suckerfish menu's in the website or application.
	 * 
	 * Note that, if you choose to display a suckerfish menu with a 'hover' trigger,
	 * this function will rely on the 
	 * 
	 * @access public
	 * @param StdObject options
	 * @return $(matchedElements)
	 */
	$.fn.Ai_Suckerfish = function(options) {
		// Merge the provided options with the default ones:
		var options = $.extend({
			// Define the event that triggers the suckerfish menu. Possible 
			// values are "hover" and "click"
			'trigger'             : 'hover',
			// Enable menu's when trigger elements in the same selection are
			// hovered, once a menu has been activated with a click. This option
			// is available only if the trigger has been set to "click":
			'showOnHoverSiblings' : false,
			// The timeout with which the menu is to be shown. This is used only
			// if the menu is triggered with "hover"; see option "trigger"
			'timeout'             : 150,
			// The callback function that is to be called when the suckerfish 
			// menu is shown. Note that this function is provided with the 
			// trigger element, and with the menu:
			'onShow'              : function($triggerElement, $menu) {},
			// The callback function that is to be called when the suckerfish 
			// menu is hidden. Note that this function is provided with the 
			// trigger element, and with the menu:
			'onHide'              : function($triggerElement, $menu) {},
			// Callback that is used to look up the suckerfish menu, on the 
			// current page. By default, we define a function that looks for the 
			// next sibling of the trigger element:
			'onGetMenu'           : function($triggerElement) {
				return $triggerElement.next();
			},
			// Hide the menu, on click?
			'hideOnClick'         : true,
			// Note that you can define the z-index that is to be applied to the
			// suckerfish menu. This may be necessary in some cases, in order to
			// make sure that the element appears on top of other elements on the
			// page.
			'zIndex'              : 1001,
			// The suckerfish menu is positioned with the $.Ai_TooltipPosition()
			// plugin function. You can provide options for positioning with the
			// 'position' object. For more info about available options, please
			// see $.Ai_TooltipPosition()
			'position'            : {
				// We set some defaults:
				'positionX'  : ['alignLeftEdges', 'alignRightEdges'],
				'positionY'  : ['bottom', 'top'],
				'margin'     : {
					'top'    : 0,
					'right'  : 0,
					'bottom' : 0,
					'left'   : 0
				}
			}
			
		}, options);

		// We define the actions for the matched element(s). Note that, in order 
		// to do so, we first check the type of trigger/event that has been 
		// requested in this call's options:
		switch(options.trigger) {
			// If the suckerfish is to be shown when hovering the element
			case 'hover':
				alert('Suckerfish with hover() event temporarily not available!');
				break;

			// If the suckerfish menu is to be shown when clicking the element
			case 'click':
				// Then, we add an event handler for the click event, on the
				// trigger element:
				$(this).click(function($e) {
					// When clicked, we show a contextual window for the trigger
					// element. This contextual window is the suckerfish menu:
					$(this).Ai_ContextWindow({
						// We define the callback function that is going to provide
						// the contextual window. In the case of the suckerfish
						// plugin function, we redirect the request for a contextual
						// window to the onGetMenu() callback:
						'onGetElement' : function($for) {
							return options.onGetMenu($for);
						},
						// We define the onShow callback for the contextual window
						'onShow' : function($trigger, $contextWindow) {
							// If a callback function has been defined for the
							// suckerfish menu
							if(typeof options.onShow == 'function') {
								// Then, we redirect to that function:
								options.onShow($trigger, $contextWindow);
							}
						},
						// We define the onHide callback for the contextual window
						'onHide' : function($trigger, $contextWindow) {
							// If a callback function has been defined for the
							// suckerfish menu
							if(typeof options.onHide == 'function') {
								// Then, we redirect to that function:
								options.onHide($trigger, $contextWindow);
							}
						},
						// We define the positioning of the contextual window.
						// This positioning has also been defined for the suckerfish
						// menu, so we can pass along the defined position:
						'position' : options.position,
						// The z-index, for layering:
						'zIndex' : options.zIndex,
						// Set some additional behavior options of the contextual 
						// window shown:
						'hideOnWindowResize'  : true,
						'hideForOtherWindows' : true,
						'hideOnClick'         : true,
						'hideOnClickOutside'  : true,
						'hideOnClickTrigger'  : false,
						'hideOnMouseOut'      : false,
						'hideOnScroll'        : true,
						'hideOnTimeout'       : null,
						'positionOnScroll'    : false
					});
					
					// We are overriding the default behavior of the link:
					$e.preventDefault();
					return false;
				});
				
				// If menu's are to be shown when siblings are hovered:
				if(options.showOnHoverSiblings) {
					// When a trigger item is clicked in the menu, and the 
					// corresponding suckerfish menu is shown, we want menu's of 
					// the other trigger elements to show up when these triggers 
					// are hovered.
					$(this).each(function(i) {
						// So, when other trigger elements are hovered:
						$(this).hover(function() {
							// Get a reference to the element:
							var $this = $(this).Ai_AssignId();

							// We run through the collection of contextual windows
							// that are currently active/shown. We need to do this in
							// order to determine whether or not a menu is shown for 
							// a related trigger element.
							$.Ai_ContextWindowEachActive(function($trigger, $contextWindow, contextWindowOptions) {
								// If the trigger being hovered is not the currently 
								// active one:
								if($trigger.Ai_AssignId().attr('id') != $this.attr('id')) {
									// Then, we'll show the menu for this trigger,
									// with...
									$this.Ai_ContextWindow({
										// The callback function that provides the menu
										'onGetElement' : function($for) {
											return options.onGetMenu($for);
										},
										// The onShow callback
										'onShow' : function($trigger, $contextWindow) {
											// If a callback function has been defined for the
											// suckerfish menu
											if(typeof options.onShow == 'function') {
												// Then, we redirect to that function:
												options.onShow($trigger, $contextWindow);
											}
										},
										// The onHide callback
										'onHide' : function($trigger, $contextWindow) {
											// If a callback function has been defined for the
											// suckerfish menu
											if(typeof options.onHide == 'function') {
												// Then, we redirect to that function:
												options.onHide($trigger, $contextWindow);
											}
										},
										// The positioning options provided
										'position' : options.position,
										// The z-index, for layering:
										'zIndex' : options.zIndex,
										// Some additional behavior options of the 
										// contextual window shown:
										'hideOnWindowResize'  : true,
										'hideForOtherWindows' : true,
										'hideOnClick'         : true,
										'hideOnClickOutside'  : true,
										'hideOnClickTrigger'  : false,
										'hideOnMouseOut'      : false,
										'hideOnScroll'        : true,
										'hideOnTimeout'       : null,
										'positionOnScroll'    : false
									});
								}
							});
						});
					});
				}
				
				// Done with event type "click"
				break;
		}
		
		// Return the matched elements:
		return this;
	}
	
	/**
	 * Is the element referring to the window/document?
	 * 
	 * This private function is used by $.fn.Ai_ShowLoading(), in order to determine
	 * whether or not the matched element is referring to the window or the 
	 * document. This way, we can tell if a specific element on the page has been 
	 * selected, or not.
	 * 
	 * @access private
	 * @var $() $element
	 * @return bool flag
	 *		Returns TRUE if referring to the window/document, FALSE if not
	 */
	function _isWindow($element) {
		return ($element.Ai_Equals($(window)) || $element.Ai_Equals($(document)));
	}
	
	/**
	 * Get path of overlay
	 * 
	 * This private function can be used to generate the path string that draws
	 * the overlay.
	 * 
	 * @access private
	 * @return string
	 */
	function _getPathOverlay() {
		// Compose the path syntax for the overlay. The overlay is a rectangle, 
		// from the upper left corner of the window viewport to the bottom right 
		// corner:
		return 'M0 0H' + $(window).width() + 'V' + $(document).height() + 'H0V0';
	};
	
	/**
	 * Get path of cutout
	 * 
	 * This private function can be used to generate the path string that draws
	 * the cutout in the highlighting overlay.
	 * 
	 * @access private
	 * @param $() $element
	 *		The DOM element, selected with a jQuery selector
	 * @param StdObject options
	 *		The options, as provided to $.fn.Ai_Highlight
	 * @param StdObject extraPadding
	 *		Extra padding, to be applied to the cutout. This extra padding will
	 *		be added to the padding that has been defined in the options.
	 * @return string
	 */
	function _getPathCutout($element, options, extraPadding) {
		// Extra padding can be added to the cutout, in order to animate to a 
		// shape with less padding. This extra padding is to be provided to this
		// function in the same format as in $.fn.Ai_Highlight.defaults
		extraPadding = $.extend({left : 0, right : 0, top : 0, bottom : 0}, extraPadding);
		
		// First of all, we get the bounding box of the element that is to be 
		// highlighted. In order to do so, we get the offset of the element. Note 
		// that we already apply padding to the coordinates of the box:
		var elmOffset   = $element.Ai_Offset();
		var boundingBox = {
			x1 : elmOffset.left,
			y1 : elmOffset.top,
			x2 : elmOffset.left + $element.outerWidth(),
			y2 : elmOffset.top + $element.outerHeight()
		};
		
		// Before we start drawing the cut out, we apply padding to the bounding 
		// box of the matched element. We save this information to the object 
		// "outerBoundingBox"
		var outerBoundingBox = {
			x1 : boundingBox.x1 - options.padding.left - extraPadding.left,
			x2 : boundingBox.x2 + options.padding.right + extraPadding.right,
			y1 : boundingBox.y1 - options.padding.top - extraPadding.top,
			y2 : boundingBox.y2 + options.padding.bottom + extraPadding.bottom
		};
		
		// In order to cut out the bounding box from the overlay, we need to draw in 
		// the opposite direction of the overlay. Note that we have drawn the overlay 
		// clockwise. So, we draw the cutout counter-clockwise. Note that we include 
		// bezier curves, in order to achieve rounded corners for the cutout:
		var p = '';

		// Bottom left corner (Bezier curve)
		p += 'M' + outerBoundingBox.x1 + ' ' + boundingBox.y2;
		p += 'C' + outerBoundingBox.x1 + ',' + outerBoundingBox.y2 + ' ';
		p += outerBoundingBox.x1 + ',' + outerBoundingBox.y2 + ' ';
		p += boundingBox.x1 + ',' + outerBoundingBox.y2;

		// Bottom line
		p += 'H' + boundingBox.x2;

		// Bottom right corner (Bezier curve)
		p += 'C' + outerBoundingBox.x2 + ',' + outerBoundingBox.y2 + ' ';
		p += outerBoundingBox.x2 + ',' + outerBoundingBox.y2 + ' ';
		p += outerBoundingBox.x2 + ',' + boundingBox.y2;

		// Line on right hand side
		p += 'V' + boundingBox.y1;

		// Upper right corner (Bezier curve)
		p += 'C' + outerBoundingBox.x2 + ',' + outerBoundingBox.y1 + ' ';
		p += outerBoundingBox.x2 + ',' + outerBoundingBox.y1 + ' ';
		p += boundingBox.x2 + ',' + outerBoundingBox.y1;

		// Top line
		p += 'H' + boundingBox.x1;

		// Upper left corner (Bezier curve)
		p += 'C' + outerBoundingBox.x1 + ',' + outerBoundingBox.y1 + ' ';
		p += outerBoundingBox.x1 + ',' + outerBoundingBox.y1 + ' ';
		p += outerBoundingBox.x1 + ',' + boundingBox.y1;

		// Line on left hand side
		p += 'V' + boundingBox.y2;

		// Close the shape of the cutout:
		p += 'z';
		
		// Finally, return the path:
		return p;
	};

// end of closure
})(jQuery);