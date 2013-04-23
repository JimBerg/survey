<?php
/**
 * MODUL 133 | WEBUMFRAGE  
 * 
 * class Results
 * evaluation of survey results
 *  
 * @author Janina Imberg
 * @version 1.0
 * 
 * ---------------------------------------------------------------- */

class Results {

	/**
	 * @var int $total number of particpants
	 */
	public static $total;
	
	public function __construct()
	{
	}
	
	/**
	 * get content of surveyfile with given answers
	 * @return String $file
	 */
	private static function readFile() 
	{
		if( file_exists('surveyAnswersV1.json' ) ) {
			$json = file_get_contents( 'surveyAnswersV1.json' ); 
			$file = json_decode( $json );
		} else {
			$file = array( 'error' => 'Datei nicht vorhanden' );
		}
		return $file;
	}
	
	/**
	 * read file with answers and set $total according to number of participants
	 * @return void
	 */
	public static function setNumberOfParticipants() 
	{
		$file = self::readFile();
		self::$total = sizeof( $file );// count elements => how many people participated
	}
	
	/**
	 * read textfile with answers
	 * loop over all results keys, 
	 * match same keys together 
	 * build new array, with arraykeys = radiobutton groups
	 * @return array $questions | array error
	 */
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
	
	/**
	 * get results of given question from textfile
	 * array with results for values 1 - 4
	 * @param $key = array key
	 * @return array $question
	 */
	public static function getSingleData( $key ) 
	{
		$questions = self::getResults();
		return $questions[ $key ];
	}
	
	/**
	 * set label according to array key
	 * @param String $key = array key
	 * @return String $label = original question
	 */
	public static function getLabel( $key ) 
	{
		$labels = self::labels();
		return $labels[ $key ];
	}
	
	/**
	 * matches array keys to questions
	 * (well no function would be needed here...)
	 * @return array 
	 */
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
	
	/**
	 * format data for chart.js as json object
	 * with keys: value and color
	 * @param String $key
	 * @return json Object | stdClass
	 */
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
	
	/**
	 * match colors for labels
	 * @param int $key = $key of answer for each group
	 * @return String $color as hexval
	 */
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

	/**
	 * set labels for each value
	 * @param $key = array key
	 * @return String $answer
	 */
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

	/**
	 * calculate percent of given answer
	 * @param $count = total results
	 * @return float $percent
	 */
	public static function getPercent( $count ) 
	{
		$total = self::$total;
		$percent = round( ( $count / $total ), 2 ) * 10;
		return $percent;
	}
}
