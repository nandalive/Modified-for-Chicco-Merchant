 <?php

class KeyStoreOab
{
    function doSimleEncrypt($keyToBeEncrypted, $keyStorePath)
    {
        $hexData = ($keyToBeEncrypted);
        $encData = $this->xor_this($keyToBeEncrypted);
        $myfile = fopen($keyStorePath . "keystore.pooh", "w") or die("Unable to open file!");
        fwrite($myfile, $encData);
        fflush($myfile);
        fclose($myfile);
    }
    function parseKeyStore($keyStorePath)
    {
        $myfile = fopen($keyStorePath . "keystore.pooh", "r") or die("Unable to open file!");
        $decData = $this->xor_this(fread($myfile, filesize($keyStorePath . "keystore.pooh")));
        fclose($myfile);
        return $decData;
    }
    function xor_this($text)
    {
        $key       = "frtkj";
        $i         = 0;
        $encrypted = "";
        foreach (str_split($text) as $char) {
            $encrypted .= chr(ord($char) ^ ord($key[$i++ % strlen($key)]));
        }
        return $encrypted;
    }
    function encryptData($payload, $key)
    {
        $chiper = "des-ede3";
        if ((strlen($payload) % 8) != 0) {
            $payload = $this->rightPadZeros($payload);
        }
		echo openssl_cipher_iv_length($chiper);
        $iv        = openssl_random_pseudo_bytes(1);
        $encrypted = openssl_encrypt($payload, $chiper, $key, OPENSSL_RAW_DATA, $iv);
        $encrypted = unpack("C*", ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        return strtoupper($encrypted);
    }
    function decryptData($data, $key)
    {
        $chiper    = "des-ede3";
        $data      = $this->hex2ByteArray($data);
        $data      = $this->byteArray2String($data);
        $data      = base64_encode($data);
        $iv        = openssl_random_pseudo_bytes(1);
        $decrypted = openssl_decrypt($data, $chiper, $key, OPENSSL_ZERO_PADDING, $iv);
        return $decrypted;
    }
    function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);
        return unpack("C*", $string);
    }
    function byteArray2String($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }
    function pkcs5_pad($message)
    {
        $message_padded = $message;
        if (strlen($message_padded) % 8) {
            $message_padded = str_pad($message_padded, strlen($message_padded) + 8 - strlen($message_padded) % 8, "");
        }
    }
    function rightPadZeros($Str)
    {
        if (null == $Str) {
            return null;
        }
        $PadStr = $Str;
        for ($i = strlen($Str); ($i % 8) != 0; $i++) {
            $PadStr .= "^";
        }
        return $PadStr;
    }
    function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin   = join($chars);
        return bin2hex($bin);
    }
}
?> 