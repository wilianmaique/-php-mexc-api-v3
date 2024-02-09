<?php

const MEXC_CONFIG = [
	'MEXC_URL_API' => 'https://api.mexc.com/api/v3',
	'MEXC_API_ACCESS_KEY' => 'mx0vglDTfAPSDCof1m',
	'MEXC_API_SECRET' => '7cf68dd323074ba3b21554091290b607'
];

require __DIR__ . '/../vendor/autoload.php';

use WilianMaique\Mexc\Mexc\Account;
use WilianMaique\Mexc\Mexc\InfoToken;
use WilianMaique\Mexc\Mexc\PriceTicker;

dd([
	'InfoToken' => InfoToken::get('WEMIX'),
	'Account' => Account::get(),
	'PriceTicker' => PriceTicker::get(),
]);