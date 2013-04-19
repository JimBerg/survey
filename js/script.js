(function( $ ) {
	/** fetch n cache dom elems **/
	var $form = $( '#login-form' );
	var $registerform = $( '#register-form' );
	var $fields = $( 'input[type="text"], input[type="password"]' );
	
	/** placeholder values for input fields */
	var placeholder = function( name ) {
		if( name == 'username' || name == 'username-register' ) {
			return 'Benutzername';
		} else if ( name =='pwd' | name == 'pwd-register' ) {
			return 'Passwort';	
		} else if ( name == 'pwd-register-confirm' ) {
			return 'Passwort bestätigen';
		}
	};
	
	/**
	 * submit and process form if values 
	 * - are not empty
	 * - valid data was passed
	 * else show error messages
	 */
	var submitForm = function( form ) {
		$.ajax({
			type: 'POST',
		  	url: 'user.php',
		  	data: form.serialize(),
		  	success: function( response ) {
		  		if( response !== 'undefined' && response !== null ) {
		  			if ( response.valid === true ) {
		  				window.location.href = "survey.php";
			  		} else {
			  			if( response.type == 1 ) {
			  				$( form ).find( '.error-msg:first' ).prev( 'input' ).addClass( 'error' );
			  				$( form ).find( '.error-msg:first' ).html( ''+response.msg+'' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );
			  			} else if( response.type == 2 ) {
			  				$( form ).find( '.error-msg:not(:first)' ).prev( 'input' ).addClass( 'error' );
			  				$( form ).find( '.error-msg:not(:first)' ).html( ''+response.msg+'' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );
			  			} else {
			  				$( form ).find( '.error-msg' ).prev( 'input' ).addClass( 'error' );
			  				$( form ).find( '.error-msg' ).html( ''+response.msg+'' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );	
			  			}
			  		}
		  		} else {
		  			$( '<p class="error-msg">Huch, hier ging was schief!</p>').appendTo( $form );
		  		}
		 	},
		 	dataType: 'json'
		});	
		return false;
	}

	/**
	 * logout -> request -> destroy session
	 * on success redirect to index
	 */
	$( '#logout' ).on( 'click', function( event ) { 
		$.ajax({
			type: 'POST',
		  	url: 'user.php',
		  	async: 'false',
		  	data: { 'logout': 'logout' },
		  	success: function( response ) {
		  		window.location.href = "index.php";
		 	},
		});	
		event.preventDefault();
		return false;
	});
	
	/** 
	 * remove placeholder on focus 
	 * add placeholder on blur if input is empty
	 */
	$.each( $fields, function() {
		$( this ).live( 'focus', function() {
			$( this ).attr( 'placeholder', '' );
			$( this ).removeClass( 'error' );
			$( this ).next( '.error-msg' ).html( '' );
		});
		
		$( this ).live( 'blur', function() {
			if( $.trim( $( this ).val() ) == '' ) {
				var name = $( this ).attr( 'name' );
				$( this ).attr( 'placeholder', placeholder( name ) );
			}
		});
	});

	/** 
	 * delegate submit to js function
	 **/
	$( $form ).on( 'submit', function( event ) {
		var user = $( 'input[name="username"]' );
		var pwd = $( 'input[name="pwd"]' );
		var valid = true;

		if( $( '.error' ).length > 0 ) {
			$( '.error-msg' ).text( '' ).animate( { 'opacity': '0' }, 300, 'swing', function() {} );
		}
		
		if( $.trim( user.val() ) == '' ) {
			valid = false;
			$( user ).addClass( 'error' );
			$( user ).next( '.error-msg' ).html( 'Bitte Benutzername angeben.').animate( { 'opacity': '1' }, 300, 'swing', function() {} );
		}
		if( $.trim( pwd.val() ) == '' ) {
			valid = false;
			$( pwd ).addClass( 'error' );
			$( pwd ).next( '.error-msg' ).html( 'Bitte Passwort angeben.' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );
		}
		
		if( valid == true ) {
			submitForm( $form );
		}
		event.preventDefault();
	});
	
	/** 
	 * delegate register submit to js function
	 **/
	$( $registerform ).on( 'submit', function( event ) {
		var user = $( 'input[name="username-register"]' );
		var pwd = $( 'input[name="pwd-register"]' );
		var valid = true;
		
		if( $( '.error' ).length > 0 ) {
			$( '.error-msg' ).text( '' ).animate( { 'opacity': '0' }, 300, 'swing', function() {} );
		}
		
		if( $.trim( user.val() ) == '' ) {
			valid = false;
			$( user ).addClass( 'error' );
			$( user ).next( '.error-msg' ).html( 'Bitte Benutzername angeben.' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );
		}
		if( $.trim( pwd.val() ) == '' ) {
			valid = false;
			$( pwd ).addClass( 'error' );
			$( pwd ).next( '.error-msg' ).html( 'Bitte Passwort angeben.' ).animate( { 'opacity': '1' }, 300, 'swing', function() {} );
		}
		
		if( valid == true ) {
			submitForm( $registerform );
		}
		event.preventDefault();
	});
	
	/**
	 * load results page
	 */	
	$( '#results' ).on( 'click', function( event ) { 
		$( this ).parent( 'li' ).siblings().find( 'a' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		$( '#container' ).load( 'evaluation.php' );
		event.preventDefault();
		return false;
	});
	
	/**
	 * load survey page
	 */
	$( '#survey' ).on( 'click', function( event ) { 
		$( this ).parent( 'li' ).siblings().find( 'a' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		$( '#container' ).load( 'questions.php' );
		event.preventDefault();
		return false;
	});
	
	/**
	 * load register form
	 */
	$( '#register' ).live( 'click', function( event ) { 
		$( '#content' ).load( 'register.php' );
		event.preventDefault();
		return false;
	});
	
	/**
	 * load login form
	 */
	$( '#to-login' ).live( 'click', function( event ) { 
		$( '#content' ).load( 'login.php' );
		event.preventDefault();
		return false;
	});
	
	
	/**
	 * submit question form if validation succeeded
	 * return success message an print on site
	 */
	function submitSurveyForm( form ) {
		var data = form.serialize();
		$.ajax({
			type: 'POST',
		  	url: 'user.php',
		  	data: data,
		  	async: 'false',
		  	success: function( response ) {
		  		if ( response.success == true ) {
		  			$( '#container' ).html('<h2>Vielen Dank für deine Teilnahme!</h2>');
	  				return;
		  		}
		 	},
		 	dataType: 'json'
		});	
	}
	
	/**
	 * delegate question form to js
	 */
	$( '#question-form' ).on( 'submit', function( event ) {
		
		  		
		  		//{"msg":{"cat2_question1":"1","cat2_question3":"3","cat3_question1":"2","question":"question"}} 
		  		//var test = $( '#question-form' ).find( 'input[type="radio"]:checked' ).css( { 'background': 'red'} );
		  		//console.log(test);
		//if( valid == true ) {
			submitSurveyForm( $( this ) );
		//}
		event.preventDefault();	
		return false;
	});
	
})( jQuery );
