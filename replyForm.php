<?php 
	session_start(); 
	$thisUser = $_SESSION['currentUser'];
?>
<html>
	
<head>
	<link type="text/css" rel="stylesheet" href="replyFormStyle.css" />
	<script src="replyFormValidation.js" type="text/javascript"></script>
	<script src="prototype.js" type="text/javascript"></script>	
</head>

<body>
	
<form action="#" name="replyForm" id="replyForm" method="post">	
	
	<label for="recipient">Reply-To</label>
	<input title="The person you got this mail from" type="text" name="recipient" id="recipient" />
	
	<label for="subject">Subject</label>
	<input title="The subject of your message here." type="text" name="subject" id="subject" />
	
	
	<div id="effectForm"></div>
	
	
	<textarea name="message" id="message" rows="10" cols="24"></textarea>
	
	<input type="button" class="controller" id="replyButton" value="Reply" />
	<input type="reset" class="controller" id="resetButton" value="Clear" />
	
</form>

<div id="validationResults">
	<h3>Validation Status</h3>
	<div id="info"></div>
	
</div>

</body>

</html>
