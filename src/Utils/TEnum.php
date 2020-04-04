<?php
namespace App\Utils;


trait TEnum
{
	public static function getAll(): array
	{
		$reflector = new \ReflectionClass(self::class);
		$constants = $reflector->getConstants();
		
		return array_values($constants);
	}
}