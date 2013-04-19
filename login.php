<form id="login-form" method="post" action="#">
	<h1>Login</h1>
	<p class="no-account">Kein Account? <a href="#" id="register">Registriere Dich!</a></p>
	<span class="form">
		<label for="username">Benutzername: </label>
		<input type="text" value="<?php if( !isset( $_POST ) ) { echo ""; } else { echo $_POST[ 'username' ]; } ?>" placeholder="Benutzername" id="username" name="username" />
		<p class="error-msg">&nbsp;</p>
	</span>
	
    <span class="form">
		<label for="username">Passwort: </label>
		<input type="password" value="<?php if( !isset( $_POST ) ) { echo ""; } else { echo $_POST[ 'pwd' ]; } ?>" placeholder="Passwort" id="pwd" name="pwd" />
		<p class="error-msg">&nbsp;</p>
	</span>
	
	<input type="hidden" name="login" value="login" />	
	<input type="submit" value="einloggen" />
</form> 

<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>