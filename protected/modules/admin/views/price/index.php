<script type="text/javascript">
    $(function() {
        
        
        
	var baseUrl = '<? echo Yii::app()->createUrl('admin/price', array(
	    'pid' => ''
	)) ?>',
	    pid = <? echo $pid ?>;
	$('#add-price').click(function() {
	    $('#bg').show();
	    $('#add-price-dialog').show();
	    $('#add-price-dialog input[name="name"]').focus();
	});
	
	$('#bg').click(function() {
	    $('#bg').hide();
	    $('#add-price-dialog').hide().find('input[type="text"]').val('');
	});

	$('#add-price-dialog form').ajaxForm({
	    dataType: 'json',
	    beforeSubmit: function (d, f) {
		var form = $(f),
		    val = form.find('input[name="name"]').val();
		form.find('.err').html('');
		form.find('input[name="name"]').removeClass('error');
		if (val == '') {
		    form.find('.err').html('Поле "Название" не может быть пустым');
		    form.find('input[name="name"]').addClass('error');
		    return false;
		}
	    },
	    success: function(d) {
		var form = $('#add-price-dialog form');
		if (!d.error) {
		    document.location.href = baseUrl+d.pid;
		} else {
		    form.find('.err').html(d.msg);
		    form.find('input[name="name"]').addClass('error');
		}
	    }
	});
	
	$('#upload-price-form').ajaxForm({
	    dataType: 'json',
	    beforeSubmit: function (d, f) {
		var form = $(f),
		    type = form.find('input[name="type"]:checked').val(),
		    file = form.find('input[name="price"]').val();
		form.find('label').removeClass('error');
		form.find('input[name="price"]').removeClass('error');

		if (file == '') {
		    alert("Вы должны указать файл");
		    form.find('input[name="price"]').addClass('error');
                    return false;
		}
		$('#bg').unbind('click');
		$('#bg').show();
		$('#upload-status').show();
		return true;
	    },
	    success: function(d) {
                //console.log(d) ;
		$('#bg').hide();
		$('#upload-status').hide();
		$('#bg').click(function() {
		    $('#bg').hide();
		    $('#add-price-dialog').hide().find('input[type="text"]').val('');
		});
		if (!d.error) {
		    document.location.reload();
		} else {
		    $('#err-flash').html(d.msg).show();
		    setTimeout(function() {
			$('#err-flash').fadeOut(300);
		    }, 5000);
		}
	    }
	});
	
	$('.pr-delete').click(function() {
	    var name = $(this).attr('name');
	    return confirm("Будет удалёен прайс: \""+name+"\" и все запчасти, которые к нему относятся.\n\nПосле удаления данные невозможно будет восстановить.\n\nПродолжить?");
	});
    });
</script>
<div id="err-flash">Текст сообщения</div>
<section id="prices">
    <fieldset>
	<div>
	    <div class="left">
		<form method="POST" enctype="multipart/form-data" id="upload-price-form" action="<? echo Yii::app()->createUrl('admin/ajax/uploadprice') ?>">
		    <fieldset><legend>Форма загрузки</legend>
			<br><br>
			<input type="hidden" name="pid" value="<? echo $pid ?>"/>
			<input type="file" name="price"/>
			<input type="submit" value="Загрузить прайс" <? if($pid == 0) echo 'disabled' ?>/>
		    </fieldset>
		</form>
	    </div>
	    <div class="mt10 right">
		<br><br><br>
		<input type="button" value="Добавить прайс" id="add-price"/>&nbsp;
	    </div>
	    <div class="both"></div>
	    <div class="mt5">
		<table cellpadding="0" cellspacing="2">
		    <thead>
			<tr>
			    <td>ID</td>
			    <td>Название</td>
			    <td>Пользователь</td>
			    <td>Создан</td>
			    <td>Обновлён</td>
			    <td>Кол-во</td>
			    <td></td>
			    <td></td>
			</tr>
		    </thead>
		    <tbody>
			<? foreach ($priceList as $i => $price): ?>
			<tr class="<? if ($i%2 == 0) echo 'gray' ?> <? if ($pid == $price['pid']) echo 'active' ?>" >
			    <td><? echo $price['pid'] ?></td>
			    <td><? echo $price['name'] ?></td>
			    <td><? echo $price['login'] ?></td>
			    <td><? echo $price['created'] ?></td>
			    <td><? echo $price['updated'] ?></td>
			    <td><? echo $price['parts_count'] ?></td>
			    <td><a href="<? echo Yii::app()->createUrl('admin/price', array(
				'pid' => $price['pid']
			    )) ?>">Выбрать</a></td>
			    <td><a name="<? echo $price['name'] ?>" class="pr-delete" href="<? echo Yii::app()->createUrl('admin/price/deleteprice', array(
				'pid' => $price['pid']
			    )) ?>">Удалить</a></td>
			</tr>
			<? endforeach ?>
		    </tbody>
		</table>
	    </div>
	</div>
    </fieldset>
</section>
<div id="upload-status">
    <div>Идёт загрузка<br>Пожалуйста, подождите</div>
    <img width="128" height="128" src="<? echo Yii::app()->baseUrl . '/static/img/al.gif' ?>" />
</div>
<div id="add-price-dialog">
    <form method="POST" action="<? echo Yii::app()->createUrl('admin/ajax/createprice') ?>">
	<div>
	    <div class="err"></div>
	    <span class="t75">Название:</span>
	    <input type="text" name="name"/>
	</div>
	<div class="mt10">
	    <input type="submit" value="Создать"/>
	</div>
    </form>
</div>