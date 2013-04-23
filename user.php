<?php
/**
 * MODUL 133 | WEBUMFRAGE  
 * 
 * class User
 * User and Sessionmanagement
 * 
 * @author Janina Imberg
 * @version 1.0
 * 
 * ---------------------------------------------------------------- */

class User 
{
	public static $user;
	
	/**
	 * stores various config parameters
	 * @var array $config 
	 */
	private $config = array(
		'salt' => 'wLo1MbsyVM10df90DZ3d2a54p0703lzS'
	);
	
	/**
	 * constructor function - called on init
	 * check if $_POST is set, then
	 * delegate to login, register, logout, survey
	 * @return void
	 */
	public function __construct() 
	{
		session_start();
		if( $_SESSION[ 'username' ] ) {
			self::$user = $this->getCurrentUser();
		}
			
		if( isset( $_POST ) ) {
			if( isset( $_POST[ 'login' ] ) ) {
				$user = trim( htmlentities( $_POST[ 'username' ] ) );
				$pwd = trim( htmlentities( $_POST[ 'pwd' ] ) );
				$this->login( $user, $pwd );
				exit();
			} else if( isset( $_POST[ 'logout' ] ) ) {
				$this->logout();
				exit();
			} else if( isset( $_POST[ 'register' ] ) ) {
				$this->register();
				exit();
			} else if( isset( $_POST[ 'question' ] ) ) {
				$save = $this->saveSurvey();
				echo $save;
				exit();
			}
		}
	}
	
	/**
	 * login process is called when form was submitted
	 * check if all fields where filled in and input is valid
	 * - redirect to index.php if not
	 * - start session and redirect to survey.php if valid
	 * @param string $user
	 * @param string $pwd
	 * @return void
	 */	
	private function login( $user, $pwd ) 
	{
		if( $this->validateData( $user, $pwd ) ) {
			session_start();
			$_SESSION[ 'username' ] = $user; //get username from session
			self::$user = $this->getCurrentUser();
			$response[ 'valid' ] = true;
			echo json_encode( $response );
		} else {
			$_SESSION = array();
			if( isset( $_COOKIE[ session_name() ] ) ) {
			   $cookie_expires  = time() - date('Z') - 3600;
			   setcookie( session_name(), '', $cookie_expires, '/');
			}
			session_destroy(); //just to make sure...
			$response[ 'valid' ] = false;
			$response[ 'msg' ] = "Benutzername oder Passwort falsch.";
			echo json_encode( $response );
		}
	}
	
	/**
	 * evaluate post data of submitted form
	 * check if user already exits
	 * - if not save new user object to file
	 * - then redirect to app / login function
	 * @return void
	 */	
	private function register() 
	{
		$user = trim( htmlentities( $_POST[ 'username-register' ] ) );
		$pwd = trim( htmlentities( $_POST[ 'pwd-register' ] ) );
		$pwdConfirm = trim( htmlentities( $_POST[ 'pwd-register-confirm' ] ) );
		
		$registered = false;
		
		if( $this->notExists( $user ) ) {
			if( $this->passwordMatch( $pwd, $pwdConfirm ) ) {
				$this->createUser( $user, $pwd );
				$registered = true;
			} else {
				$response[ 'valid' ] = false;
				$response[ 'type' ] = 2;
				$response[ 'msg' ] = "Passwörter stimmen nicht überein.";
				echo json_encode( $response );
				exit();
			}
		} else {
			$response[ 'valid' ] = false;
			$response[ 'type' ] = 1;
			$response[ 'msg' ] = "Benutzer existiert bereits.";
			echo json_encode( $response );
			exit();
		}
		
		if( $registered == true ) {
			$this->login( $user, $pwd );
		} 
	}

	/**
	 * logout process
	 * clear session and cookies
	 * redirect to index
	 * @return void
	 */
	private function logout() 
	{
		$_SESSION = array();
		if( isset( $_COOKIE[ session_name() ] ) ) {
		   $cookie_expires  = time() - date('Z') - 3600;
		   setcookie( session_name(), '', $cookie_expires, '/');
		}
		session_destroy();
		exit();
	}

	 /**
	 * checks if user already exists
	 * true if not exists
	 * else false
	 * @param string $user
	 * @return boolean
	 */
	private function notExists( $user = null ) 
	{
		if( $user == null ) { // just to make sure
			return false;
		} else {
			$json = file_get_contents( 'saveUserV1.json' ); //read data from file
			$file = json_decode( $json );
	
			foreach( $file as $data ) {
				if( $data->user == $user ) {
					return false;
				} 
			}
		}
		return true;
	}
	
