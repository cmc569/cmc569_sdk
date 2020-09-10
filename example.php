<?php 
require_once 'vendor/autoload.php';
 
use CMC\DB\Database;
use CMC\LineSDK\LineBotRequest;
use CMC\JWT\Jwt;
use CMC\Encryption\Aes;

$key = 'accuhit';
$str = 'abc123 中文';
$aes = new Aes($key);
$encode = $aes->bencode($str);
echo $encode."\n\n";

$decode = $aes->bdecode($encode);
echo $decode."\n";
/*
$key = 'accuhit123';
$payload = array(
    "iss" => "Accuhit Login Center",
    "iat" => time(),
    "exp" => strtotime('+30min'),
);

$jwt = new Jwt($key);

$encode = $jwt->jwt_encode($payload);
echo $encode."\n";

$decode = $jwt->jwt_decode($encode);
print_r($decode);
*/

/*
$conn = new Database([
    'host'  => 'accu-db.mysql.database.azure.com',
    'user'  => 'aqadmin@accu-db',
    'pass'  => 'AccuHit5008!!',
    'port'  => 3306,
    'db'    => 'disease_ac_test',
]);

$sql = 'SELECT * FROM `clinic` WHERE 1;';
print_r($conn->all($sql));
*/

/*
$bot = new LineBotRequest('1625701889', '8702e9c9bda49b72e439488beff06cbb', 'CnOVw8LuxrK8z6SrfDlNvqCbgKsYT4lMm0tY9w+ATGRzs/7HMlIWHwO0qW2f7qNOeFsudGZ8QsDdXtp/E0UOK3kxYeKaG9fpLxXrNotkPph+FEIFI084SvvTBvgM/D3VsmPhlFhVB9QEuQt4ConeRVGUYhWQfeY8sLGRXgo3xvw=');

$userId = 'U62e7e4ca0ad872f7d38c603757f8fb7f';
$replyToken = '';

$response = array() ;

$response['reply_token'] = $replyToken ;
$response['userId'] = $userId ;

$response['messages'][0]['actionType'] = 'text' ;
$response['messages'][0]['text'] = '你好' ;
$response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

$json_arr = $bot->send($response) ;
print_r($json_arr) ;
*/

?>