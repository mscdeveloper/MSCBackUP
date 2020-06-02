<?php

if(!function_exists('hash_equals')) {
  function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
    }
  }
}



function encrypt($plaintext, $password) {
    $method = "AES-256-CBC";
    $key = hash('sha256', $password, true);
    $iv = openssl_random_pseudo_bytes(16);

    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

    $result = $iv . $hash . $ciphertext;
    $result = base64_encode($result);
    $result = substr($result, 0, -2);
    return $result;
}

function decrypt($ivHashCiphertext, $password) {	$ivHashCiphertext = $ivHashCiphertext . '==';	$ivHashCiphertext = base64_decode($ivHashCiphertext);

    $method = "AES-256-CBC";
    $iv = substr($ivHashCiphertext, 0, 16);
    $hash = substr($ivHashCiphertext, 16, 32);
    $ciphertext = substr($ivHashCiphertext, 48);
    $key = hash('sha256', $password, true);

    if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}

function encrypton_valid($plaintext, $ivHashCiphertext, $password){	$new_plain = decrypt($ivHashCiphertext, $password);
	if($new_plain === $plaintext){		return true;
	}else{		return false;
	}
}


?>