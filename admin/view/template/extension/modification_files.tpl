<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th bgcolor="#f5f5f5" class="text-center"><?php echo $text_file; ?></th>
                <th bgcolor="#f5f5f5" class="text-center"><?php echo $text_modifications; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($modified_files) > 0) { ?>
              <?php foreach ($modified_files as $modified_file) { ?>
              <tr>
                <td style="vertical-align:top"><?php echo $modified_file['file']; ?></td>
                <td>
                  <?php if ($modified_file['modifications']) { ?>
                  <?php $i = 0; ?>
                  <?php foreach ($modified_file['modifications'] as $modification) { ?>
                  <?php if ($i > 0) { echo '<br /><br />'; } ?>
                  <strong><?php echo $text_modification; ?></strong> <?php echo $modification['name']; ?><br />
                  <strong><?php echo $text_version; ?></strong> <?php echo $modification['version']; ?><br />
                  <strong><?php echo $text_author; ?></strong> <?php echo $modification['author']; ?>
                  <?php $i++; ?>
                  <?php } ?>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="2"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>