<?php


$locationPages = [];
$locations = [];

// keywords
$keywords = ['dining-chairs', 'furniture'];

// burnside
$locations['burnside'] = ['Aintree', 'Albanvale', 'Burnside', 'Carnlea', 'Caroline Springs', 'Deanside', 'Delahey', 'Deer Park', 'Derrimut', 'Fraser Rise', 'Hillside', 'Ravenhall', 'Rockbank', 'Sunshine', 'Sunshine West', 'Taylors Hill', 'Taylors Lakes', ];

// dandenong
$locations['dandenong'] = ['Bangholme', 'Berwick', 'Chelsea Heights', 'Clyde', 'Cranbourne North', 'Dandenong', 'Dandenong South', 'Eumemmerring', 'Endevour Hills', 'Hallam', 'Hampton Park', 'Keysborough', 'Lynbrook', 'Lyndhurst', 'Narre Warren', 'Narre Warren South', 'Noble Park', 'Officer', 'Pakenham', 'Springvale'];

// epping
$locations['epping'] = ['Bundoora', 'Campbellfield', 'Craigieburn', 'Donnybrook', 'Doreen', 'Epping', 'Greenvale', 'Kalkallo', 'Keilor', 'Keilor Park', 'Lalor', 'Mernda', 'Mickleham', 'Mill Park', 'Roxburgh Park', 'Somerton', 'South Morang', 'Sydenham', 'Thomastown', 'Yan Yean', 'Whittlesea', 'Wollert', 'Woodstock'];

// hoppers-crossing
$locations['hoppers-crossing'] = ['Altona', 'Altona Meadows', 'Altona North', 'Cocoroc', 'Eynesbury', 'Hoppers Crossing', 'Lara', 'Laverton', 'Laverton North', 'Little River', 'Mambourin', 'Manor Lakes', 'Mouth Cottrell', 'Point Cook', 'Seabrook', 'Tarneit', 'Truganina', 'Werribee', 'Werribee South', 'Wyndham Vale'];


foreach ($keywords as $keyword) {
	foreach ($locations as $area => $rows) {
		foreach ($rows as $location) {
			$suburbUrl = str_replace(' ', '-', strtolower($location));
            
			$locationPages['/' . $suburbUrl . '-' . $keyword] = ['keyword' => $keyword, 'location' => $location];
		}
	}
}

if (isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) && isset($locationPages[$_SERVER['REQUEST_URI']])) {
	$urlKeyword = rawurlencode(str_replace('-','%20',$locationPages[$_SERVER['REQUEST_URI']]['keyword']));
	$urlLocation = rawurlencode(str_replace('-','%20',$locationPages[$_SERVER['REQUEST_URI']]['location']));
	$url = 'https://65648939.walkingtrackmedia.com.au/location/landing/display/item/database/keyword-surburb/page?keyword=' . $urlKeyword . '&location=' . $urlLocation;

echo "<span style='display:none'>".$url."</span>";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_URL, $url);
	echo curl_exec($ch);
	exit();
		var_dump($url);
die();
}
/**
 * Public alias for the application entry point
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\Framework\App\Bootstrap;

try {
    require __DIR__ . '/../app/bootstrap.php';
} catch (\Exception $e) {
    echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
        <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
        Autoload error</h3>
    </div>
    <p>{$e->getMessage()}</p>
</div>
HTML;
    http_response_code(500);
    exit(1);
}

$bootstrap = Bootstrap::create(BP, $_SERVER);
/** @var \Magento\Framework\App\Http $app */
$app = $bootstrap->createApplication(\Magento\Framework\App\Http::class);
$bootstrap->run($app);
