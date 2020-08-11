<?php
class Person
{
	public $name;
	private $old;
	private $sick;

	public function __construct(string $name, int $old, bool $sick)
	{
		$this->name = $name;
		$this->old = $old;
		$this->sick = $sick;
	}


	public function getName(): string
	{
		return $this->name;
	}

	public function getOld(): int
	{
		return $this->old;
	}

	public function isSick(): bool
	{
		return $this->sick;
	}

}