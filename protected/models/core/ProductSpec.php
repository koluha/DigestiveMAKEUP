<?php

class ProductSpec extends CActiveRecord
{

	public function tableName()
	{
		return '{{product_spec}}';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'type' => 'Тип',
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
          //Список типов 
    public static function statusType() {
        $r['text'] = 'Текстовой';
        $r['int'] = 'Числовой';
        $r['float'] = 'Дробный';
        return $r;
      
    }

    //Возвращает имя статуса
    public static function getType($name) {
        $r = '';
        switch ($name) {
            case 'text':
                $r = 'Текстовой';
                break;
            case 'int':
                $r = 'Числовой';
                break;
            case 'float':
                $r = 'Дробный';
                break;
        }
        return $r;
    }
    
    //Получить список list для ыкдусе
    static function list_spec_select(){
        $res=self::model()->findAll();
         if (!empty($res)) {
            $drop = ModelCatalog::FormatDropList($res, 'id', 'name');
        } else {
            $drop = array();
        }
        return $drop;
    }
    
}
