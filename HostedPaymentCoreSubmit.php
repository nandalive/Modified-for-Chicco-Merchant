
	<?php 
	
	
	   include ("../libfiles/iPayOabPipe.php");
		try {

			$currency	= "512";
 			$language	= "ENG";
 			$receiptURL	= "http://localhost/MerchantApp_PHP-main/bankHosted/HostedPaymentResult.php";
 			$errorURL	= "http://localhost/MerchantApp_PHP-main/bankHosted/HostedPaymentResult.php";
			//$resourcePath = "C:\\xampp\\htdocs\\oabPhpPlain_7x\\cgnFiles\\sha\\";
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

		    $myObj->setAction(trim($_POST['action'] ?? null));
			$myObj->setAmt($_POST['amount'] ?? null);
			$myObj->setTrackId($_POST['trackId'] ?? null);
			$myObj->setUdf1($_POST['udf1'] ?? null);
			$myObj->setUdf2($_POST['udf2'] ?? null);
			$myObj->setUdf3($_POST['udf3'] ?? null);
			$myObj->setUdf4($_POST['udf4'] ?? null);
			$myObj->setUdf5($_POST['udf5'] ?? null);
			
			if(trim($_POST['tokennumber'] ?? null) != null && trim($_POST['tokennumber'] ?? null) != ''){
				$myObj->settokenNumber(trim($_POST['tokennumber'] ?? null));
				$myObj->settokenFlg('2');
			}
			$result = $myObj->performPaymentInitializationHTTP();
			if(trim($result) == 0) {
				$url=$myObj->getWebAddress();
			} else {
				$url = $myObj->getErrorURL()."?ErrorText=".$myObj->getError();
			}
			//echo $url;
            //die;			
			header( 'Location:'.$url ) ;
		} catch(Exception $e) {
			echo 'Message: ' .$e->getFile();
	  		echo 'Message1 : ' .$e->getCode();
		}
		
	?>
	
