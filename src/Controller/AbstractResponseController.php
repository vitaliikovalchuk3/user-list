<?php
namespace App\Controller;


use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\AbstractFOSRestController;


class AbstractResponseController extends AbstractFOSRestController
{
	protected function fail(string $message, int $code): View
	{
		return View::create([
			'status' => 'error',
			'result' => $message
		], $code);
	}
	
	protected function success($result, int $code): View
	{
		return View::create([
			'status' => 'success',
			'result' => $result
		], $code);
	}
}