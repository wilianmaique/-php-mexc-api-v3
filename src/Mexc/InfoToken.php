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
			CURLOPT_SSL_VERIFYPEER => true,
		]);

		$res = curl_exec($ch);

		if (!$res) {
			curl_close($ch);
			return false;
		}

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$resJson = json_decode($res, true);
		curl_close($ch);

		if ($status_code != 200 || empty($tokenCoinName))
			return $resJson;

		$info = [];

		foreach ($resJson as $resJsonValue) {
			if ($resJsonValue['coin'] === $tokenCoinName) {
				return self::transformInfo($resJsonValue);
			}
		}

		if (empty($info))
			return ['msg' => 'Token not found...'];

		return $info;
	}

	/*
	*
	* transform array info
	*/
	private static function transformInfo(array $resJsonValue): array
	{
		$info = [
			'msg' => 'ok',
			'coin' => $resJsonValue['coin'],
			'name' => $resJsonValue['name'],
			'networkList' => [],
		];

		foreach ($resJsonValue['networkList'] as $value) {
			$info['networkList'][] = [
				'coin' => $value['coin'],
				'depositDesc' => $value['depositDesc'],
				'depositEnable' => $value['depositEnable'],
				'minConfirm' => $value['minConfirm'],
				'name' => $value['name'],
				'network' => $value['network'],
				'withdrawEnable' => $value['withdrawEnable'],
				'withdrawFee' => $value['withdrawFee'],
				'withdrawIntegerMultiple' => $value['withdrawIntegerMultiple'],
				'withdrawMax' => $value['withdrawMax'],
				'withdrawMin' => $value['withdrawMin'],
				'sameAddress' => $value['sameAddress'],
				'contract' => $value['contract'],
				'withdrawTips' => $value['withdrawTips'],
				'depositTips' => $value['depositTips'],
			];
		}

		if (count($resJsonValue['networkList']) <= 0) {
			reset($info['networkList']);
		}

		return $info;
	}
}
