<script type="text/javascript">
    $(function() {
        $('#id_group').change(function() {
            $("#tb_product").empty().html('<tr></tr>');
            // $('#form_spec input[name="id_prod"]').val('1');

        });



        //1 - Работа с формой добавления группы   
        $('#form_spec form').ajaxForm({
            dataType: 'json',
            type: 'POST',
            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdospec') ?>',
                    beforeSubmit: function(d, f) {
                        var form = $(f);
                        val_spec = form.find('.val_spec input').val(),
                                form.find('.err').html('');
                        form.find('input').removeClass('error');

                        if (val_spec == '') {
                            form.find('.val_spec .err').html('Поле "val_spec" не может быть пустым');
                            form.find('.val_spec input').addClass('error');
                            return false;
                        }
                        return true;
                    },
            success: function(d) {
                var form = $('#form_spec');
                //  console.log(d);
                if (!d.error) {
                    //document.location.reload();
                    form.hide();
                    $('#bg').hide();
                    $("#tb_product").empty().html(d.ajaxform); //Обновление содержимого
                } else {
                    form.find('.title .err').html(d.msg);
                    form.find('.title input').addClass('error');
                }
            }
        });



        //подгруженных ajax элементах (клик по кнопке)
        $(document).on('click', '#button_add_spec', function() {
            //Получаем id продукта передается по кнопке
            var id_pr = $(this).attr('data-idproduct');
            $('#form_spec input[name="id_prod"]').val(id_pr);

            var id_cat = $("#id_category option:selected").val();
            $('#form_spec input[name="id_cat"]').val(id_cat);

            //чистим поля формы
            $('#form_spec input[name="val_spec"]').val('');
            //Заполение заголовок
            $('#form_spec input[name="action"]').val('1');
            $('#form_spec input[type="submit"]').val('Добавить');
            $('#form_spec form h3').text('Добавить спецификацию к товару');
            $('#form_spec').show();

            $('#bg').show();
            $('#form_spec').show();
        });

        //Удаление спецификаций
        $(document).on('click', '#button_del_spec', function() {
            //Получаем id продукта и id спец-ий передается по кнопке
            var id_pr = $(this).attr('data-idproduct');
            var id_sp = $(this).attr('data-idspec');
            var sel_cat=$("#id_category option:selected").val();
            //Тут скрытое поле
            
            $('#form_spec input[name="id_prod"]').val(id_pr);
            if(confirm('Удалить характеристику?')){
            $.ajax({
                url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdeletespec') ?>',
                type: 'post',
                data: {id_prod: id_pr,id_spec: id_sp, id_cat:sel_cat},
                success: function(d) {
                      if (!d.error) {
                    //document.location.reload();
                    data = JSON.parse(d);
                   // console.log(data);
                    $("#tb_product").empty().html(data.ajaxform); //Обновление содержимого
                } else {
                    form.find('#res').html('Ошибка удаления');
                  }
                }
            });
            
            return false;
            }
        });
        
        //Кнопка добавление продукта
        $('#button_add_product').click(function() {
                var id_cat = $("#id_category option:selected").val();
              //    console.log(id_cat);
                //Если категория выбрана
                 if(id_cat!=0){
                    $('#bg').show();
                    //чистим поля формы
                    $('#form_prod input[name="title"]').val('');
                    $('#form_prod input[name="price"]').val('');
                    $('#form_prod input[name="old_price"]').val('');
                    $( "#form_prod input[name='availability']" ).prop( "checked", true);
                    
                    $('#form_prod .img').hide(); 
                    $("#form_prod input[name='img']").val('');
                    
                    $('#form_prod input[name="url"]').val('');
                    $('#form_prod input[name="meta_title"]').val('');
                    $('#form_prod input[name="meta_keywords"]').val('');
                    $('#form_prod input[name="meta_description"]').val('');
                    
                    $('#form_prod input[name="filename"]').val('');
                    //Заполение заголовок
                    $("input[name='id_cat']").val(id_cat);
                    
                    $('#form_prod input[name="action"]').val('1');
                    $('#form_prod input[type="submit"]').val('Добавить');
                    $('#form_prod form h3').text('Добавить новый продукт ');
                    $('#form_prod').show();
                 }else{
                      $('#bg').show();
                      $(".error_up").text('Выберете из списка группу категории');
                      $('.error_up').show();
                }
        });
        
         //Кнопка Удаления Продукта
          $(document).on('click', '#button_delete_prod', function() {
               var id_pr = $(this).attr('data-idproduct');
               var sel_cat=$("#id_category option:selected").val();
                  if(confirm('Удалить продукт?')){
                       $.ajax({
                            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdeleteproduct') ?>',
                            type: 'post',
                            data: {id_prod: id_pr,id_cat:sel_cat},
                            success: function(d) {
                                         if (!d.error) {
                                            //document.location.reload();
                                            data = JSON.parse(d);
                                            // console.log(data);
                                            $("#tb_product").empty().html(data.ajaxform); //Обновление содержимого
                                        } else {
                                             form.find('#res').html('Ошибка удаления');
                                        } 
                }
            });
            
            return false;
            }
        });
        
        //Кнопка редактирование Продукта
          $(document).on('click', '#button_update_prod', function() {

            var id = $(this).attr('data-idproduct');
            var id_cat = $("#id_category option:selected").val();
                    $.ajax({
                        type: 'POST',
                        data:{id_prod:id},
                        url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdataprod') ?>',
                        success: function(data) {
                            find = JSON.parse(data);
                                // console.log(find);
                                if (!find.error) {
                                   $("input[name='id_cat']").val(id_cat);
                                   //id=find.data.id;
                                    $("#form_prod input[name='id_up']").val(find.data.id);
                                    $("#form_prod input[name='title']").val(find.data.title);
                                    $("#form_prod input[name='old_price']").val(find.data.old_price);
                                    $("#form_prod input[name='price']").val(find.data.price);
                                    
                                    $("#form_prod input[name='img']").val(find.data.img); 
                                    $("#form_prod .img").show(); 
                                   
                                     
                                    $("#form_prod input[name='url']").val(find.data.url);
                                    $("#form_prod input[name='meta_title']").val(find.data.meta_title);
                                    $("#form_prod input[name='meta_keywords']").val(find.data.meta_keywords);
                                    $("#form_prod input[name='meta_description']").val(find.data.meta_description);
                                    
                                    //$("#form_prod input[name='availability']").val(find.data.availability);
                                    if(find.data.availability==1){
                                        $( "#form_prod input[name='availability']" ).prop( "checked", true);
                                            }else{
                                        $( "#form_prod input[name='availability']" ).prop( "checked", false);
                                     }
                                     $('#bg').show();
                                     $('#form_prod').show();
                                     
                                      $('#form_prod input[name="action"]').val('0');
                                      $('#form_prod input[type="submit"]').val('Изменить');
                                      $('#form_prod form h3').text('Изменить выбранный продукт');
                                  }else{
                                      $('#bg').hide();
                                      $('#form_prod').hide();
                                     // $(".error_up").text(find.msg);
                                      $('.error_up').show();
                                  }
                        }
                    });
        });
        
          //1 - Работа с формой  продукта   
    $('#form_prod form').ajaxForm({
            dataType: 'json',
            type: 'POST',
            url: '<? echo Yii::app()->createUrl('admin/ajax/ajaxdoproduct') ?>',
            beforeSubmit: function(d, f) {
            var form = $(f);
                    title = form.find('.title input').val(),
                    price = form.find('.price input').val(),
                    old_price = form.find('.old_price input').val(),
                    chek=$("#avail").prop("checked");
                    //console.log(chek);
                    
                    url = form.find('.url input').val(),
                    meta_title = form.find('.meta_title input').val(),
                    meta_keywords = form.find('.meta_keywords input').val(),
                    meta_description = form.find('.meta_description input').val(),
                 
                    form.find('.err').html('');
                    form.find('input').removeClass('error');
                    if (title == '') {
                       form.find('.title .err').html('Поле "Продукт" не может быть пустым');
                       form.find('.title input').addClass('error');
                    return false;
                    }
                    if (price == '') {
                        form.find('.price .err').html('Поле "price" не может быть пустым');
                        form.find('.price input').addClass('error');
                    return false;
                    }
                    if (old_price == '') {
                        form.find('.old_price .err').html('Поле "old_price" не может быть пустым');
                        form.find('.old_price input').addClass('error');
                    return false;
                    }
                    if (url == '') {
                        form.find('.url .err').html('Поле "url" не может быть пустым');
                        form.find('.url input').addClass('error');
                    return false;
                    }
                    if (meta_title == '') {
                        form.find('.meta_title .err').html('Поле "meta_title" не может быть пустым');
                        form.find('.meta_title input').addClass('error');
                    return false;
                    }
                    if (meta_keywords == '') {
                        form.find('.meta_keywords .err').html('Поле "meta_keywords" не может быть пустым');
                        form.find('.meta_keywords input').addClass('error');
                    return false;
                    }
                    if (meta_description == '') {
                        form.find('.meta_description .err').html('Поле "meta_description" не может быть пустым');
                        form.find('.meta_description input').addClass('error');
                    return false;
                    }
                    
            return true;
            },
            success: function(d) {
                    var form = $('#form_group');
                  //  console.log(d);
                    if (!d.error) {
                         //  document.location.reload();
                          $('#bg').hide();
                          $('#form_prod').hide();
                          $("#tb_product").empty().html(d.ajaxform); //Обновление содержимого
                        } else {
                        form.find('.title .err').html(d.msg);
                        form.find('.title input').addClass('error');
                        }
                }
            });
            

        //При клике на фон все закрыть
        $('#bg').click(function() {
            $('#bg').hide();
            $('#form_spec').hide();
            $('#form_prod').hide();
            $('.error_up').hide();
        });
        
        
    });
