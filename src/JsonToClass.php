<?php 
namespace JTC;

use Exception;

require "../vendor/autoload.php";

class JsonToClass{

    private $jsonData;
    private $attrs = [];
    private $class_name;
    private $str;
    private $attrsNames = [];

    public function __construct(string $filename)
    {
        $this->jsonData = file_get_contents($filename);
        $this->jsonData = json_decode($this->jsonData);
        $this->parse();
        
    }

    public function parse()
    {
        foreach ($this->jsonData as $key => $value) {
            if ($key === "class_name") {
                //get the class name
               $this->class_name = $value;
            }else if ($key === "class_attrs") {
                //get all class attributes
                
                foreach ($value as $key => $val) {
                    //add attr name = ($key)
                    $attr = [];
                    array_push( $attr , $key );
                    array_push( $this->attrsNames, $key );
                    foreach ($val as $key => $v) {
                        //add attr visibility and type
                        array_push( $attr , $v );
                    }
                    array_push( $this->attrs , $attr );
                }
                
            }
        }
    }

    public function getAttrs()
    {
        return $this->attrs;
    }

    private function buildConstructor()
    {
        $constructorBody = "";
        $constructor = "\tpublic function __construct(";
        for ($i=0; $i < count($this->attrsNames); $i++) { 
            //add all constructor params
            $constructor .= $this->attrs[$i][1] . " $". $this->attrsNames[$i];
            if ($i === count($this->attrsNames) -1 ) {
                //close constructor params declaration
                $constructor .= ")\n\t{\n";
            }else{
                $constructor .= ", ";
            }
            //body declaration
            $constructorBody .= "\t\t" . "$" ."this->". $this->attrsNames[$i] ." = " . "$" . $this->attrsNames[$i] .";\n";

        }
        //add body declaration
        $constructor .= $constructorBody;
        $constructor .= "\t}\n";
        return $constructor;    
    }

    private function buildGetters()
    {
        $getters = "";
        for ($i=0; $i < count($this->attrsNames); $i++) {
            $attrName =  $this->attrsNames[$i];
            $type = $this->attrs[$i][1];
            $getterName = strtoupper($attrName[0]) . str_replace($attrName[0], "", $attrName) ;
            $func = "\tpublic function "; 
            //$func = "\tpublic function get" . $getterName . "()\n\t{\n";
            if ($type === "bool") {
                //isser name
                $func .= "is";
            }else{
                //getter name
                $func .= "get";
            }
            if ($type !== "mixed") {
                //add function return type
                $func .= $getterName . "(): " . $type;
            }
            $func .= "\n\t{\n";
                        
            $func .= "\t\treturn $" . "this->" . $attrName . ";\n";
            $func .= "\t}";
            $getters .= $func ."\n\n";
        }
        return $getters;    
    }

    private function buildSetters()
    {
        $setters = "";
        for ($i=0; $i < count($this->attrsNames); $i++) {
            $attrName =  $this->attrsNames[$i];
            $type = $this->attrs[$i][1];
            $param = "$" . $attrName;
            $setterName = strtoupper($attrName[0]) . str_replace($attrName[0], "", $attrName) ;
            
            if ($type !== "mixed") {
                $param = $type . " " .$param;
            } 
            $func = "\tpublic function set" . $setterName . "(" . $param . ")\n\t{\n";
            $func .= "\t\t$" . "this->" . $attrName . " = $" . $attrName .";\n";
            $func .= "\t}";
            $setters .= $func ."\n\n";
        }
        return $setters;    
    }

    public function build(): string
    {
        //class declaration

        $this->str = "<?php\n";
        $this->str .= "class " . $this->class_name . "\n{\n";
        //attribute declaration
        for ($i=0; $i < count($this->attrs); $i++) { 
            $attr = $this->attrs[$i];
            $this->str .= "\t" .$attr[2]. " $". $attr[0] . ";\n";
        }
        $this->str .= "\n" . $this->buildConstructor();
        $this->str .="\n";
        $this->str .= $this->buildGetters();
        $this->str .="\n";
        $this->str .= $this->buildSetters();
        $this->str .= "}";
        //print_r($this->str);
        return $this->str;
    }

    public function toFile(string $filename=null, bool $force=false)
    {
        if ($filename === null) {
            $filename = strtoupper($this->class_name[0]) . str_replace($this->class_name[0], "", $this->class_name);
            $filename .= ".php";
        }
        
        if ( file_exists($filename) === true ) {
            if ($force === false) {
                throw new Exception($filename . " already exist!");
            }
        }
        $file = fopen($filename, "w+");
        fwrite($file, $this->build());
        fclose($file);
    }
    
}


$jtc = new JsonToClass(__DIR__."\\test.json");
$jtc->toFile();


