<h2>Управление Продуктами</h2>
<?php
//Select группы
echo CHtml::dropDownList('id_group', 0, ModelCatalog::DropListGroup(), array(
    'style' => 'width: 225px;',
    'empty' => '(Выбрать группу)',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('category/ajaxdropcategory'), //url to call.
        'update' => '#id_category', //selector to update
        'data' => array('id_group' => 'js:this.value'),
)));
echo '<br><br>';
//Лист Категории
echo CHtml::dropDownList('id_category', 0, array(), array(
    'style' => 'width: 225px;',
    'empty' => '(Выбрать категорию)',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => '', //url to call.
        'update' => '', //selector to update
        'data' => array(),
)));

echo '<br><br><span>Название продукта:</span><br>';
echo CHtml::textField('text', '', array('class' => 'title', 'size' => '50px'));

echo '<br><br><span>Старая цена:</span><br>';
echo CHtml::textField('text', '', array('class' => 'old_price'));

echo '<br><br><span>Цена:</span><br>';
echo CHtml::textField('text', '', array('class' => 'price'));

echo '<br><br><span>Наличие на складе:</span><br>';
echo CHtml::textField('text', '', array('class' => 'availability'));

echo '<br><br>';
echo CHtml::submitButton('Добавить');
?>
<br><br>

