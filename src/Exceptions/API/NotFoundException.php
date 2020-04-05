<?php
namespace App\Exceptions\API;


use App\Exceptions\APIExcetion;


class NotFoundException extends APIExcetion
{
	public function __construct(string $message)
	{
		$code = 404;
		parent::__construct($message, $code);
	}
}