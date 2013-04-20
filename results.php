<?php 
class Results {

	public static $total;
	
	public function __construct()
	{
	}
	
	public static function readFile() 
	{
		if( file_exists('surveyAnswersV1.json' ) ) {
			$json = file_get_contents( 'surveyAnswersV1.json' ); 
			$file = json_decode( $json );
		} else {
			$file = array( 'error' => 'Datei nicht vorhanden' );
		}
		return $file;
	}
	
	public static function setNumberOfParticipants() 
	{
		$file = self::readFile();
		self::$total = sizeof( $file );// count elements => how many people participated
	}
	
	public static function getResults() 
	{
		$file = self::readFile();
		if( !isset( $file['error'] ) ) {
			$elems = self::$total; 
			$results = array();
			
			for( $i = 0; $i < $elems; $i++ ) { // loop over all records and split into questions
				foreach( $file[$i] as $key => $value ) {
					if( $key != 'question' ) { // TODO: dont save it to json
						$question[$key][] = $value; // save each question bundled with its results
					}
				}
			}
			return $question;
		} else {
			return array( 'error' => 'Ein Fehler ist aufgetreten' );
		}
	}
	
	public static function getSingleData( $key ) 
	{
		$questions = self::getResults();
		return $questions[ $key ];
	}
	
	public static function getLabel( $key ) 
	{
		$labels = self::labels();
		return $labels[ $key ];
	}
	
	public static function labels() 
	{
		return array(
			'cat1_question1' => 'War das Essen für Sie vielseitig?',
			'cat1_question2' =>	'Erhalten Sie zu dem Mitagessen jeweils Salat oder Gemüse?',
			'cat2_question1' => 'Nehmen Sie das Personal als freundlich wahr?',
			'cat2_question2' => 'Kann Ihnen das Personal bei Fragen weiterhelfen?',
			'cat2_question3' => 'Fühlen Sie sich wohl in dieser Atmosphäre?',
			'cat3_question1' => 'Stehen Ihnen genügend Hilfsmittel für den Alltag zur Verfügung?',
			'cat3_question2' => 'Wenn Sie weitere Hilfsmittel wünschen, wird ihrem Wunsch entsprochen?',
		);
	}
	
	public static function setChartData( $key ) 
	{
		$single = self::getSingleData( $key );
		$values = array_count_values( $single );
		
		$data = array();
		foreach ( $values as $key => $value ) {
			$item = new stdClass();
			$item->value = $value * 10;
			$item->color = self::getColors( $key );
			array_push( $data, $item );
		} 
		return json_encode( $data );
	}
	
	public static function getColors( $key ) 
	{
		$colors = array(
			'1' => '#E0E4CC',
			'2' => '#69D2E7',
			'3' => '#697000',
			'4' => '#F38630'
		);
		return $colors[ $key ];
	}

	
	public static function getAnswers( $key ) 
	{
		$answers = array(
			0 => 'Miserabel',
			1 => 'Eher schlecht',
			2 => 'Ganz in Ordnung',
			3 => 'Brilliant'
		);
		return $answers[ $key ];
	} 

	public static function getPercent( $count ) 
	{
		$total = self::$total;
		$percent = round( ( $count / $total ), 2 ) * 10;
		return $percent;
	}
}
