<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $upload; ?>">
          <div class="form-group">           
            <div class="col-sm-12">
              <input type="file" class="custom-file-input" id="file" name="file" accept=".xlsx">
              <button class="btn btn-primary" type="submit" class="btn btn-default">Загрузить реестр Ehealth/Скарб</button>
            </div>
          </div>
        </form>   
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                  <a class="btn btn-danger" href="<?php echo $filter_morion_not_found; ?>">Морион EH не найден в AГП</a>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group">
                  <a class="btn btn-danger" href="<?php echo $filter_regnumber_not_found; ?>">Морион РЕГ не найден в AГП</a>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group">
                  <a class="btn btn-warning" href="<?php echo $filter_many_products_found; ?>">Найдено несколько товаров</a>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group">
                  <a class="btn btn-success" href="<?php echo $canonical; ?>">Без фильтра</a>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group">
                  <button class="btn btn-success" onclick="getOutput();">Обновить привязки</button>
              </div>
            </div>
          </div>
        </div>

        <div id="output" style="max-height:300px; overflow-y:scroll;">
        </div>

        <script>
          function getOutput() {
            var outputDiv = document.getElementById("output");
            var xhr = new XMLHttpRequest();  
            xhr.open("GET", "<?php echo htmlspecialchars_decode($parseehealth); ?>", true);
            xhr.responseType = "text";
            xhr.onreadystatechange = function() {
              if (this.readyState === 4 && this.status === 200) {
                outputDiv.innerHTML += this.responseText;
                outputDiv.scrollTop = outputDiv.scrollHeight;
              }
            };
            xhr.send();
          }
        </script>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-ehealth">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left" colspan="4">Данные в реестре Ehealth</td>
                  <td class="text-center">
                    <i class="fa fa-arrow-right"></i>
                  </td>
                  <td class="text-left" colspan="4">Данные в базе АГП</td>
                </tr>
                <tr>
                  <td class="text-left">
                    Название
                  </td>
                  <td class="text-left">
                    Морион
                  </td>
                  <td class="text-left">
                    Регномер
                  </td>
                  <td class="text-left">
                    Производитель
                  </td>
                  <td class="text-center">
                    <i class="fa fa-arrow-right"></i>
                  </td>
                  <td class="text-left">
                    Товар
                  </td>
                  <td class="text-left">
                    Морион
                  </td>
                  <td class="text-left">
                    Регномер
                  </td>
                  <td class="text-left">
                    Производитель
                  </td>
                </tr>
              </thead>
              <tbody>
                <?php if ($ehealths) { ?>
                <?php foreach ($ehealths as $ehealth) { ?>
                <tr>
                  <td class="text-left">    
                    <?php echo $ehealth['trade_name']; ?>
                    <br />
                    <span class="label label-success"><?php echo $ehealth['pack']; ?></span>                      
                    <span class="label label-warning">Доз <?php echo $ehealth['package_qty']; ?></span>            
                    <span class="label label-danger">Мин <?php echo $ehealth['package_min_qty']; ?></span>

                    <?php if  ($ehealth['pack_number']) { ?>
                      <span class="label label-success"><?php echo $ehealth['pack_number']; ?></span> 
                    <?php } ?>      

                    <?php if  ($ehealth['dosage']) { ?>
                      <span class="label label-info"><?php echo $ehealth['dosage']; ?></span> 
                    <?php } ?>   

                    <?php if  ($ehealth['dosage2']) { ?>
                      <span class="label label-info"><?php echo $ehealth['dosage2']; ?></span> 
                    <?php } ?> 
                  </td>
                  <td class="left" style="width:90px;">
                    <?php echo $ehealth['morion_code']; ?>

                    <br />
                      <?php if ($ehealth['morion_exists'] && $ehealth['morion_exists'] == 1) { ?>
                        <small class="text-success"><i class="fa fa-check-circle text-success"></i> 1 товар</small>
                      <?php } elseif ($ehealth['morion_exists'] && $ehealth['morion_exists'] > 1) { ?>
                        <small class="text-danger"><i class="fa fa-exclamation-circle text-danger"></i> <?php echo $ehealth['morion_exists']; ?> товара</small>
                      <?php } else { ?>
                        <small class="text-danger"><i class="fa fa-exclamation-circle text-danger"></i> не найден</small>
                      <?php } ?>
                    </small>
                  </td>

                  <td class="text-left" style="width:110px;">
                      <?php echo $ehealth['reg_number']; ?>

                      <br />
                      <?php if ($ehealth['regnumber_exists'] && $ehealth['regnumber_exists'] == 1) { ?>
                        <small class="text-success"><i class="fa fa-check-circle text-success"></i> 1 товар</small>
                      <?php } elseif ($ehealth['regnumber_exists'] && $ehealth['regnumber_exists'] > 1) { ?>
                        <small class="text-warning"><i class="fa fa-exclamation-circle text-danger"></i> <?php echo $ehealth['regnumber_exists']; ?> товара</small>
                      <?php } else { ?>
                        <small class="text-danger"><i class="fa fa-exclamation-circle text-danger"></i> не найден</small>
                      <?php } ?>
                    </small>
                  </td>

                  <td class="text-left"  style="width:150px;"> 
                    <small><?php echo $ehealth['manufacturer']; ?></small>                   
                  </td>

                  <td class="text-center">
                    
                    <?php if ($ehealth['parse_info']) { ?>
                      <?php foreach ($ehealth['parse_info']['success'] as $success => $t) { ?>                        
                        <div class="label label-success" style="display: block; margin-bottom: 2px;"><?php echo $success; ?></div>
                      <?php } ?>

                      <?php foreach ($ehealth['parse_info']['error'] as $error => $t) { ?>       
                        <div class="label label-danger"  style="display: block;  margin-bottom: 2px;"><?php echo $error; ?></div>
                      <?php } ?>

                    <?php } ?>

                  </td>

                  <td class="text-left">
                    <?php if ($ehealth['product']) { ?>
                      <i class="fa fa-check-circle text-success"></i> <?php echo $ehealth['product']['name']; ?>

                      <br />
                      <?php if  (!$ehealth['product']['status']) { ?>
                        <span class="label label-danger"><i class="fa fa-exclamation-circle"></i> ОТКЛЮЧЕН</span> 
                      <?php } ?>

                      <?php if  ($ehealth['product']['upc']) { ?>
                        <span class="label label-success"><?php echo $ehealth['product']['upc']; ?></span>  
                      <?php } ?>

                      <?php if  ($ehealth['product']['pack_number']) { ?>
                        <span class="label label-success"><?php echo $ehealth['product']['pack_number']; ?></span> 
                      <?php } ?>      

                      <?php if  ($ehealth['product']['dosage']) { ?>
                        <span class="label label-info"><?php echo $ehealth['product']['dosage']; ?></span> 
                      <?php } ?>

                      <?php if  ($ehealth['product']['dosage2']) { ?>
                        <span class="label label-info"><?php echo $ehealth['product']['dosage2']; ?></span> 
                      <?php } ?>
                    <?php } ?>

                     <?php if ($ehealth['possible']) { ?>
                        <?php foreach ($ehealth['possible'] as $possible) { ?>
                          <div>
                            <i class="fa fa-question-circle text-info"></i> <?php echo $possible['name']; ?>
                            
                            <br />
                            <?php if (!$possible['status']) { ?>
                              <span class="label label-danger"><i class="fa fa-exclamation-circle"></i> ОТКЛЮЧЕН</span> 
                            <?php } ?>

                            <?php if  ($possible['upc'] && $possible['upc'] == $ehealth['morion_code']) { ?>
                              <span class="label label-success"><?php echo $possible['upc']; ?></span> 
                            <?php } elseif ($possible['upc']) { ?>
                              <span class="label label-warning"><?php echo $possible['upc']; ?></span> 
                            <?php } ?>

                            <?php if  ($possible['pack_number']) { ?>
                              <span class="label label-success"><?php echo $possible['pack_number']; ?></span> 
                            <?php } ?>      

                            <?php if  ($possible['dosage']) { ?>
                              <span class="label label-info"><?php echo $possible['dosage']; ?></span> 
                            <?php } ?>

                            <?php if  ($possible['dosage2']) { ?>
                              <span class="label label-info"><?php echo $possible['dosage2']; ?></span> 
                            <?php } ?>
                          </div>

                        <?php } ?>
                     <?php } ?>

                  </td>

                  <td class="text-left" style="width:90px;">
                    <?php if ($ehealth['product']) { ?>
                      <?php echo $ehealth['product']['upc']; ?><br />
                    <?php } ?>

                    <?php if ($ehealth['possible']) { ?>
                        <?php foreach ($ehealth['possible'] as $possible) { ?>
                            <?php echo $possible['upc']; ?><br />
                        <?php } ?>
                     <?php } ?>   
                  </td>

                  <td class="text-left" style="width:110px;">
                     <?php if ($ehealth['product']) { ?>
                      <?php echo $ehealth['product']['reg_number']; ?>
                    <?php } ?>
                  </td>

                  <td class="text-left" style="width:150px;">
                    <?php if ($ehealth['product']) { ?>
                      <small><?php echo $ehealth['product']['manufacturer']; ?></small>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
         <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>