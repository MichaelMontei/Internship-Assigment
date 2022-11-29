
/**
 * Export: Initiate the interface
 * 
 * @access public
 * @return void
 */
function Ai_Export_InterfaceKickoff() {
	// Show the "Export Running" message:
	$('#export-complete').hide();
	$('#export-running').show();
	$('#export-error').hide();

	// Send the first batch request:
	Ai_Export_SendBatchRequest(AiExportDefinition.page);
}

/**
 * Export: Send Batch Request
 * 
 * This function sends a batch request to the server, causing the next batch of
 * export to be executed. Note that, if the batch is executed, this function 
 * will also
 * 
 * - Update the interface with the current progress
 * - Send a request for the next batch (if the current batch was successful)
 * 
 * @access public
 * @param integer pageNumber
 * @return void
 */
function Ai_Export_SendBatchRequest(pageNumber) {
	// Perform an AJAX Call
	$.ajax({
		// To the Export URL with the current PATH
		url : jQueryBaseHref + '/ai/export/batch/' + AiExportDefinition.definitionId + '/' + AiExportDefinition.path,
		// The requested Page Number
		data : {
			page : pageNumber
		},
		// We expect JSON as a response:
		dataType : 'json',
		// When successful:
		success : function(data) {
			// Do an update in the interface:
			Ai_Export_InterfaceRefreshAfterBatch(data);
			
			// If the outcome of the request is successful:
			if(data.outcome) {
				// And the export is not yet complete:
				if(! data.progress.complete) {
					// We send a batch request for the next page
					Ai_Export_SendBatchRequest(data.progress.nextPage);
				}
			}
		},
		// If the request fails:
		error: function(xhr, ajaxOptions, thrownError) {
			// Fail In Error:
			Ai_Export_InterfaceFailInError();
		}
	});
}

/**
 * Export: Interface Refresh After Batch
 * 
 * @access public
 * @param stdObject data
 * @return void
 */
function Ai_Export_InterfaceRefreshAfterBatch(data) {
	// If the outcome of the batch is successful:
	if(data.outcome) {
		// Update the percentage completed:
		$('#export-percentage').html(data.progress.percent.string);
		
		// Update the progress bar:
		$('#export-running .progress-bar').css('width', data.progress.percent.number + '%').attr('aria-valuenow', data.progress.percent.number);
		
		// Update the number of entries exported:
		$('#export-done').html(data.progress.end.string);
		$('#export-total').html(data.progress.total.string);
		
		// If the export is complete:
		if(data.progress.complete) {
			setTimeout(function() {
				// Update the link to the download file:
				$('#export-download').attr('href', data.download.uri);
				$('#export-size').html(data.download.size);

				// Then, show the container with "Export Complete" message:
				$('#export-complete').show();
				$('#export-running').hide();
			}, 4000);
		}
	}
	// If not:
	else {
		// Then, handle error here in the interface:
		Ai_Export_InterfaceFailInError();
	}
}

/**
 * Export: Show FAILURE in interface
 * 
 * @access public
 * @return void
 */
function Ai_Export_InterfaceFailInError() {
	$('#export-complete').hide();
	$('#export-running').hide();
	$('#export-error').show();
}