# JsonToClass

simple tool to create **php class** from **json file**.

#### Example:

```json
{
    "class_name": "post",
    "class_attrs": {
        "id": {
            "type": "int",
            "visibility": "private"
        },
        "id_member": {
            "type": "int",
            "visibility": "private"
        },
        "content": {
            "type": "string",
            "visibility": "private"
        },
        "create_at": {
            "type": "DateTime",
            "visibility": "private"
        }
    }
}
```

```php
$jtc = new JsonToClass(__DIR__."\\post.json");
$jtc->toFile();
```

#### Output:
```php
//Post.php
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

```


