<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); 

$subpages = Page::getCurrentPage()->getCollectionChildren();
$numPages = 0;

$thisLanguage = Localization::activeLanguage();

class CgLib {
public static function getFileList ( $setName, $orderKey = 'fID' ) {
    $fs = FileSet::getByName( $setName );
    if ( !is_object( $fs) ) {
        $fs = FileSet::getByID( $setName );
        if ( !is_object( $fs ) ) { return; }
    }
    $fl = new FileList();
    $fl->filterBySet( $fs );
    if ( is_object(FileAttributeKey::getByHandle($orderKey) ) ) {
        $fl->sortByAttributeKey( $orderKey);
    } else {
        $fl->sortBy( $orderKey );
    }
    $getFileList = $fl->get();
    return $getFileList;
}
}

?>

<main class="slide">

    <div id="instant_peace">
        <img class="instant-peace-on instant-peace" src="<?=$this->getThemePath()?>/images/instant-peace.png" border="0" title="Click here for instant access to peace!">
    <div id="languageSelection" class="" style="position: relative; z-index: 100;width: 100%;text-align: center">
            <?php
            $a = new Area('Language Selection');
            $a->setBlockLimit(1);
            $a->display($c);
            ?>
    </div></div>
    

    
    <!-- BACKGROUND -->
    <div id="background" class="instant-peace-off">

        <?php
        foreach ( $subpages as $subpage ) {

            if ( !$subpage->isAdminArea() ) { 

                $numPages++;
                    
                # get the areas from the subpage
                $background_area =  \Concrete\Core\Area\Area::get($subpage, 'Background');

                if ( is_object( $background_area ) ) {

                    $background_blocks = $background_area->getAreaBlocksArray($subpage);

                    if ( count( $background_blocks) ) { 
                        ?><div class="background" id="background_<?php echo $subpage->getCollectionID(); ?>"><?php
                            $background_blocks[0]->display('view');
                        ?></div><?php 
                    }

                }

            }
            
        }
        ?>

    </div>

    <!-- THUMBS -->
    <div id="thumbs" class="instant-peace">
        <div id="thumbs-wrapper">

        <?php
        foreach ( $subpages as $subpage ) {

            if ( !$subpage->isAdminArea() && !$subpage->isSystemPage() ) { 

                $de = strtolower( $subpage->getCollectionName() );
                $ar = strtolower( $subpage->getCollectionAttributeValue('name_arabic'));
                $he = strtolower( $subpage->getCollectionAttributeValue('name_hebrew'));
                $it = strtolower( $subpage->getCollectionAttributeValue('name_italian'));
                $letter = strtoupper( substr( $de, 0, 1) ); 
                ?>

                <div class="thumb" id="thumb_<?php echo $subpage->getCollectionID(); ?>" title="">
                    <div class="square"></div>
                    <div class="letter"><?php echo $letter; ?></div>
                    <div class="tags">
                        <div class="tag-de latin"><?php echo $de; ?></div>
                        <div class="tag-ar arabic" lang="ar"><?php echo $ar; ?></div>
                        <div class="tag-he hebrew" lang="he"><?php echo $he; ?></div>
                        <div class="tag-it latin" lang="it"><?php echo $it; ?></div>
                    </div>
                </div>

            <?php
            }

        }
        ?>
        </div>
    </div>


    <!-- CONTENT -->
    <!--<div id="content"></div>-->

    <div id="content" class="instant-peace">
        <?php        

            foreach ( $subpages as $subpage ) {
                if ( !$subpage->isAdminArea() ) { 
                            
                    $content_area =  \Concrete\Core\Area\Area::get($subpage, 'Content');
                    $content_left_area =  \Concrete\Core\Area\Area::get($subpage, 'Content Left');
                    $content_right_area =  \Concrete\Core\Area\Area::get($subpage, 'Content Right');

                    $gallery_mode_on = $subpage->getCollectionAttributeValue('gallery_mode_on');
                    # get a list of all file-objects of the choosen set in the chosen order
                    $galleryImages = CgLib::getFileList( $subpage->getCollectionName() );
                    


                    if ( is_object($content_area) ) {
                        $content_blocks = $content_area->getAreaBlocksArray($subpage); 
                        $content_left_blocks = $content_left_area->getAreaBlocksArray($subpage); 
                        $content_right_blocks = $content_right_area->getAreaBlocksArray($subpage); ?>

                        <div class="content-item" title="<?php echo $subpage->getCollectionName(); ?>" id="content_<?php echo $subpage->getCollectionID(); ?>">
                            <div class="content-wrapper">
                                <div class="content-colum left">
                                    <?php foreach ( $content_left_blocks as $block ) {
                                        $h = $block->getBlockTypeHandle();
                                        echo '<div class="content-block ';
                                        echo " content-" . $h . " ";
                                        echo '">';
                                        $block->display('view');
                                        echo "</div>";
                                    } ?>
                                    <?php if ( $gallery_mode_on ) { ?>
                                        <div class="gallery-colum">
                                        <?php $spaltenindex = 0; foreach ( $galleryImages as $image ) { if ( $spaltenindex % 3 == 0 ) { 
                                            if ( $thisLanguage == 'de' ) {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getDescription(), '<em><strong><i><u><span><a>');
                                            } else {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getAttribute('description_' . $thisLanguage ), '<em><strong><i><u><span><a>');
                                            }
                                            ?>
                                            <div class="content-block content-gallery">
                                                    <img src="<?php echo $image->getRelativePathFromID($image->getFileID()); ?>" >
                                                    <?php if ( $imageSubtitle ) { ?><p class="gallery-subtitle"><?php echo $imageSubtitle ?></p><?php } ?>
                                            </div>
                                        <?php } $spaltenindex++; } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="content-colum center">
                                    <div class="content-block tags-block instant-peace-on" title="Click here for instant transfer to peace!">
                                        <span lang="de" class="latin"><?php echo $subpage->getCollectionName(); ?></span><br />
                                        <span lang="ar" class="arabic"><?php echo $subpage->getCollectionAttributeValue('name_arabic'); ?></span><br />
                                        <span lang="he" class="hebrew"><?php echo $subpage->getCollectionAttributeValue('name_hebrew'); ?></span><br />
                                        <span lang="it" class="latin"><?php echo $subpage->getCollectionAttributeValue('name_italian'); ?></span><br />
                                    </div>
                                    <?php foreach ( $content_blocks as $block ) {
                                        $h = $block->getBlockTypeHandle();
                                        echo '<div class="content-block ';
                                        echo " content-" . $h . " ";
                                        echo '">';
                                        $block->display('view');
                                        echo "</div>";
                                    } ?>
                                    <?php if ( $gallery_mode_on ) { ?>
                                        <div class="gallery-colum">
                                        <?php $spaltenindex = 0; foreach ( $galleryImages as $image ) { if ( $spaltenindex % 3 == 1 ) { 
                                            if ( $thisLanguage == 'de' ) {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getDescription(), '<em><strong><i><u><span><a>');
                                            } else {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getAttribute('description_' . $thisLanguage ), '<em><strong><i><u><span><a>');
                                            }
                                            ?>
                                            <div class="content-block content-gallery">
                                                    <img src="<?php echo $image->getRelativePathFromID($image->getFileID()); ?>" >
                                                    <?php if ( $imageSubtitle ) { ?><p class="gallery-subtitle"><?php echo $imageSubtitle ?></p><?php } ?>
                                            </div>
                                        <?php } $spaltenindex++; } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="content-colum right">
                                    <?php foreach ( $content_right_blocks as $block ) {
                                        $h = $block->getBlockTypeHandle();
                                        echo '<div class="content-block ';
                                        echo " content-" . $h . " ";
                                        echo '">';
                                        $block->display('view');
                                        echo "</div>";
                                    } ?>
                                    <?php if ( $gallery_mode_on ) { ?>
                                        <div class="gallery-colum">
                                        <?php $spaltenindex = 0; foreach ( $galleryImages as $image ) { if ( $spaltenindex % 3 == 2 ) {
                                             if ( $thisLanguage == 'de' ) {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getDescription(), '<em><strong><i><u><span><a>');
                                            } else {
                                                $imageSubtitle = strip_tags($image->getApprovedVersion()->getAttribute('description_' . $thisLanguage ), '<em><strong><i><u><span><a>');
                                            }
                                            ?>
                                            <div class="content-block content-gallery">
                                                    <img src="<?php echo $image->getRelativePathFromID($image->getFileID()); ?>" >
                                                    <?php if ( $imageSubtitle ) { ?><p class="gallery-subtitle"><?php echo $imageSubtitle ?></p><?php } ?>
                                            </div>
                                        <?php } $spaltenindex++; } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="impressum">
                                    Impressum<br>
                                    Verantwortlich für den Inhalt: Issam A. Karim, Am Kochenhof 3, 70192 Stuttgart, issam@1strich1.de<br>
                                    English translation: Glenda Maier - 
                                    Design & Code: <a href="http://www.cgrauer.de">christian grauer | infosophie</a> -
                                    CMS: <a href="http://www.concrete5.org">concrete5</a>
                                 </div>
                            
                           </div>
                        </div>    
                                        <?php }

                }
            }

        ?>



</div>

</main>


<?php  $this->inc('elements/footer.php'); ?>
