<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php'); 
$gallery_mode_on = Page::getCurrentPage()->getCollectionAttributeValue('gallery_mode_on');
$c = Page::getCurrentPage();
?>

<main class="slide slide-subpage">


<div class="h1">Subpage: <?php echo $c->getCollectionName(); ?></div>

    <div class="content-wrapper">
        <div class="content-colum left">

            <div class="h2">Text for Thumbnail</div>
            <div id="sub_thumb" class="content-area">
                &mdash;&gt; Page Settings<br />
                <strong><?php echo $c->getCollectionName(); ?></strong><br />
                <strong lang="ar" class="arabic"><?php echo $c->getCollectionAttributeValue('name_arabic'); ?></strong><br />
                <strong lang="he" class="hebrew"><?php echo $c->getCollectionAttributeValue('name_hebrew'); ?></strong><br />
                <strong lang="it" class="latin"><?php echo $c->getCollectionAttributeValue('name_italian'); ?></strong><br />
            </div>

        </div>
        <div class="content-colum center">

            <div class="h2">Background Image</div>
            <div id="sub_background" class="content-area">
            <?php
            $a = new Area('Background');
            $a->setBlockLimit(1);
            $a->display($c);
            ?>
            </div>

        </div>
    </div>

<div class="h2">Content</div>

    <div class="content-wrapper">
        <div class="content-colum left">

            <?php if ( $gallery_mode_on ) { ?> <h2>This page uses the gallery mode!</h2> <?php } ?>

            <?php
            $a = new Area('Content Left');
            $a->display($c);
            ?>

        </div>
        <div class="content-colum center">

            <?php if ( $gallery_mode_on ) { ?> <h2>This page uses the gallery mode!</h2> <?php } ?>
            <?php
            $a = new Area('Content');
            $a->display($c);
            ?>

        </div>

        <div class="content-colum right">

            <?php if ( $gallery_mode_on ) { ?> <h2>This page uses the gallery mode!</h2> <?php } ?>
            <?php
            $a = new Area('Content Right');
            $a->display($c);
            ?>

        </div>
    </div>


</main>

<?php  $this->inc('elements/footer_bottom.php'); ?>
