<?php
namespace App\Base\Service;


use App\Entity\Task;


interface ITaskService
{
	public function createTask(Task $task): void;
	public function removeTask(Task $task): void;
	public function markAsDone(Task $task): void;
	public function getAll(): array;
	public function getById(string $id): ?Task;
}