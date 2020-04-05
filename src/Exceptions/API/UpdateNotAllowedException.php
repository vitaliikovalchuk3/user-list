<?php
namespace App\Exceptions\API;


use App\Exceptions\APIExcetion;


class UpdateNotAllowedException extends APIExcetion
{
	public function __construct(string $message)
	{
		$code = 403;
		parent::__construct($message, $code);
	}
}