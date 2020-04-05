<?php
namespace App\Base\Module;


use App\Entity\Task;


interface ITaskModule
{
	public function create(array $data): Task;
	public function update(array $data): Task;
}