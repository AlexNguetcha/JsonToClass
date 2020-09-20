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


	public function setName(string $name):self
	{
		$this->name = $name;
		return $this;
	}

	public function setOld(int $old):self
	{
		$this->old = $old;
		return $this;
	}

	public function setSick(bool $sick):self
	{
		$this->sick = $sick;
		return $this;
	}

}