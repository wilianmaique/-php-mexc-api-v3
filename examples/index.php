<?php

const MEXC_CONFIG = [
  'MEXC_URL_API' => 'https://api.mexc.com/api/v3',
  'MEXC_API_ACCESS_KEY' => 'mx0vgleBCS3z3msSyq',
  'MEXC_API_SECRET' => 'f7d42e5beb7948e083b3d44d2beb4876'
];

require __DIR__ . '/../vendor/autoload.php';

use WilianMaique\Mexc\Mexc\Account;
use WilianMaique\Mexc\Mexc\ExchangeInfo;
use WilianMaique\Mexc\Mexc\InfoToken;
use WilianMaique\Mexc\Mexc\PriceTicker;

dd([
  'ExchangeInfo' => ExchangeInfo::get(['MXUSDT', 'BTCUSDT']),
  'InfoToken' => InfoToken::get('WEMIX'),
  'Account' => Account::get(),
  'PriceTicker' => PriceTicker::get('WEMIXUSDT'),
]);
