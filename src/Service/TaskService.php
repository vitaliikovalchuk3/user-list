<?php
namespace App\Service;


use App\Base\Repository\ITaskRepository;
use App\Base\Service\ITaskService;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;


class TaskService implements ITaskService
{
	/**
	 * @var ITaskRepository
	 */
	private $taskRepository;
	
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	
	
	public function __construct(ITaskRepository $taskRepository, EntityManagerInterface $entityManager)
	{
		$this->taskRepository = $taskRepository;
		$this->entityManager = $entityManager;
	}
	
	public function saveTask(Task $task): void
	{
		$this->taskRepository->save($task);
		$this->entityManager->flush();
	}
	
	public function removeTask(Task $task): void
	{
		$this->taskRepository->delete($task);
		$this->entityManager->flush();
	}
	
	public function getAll(): array
	{
		return $this->taskRepository->getAll();
	}
	
	public function getById(string $id): ?Task
	{
		return $this->taskRepository->getById($id);
	}
}