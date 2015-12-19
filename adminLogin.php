<html>
<head>
	<title>CheapoMail | ~Admininistrator * Login * System~</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	

	
	<script src="//www.cs.washington.edu/education/courses/cse190m/09sp/prototype.js" type="text/javascript"></script>



	<script>
			
			 //Create AJAX Browser for VALIDATION MESSAGES
		 function getValidationMessage(a,b)
		 {
			var xmlhttp;
			if (window.XMLHttpRequest)
			{
			    // code for IE7+, Firefox, Chrome, Opera & Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{
			    // code for IE6 & IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			   
			xmlhttp.onreadystatechange=function()
			{
			    	if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    	{
					$("errorMessages").innerHTML=xmlhttp.responseText;
				}
			};
			   
			xmlhttp.open("GET","http://localhost/cmail/adminLoginValidation.php?userName=" + a + "&passWord=" + b,true);
			xmlhttp.send();
		   
		 }  
		  
		 $('submitButton').onclick = function()
		 {
		 	getValidationMessage($('userName').value,$('password').value);
		 };
		 
		 
		 //Create AJAX Browser for Composing messages
		 function goToLogin()
		 {
		 	var loginBrowser;
		  	if(window.XMLHttpRequest)
		  	{
		   // IE7+, Firefox, Chrome, Opera & Safari
		    		loginBrowser=new XMLHttpRequest();
		  	}
		  	else
		  	{
		   // IE6 & IE5 
		    		loginBrowser=new ActiveXObject("Microsoft.XMLHTTP");
		  	}
		  
		  	loginBrowser.onreadystatechange=function()
		  	{
		    		if (loginBrowser.readyState==4 && loginBrowser.status==200)
		    		{
		     			document.body.innerHTML=loginBrowser.responseText;
		    		}
		   	};
		   
		   	loginBrowser.open("GET",window.location.href = "http://localhost/cmail/login.php",true);
		   	loginBrowser.send();  
		  
		 };
		 
		 document.getElementById('backButton').onclick = function()
		 {
		 	goToLogin();
		 };
		 
	 </script>
 </head>


<body>
	
	<!--START HTML PAGE WITH MAIN ELEMENTS-->
	<div id="header">
		Welcome to Cheapo Mail
	</div>
	
	<div id = "navMenu">
		<ul>
			<li id="backButton"><a href="#">Back</a></li>
		</ul>
	</div>
	
	<div id="contents">		
		<div id="instructions">			
			<span>Administrator Login</span>
		</div>
		
		<form action="adminLogin.php" name="loginForm" id="loginForm" method="post">
			<label for="userName">Username:</label>
			<input title="Enter your username please" type="text" name="userName" id="userName" />
			
			<label for="password">Password:</label>
			<input title = "Enter your password please" type="password" name="passWord" id="password" />
			
			<input type="submit" class="controller" id="submitButton" value="Login"/>
			<input type="reset" class="controller" id="resetButton" value="Clear"/>
			
		</form>
	</div>
	<!--END HTML PAGE WITH MAIN ELEMENTS-->	
	
	<!--START PHP ~ USING INCLUDES STATEMENT-->	
	<?php
		include 'setupDatabase.php';
	?>
	
	<?php
	// To prevent sending of incorrect data to the database
		$userName = $_POST["userName"];
		$password = $_POST["passWord"];
		
		$admin1 = "vwainne";
		$admin2 = "scampbell";
		
		$validationStatus = "";
	?>
	
	<?php
	// Start check if username matches existing admin staff credentials
	$findAdminStatus = "";
		if($userName == $admin1 || $userName == $admin2)
		{
			$isAdmin = TRUE;
		}
		
		if($userName == $admin1)
		{
			$userName = $admin1;
		}
		elseif ($userName == $admin2) 
		{
			$userName = $admin2;
		}
		else
		{
			$isAdmin = FALSE;
			$findAdminStatus = "<br/><li class='status' id='error'>user information entered is not an administrator</li>";
		}
	// End check if username matches admin staff credentials
	?>
	
	
	<?php
	// test data entered	
		if($userName != "" && $password != "")
		{
			$notEmpty = TRUE;
			$emptyStatus = "";
		}
		else
		{
			$emptyStatus = "<br/><li class='status' id='error'>You should have no empty feilds.</li>";
		}
	?>
	
	<?php
	// Just to test if user matches any in database		
	$con = mysqli_connect("localhost","mailInfo2180","administrator","MailingSystem");
	

	// Verify connection to MySql
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to MySql: " . mysqli_connect_error();
	}
	
	

	// get user check
	$resultUsers = mysqli_query($con, "SELECT * FROM User Where Username = '$userName'");
	
	
	$names = mysqli_fetch_array($resultUsers);
	
	if($names != "")
	{
		$userCheck = TRUE;	
	}
	

	// password exists check	
	$resultPasswords = mysqli_query($con, "SELECT Password FROM User Where Username = '$userName'");		
	
	$userPassword = mysqli_fetch_array($resultPasswords);
	
	if($userPassword != "")
	{
		$passwordExistsCheck = TRUE;
	}
	


	// Start password-user verification
	$resultUserForPassword = mysqli_query($con, "SELECT Username FROM User Where Password = '$password'");
	
	$userPassCheck = mysqli_fetch_array($resultUserForPassword);
	
	if($userPassCheck !="")
	{
		$userPasswordMatch = TRUE;
	}
	// End password-user verification
	


	// Start username and password validation 
	if(!($passwordExistsCheck && $userPasswordMatch))
	{
		$feildsCorrespondStatus = "<br/><li class='status' id='error'>Invalid username or password.</li>";
	}else
	{
		$feildsCorrespondStatus = "";
	}
	
	$validationStatus = $emptyStatus.$findAdminStatus.$feildsCorrespondStatus;
	
	if($userCheck && $isAdmin && $passwordExistsCheck && $userPasswordMatch && $notEmpty)
	{
		echo "<br><p class='status' id='successful'>entry successful. Everything matches</p>";
		header("Location: signup.php");
			
	}
	else
	{
		echo "<br><p class='status' id='error'>Error(s):<br/> </p>";
		echo $validationStatus;
	}
	// End username and password validation

	?>
	<!--END PHP-->	
</body>
</html>