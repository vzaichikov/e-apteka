<div id="carousel<?php echo $module; ?>" class="owl-carousel carousel">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="item__image img-responsive" width="60" height="45">
    <div class="item__title"><?php echo $banner['title']; ?></div>
    <div class="item__text"><?php echo $banner['text1']; ?></div>
    <?php if ($banner['link']) { ?>
      <a href="<?php echo $banner['link']; ?>" class="item__link"><?php echo $banner['text3']; ?> <svg class="icon item__link-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#arrow-pointing-to-right"></use></svg></a>
    <?php } ?>
  </div>
  <?php } ?>
</div>
