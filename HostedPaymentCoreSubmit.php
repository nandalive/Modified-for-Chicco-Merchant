
	<?php 
	//Updated for chio 10apr23
	
	   include ("../libfiles/iPayOabPipe.php");
	   $url= '';
		try {

			$currency	= "512";
 			$language	= "ENG";
 			$receiptURL	= "http://localhost/MerchantApp_PHP-main/bankHosted/HostedPaymentResult.php";
 			$errorURL	= "http://localhost/MerchantApp_PHP-main/bankHosted/HostedPaymentResult.php";
			$resourcePath = "D:\\Softwares\\PHP\\htdocs\\MerchantApp_PHP-main\\cgnFiles\CGN\\";
			$aliasName = "nandos";
			$myObj = new iPayOabPipe();
			$myObj->setresourcePath(trim($resourcePath));
			$myObj->setkeystorePath(trim($resourcePath));
			$myObj->setalias(trim($aliasName));
			$myObj->setcurrency(trim($currency));
			$myObj->setlanguage(trim($language));
			$myObj->setresponseURL(trim($receiptURL));
			$myObj->seterrorURL(trim($errorURL));

			$myObj->setaction(trim($_POST['action']));
			$myObj->setamt($_POST['amount']);
			$myObj->settrackId($_POST['trackId']);
			$myObj->setudf1($_POST['udf1']);
			$myObj->setudf2($_POST['udf2']);
			$myObj->setudf3($_POST['udf3']);
			$myObj->setudf4($_POST['udf4']);
			$myObj->setudf5($_POST['udf5']);
			
			if(trim($_POST['tokennumber']) != null && trim($_POST['tokennumber']) != ''){
				$myObj->settokenNumber(trim($_POST['tokennumber']));
				$myObj->settokenFlg('2');
			}
			$result = $myObj->performPaymentInitializationHTTP();
			if(trim($result) == 0) {
				$url=$myObj->getwebAddress();
			} else {
				$url = $myObj->geterrorURL()."?ErrorText=".$myObj->getError();
			}
			
			?>

			<html>	
	<body onload="document.myform.submit();">
		<form action='<?php echo $url ?>' method='GET' name="myform">
			<input type='hidden' name='param' value='paymentInit' />
			<input type='hidden' name='trandata' value='<?php echo $myObj->getTranData() ?>' />
			<input type='hidden' name='tranportalId' value='<?php echo $myObj->getid() ?>' />
			<input type='hidden' name='errorURL' value='<?php echo $myObj->geterrorURL() ?>' />
			<input type='hidden' name='responseURL' value='<?php echo $myObj->getresponseURL() ?>' />
		</form>
	</body>
</html>
<?php 
		} catch(Exception $e) {
			echo 'Message: ' .$e->getFile();
	  		echo 'Message1 : ' .$e->getCode();
		}
		
	?>
