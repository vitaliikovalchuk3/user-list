<?php
namespace App\Entity;


use App\Entity\Enum\TaskStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task
{
	/**
	 *@ORM\Column(type="integer")
	 *@ORM\Id
	 *@ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 *@ORM\Column(type="string",length=100)
	 *@Assert\NotBlank()
	 **/
	private $created;
	
	/**
	 *@ORM\Column(type="string",length=100)
	 *@Assert\NotBlank()
	 **/
	private $modified;
	
	/**
	 *@ORM\Column(type="string",length=20)
	 *@Assert\NotBlank()
	 **/
	private $name;
	
	/**
	 *@ORM\Column(type="text")
	 **/
	private $description;
	
	/** @ORM\Column(type="string")
	 *@Assert\NotBlank()
	 */
	private $status;
	
	
	public function getId(): int
	{
		return $this->id;
	}
	
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	
	public function getCreated(): string
	{
		return $this->created;
	}
	
	public function setCreated(string $created): void
	{
		$this->created = $created;
	}
	
	public function getModified(): string
	{
		return $this->modified;
	}
	
	public function setModified(string $modified): void
	{
		$this->modified = $modified;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name): void
	{
		$this->name = $name;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function setDescription($description): void
	{
		$this->description = $description;
	}
	
	public function getStatus(): string
	{
		return $this->status;
	}
	
	public function setStatus(string $status): void
	{
		if (!in_array($status, TaskStatus::getAll()))
		{
			throw new \InvalidArgumentException("Invalid status");
		}
		
		$this->status = $status;
	}
	
	
	
}