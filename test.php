<meta http-equiv="refresh" content="5">
<?php
$username = 'admin';
$password = '1234';
$host = '192.168.1.41';

$socket = @fsockopen($host,"5038");

fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$username."\r\n");
fputs($socket, "Secret: ".$password."\r\n\r\n");

fputs($socket,"Action: Command\r\n");
fputs($socket,"Command: sip show peers\r\n\r\n");

fputs($socket, "Action: Logoff\r\n\r\n");

$wrets = 'begin';
while(trim($wrets) != '--END COMMAND--'){
	$wrets=trim(fgets($socket));
	//echo $wrets."<br>";

	
	if(strpos($wrets,'Unspecified') !== false){
		$allume = '<p style="background-color:red;color:white">';
	}else{
		$allume = '<p style="background-color:green;color:white">';	
	}
	if(strpos($wrets,'(No)')){
		$tmp = explode('/',$wrets);
		$tmp2 = explode(' ',$tmp[1]);
		echo($allume."Telephone : ".$tmp2[0]. "</p>");
	}
	
}

fclose($socket);
?> 