<?php
/**
 * Craft web bootstrap file
 */

// Set path constants
define('CRAFT_BASE_PATH', dirname(__DIR__));
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor');

// Load Composer's autoloader
require_once CRAFT_VENDOR_PATH.'/autoload.php';

// Load dotenv?
if (class_exists('Dotenv\Dotenv') && file_exists(CRAFT_BASE_PATH.'/.env')) {
    Dotenv\Dotenv::create(CRAFT_BASE_PATH)->load();
}

// Load and run Craft
define('CRAFT_ENVIRONMENT', getenv('ENVIRONMENT') ?: 'production');
/** @var craft\web\Application $app */
$app = require CRAFT_VENDOR_PATH.'/craftcms/cms/bootstrap/web.php';
$app->run();

$url = "https://developers.zomato.com/api/v2.1/search?entity_id=259&entity_type=city&q=Melbourne&count=20";
// user-key is based on the key registered in zomato API page ...
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'user-key: 419a4c531b337d0e0d082a84065726e2'
  ));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

//
$array = json_decode($output, true);
    $restaurantName = "<ul class='list-group'>";
for ($i=0 ; $i<count($array['restaurants']) ; $i++){
  $restaurantName .= "<li class='list-group-item list-group-item-action'>";
  $restaurantName .= ($array['restaurants'][$i]['restaurant']['name']."<br>");
$restaurantName .= "</li>";
}
  $restaurantName .= "</ul>";
  echo $restaurantName;
  // in the case of error related to returned value...
print_r($curl_error);

