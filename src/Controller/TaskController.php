<?php
namespace App\Controller;


use App\Common;
use App\Entity\Enum\TaskStatus;
use App\Entity\Task;
use App\Service\TaskService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TaskController extends AbstractResponseController
{
	/**
	 * @Rest\Get("/task")
	 * @return View
	 */
	public function getTasksAction(TaskService $service): View
	{
		$tasks = $service->getAll();
		
		return $this->success($tasks, Response::HTTP_OK);
	}
	
	/**
	 * @Rest\Get("/task/{taskId}")
	 * @return View
	 */
	public function getTaskAction(int $taskId, TaskService $service): View
	{
		$task = $service->getById($taskId);
		
		if (!$task)
		{
			return $this->fail('Item was not found', Response::HTTP_NOT_FOUND);
		}
		
		return $this->success($task, Response::HTTP_OK);
	}
	
	/**
	 * @Rest\Post("/task")
	 * @return View
	 */
	public function createTask(Request $request, TaskService $service, LoggerInterface $logger): View
	{
		$task = new Task();
		
		$task->setName($request->get('name'));
		$task->setDescription($request->get('description'));
		$task->setStatus(TaskStatus::ACTIVE);
		$task->setCreated(Common::now());
		$task->setModified(Common::now());
		
		try
		{
			$service->saveTask($task);
		}
		catch (\Throwable $e)
		{
			$logger->error($e->getMessage());
			return $this->fail('Unexpected error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		return $this->success($task, Response::HTTP_CREATED);
	}
	
	/**
	 * @Rest\Put("/task/{taskId}")
	 * @return View
	 */
	public function updateTask(int $taskId, Request $request, TaskService $service, LoggerInterface $logger): View
	{
		$task = $service->getById($taskId);
		
		if (!$task)
		{
			return $this->fail('Item was not found', Response::HTTP_NOT_FOUND);
		}
		
		$task->setName($request->get('name'));
		$task->setDescription($request->get('description'));
		$task->setStatus($request->get('status'));
		$task->setModified(Common::now());
		
		try
		{
			$service->saveTask($task);
		}
		catch (\Throwable $e)
		{
			$logger->error($e->getMessage());
			return $this->fail('Unexpected error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		return $this->success($task, Response::HTTP_OK);
	}
	
	/**
	 * @Rest\Delete("/task/{taskId}")
	 * @return View
	 */
	public function deleteTask(int $taskId, TaskService $service, LoggerInterface $logger): View
	{
		$task = $service->getById($taskId);
		
		if (!$task)
		{
			return $this->fail('Item was not found', Response::HTTP_NOT_FOUND);
		}
		
		try
		{
			$service->removeTask($task);
		}
		catch (\Throwable $e)
		{
			$logger->error($e->getMessage());
			$this->fail('Unexpected error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		return $this->success([], Response::HTTP_NO_CONTENT);
	}
}