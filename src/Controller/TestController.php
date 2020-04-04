<?php
namespace App\Controller;


use App\Entity\Enum\TaskStatus;


class TestController
{
	public function test()
	{
		var_dump(TaskStatus::getAll());die;
	}
}