</script>
<div class="error_up"></div>
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
        'url' => CController::createUrl('ajax/ajaxlist'), //url to call.
        'update' => '#tb_product', //selector to update
        'data' => array('id_category' => 'js:this.value'),
)));
?>
<br><br>
<table cellpadding="0" cellspacing="2">
    <thead>
        <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Цена</td>
            <td>Старая цена</td>
            <td>Наличие</td>
            <td>Ссылка</td>
            <td>Title</td>
            <td>Keywords</td>
            <td>Description</td>
          
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody id="tb_product">
        <tr></tr>
    </tbody>
</table>

<?php echo CHtml::submitButton('Добавить продукт', array('id' => 'button_add_product'));?>

<!-- Форма добавления спецификации-->
<div id="form_spec" class="form">
    <form autocomplete="off">
        <h3></h3>
        <input type="hidden" name="id_up" size="30" value=""/> 

        <!-- Скрытое поля id_cat для привязке категорий к продукту-->
        <input type="hidden" name="id_cat" size="30" value=""/> 
        <!-- Скрытое поля id_prod для привязке к продукту-->
        <input type="hidden" name="id_prod" size="30" value=""/> 
        <!-- Скрытое поля action для контроллера ADD (TRUE) или UPDATE (FALSE)-->
        <input type="hidden" name="action" size="30" value=""/> 

        <div class="drop_spec">
            <div class="err"></div>
            <span class="t125">Название спецификации</span><br>
            <?php echo CHtml::dropDownList('drop_spec', '0', ProductSpec::list_spec_select()) ?><br>
        </div>
        <div class="val_spec">
            <div class="err"></div>
            <span class="t125">Значение</span><br>
            <input type="text" name="val_spec" size="30" value=""/>
        </div>
        <br>
        <div class="mt10">
            <input type="submit" value=""/>
        </div>
    </form>
