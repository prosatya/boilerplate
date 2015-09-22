<?php

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

$_GET['start'] = "2013-12-29"; 
$_GET['end'] ="2015-12-29" ; 

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
	die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
	$timezone = new DateTimeZone($_GET['timezone']);
}

// sprintf("%s/templates/json/events.json", dirname(__FILE__));
// Read and parse our events JSON file into an array of event data arrays.

// $json = file_get_contents(dirname(__FILE__) . '/json/events.json');
// $input_arrays = json_decode($json, true);
// Accumulate an output array of event data arrays.
	
		$args = array( 'post_type' => 'bp_calender');
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
		  $id = get_the_ID();
		  //$title = get_post_meta( $id , '_bp_calender_title', true );
		  $start = get_post_meta( $id , '_bp_calender_start_date', true );
		  $end = get_post_meta( $id , '_bp_calender_end_date', true );
		  $url = get_post_meta( $id , '_bp_calender_url', true );
		  $input_arrays[] = array("title"=>get_the_title(), "start"=>$start, "end"=>$end, "url"=>$url);
		endwhile;

$output_arrays = array();
foreach ($input_arrays as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);
	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}

// Send JSON to the client.
echo json_encode($output_arrays);