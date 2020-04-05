<?php
namespace App;


class Common
{
	public static function now(): string
	{
		return date("Y-m-d H:i:s");
	}
}