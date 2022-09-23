<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
			<style>
            .table th, .table td {
                border-top:none;
                border-bottom: 1px solid #DDD;
            }
            #statistics .nmbrPurchasesTogether {
                font-size: 28px;
                width: 80px;
                vertical-align: middle;
                color: #333;
                padding-left: 20px;
            }
            </style>
            <table class="table">
              <tr>
                <th style="font-weight:normal;"><?php echo $purchases; ?></th>
                <th colspan="2" style="background:rgba(0, 136, 204,0.05);padding:10px;font-weight:normal;"><?php echo $viewed_together; ?></th>
              </tr>
            <?php foreach($alsoViewedStats as $pair): ?>  
              <tr>
                <td class="nmbrPurchasesTogether"><?php echo $pair['number']; ?></td>
                <td><a target="_blank" href="../index.php?route=product/product&product_id=<?php echo $pair['lowProduct']['product_id']; ?>"><img src="<?php echo $pair['lowProduct']['image']; ?>" style="margin-right:10px;border:none;" /><?php echo $pair['lowProduct']['name']; ?></a></td>
                <td><a target="_blank" href="../index.php?route=product/product&product_id=<?php echo $pair['lowProduct']['product_id']; ?>"><img src="<?php echo $pair['highProduct']['image']; ?>" style="margin-right:10px;border:none;" /><?php echo $pair['highProduct']['name']; ?></a></td>
              </tr>
            <?php endforeach; ?>
            </table>
        </div>
        <div class="col-md-4">
            <div class="box-heading">
              <h1><strong><i class="fa fa-info-circle"></i><?php echo $intelligent_sorting; ?></strong></h1>
            </div>
            <div class="box-content" style="min-height:100px; line-height:20px; border-top: 1px solid #CCCCCC;"><?php echo $intelligent_sorting_help; ?></div>
        </div>
   </div>
</div>