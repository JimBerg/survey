<?php include_once 'results.php'; ?>
<h2>Auswertung</h2>

<?php 
	$i = 0;
	$questions = Results::getResults(); 
	$data = array();
	$answer = array(
		0 => 'Miserabel',
		1 => 'Eher schlecht',
		2 => 'Ganz in Ordnung',
		3 => 'Brilliant'
	);
	
	foreach ( $questions as $key => $value ) {
		$data[$i] = Results::setChartData( $key ); 
		$label[$i] = Results::getLabel( $key );
		$json = json_decode( $data[$i] );
		echo "<div class='result-charts'>";
			echo "<h3>$label[$i]</h3>";
			echo "<div class='result-charts-graph'>";
				echo "<canvas id='chart_$i' class='chart' width='150' height='150' data-chart='$data[$i]'></canvas>";			
			echo "</div>";
			echo "<div class='result-charts-text'>";
				echo "<ul>";
					for( $j = 0; $j <= 3; $j++ ) {
						$percent = $json[$j]->value;
						$color = $json[$j]->color;
						echo "<li>";
							echo "<span class='color-icon' style='background: $color;'></span>";
							echo "<span class='percent-text'>$answer[$j]: $percent %</span>";
						echo "</li>";	
					}
				echo "</ul>";
			echo "</div>";
		echo "</div>";
		$i++;
	} 
?>


<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script src="js/Chart.js"></script> 
<script>
  	var charts = $( '.chart' );
  	$( charts ).each( function( index ) {
  		var canvas = document.getElementById( 'chart_'+index );
 		var ctx = canvas.getContext( '2d' );
		var data = $.parseJSON( $( canvas ).attr( 'data-chart' ) );
		var options = {};
  		var pie = new Chart( ctx ).Pie( data, options );
	});
</script>
 
