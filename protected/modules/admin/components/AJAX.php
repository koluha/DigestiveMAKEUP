<?php

class AJAX {
    public static $reportFile = '';
    
    public static function setReport(array $report) {
	self::init();
	file_put_contents(self::$reportFile, serialize($report));
    }
    
    public static function getReport() {
	self::init();
	return unserialize(file_get_contents(self::$reportFile));
    }
    
    public static function flushReport() {
	self::init();
	@unlink(self::$reportFile);
    }
    
    private static function init() {
	if (self::$reportFile == '') 
	    self::$reportFile = Yii::app()->basePath . '/runtime/status.bin';
    }
}