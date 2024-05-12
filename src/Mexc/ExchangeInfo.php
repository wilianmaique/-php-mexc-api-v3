<?php

namespace WilianMaique\Mexc\Mexc;

class ExchangeInfo
{
  /*
	*
  * get current exchange trading rules and symbol information, symbol by name or null to get all list
  * https://mexcdevelop.github.io/apidocs/spot_v3_en/#exchange-information
	*/
  public static function get(?array $symbols = ['MXUSDT']): array|bool
  {
    if (!empty($symbols)) {
      $upperCaseSymbols = array_map('strtoupper', $symbols);
      $symbols = implode(',', $upperCaseSymbols);
    } else $symbols = '';

    $url = MEXC_CONFIG['MEXC_URL_API'] . '/exchangeInfo?symbols=' . $symbols;
    $ch = curl_init($url);

    curl_setopt_array($ch, [
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $res = curl_exec($ch);

    if (!$res) {
      curl_close($ch);
      return false;
    }

    curl_close($ch);

    return json_decode($res, true);
  }
}
