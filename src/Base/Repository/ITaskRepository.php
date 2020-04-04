<?php
namespace App\Base\Repository;


use App\Entity\Task;


interface ITaskRepository
{
	/**
	 * @return Task[]
	 */
	public function getAll(): array;
	public function getById(string $id): ?Task;
	public function save(Task $task): void;
	public function delete(Task $task): void;
}