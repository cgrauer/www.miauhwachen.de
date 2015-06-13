<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo Localization::activeLanguage()?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/c95cc8fd-bded-4a6b-8345-733cf6a18a25.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getThemePath()?>/css/bootstrap-modified.css">
    <?php echo $html->css($view->getStylesheet('main.less'))?>
    <?php Loader::element('header_required', array('pageTitle' => $pageTitle));?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style')
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            )
            document.querySelector('head').appendChild(msViewportStyle)
        }
    </script>
<!--    <script type="text/javascript" src="<?php echo $this->getThemePath()?>/js/jquery.fullscreen-0.4.2.js"></script>-->
</head>
<body>

<div class="<?php echo $c->getPageWrapperClass()?>">
