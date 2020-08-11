<?php
class Person
{
	private $name;
	private $old;
	private $sick;

	public function __construct(string $name, int $old, bool $sick)
	{
		$this->name = $name;
		$this->old = $old;
		$this->sick = $sick;
	}
}