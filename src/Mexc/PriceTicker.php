<?php

namespace WilianMaique\Mexc\Mexc;

/*
* List symbols name
* -> https://api.mexc.com/api/v3/ticker/price
*/

class PriceTicker
{
	public static function get(string $symbolToken = null): array|bool
	{
		$symbolToken = strtoupper($symbolToken ?? '');

		$url = MEXC_CONFIG['MEXC_URL_API'] . '/ticker/price';
		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		]);

		$res = curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$resJson = json_decode($res, true);

		if ($status_code != 200)
			return $resJson;

		if (empty($symbolToken))
			return $resJson;

		$info = [];

		foreach ($resJson as $key => $resJsonValue) {
			if ($resJsonValue['symbol'] === $symbolToken) {
				$info['symbol'] = $resJsonValue['symbol'];
				$info['price'] = $resJsonValue['price'];
				break;
			}
		}

		if (empty($info))
			return ['msg' => 'Symbol token not found...'];

		return $info;
	}
}
