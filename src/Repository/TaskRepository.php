<?php
namespace App\Repository;


use App\Base\Repository\ITaskRepository;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;


class TaskRepository implements ITaskRepository
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	
	/**
	 * @var \Doctrine\Persistence\ObjectRepository
	 */
	private $objectRepository;
	
	
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->objectRepository = $this->entityManager->getRepository(Task::class);
		
	}
	
	/**
	 * @return Task[]
	 */
	public function getAll(): array
	{
		return $this->objectRepository->findAll();
	}
	
	public function getById(string $id): ?Task
	{
		/** @var Task|null $task */
		$task = $this->objectRepository->find($id);
		return $task;
	}
	
	public function save(Task $task): void
	{
		$this->entityManager->persist($task);
	}
	
	public function delete(Task $task): void
	{
		$this->entityManager->remove($task);
	}
}