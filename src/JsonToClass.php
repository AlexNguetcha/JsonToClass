<?php 

class JsonToClass{

    private $jsonData;
    private $attrs = [];
    private $class_name;

    public function __construct(string $filename)
    {
        $this->jsonData = file_get_contents($filename);
        $this->jsonData = json_decode($this->jsonData);
        $this->parse();
        
    }

    private function parse()
    {
        foreach ($this->jsonData as $key => $value) {
            if ($key === "class_name") {
                //get the class name
               $this->class_name = $value;
            }else if ($key === "class_attrs") {
                //get all class attributes
                $attr = [];
                foreach ($value as $key => $val) {
                    array_push( $attr , $val );
                    foreach ($val as $key => $v) {
                        array_push( $attr , $v );
                    }
                }
               array_push( $this->attrs , $attr );
            }
        }
        //var_dump($this->attrs);
    }

    public function getAttrs(){
        return $this->attrs;
    }
    
}


$jtc = new JsonToClass(__DIR__."\\test.json");
