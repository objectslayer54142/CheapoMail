window.onload = function(){
	//Declare Variables
	var replyButton = document.getElementById("replyButton");
	
	//Create AJAX Browser for replying to messages
	function goToReply(){
		var myBrowser;
		if(window.XMLHttpRequest){
			// IE7+, Firefox, Chrome, Opera & Safari
		 	myBrowser=new XMLHttpRequest();
		}else{
			// cIE6 & IE5
		 	myBrowser=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		myBrowser.onreadystatechange=function(){
		 	if (myBrowser.readyState==4 && myBrowser.status==200){
		 		document.body.innerHTML=myBrowser.responseText;
		 	}
		 };
		 
		 myBrowser.open("GET","http://localhost/cmail/reply.php",true);
		 myBrowser.send();		
		
	}
	
	replyButton.onclick = function(){
		goToReply();
	};
	
};
