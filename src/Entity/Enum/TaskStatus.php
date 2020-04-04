<?php
namespace App\Entity\Enum;


use App\Utils\TEnum;


class TaskStatus
{
	use TEnum;
	
	
	public const ACTIVE 	= 'active';
	public const DELETED 	= 'deleted';
	public const COMPLETED 	= 'completed';
}