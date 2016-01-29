<?php
require_once( "jwt.php" );

$uid = isset($_GET[ 'uid' ])? $_GET[ 'uid' ] : '0';

$key    = '611fcf0aea964faea1b3d7fcba16d685';
$secret = '4cf33218-dd66-42a5-b06b-36939da3ec6a';
$now    = @date(DateTime::ISO8601).'Z';
$ttl    = 86400;

$jwt = new JWT();

$token  = $jwt->encode(
	['consumerKey'=> $key , 
         'userId'     => $uid ,
	 'issuedAt'   => $now , 
         'ttl'        => $ttl ], $secret );

echo $token;
?>
