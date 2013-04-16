<form id="register-form" method="post" action="#">
	<h1>Webumfrage: Register</h1>
	<p class="no-account"><a href="#" id="to-login">Zum Login!</a></p>
	<span class="form">
		<label for="username">Benutzername: </label>
		<input type="text" value="<?php if( !isset( $_POST ) ) { echo ""; } else { echo $_POST[ 'username-register' ]; } ?>" placeholder="Benutzername" id="username-register" name="username-register" />
		<p class="error-msg">&nbsp;</p>
	</span>
	
    <span class="form">
		<label for="password">Passwort: </label>
		<input type="password" value="<?php if( !isset( $_POST ) ) { echo ""; } else { echo $_POST[ 'pwd-register' ]; } ?>" placeholder="Passwort" id="pwd-register" name="pwd-register" />
		<p class="error-msg">&nbsp;</p>
	</span>
		
    <span class="form">
		<label for="password-confirm">Bestätigen: </label>
		<input type="password" value="<?php if( !isset( $_POST ) ) { echo ""; } else { echo $_POST[ 'pwd-register-confirm' ]; } ?>" placeholder="Passwort bestätigen" id="pwd-register-confirm" name="pwd-register-confirm" />
		<p class="error-msg">&nbsp;</p>
	</span>
	
	<input type="hidden" name="register" value="register" />	
	<input type="submit" value="registrieren" />
</form>    	

<!-- well let's do it the dirty way, once again... -->
<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>