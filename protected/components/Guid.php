<?php
class Guid  extends CActiveRecord{

    public function getGUID($opt = true ) {
     
    if( function_exists('com_create_guid') ){
        if( $opt ){ return com_create_guid(); }
            else { return trim( com_create_guid(), '{}' ); }
        }
        else {
            mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
            $charid = strtoupper( md5(uniqid(rand(), true)) );
           // $hyphen = chr( 45 );    // "-"
            $hyphen = '';    // "-"
            $left_curly = $opt ? chr(123) : "";     //  "{"
            $right_curly = $opt ? chr(125) : "";    //  "}"
            $uuid = $left_curly
                . substr( $charid, 0, 8 ) . $hyphen
                . substr( $charid, 8, 4 ) . $hyphen
                . substr( $charid, 12, 4 ) . $hyphen
                . substr( $charid, 16, 4 ) . $hyphen
                . substr( $charid, 20, 12 )
                . $right_curly;
            return strtoupper($uuid);
            }
    }

    public function testguid() {
        if (function_exists('com_create_guid') === true) {
            echo "Yes";
            $guid = com_create_guid();
            echo $guid;
        } else {
            echo "Nope !";
        }
    }
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
