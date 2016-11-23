<script type="text/javascript">
    $(function() {
    
//При выборе первого selecta чистим последний
    $('#id_group').change(function(){
    $('#id_type').find('option').remove();
    });
            //1 - Работа с формой добавления группы   
            $('#form_group form').ajaxForm({
    dataType: 'json',
            type: 'POST',
            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdogroup') ?>',
            beforeSubmit: function(d, f) {
            var form = $(f);
                    title = form.find('.title input').val(),
                    url = form.find('.url input').val(),
                    form.find('.err').html('');
                    form.find('input').removeClass('error');
                    if (title == '') {
            form.find('.title .err').html('Поле "Группа" не может быть пустым');
                    form.find('.title input').addClass('error');
                    return false;
            }
            if (url == '') {
            form.find('.url .err').html('Поле "url" не может быть пустым');
                    form.find('.url input').addClass('error');
                    return false;
            }
            return true;
            },
            success: function(d) {
            var form = $('#form_group');
                    //console.log(d);
                    if (!d.error) {
            document.location.reload();
            } else {
            form.find('.title .err').html(d.msg);
                    // form.find('.title input').addClass('error');
            }
            }
    });
            //Клик по кнопке
            $('#button_add_group').click(function() {
    $('#bg').show();
            //чистим поля формы
            $('#form_group input[name="title"]').val('');
            $('#form_group input[name="url"]').val('');
            $('#form_group input[name="id_up"]').val('');
            //Заполение заголовок

            $('#form_group input[name="action"]').val('1');
            $('#form_group input[type="submit"]').val('Добавить');
            $('#form_group form h3').text('Добавить новую группу');
            $('#form_group').show();
    });
            //При клике на фон все закрыть
            $('#bg').click(function() {
    $('#bg').hide();
            $('#form_group').hide();
            $('#form_cat').hide();
            $('#form_type').hide();
            $('.error_up').hide();
    });
            // END 1 - Работа с формой добавления группы      

            // 2 - Работа с формой редактирование группы        

            $('#button_update_group').click(function() {
    //При клике получаем id выбранной группы, заполняем edit

    var id = $("#id_group option:selected").val();
            $.ajax({
            type: 'POST',
                    data:{id_group: id },
                    url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdatagroup') ?>',
                    success: function(data) {
                    find = JSON.parse(data);
                            //console.log(find);
                            if (!find.error) {

                    //id=find.data.id;
                    $("input[name='id_up']").val(find.data.id);
                            $("input[name='title']").val(find.data.title);
                            $("input[name='url']").val(find.data.url);
                            $('#bg').show();
                            $('#form_group').show();
                            $('#form_group input[name="action"]').val('0');
                            $('#form_group input[type="submit"]').val('Изменить');
                            $('#form_group form h3').text('Изменить выбранную группу');
                    } else{
                    $('#bg').show();
                            $('#form_group').hide();
                            $(".error_up").text(find.msg);
                            $('.error_up').show();
                    }
                    }
            });
    });
            // END 2 - Работа с формой редактирование группы   

            //3 - Работа с формой добавление Категорий   

            //Клик по кнопке add
            $('#button_add_cat').click(function() {
    var id_group = $("#id_group option:selected").val();
            //Если категория выбрана
            if (id_group){
    $('#bg').show();
            //чистим поля формы
            $('#form_cat input[name="title"]').val('');
            $('#form_cat input[name="url"]').val('');
            $('#form_cat input[name="img"]').val('');
            $('#desc_product').val('');
            $('#form_cat input[name="id_up"]').val('');
            $('#form_cat .img').hide();
            $('#form_cat input[name="filename"]').val('');
            //Заполение заголовок
            $("input[name='id_gr']").val(id_group);
            $('#form_cat input[name="action"]').val('1');
            $('#form_cat input[type="submit"]').val('Добавить');
            $('#form_cat form h3').text('Добавить новую Категорию');
            $('#form_cat').show();
    } else{
    $('#bg').show();
            $(".error_up").text('Выберете из списка группу');
            $('.error_up').show();
    }


    });
            //Клик по форме кнопка  категории
            $('#form_cat form').ajaxForm({
    dataType: 'json',
            type: 'POST',
            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdocat') ?>',
            beforeSubmit: function(d, f) {
            var form = $(f);
                    title = form.find('.title input').val(),
                    url = form.find('.url input').val(),
                    img = form.find('.img input').val(),
                    desc_product = form.find('#desc_product').val(),
                    form.find('.err').html('');
                    form.find('input').removeClass('error');
                    if (title == '') {
            form.find('.title .err').html('Поле "Категория" не может быть пустым');
                    form.find('.title input').addClass('error');
                    return false;
            }
            if (url == '') {
            form.find('.url .err').html('Поле "url" не может быть пустым');
                    form.find('.url input').addClass('error');
                    return false;
            }
           // if (desc_product == '') {
           // form.find('.desc_product .err').html('Поле "desc_product" не может быть пустым');
           //         form.find('.desc_product textarea').addClass('error');
           //         return false;
           // }
            return true;
            },
            success: function(d) {
            var form = $('#form_cat');
                    console.log(d);
                    if (!d.error) {
            //document.location.reload();
            //Обновляем список без перезагрузки
            $('#id_category').html(d.select_cat);
                    //Очистим список типа
                    $('#id_type').find('option').remove();
                    form.hide();
                    $('#bg').hide();
            } else {

            form.find('.title .err').html(d.msg);
                    //form.find('.title input').addClass('error');
            }
            }
    });
            //Клик по кнопке update cat
            $('#button_update_cat').click(function() {
    //При клике получаем id выбранной группы, заполняем edit

    var id = $("#id_category option:selected").val();
            var id_2 = $("#id_group option:selected").val();
            $.ajax({
            type: 'POST',
                    data:{id_cat: id},
                    url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdatacat') ?>',
                    success: function(data) {
                    find = JSON.parse(data);
                            // console.log(find);
                            if (!find.error) {

                    //id=find.data.id;
                    $("input[name='id_gr']").val(id_2);
                            $("input[name='id_up']").val(find.data.id);
                            $("input[name='title']").val(find.data.title);
                            $("input[name='url']").val(find.data.url);
                            $("input[name='img']").val(find.data.img);
                            $('#form_cat #desc_product').val(find.data.desc_product);
                            $('#form_cat input[name="filename"]').val('');
                            $('#form_cat .img').show();
                            $('#bg').show();
                            $('#form_cat').show();
                            $('#form_cat input[name="action"]').val('0');
                            $('#form_cat input[type="submit"]').val('Изменить');
                            $('#form_cat form h3').text('Изменить выбранную Категорию');
                    } else{
                    $('#bg').show();
                            $('#form_cat').hide();
                            $(".error_up").text(find.msg);
                            $('.error_up').show();
                    }
                    }
            });
    });
            //END 3 - Работа с формой добавление Категорий 

            //4 - Работа с формой добавление Типа   

            //Клик по кнопке add типа
            $('#button_add_type').click(function() {
    var id_cat = $("#id_category option:selected").val();
            //Если категория выбрана
            if (id_cat != 0){
    $('#bg').show();
            //чистим поля формы
            $('#form_type input[name="title"]').val('');
            $( "input:checkbox[name=check_class]" ).prop( "checked", false ),
            $('#form_type input[name="url"]').val('');
            $('#form_type input[name="img"]').val('');
            $('#form_type #desc_product').val('');
            $('#form_type input[name="id_up"]').val('');
            $('#form_type .img').hide();
            $('#form_type input[name="filename"]').val('');
            //Заполение заголовок
            $("input[name='id_cat']").val(id_cat);
            $('#form_type input[name="action"]').val('1');
            $('#form_type input[type="submit"]').val('Добавить');
            $('#form_type form h3').text('Добавить новый тип');
            $('#form_type').show();
    } else{
    $('#bg').show();
            $(".error_up").text('Выберете из списка группу категории');
            $('.error_up').show();
    }


    });
            //Клик по форме кнопка  типа
            $('#form_type form').ajaxForm({
    dataType: 'json',
            type: 'POST',
            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdotype') ?>',
            beforeSubmit: function(d, f) {
            var form = $(f);
                    console.log(form);
                    title = form.find('.title input').val(),
                    check_class = form.find('input:checkbox[name=check_class]:checked').val(),        
                    url = form.find('.url input').val(),
                    img = form.find('.img input').val(),
                    desc_product = form.find('#desc_product').val(),
                    form.find('.err').html('');
                    form.find('input').removeClass('error');
                       console.log(check_class);
                    if (title == '') {
            form.find('.title .err').html('Поле "Категория" не может быть пустым');
                    form.find('.title input').addClass('error');
                    return false;
            }
            if (url == '') {
            form.find('.url .err').html('Поле "url" не может быть пустым');
                    form.find('.url input').addClass('error');
                    return false;
            }
          //  if (desc_product == '') {
          //  form.find('.desc_product .err').html('Поле "desc_product" не может быть пустым');
          //          form.find('.desc_product textarea').addClass('error');
          //          return false;
          //  }
            return true;
            },
            success: function(d) {
            var form = $('#form_type');
                    console.log(d);
                    if (!d.error) {
            //document.location.reload();
            //Обновляем список без перезагрузки
            $('#id_type').html(d.select_cat);
                    form.hide();
                    $('#bg').hide();
            } else {

            form.find('.title .err').html(d.msg);
                    //form.find('.title input').addClass('error');
            }
            }
    });
            //Клик по кнопке update type
            $('#button_update_type').click(function() {
    //При клике получаем id выбранной группы, заполняем edit

    var id = $("#id_type option:selected").val();
            var id_2 = $("#id_category option:selected").val();
            $.ajax({
            type: 'POST',
                    data:{id_type: id},
                    url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdatatype') ?>',
                    success: function(data) {
                    find = JSON.parse(data);
                            console.log(find);
                            if (!find.error) {

                    //id=find.data.id;
                    $("input[name='id_cat']").val(id_2);
                            $("input[name='id_up']").val(find.data.id);
                            $("input[name='title']").val(find.data.title);
                            
                            
                            check_class=find.data.check_class;
                            
                            if (check_class==1) {
                                   $( "input:checkbox[name=check_class]" ).prop( "checked", true );
                                 } else {
                                   $( "input:checkbox[name=check_class]" ).prop( "checked", false );
                            } 
                            
                            $("input[name='url']").val(find.data.url);
                            $("input[name='img']").val(find.data.img);
                            $('#form_type #desc_product').val(find.data.desc_product);
                            $('#form_type input[name="filename"]').val('');
                            $('#form_type .img').show();
                            $('#bg').show();
                            $('#form_type').show();
                            $('#form_type input[name="action"]').val('0');
                            $('#form_type input[type="submit"]').val('Изменить');
                            $('#form_type form h3').text('Изменить выбранный тип');
                    } else{
                    $('#bg').show();
                            $('#form_type').hide();
                            $(".error_up").text(find.msg);
                            $('.error_up').show();
                    }
                    }
            });
    });
            //END 4 - Работа с формой добавление Типа 

    });
