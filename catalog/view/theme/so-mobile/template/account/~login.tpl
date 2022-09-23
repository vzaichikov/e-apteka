<?php echo $header; ?>
<div class="container">

  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="tab-account">
        <div class="icon-custom"></div>
        <ul class="nav nav-tabs segmented-control">
          <li class="active"><a class="platform-switch control-item" data-toggle="tab" href="#home">Login</a></li>
          <li><a class="platform-switch control-item" data-toggle="tab" href="#menu1">Registed</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <div class="col-sm-12">
              <div class="well-full form-login">
                <h2 class="hidden"><?php echo $text_returning_customer; ?></h2>
                <p class="hidden"><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group form-user">
                    <label class="control-label font-ct" for="input-email"><?php echo $entry_email; ?></label>
                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                  </div>
                  <div class="form-group form-pw">
                    <label class="control-label font-ct" for="input-password"><?php echo $entry_password; ?></label>
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                    <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
                  <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" />
                  <?php if ($redirect) { ?>
                  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                  <?php } ?>
                </form>
              </div>
            </div>
          </div>
          <div id="menu1" class="tab-pane fade">
            <div class="col-sm-12">
              <div class="well-full">
                <h2 class="hidden"><?php echo $text_new_customer; ?></h2>
                <p><strong class="font-ct"><?php echo $text_register; ?></strong></p>
                <p style="margin-bottom: 2em;"><?php echo $text_register_account; ?></p>
                <a href="<?php echo $register; ?>" class="btn btn-sn"><?php echo $button_continue; ?></a></div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>