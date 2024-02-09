<?php

namespace WilianMaique\Mexc\Mexc;

class Withdraw extends Time
{
	public static function withdraw(string $coin, string $network, string $address, string $amount): array|bool
	{
		$coin = strtoupper($coin ?? 'WEMIX');
		$network = strtoupper($network ?? 'WEMIX');

		$buildQuery = [
			'coin' => $coin,
			'network' => $network,
			'address' => $address,
			'amount' => $amount,
			'recvWindow' => 10000,
			'timestamp' => Time::time(5000)
		];

		$url = MEXC_CONFIG['MEXC_URL_API'] . '/capital/withdraw/apply?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'POST',
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
		curl_close($ch);

		return json_decode($res, true);
	}

	public static function history(string $coin, string $withdrawId = null): array|bool
	{
		$coin = strtoupper($coin ?? 'WEMIX');

		$buildQuery = [
			'coin' => $coin,
			'recvWindow' => 10000,
			'timestamp' => Time::time(5000)
		];

		$url = MEXC_CONFIG['MEXC_URL_API'] . '/capital/withdraw/history?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
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
		curl_close($ch);

		if ($status_code != 200 || empty($withdrawId))
			return json_decode($res, true);

		$resJson = array_filter(json_decode($res, true), function ($subarray) use ($withdrawId) {
			return $subarray['id'] == $withdrawId;
		});

		$resJson = reset($resJson);

		if (!$resJson)
			return false;

		return $resJson;
	}

	/*
	* withdraw status, 1:APPLY, 2:AUDITING, 3:WAIT, 4:PROCESSING, 5:WAIT_PACKAGING, 6:WAIT_CONFIRM, 7:SUCCESS, 8:FAILED, 9:CANCEL, 10:MANUAL
	*/
	public static function getMessageWithdrawStatus(int $status)
	{
		switch ($status) {
			case 1:
				return 'Foi solicitado o envio.';
				break;

			case 2:
				return 'Passando pela auditoria :)';
				break;

			case 3:
				return 'Esperando resposta.';
				break;

			case 4:
				return 'Tá processando, espera ai...';
				break;

			case 5:
				return 'Embalando para enviar...';
				break;

			case 6:
				return 'Espere mais um pouquinho, esperando confirmação.';
				break;

			case 7:
				return 'Envio concluído. Vê lá se chegou :)';
				break;

			case 8:
				return 'Falha ao enviar.';
				break;

			case 9:
				return 'Cancelado.';
				break;

			case 10:
				return 'Manual, deu alguma merda. Entre em contato.';
				break;
		}

		return 'Status não encontrado.';
	}
}
