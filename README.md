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
$jtc->toFile(null, true);
```

#### Output:
```php
//Post.php
<?php

class Post
{
	private $id;
	private $id_member;
	private $content;
	private $create_at;

	public function __construct(int $id, int $id_member, string $content, DateTime $create_at)
	{
		$this->id = $id;
		$this->id_member = $id_member;
		$this->content = $content;
		$this->create_at = $create_at;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getIdMember(): int
	{
		return $this->id_member;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function getCreateAt(): DateTime
	{
		return $this->create_at;
	}


	public function setId(int $id)
	{
		$this->id = $id;
	}

	public function setIdMember(int $id_member)
	{
		$this->id_member = $id_member;
	}

	public function setContent(string $content)
	{
		$this->content = $content;
	}

	public function setCreateAt(DateTime $create_at)
	{
		$this->create_at = $create_at;
	}

}

```