</script>

<h2>Управление категориями</h2>

<?php
//Select группы
echo CHtml::dropDownList('id_group', Yii::app()->session['ses_id_group'] ? Yii::app()->session['ses_id_group'] : 0, ModelCatalog::DropListGroup(), array(
    'style' => 'width: 225px;',
    'empty' => '(Выбрать группу)',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('category/ajaxdropcategory'), //url to call.
        'update' => '#id_category', //selector to update
        'data' => array('id_group' => 'js:this.value'),
)));

//Кнопки группы
echo '&nbsp';
echo CHtml::submitButton('Добавить', array('id' => 'button_add_group'));
echo '&nbsp';
echo '&nbsp';
echo CHtml::submitButton('Редактировать', array('id' => 'button_update_group'));
echo '<br><br>';

//Лист Категории
echo CHtml::dropDownList('id_category', 0, array(), array(
    'style' => 'width: 225px;',
    'empty' => '(Выбрать категорию)',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('category/ajaxdroptype'), //url to call.
        'update' => '#id_type', //selector to update
        'data' => array('id_category' => 'js:this.value'),
)));

//Кнопки Категории
echo '&nbsp';
echo CHtml::submitButton('Добавить', array('id' => 'button_add_cat'));
echo '&nbsp';
echo '&nbsp';
echo CHtml::submitButton('Редактировать', array('id' => 'button_update_cat'));
echo '<br><br>';


