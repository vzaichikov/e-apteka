<div class="superproducts_tabs">
    <ul class="nav nav-tabs">
        <?php $n =0; foreach($tabs as $tab) { ?>
            <li<?php if (!$n) { ?> class="active"<?php } ?>><a href="#<?php echo $tab['id']; ?>" data-toggle="tab"><?php echo $tab['head']; ?></a></li>
        <?php $n++; } ?>
    </ul>
    <div class="tab-content">
        <?php $n =0; foreach($tabs as $tab) { ?>
            <div class="tab-pane<?php if (!$n) { ?> active<?php } ?>" id="<?php echo $tab['id']; ?>">
                <?php if ($viewlink_pos && $tab['link']) { ?><div class="clearfix" style="text-align: right; padding-bottom: 10px;"><?php echo $tab['link']; ?></div><?php } ?>
                <?php echo $tab['body']; ?>
                <?php if (!$viewlink_pos && $tab['link']) { ?><div class="clearfix" style="padding: 8px; border: 1px solid #eee; margin-bottom: 20px; text-align: center;"><?php echo $tab['link']; ?></div><?php } ?>
            </div>
        <?php $n++; } ?>
    </div>
</div>