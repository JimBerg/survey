<?php

class User 
{
	public $user;
	private $config = array(
		'salt' => 'wLo1MbsyVM10df90DZ3d2a54p0703lzS'
	);
	
	
	/**
	 * check if $_POST is set,
	 * delegate to login or logout
	 * cheating if no post is set ;)
	 */
	public function __construct() 
	{
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
			}
		} else {
			//self::redirect( 'index' );
		}
	}
	
	/**
	 * login process is called when form data is send
	 * check if all fields where filled in and input is valid
	 * - redirect to index.php if not
	 * - start session and redirect to survey.php if valid
	 */	
	private function login( $user, $pwd ) 
	{
		if( $this->validateData( $user, $pwd ) ) {
			session_start();
			$_SESSION[ 'username' ] = $user;
			$this->user = $this->getCurrentUser( $_SESSION[ 'username' ] );
			$_SESSION[ 'data' ] = $this->user;
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
	 * clear session
	 * logout process
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
	 * check 
	 */	
	private function register() 
	{
		$user = trim( htmlentities( $_POST[ 'username-register' ] ) );
		$pwd = trim( htmlentities( $_POST[ 'pwd-register' ] ) );
		$pwdConfirm = trim( htmlentities( $_POST[ 'pwd-register-confirm' ] ) );
		
		$registered = false;
		
		if( $this->notExists( $user ) ) {
			if( $this->passwordMatch( $pwd, $pwdConfirm ) ) {
				$this->saveData( $user, $pwd );
				$registered = true;
			}
		} 
		
		if( $registered == true ) {
			$this->login( $user, $pwd );
		} else {
			//some error message
		}
	}
	
	/**
	 * checks if user already exists
	 * @return true | false
	 */
	private function notExists( $user = null ) 
	{
		if( $user == null ) {
			return false;
		} else {
			//read data from file
			$json = file_get_contents( 'saveUser.json' );
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
	 * checks if password matches
	 * @return true | false
	 */
	private function passwordMatch( $pwd, $pwdConfirm ) 
	{
		return $pwd == $pwdConfirm ? true : false;
	}
	
	/**
	 * check if password & user is matching
	 * @param $user
	 * @param $pwd
	 * @return true | false
	 */
	private function validateData( $user = null, $pwd = null ) 
	{
		if( $user == null || $pwd == null ) {
			return false;
		} else {
			//read data from file
			$json = file_get_contents( 'saveUser.json' );
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
	 * get data of current logged in user
	 * @param $user from session
	 * @return $userdata | false
	 */
	private function getCurrentUser( $user ) 
	{
		$json = file_get_contents( 'saveUser.json' );
		$file = json_decode( $json );

		foreach( $file as $data ) {
			if( $data->user == $user ) {
				return $data->survey;
			}
		}
		return false;
	}

	
	/**
	 * save user data to textfile in json format
	 * @param $user, $pwd
	 * @return false | true
	 */
	private function saveData( $user = null, $pwd = null ) 
	{
		if( $user == null || $pwd == null ) {
			return false;
		} else {
			// get saved data
			$json = file_get_contents( 'saveUser.json' );
			$file = json_decode( $json );
			
			// if user not exist, add new user obj
			$data = new stdClass();
			$data->user = $user;
			$data->pwd = $this->encryptPassword( $pwd );
			
			$survey = new stdClass();
			$survey->hasParticipated = false;
			$survey->hasParticipated = false;
			for( $i = 1; $i <= 5; $i++ ) {
				$survey->{"question_".$i} = null;
			}
			$data->survey = $survey; //json_encode( $survey );
		
			array_push( $file, $data ); //add user to array
			file_put_contents( 'saveUser.json', json_encode( $file ) ); //save new data to file
		
			//return true;
		}
	}
	
	/**
	 * encrypt n salt password
	 * @return encrypted password
	 */
	private function encryptPassword( $pwd ) 
	{
	 	return hash( 'sha512', $pwd . $this->config[ 'salt' ] );
	}
	
	/**
	 * checks if current user has already taken the survey
	 * if true, only show evaluation / user may not take survey twice
	 * @return true | false
	 */
	private function hasParticipated()
	{
	 	
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
