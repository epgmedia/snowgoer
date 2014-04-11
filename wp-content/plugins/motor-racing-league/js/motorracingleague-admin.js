
jQuery(document).ready(function($) {

	/**
	 * Tabs for championship settings
	 */
	$('#motor-racing-league-champ-tabs').tabs({active:0});
	
	/**
	 * Add a table row for an extra pole time option
	 */
	$('#motorracingleague_poletimetable_add').click(function() {
		
		var row = $('#motorracingleague_poletimetable tr:first').html();
		var rowCount = $('#motorracingleague_poletimetable tr').length;
		
		var newRow = row.replace(/\[0\]/g,'['+rowCount+']');
		
		$('#motorracingleague_poletimetable tr:last').after('<tr valign="top" class="motorracingleague_hideinfo">' + newRow + '</tr>');

	});
	
	/**
	 * Remove a table row from the pole time options
	 */
	$('#motorracingleague_poletimetable_remove').click(function() {
		
		var rowCount = $('#motorracingleague_poletimetable tr').length;

		if (rowCount > 1) {
			$('#motorracingleague_poletimetable tr:last').remove();
		}

	});
	
	/*
	 * Toggle using points from results or calculations
	 */
	$("#motorracingleague_toggleinputs").change(function() {
		if ($('#motorracingleague_toggleinputs').is(':checked')) {
	        $('#motorracingleague_inputs :input').attr('disabled', true);
	    } else {
	        $('#motorracingleague_inputs :input').removeAttr('disabled');
	    }   
	});
	
	/*
	 * Help boxes
	 */
    $('#motorracingleague_moreresults_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_moreresults').click(function() {
	    $('#motorracingleague_moreresults_info').dialog('open');
	});
	
    $('#motorracingleague_viewpredictions_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_viewpredictions').click(function() {
	    $('#motorracingleague_viewpredictions_info').dialog('open');
	});
		
    $('#motorracingleague_cookie_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_cookie').click(function() {
	    $('#motorracingleague_cookie_info').dialog('open');
	});

    $('#motorracingleague_poletimedialog_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_poletimedialog').click(function() {
	    $('#motorracingleague_poletimedialog_info').dialog('open');
	});

	$('#motorracingleague_correctposition_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_correctposition').click(function() {
	    $('#motorracingleague_correctposition_info').dialog('open');
	});

	$('#motorracingleague_racepoints_info').dialog({autoOpen:false, bgiframe:true, width:400});
	$('#motorracingleague_racepoints').click(function() {
	    $('#motorracingleague_racepoints_info').dialog('open');
	});

});