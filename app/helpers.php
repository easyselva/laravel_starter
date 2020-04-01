<?php

if (!function_exists('classActivePath')) {
  function classActivePath($path)
  {
    return Request::is($path) ? ' active' : '';
  }
}

if (!function_exists('pathcheck')) {
  function pathcheck($path)
  {
    return Request::is($path) ? true : false;
  }
}



if (!function_exists('classActiveRoute')) {
  function classActiveRoute($route_name)
  {
    return Route::current()->getName()==$route_name ? ' active' : '';
  }
}





if (!function_exists('classActiveSegment')) {
  function classActiveSegment($segment, $value)
  {
    if (!is_array($value)) {
      return Request::segment($segment) == $value ? ' active' : '';
    }
    foreach ($value as $v) {
      if (Request::segment($segment) == $v) {
        return ' active';
      }
    }
    return '';
  }
}

if (!function_exists('classOpenPath')) {
  function classOpenPath($path)
  {
    return Request::is($path) ? ' menu-open show' : '';
  }
}

if (!function_exists('classOpenRoute')) {
    function classOpenRoute($route_name)
    {
      return Route::current()->getName()==$route_name ? ' menu-open show' : '';
    }
  }


if (!function_exists('classOpenSegment')) {
  function classOpenSegment($segment, $value)
  {
    if (!is_array($value)) {
      return Request::segment($segment) == $value ? ' menu-open show' : '';
    }
    foreach ($value as $v) {
      if (Request::segment($segment) == $v) {
        return ' active';
      }
    }
    return '';
  }
}



if (!function_exists('formatDate')) {
  function formatDate($date)
  {
    return \Carbon\Carbon::parse($date)->format(config('app.locale') != 'en' ? 'd/m/Y H:i:s' : 'm/d/Y H:i:s');
  }
}

if (!function_exists('viewDate')) {
  function viewDate($date)
  {
    return \Carbon\Carbon::parse($date)->format(config('app.locale') != 'en' ? 'd/m/Y' : 'd/m/Y');
  }
}

if (!function_exists('viewDatewithTime')) {
  function viewDatewithTime($date)
  {
    return \Carbon\Carbon::parse($date)->format(config('app.locale') != 'en' ? 'd/m/Y h:i A' : 'd/m/Y h:i A');
  }
}

if (!function_exists('viewDateHuman')) {
  function viewDateHuman($date)
  {
    return \Carbon\Carbon::parse($date)->diffForHumans();;
  }
}

if (!function_exists('viewTime')) {
    function viewTime($time)
    {
      return \Carbon\Carbon::parse($time)->format('h:i A');
    }
  }




function MapColumns($data,$key,$value)
{
  $map=array();

  foreach( $data AS $d )
  {
    $map[$d->{$key}]=$d->{$value};
  }
  $map=(object)$map;
  return $map;
}





function image_helper($filename, $version) {
  try {
    $path_parts = pathinfo($filename);
    $dir=$path_parts['dirname'];
    $base=$path_parts['basename'];
    if (!file_exists(public_path().'/'.$dir.'/'.$version . '/' . $base)) {
      create_image_version($filename,$dir,$base, $version);
    }
    return $dir.'/'.$version . '/' . $base;
  }catch(Exception $e)
  {
    return $filename.$e->getMessage();
  }
}

function create_image_version($filename,$dir,$base, $version) {
  if($version=="lazy"){
    if( ! \File::isDirectory($dir.'/lazy') ) {
      \File::makeDirectory($dir.'/lazy', 493, true);
    }
    $img = Image::make($filename)->fit(30, 20)->save($dir.'/'.$version . '/' . $base);
  }
  elseif($version=="thumb"){
    if( ! \File::isDirectory($dir.'/thumb') ) {
      \File::makeDirectory($dir.'/thumb', 493, true);
    }
    $img = Image::make($filename)->fit(150, 150)->save($dir.'/'.$version . '/' . $base);
  }

  elseif($version=="medium"){
    if( ! \File::isDirectory($dir.'/medium') ) {
      \File::makeDirectory($dir.'/medium', 493, true);
    }
    $img = Image::make($filename)->fit(300, 200)->save($dir.'/'.$version . '/' . $base);

  }
  else{
    if( ! \File::isDirectory($dir.'/full') ) {
      \File::makeDirectory($dir.'/full', 493, true);
    }
    $img = Image::make($filename)->resize(1000,1000, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    })->save($dir.'/'.$version . '/' . $base);
  }
}





