<?php
    defined('C5_EXECUTE') or die("Access Denied.");
    $c = Page::getCurrentPage();
    if (!$content && is_object($c) && $c->isEditMode()) { ?>
        <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Content Block.')?></div> 
    <?php } else { ?>
        <div class="content-block-grey-box content-block-wrapper">
            <?php print $content; ?>
        </div>
        <?php
    }