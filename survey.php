<?php session_start(); ?> 
<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <title>Webumfrage</title>
        <meta name="description" content="webumfrage">
        <meta name="author" content="janina imberg">
        <meta name="viewport" content="width=device-width">
		
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
        <link rel="stylesheet" href="css/styles.css">
    </head>
    
    <body>
    	<?php if( isset( $_SESSION['username'] ) ): ?> 
    	<?php $user = $_SESSION['data']; ?>
		<div id="header">
			<h1>Umfrage</h1>
			<span class="right small">Willkommen, <?php echo $_SESSION['username']; ?></span>
			<ul id="main-nav">
				<li><a href="#" id="survey" class="active">Umfrage</a></li>
				<li><a href="#" id="results">Ergebnisse</a></li>
				<li class="right"><a href="#" id="logout">Logout</a></li>
			</ul>
		</div>
	    <div id="container">
	    	<?php 
	    		if( $user->hasParticipated == false ) {
	    			include_once 'questions.php';
				} else {
					echo "Du hast schon teilgenommen.";
				}
			?>
	    </div>
		<?php else: ?>
			<?php header( "Location: index.php" ); ?>
		<?php endif; ?>

		
		<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
    </body>
</html>