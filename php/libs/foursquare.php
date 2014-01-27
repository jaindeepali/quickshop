<?php
require_once 'vendor/autoload.php';

use Jcroll\FoursquareApiClient\Client\FoursquareClient;

$client = FoursquareClient::factory(array(
    'client_id'     => 'G1GAYQ2UD113CNWKCVN4HEVFQF5TY1CLS4OJA4CCIJM43F10',    // required
    'client_secret' => 'D1NW5PKVQPTWZSEGAHCDQ1JPCEPIYYOZSSVLDV4KC2LJYAYS' // required
));

// $ip_addresses = array();
// $ip_elements = array(
//         'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
//         'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
//         'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
//         'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
//         'REMOTE_ADDR'
// );

// foreach ( $ip_elements as $element ) {
//         if(isset($_SERVER[$element])) {
//                 if ( !is_string($_SERVER[$element]) ) {
//                         // Log the value somehow, to improve the script!
//                         continue;
//                 }

//                 $address_list = explode(',', $_SERVER[$element]);
//                 $address_list = array_map('trim', $address_list);

//                 // Not using array_merge in order to preserve order
//                 foreach ( $address_list as $x ) {
//                         $ip_addresses[] = $x;
//                 }
//         }
// }

// if ( count($ip_addresses)==0 ) {
//         $ip = "";

// } else {
//         $ip = $ip_addresses[0];
// }
// echo $ip;
// //$ip = '180.149.49.231';
// $details = json_decode(file_get_contents("http://ipinfo.io/$ip"));
$details = option('ipinfo');
//var_dump($details['loc']);
$command = $client->getCommand('venues/search', array(
	'near' => $details['city'].", ".$details['region'].", ".$details['country'],
    'll' => $details['loc'],
    'query' => option('category')
));
$results = $command->execute(); // returns an array of results

option('stores', $results);
?>