//Лист Категории
echo CHtml::dropDownList('id_type', 0, array(), array(
    'style' => 'width: 225px;',
    'empty' => '(Выбрать Тип)',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => '', //url to call.
        'update' => '', //selector to update
        'data' => array(),
)));

//Кнопки Категории
echo '&nbsp';
echo CHtml::submitButton('Добавить', array('id' => 'button_add_type'));
echo '&nbsp';
echo '&nbsp';
echo CHtml::submitButton('Редактировать', array('id' => 'button_update_type'));
echo '<br><br>';
?>

<div id="form_group" class="form">
    <form autocomplete="off">
        <h3></h3>
        <!-- Скрытое поля id для редактирования-->
        <input type="hidden" name="id_up" size="30" value=""/> 
        <!-- Скрытое поля action для контроллера ADD (TRUE) или UPDATE (FALSE)-->
        <input type="hidden" name="action" size="30" value=""/> 

        <div class="title">
            <div class="err"></div>
            <span class="t125">Название группы</span><br>
            <input type="text" name="title" size="30" value=""/>
        </div>
        <br>
        <div class="url mt10">
            <div class="err"></div>
            <span class="t125">Ссылка URL</span><br>
            <input type="text" name="url" size="30"/>
        </div>
        <br>
        <div class="mt10">
            <input type="submit" value=""/>
        </div>
    </form>
