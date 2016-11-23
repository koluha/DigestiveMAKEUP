<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <?php
        // echo Yii::app()->basePath;
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile(CHtml::asset(Yii::app()->basePath . '/modules/admin/a_static/css/form.css', true));
        $cs->registerCssFile(CHtml::asset(Yii::app()->basePath.'/modules/admin/a_static/css/main.css', true));
        $cs->registerScriptFile(CHtml::asset(Yii::app()->basePath . '/modules/admin/a_static/js/main.js', true), CClientScript::POS_HEAD);
        $cs->registerScriptFile(CHtml::asset(Yii::app()->basePath . '/modules/admin/a_static/js/popup.js', true), CClientScript::POS_HEAD);
         $cs->registerScriptFile(Yii::app()->baseUrl . '/static/js/jquery.form.js', CClientScript::POS_HEAD);
        $cs->registerPackage('jquery');
        $cs->registerPackage('jquery.ui');
          
        ?>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            </div><!-- header -->

            <div id="mainmenu">
                <?php $this->widget('application.modules.admin.widgets.TopMenu'); ?>
            </div><!-- mainmenu -->
            <br/>
            <div id="content">
                <?php echo $content; ?>
            </div>
            <div id="footer">

            </div><!-- footer -->

        </div><!-- page -->

        <div id="bg"></div>
    </body>
</html>