	/**
	 * check if password & user is matching
	 * @param string $user
	 * @param string $pwd
	 * @return boolean
	 */
	private function validateData( $user = null, $pwd = null ) 
	{
		if( $user == null || $pwd == null ) {
			return false;
		} else {
			$json = file_get_contents( 'saveUserV1.json' ); //read data from file
			$file = json_decode( $json );
	
			foreach( $file as $data ) {
				if( $data->user == $user ) {
					if( $data->pwd == $this->encryptPassword( $pwd ) ) {
						return true;
					}
				} 
			}
		}
		return false;
	}
	
	/**
	 * checks if password matches
	 * true if match
	 * else false
	 * @param string $pwd
	 * @param string $pwdConfirm
	 * @return boolean
	 */
	private function passwordMatch( $pwd, $pwdConfirm ) 
	{
		return $pwd == $pwdConfirm ? true : false;
	}
	
	/**
	 * encrypt n salt password
	 * @param string $pwd
	 * @return string $pwd = encrypted password
	 */
	private function encryptPassword( $pwd ) 
	{
	 	return hash( 'sha512', $pwd . $this->config[ 'salt' ] );
	}
	
	/**
	 * save user data to textfile in json format
	 * @param string $user
	 * @param string $pwd
	 * @return void
	 */
	private function createUser( $user = null, $pwd = null ) 
	{
		if( $user == null || $pwd == null ) {
			return false;
		} else {
			$json = file_get_contents( 'saveUserV1.json' ); // get saved data
			$file = json_decode( $json );
			
			if( empty( $file ) ) {
				$file = array();
			}
			$data = new stdClass();
			$data->user = $user;
			$data->pwd = $this->encryptPassword( $pwd );
			$data->hasParticipated = false;
			
			array_push( $file, $data ); //add user to array
			file_put_contents( 'saveUserV1.json', json_encode( $file ) ); //save new data to file
		}
	}
	
	/**
	 * save results to file
	 * save answers to surveyAnswers
	 * set participated to true
	 * @return $response / success or error message
	 */
	 private function saveSurvey() 
	 {
		$json = file_get_contents( 'surveyAnswersV1.json' );
		$file = json_decode( $json );
		if( empty( $file ) ) {
			$file = array();
		}
	 	if( isset( $_POST ) ) {		
	 		$answers = $_POST;
	 		$data = new stdClass();
			foreach( $answers as $key => $value ) {
				$data->{$key} = $value;
			}  
			array_push( $file, $data ); 
			file_put_contents( 'surveyAnswersV1.json', json_encode( $file ) ); 
			
			$this->setParticipated();
			
			$response[ 'success' ] = true;
			return json_encode( $response );	
	 	} else {
	 		$response[ 'error' ] = "Ein Fehler ist aufgetreten";
			echo json_encode( $response );
	 		return;
	 	}
	 }
	 
	 /**
	 * get current user and set participated to true
	 * loop over user file
	 * find matching entry - copy username and pwd
	 * empty user entry and set a new one with participated true
	 * (somewhat inconvenient) 
	  * @return void
	 */
	 private function setParticipated() 
	 {
	 	$json = file_get_contents( 'saveUserV1.json' );
		$file = json_decode( $json );

		foreach( $file as $key => $value ) {
			if( $value->user == $_SESSION['username'] ) {
				$pwd = $value->pwd;
				$user = $value->user;
				$file[ $key ] = '';
				$item = new stdClass();
				$item->user = $user;
				$item->pwd = $pwd;
				$item->hasParticipated = true;
				array_push( $file, $item );
				file_put_contents( 'saveUserV1.json', json_encode( $file ) ); 
				return;
			}
		}
	 }
	
	/**
	 * get data of current logged in user
	 * @param string $user
	 * @return object $user | false
	 */
	private function getCurrentUser() 
	{
		$json = file_get_contents( 'saveUserV1.json' );
		$file = json_decode( $json );

		foreach( $file as $item ) {
			if( $item->user == $_SESSION['username'] ) {
				$user = new stdClass();
				$user->hasParticipated = $item->hasParticipated;
				$user->username = $item->username;
				return $user;
			}
		}
		return false;
	}
	
	/**
	 * redirect helper function
	 * @param string $page - where user should be redirected
	 * @return string redirect location 
	 */
	private static function redirect( $page ) 
	{
		return header( "Location: $page.php" );
	}	
}

new User();