</div>


<!-- Форма добавления продукта-->
<div id="form_prod" class="form">
    <form autocomplete="off">
        <h3></h3>
        <!-- Скрытое поля id Категорий-->
        <input type="hidden" name="id_cat" size="30" value=""/> 
        
        <!-- Скрытое поля id для редактирования-->
        <input type="hidden" name="id_up" size="30" value=""/> 
        
        <!-- Скрытое поля action для контроллера ADD (1) или UPDATE (0)-->
        <input type="hidden" name="action" size="30" value=""/> 
        
        <div class="title">
            <div class="err"></div>
            <span class="t125">Название Продукта</span><br>
            <input type="text" name="title" size="30" value=""/>
        </div>
         <div class="price mt10">
            <div class="err"></div>
            <span class="t125">Цена (Пример 150.00)</span><br>
            <input type="text" name="price" size="30"/>
        </div>
        <div class="old_price mt10">
            <div class="err"></div>
            <span class="t125">Старая цена</span><br>
            <input type="text" name="old_price" size="30"/>
        </div>
        <div class="avail mt10">
            <div class="err"></div>
            <span class="t125">Наличие на складе</span><br>
            <input id="avail" type="checkbox" name="availability" checked="" value="ON">
        </div>
          <div class="url mt10">
            <div class="err"></div>
            <span class="t125">Url</span><br>
            <input type="text" name="url" size="30"/>
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
            <span class="t125">Картинка Продукта (название из url Ш*В от 95px X 900px):</span><br><br>
          <input type="file" name="filename">
        </div>
        
        <div class="meta_title mt10">
            <div class="err"></div>
            <span class="t125">meta_title</span><br>
            <input type="text" name="meta_title" size="30"/>
        </div>
          <div class="meta_keywords mt10">
            <div class="err"></div>
            <span class="t125">meta_keywords</span><br>
            <input type="text" name="meta_keywords" size="30"/>
        </div>
          <div class="meta_description mt10">
            <div class="err"></div>
            <span class="t125">meta_description</span><br>
            <input type="text" name="meta_description" size="30"/>
        </div>
        <div class="mt10">
            <input type="submit" value=""/>
        </div>
    </form>


<div id="res"></div>