function generateToken($encryption_key,$encryption_iv,$sign_key,$merchant_id,$merchant_sub_id,$token_generation_url,$totalamt,$feetype,$merchantreplyurl)
{
			$paymentObject = new stdClass;
			$paymentObject->merchantid = $merchant_id;
			$paymentObject->merchantsubid = $merchant_sub_id;
			$paymentObject->feetype = $feetype;
			$paymentObject->totalamt = $totalamt;
			$paymentObject->replyurl = $merchantreplyurl;
			
			$paymentObject->action = 'GENTOK';
			$data_string = json_encode($paymentObject);
			$data_string = pkcs5_pad($data_string,16);
			
       logmessages("gentok data string before encryption : ".$data_string);

//$paymentData = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $encryption_key,$data_string, MCRYPT_MODE_CBC, $encryption_iv));
      $paymentData = base64_encode(openssl_encrypt ( $data_string , 'AES-256-CBC' , $encryption_key , OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $encryption_iv));//php 7.1 and above
			$paymentTokenObj = new stdClass;
			$paymentTokenObj->merchantid = $merchant_id;
			$paymentTokenObj->merchantsubid = $merchant_sub_id;
			$paymentTokenObj->action = 'GENTOK';
			$paymentTokenObj->data = $paymentData;
			$hmac = strtoupper(hash_hmac('sha256', $paymentData, $sign_key));
			$paymentTokenObj->hmac = $hmac;

			$paymentTokenString = json_encode($paymentTokenObj);
      logmessages(" Invoking token generation service with json : ".$paymentTokenString);
			$ch = curl_init($token_generation_url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $paymentTokenString);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($paymentTokenString))
			);
			curl_setopt($ch,CURLOPT_FAILONERROR,true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout in seconds		
			curl_setopt ($ch, CURLOPT_SSLVERSION, 6); //TLS 1.2

curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

			$result = curl_exec($ch);
			if(curl_error($ch))
			{
				$curl_errno= curl_errno($ch);
				logmessages(" curl error : ".curl_error($ch)." errorno :".$curl_errno);
			}
			else
			{
				logmessages(" response from token generation service : ".$result);
				$decodedVal = json_decode($result);
				$retData = $decodedVal->data;
				//$res = pkcs5_unpad(mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$encryption_key,base64_decode($retData), MCRYPT_MODE_CBC, $encryption_iv));
        $res = pkcs5_unpad(openssl_decrypt ( base64_decode($retData) , 'AES-256-CBC' , $encryption_key ,OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $encryption_iv)); //php 7.1 and above

				logmessages(" token generation service response after decryption: ".$res);

				$decodedData = json_decode($res);
				return $decodedData;
			}
}

function initiateTxn($encryption_key,$encryption_iv,$sign_key,$merchant_id,$merchant_sub_id,$txn_initiation_url,$tokenId,$merchanttxnid,$udf1,$udf2,$udf3,$totalamt,$feetype)
{
				$txninitObject = new stdClass;
				$txninitObject->merchantid = $merchant_id;
				$txninitObject->merchantsubid = $merchant_sub_id;
				$txninitObject->feetype = $feetype;
				$txninitObject->totalamt = $totalamt;
				$txninitObject->action = 'TXNINIT';
				$txninitObject->tokenid = $tokenId;
				$txninitObject->merchanttxnid = $merchanttxnid; 
				$txninitObject->udf1 = $udf1; 
				$txninitObject->udf2 = $udf2; 
				$txninitObject->udf3 = $udf3; 

				$txninitdata_string = json_encode($txninitObject);
				$txninitdata_string = pkcs5_pad($txninitdata_string,16);

				logmessages("txninit data String before encryption : ".$txninitdata_string);

				//$txninitData = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $encryption_key,$txninitdata_string, MCRYPT_MODE_CBC, $encryption_iv));
        $txninitData = base64_encode(openssl_encrypt ( $txninitdata_string , 'AES-256-CBC' , $encryption_key , OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $encryption_iv));//php 7.1 and above
				$txninitfinalobj = new stdClass;
				$txninitfinalobj->merchantid = $merchant_id;
				$txninitfinalobj->merchantsubid = $merchant_sub_id;
				$txninitfinalobj->action = 'TXNINIT';
				$txninitfinalobj->data = $txninitData;
				$hmac = strtoupper(hash_hmac('sha256', $txninitData, $sign_key));
				$txninitfinalobj->hmac = $hmac;

				$txninitfinalString = json_encode($txninitfinalobj);
				logmessages(" txninit final json  : ".$txninitfinalString);
				$txninitfinalString = str_replace("\"", "&quot;", $txninitfinalString); //to convery double quotes to &quot; before form submission
				return $txninitfinalString;
				//pass this txninitfinalString as reqjson parameter from browser using POST method form submission to IOBPAY txninit url

}

function logmessages($msg)
{
		error_log("\n".(new DateTime())->format("d:m:y h:i:s")." ".$msg,0);
}

function pkcs5_pad ($text, $blocksize) 
{ 
    $pad = $blocksize - (strlen($text) % $blocksize); 
    return $text . str_repeat(chr($pad), $pad); 
} 

function pkcs5_unpad($text) 
{ 
    $pad = ord($text{strlen($text)-1}); 
    if ($pad > strlen($text)) return false; 
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false; 
    return substr($text, 0, -1 * $pad); 
}




