<?php
namespace App\Module;


use App\Base\Module\ITaskModule;
use App\Base\Repository\ITaskRepository;
use App\Common;
use App\Entity\Enum\TaskStatus;
use App\Entity\Task;
use App\Exceptions\API\NotFoundException;
use App\Exceptions\API\UpdateNotAllowedException;


class TaskModule implements ITaskModule
{
	private $taskRepo;
	
	
	private function updateTask(Task $task)
	{
		$this->taskRepo->save($task);
	}
	
	
	public function __construct(ITaskRepository $taskRepository)
	{
		$this->taskRepo = $taskRepository;
	}
	
	
	public function update(array $data): Task
	{
		$task = $this->taskRepo->getById($data['id']);
		
		if (!$task)
		{
			throw new NotFoundException('Item not found');
		}
		
		$currentStatus 	= $task->getStatus();
		$newStatus 		= $data['status'];
		
		$task->setName($data['name']);
		$task->setDescription($data['description']);
		$task->setStatus($newStatus);
		$task->setModified(Common::now());
		
		if ($currentStatus == TaskStatus::ACTIVE && $newStatus == TaskStatus::COMPLETED)
		{
			$currentTaskId = $this->taskRepo->getCurrentActiveTaskId();
			
			if ($task->getId() != $currentTaskId)
			{
				throw new UpdateNotAllowedException('You cannot complete a task until you complete your current');
			}
		}
		else
		{
			$this->updateTask($task);
		}
		
		return $task;
		
	}
}