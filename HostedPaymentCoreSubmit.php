
	<?php 
	
	
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
			$myObj->setResourcePath(trim($resourcePath));
			$myObj->setKeystorePath(trim($resourcePath));
			$myObj->setAlias(trim($aliasName));
			$myObj->setCurrency(trim($currency));
			$myObj->setLanguage(trim($language));
			$myObj->setResponseURL(trim($receiptURL));
			$myObj->setErrorURL(trim($errorURL));

			$myObj->setAction(trim($_POST['action']));
			$myObj->setAmt($_POST['amount']);
			$myObj->setTrackId($_POST['trackId']);
			$myObj->setUdf1($_POST['udf1']);
			$myObj->setUdf2($_POST['udf2']);
			$myObj->setUdf3($_POST['udf3']);
			$myObj->setUdf4($_POST['udf4']);
			$myObj->setUdf5($_POST['udf5']);
			
			if(trim($_POST['tokennumber']) != null && trim($_POST['tokennumber']) != ''){
				$myObj->settokenNumber(trim($_POST['tokennumber']));
				$myObj->settokenFlg('2');
			}
			$result = $myObj->performPaymentInitializationHTTP();
			if(trim($result) == 0) {
				$url=$myObj->getWebAddress();
			} else {
				$url = $myObj->getErrorURL()."?ErrorText=".$myObj->getError();
			}
			
			?>

			<html>	
	<body onload="document.myform.submit();">
		<form action='<?php echo $url ?>' method='GET' name="myform">
			<input type='hidden' name='param' value='paymentInit' />
			<input type='hidden' name='trandata' value='<?php echo $myObj->getTranData() ?>' />
			<input type='hidden' name='tranportalId' value='<?php echo $myObj->getId() ?>' />
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
