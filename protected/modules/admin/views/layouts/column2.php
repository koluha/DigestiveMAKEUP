<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Действия',
		));
		
		$this->endWidget();
	?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>