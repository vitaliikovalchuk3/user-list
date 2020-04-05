<?php
namespace App\Controller;


use App\Base\Module\ITaskModule;
use App\Base\Service\ITaskService;
use App\Exceptions\APIExcetion;
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
	public function getTasksAction(ITaskService $service): View
	{
		$tasks = $service->getAll();
		
		return $this->success($tasks, Response::HTTP_OK);
	}
	
	/**
	 * @Rest\Get("/task/{taskId}")
	 * @return View
	 */
	public function getTaskAction(int $taskId, ITaskService $service): View
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
	public function createTask(Request $request, ITaskModule $taskModule, LoggerInterface $logger): View
	{
		$data = [
			'name' 			=> $request->get('name'),
			'description' 	=> $request->get('description')
		];
		
		try
		{
			$task = $taskModule->create($data);
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
	public function updateTask(
		int $taskId,
		Request $request,
		ITaskModule $module,
		LoggerInterface $logger): View
	{
		$data = [
			'id' 			=> $taskId,
			'name' 			=> $request->get('name'),
			'description' 	=> $request->get('description'),
			'status' 		=> $request->get('status')
		];
		
		try
		{
			$task = $module->update($data);
		}
		catch (APIExcetion $exception)
		{
			return $this->fail($exception->getMessage(), $exception->getCode());
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
	public function deleteTask(int $taskId, ITaskService $service, LoggerInterface $logger): View
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