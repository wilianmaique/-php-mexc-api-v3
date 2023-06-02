<?php

namespace WilianMaique\Mexc\Mexc;

class InfoToken extends Time
{
	/*
	*
	* get info token by name or null to get all list
	*/
	public static function get(string $tokenCoinName = null): array|bool
	{
		$tokenCoinName = strtoupper($tokenCoinName ?? '');

		$buildQuery = [
			'recvWindow' => 10000,
			'timestamp' => Time::time(5000)
		];

		$url = MEXC_CONFIG['MEXC_URL_API'] . '/capital/config/getall?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => [
				'X-MEXC-APIKEY: ' . MEXC_CONFIG['MEXC_API_ACCESS_KEY'] . ''
			],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		]);

		$res = curl_exec($ch);

		if (!$res) {
			curl_close($ch);
			return false;
		}

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$resJson = json_decode($res, true);
		curl_close($ch);

		if ($status_code != 200)
			return $resJson;

		if (empty($tokenCoinName))
			return $resJson;

		$info = [];

		foreach ($resJson as $resJsonValue) {
			if ($resJsonValue['coin'] === $tokenCoinName) {
				$info['coin'] = $tokenCoinName;
				$info['name'] = $resJsonValue['name'];

				foreach ($resJsonValue['networkList'] as $key => $value) {
					$info['networkList'][$key]['coin'] = $value['coin'];
					$info['networkList'][$key]['depositDesc'] = $value['depositDesc'];
					$info['networkList'][$key]['depositEnable'] = $value['depositEnable'];
					$info['networkList'][$key]['minConfirm'] = $value['minConfirm'];
					$info['networkList'][$key]['name'] = $value['name'];
					$info['networkList'][$key]['network'] = $value['network'];
					$info['networkList'][$key]['withdrawEnable'] = $value['withdrawEnable'];
					$info['networkList'][$key]['withdrawFee'] = $value['withdrawFee'];
					$info['networkList'][$key]['withdrawIntegerMultiple'] = $value['withdrawIntegerMultiple'];
					$info['networkList'][$key]['withdrawMax'] = $value['withdrawMax'];
					$info['networkList'][$key]['withdrawMin'] = $value['withdrawMin'];
					$info['networkList'][$key]['sameAddress'] = $value['sameAddress'];
					$info['networkList'][$key]['contract'] = $value['contract'];
					$info['networkList'][$key]['withdrawTips'] = $value['withdrawTips'];
					$info['networkList'][$key]['depositTips'] = $value['depositTips'];
				}

				if (count($resJsonValue['networkList']) <= 0)
					reset($info['networkList']);

				break;
			}
		}

		if (empty($info))
			return ['msg' => 'Token not found...'];

		return $info;
	}
}
