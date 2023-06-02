<?php

namespace WilianMaique\Mexc\Mexc;

class BuildHttpQuery
{
	public static function build(array $params): string
	{
		ksort($params);
		return http_build_query($params);
	}
}
