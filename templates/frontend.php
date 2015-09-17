<script>
	
	jQuery(document).ready(function() {

		jQuery('#calendar').fullCalendar({
			defaultDate: Date(),
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: <?php 
			include(sprintf("%s/get-events.php", dirname(__FILE__)));
			?>
		});
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
<div id='calendar'></div>


