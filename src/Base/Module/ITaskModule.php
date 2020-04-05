<?php
namespace App\Base\Module;


use App\Entity\Task;


interface ITaskModule
{
	public function update(array $data): Task;
}