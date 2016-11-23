<?php
/*
$file = new File('price');
$fname = Yii::app()->basePath . '/runtime/' . uniqid('', true);
$file->move($fname);
*/
class File {
    private $name;
    private $tmpName;
    private $fileName;
    
    public function __construct($name) {
	$this->name = $name;
	if (!isset($_FILES[$this->name])) {
	    throw new Exception('Файл не существует');
	}
	if ($_FILES[$this->name]['error'] != 0) {
	    throw new Exception('Ошибка при передаче файла');
	}
        
	$this->tmpName = $_FILES[$name]['tmp_name'];
	$this->fileName = $_FILES[$name]['name'];
    }
    
    public function move($destName) {
	if (!move_uploaded_file($this->tmpName, $destName)) {
	    throw new Exception('Ошибка при сохранении переданного файла');
	}
    }
    
    public function getName() {
	return $this->fileName;
    }
    
}