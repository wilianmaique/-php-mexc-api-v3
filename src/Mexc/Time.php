<?php

namespace WilianMaique\Mexc\Mexc;

class Time
{
	public static function time(int $recvWindow): int
	{
		$ts = round(microtime(true) * 1000);
		$ts -= $ts % $recvWindow;
		return $ts;
	}
}