</div>

<div id="form_cat" class="form">
    <form autocomplete="off" enctype="multipart/form-data"  method="post">
        <h3></h3>
        <!-- Скрытое поля Размер файла-->
        <input type="hidden" name="MAX_FILE_SIZE" value="120000" />
        <!-- Скрытое поля id Группы-->
        <input type="hidden" name="id_gr" size="30" value=""/> 
        <!-- Скрытое поля id для редактирования-->
        <input type="hidden" name="id_up" size="30" value=""/> 
        <!-- Скрытое поля action для контроллера ADD (1) или UPDATE (0)-->
        <input type="hidden" name="action" size="30" value=""/> 

        <div class="title">
            <div class="err"></div>
            <span class="t125">Название Категорий</span><br>
            <input type="text" name="title" size="30" value=""/>
        </div>
        <br>
        <div class="url mt10">
            <div class="err"></div>
            <span class="t125">Ссылка URL</span><br>
            <input type="text" name="url" size="30"/>
        </div>
        <br>
        <div class="desc_product">
            <div class="err"></div>
            <span class="t125">Описание производителя</span><br>
            <textarea rows="5" cols="45" id="desc_product"  name="desc_product"></textarea>
        </div>
        <br>
        <div class="img mt10">
            <div class="err"></div>
            <span class="t125">IMG </span><br>
            <input type="text" name="img" size="30" readonly />
        </div>
        <br>
        <div class="imgfile">
            <div class="err"></div>
            <span><b>Картинка производителя (не больше 100 кб) (название из url Ш*В 130px X 250 px):</b></span><br><br>
            <input type="file" name="filename">
        </div>
        <br>
        <div class="mt10">
            <input type="submit" value=""/>
        </div>
    </form>
</div>


<div id="form_type" class="form">
    <form autocomplete="off" enctype="multipart/form-data"  method="post">
        <h3></h3>
          <!-- Скрытое поля Размер файла-->
        <input type="hidden" name="MAX_FILE_SIZE" value="120000" />
        <!-- Скрытое поля id Группы-->
        <input type="hidden" name="id_cat" size="30" value=""/> 
        <!-- Скрытое поля id для редактирования-->
        <input type="hidden" name="id_up" size="30" value=""/> 
        <!-- Скрытое поля action для контроллера ADD (1) или UPDATE (0)-->
        <input type="hidden" name="action" size="30" value=""/> 

        <div class="title">
            <div class="err"></div>
            <span>Название Типа</span><br>
            <input type="text" name="title" size="30" value=""/>
        </div>
        
        <!-- Если флажок установлен, передается значение 1 -->
         <input type="checkbox" name="check_class" value="1" >Класс<Br>
         
        <div class="url mt10">
            <div class="err"></div>
            <span class="t125">Ссылка URL</span><br>
            <input type="text" name="url" size="30"/>
        </div>
        <br>
        <div class="desc_product">
            <div class="err"></div>
            <span class="t125">Описание производителя</span><br>
            <textarea rows="5" cols="45" id="desc_product"  name="desc_product"></textarea>
        </div>
        <br>
        <div class="img mt10">
            <div class="err"></div>
            <span class="t125">IMG</span><br>
            <input type="text" name="img" size="30" readonly />
        </div>
        <br>
        <div class="imgfile">
            <div class="err"></div>
            <span><b>Картинка производителя (название из url Ш*В 130px X 250 px):</b></span><br><br>
            <input type="file" name="filename">
        </div>
        <br>
        <div class="mt10">
            <input type="submit" value=""/>
        </div>
    </form>
</div>


<div class="error_up"></div>