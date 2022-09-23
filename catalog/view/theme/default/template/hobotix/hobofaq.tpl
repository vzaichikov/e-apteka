<?php if (!empty($seo_table) || !empty($faq)) { ?>
	<style>
		.faq {margin-bottom:10px; padding:10px;}
		.faq .faq__products-table table tr td{font-size:12px;}
		.faq .faq__faq-answer{font-size:12px!important;}
		.faq .faq__faq-question{font-size:12px!important;}
		.faq .faq__faq-question:not(:first-child){margin-top:10px;}
		
	</style>
	<article class="faq">
		<div class="faq__products-table">
			
			<?php if (!empty($seo_table)) { ?>
				<h2><?php echo $text_seo_price_table_header; ?></h2>
				
				<div class="table-responsive">
					<table class="table table-striped">
						<?php foreach ($seo_table as $line) { ?>
							<tr>
								<td><?php echo $line['title']; ?></td>
								<td><?php echo $line['name']; ?></td>
								<td><?php echo $line['price']; ?></td>
							</tr>
						<?php } ?>
					</table>
				</div> 
				
			<?php } ?>
			
			<?php if (!empty($faq)) { ?>
				<div class="faq__faq-qa" itemscope="" itemtype="https://schema.org/FAQPage">
					<?php if ($faq_header) { ?>
						<h2>
							<?php echo $faq_header; ?>
						</h2>
					<?php } ?>					
					<?php foreach ($faq as $qa) { ?>
						<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="faq__faq-question">
							<h3 itemprop="name"><?php echo $qa['question']; ?></h3>
							<div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
								<div itemprop="text" class="faq__faq-answer">
									<?php echo $qa['answer']; ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>	
			<?php } ?>
		</div>
	</article>
<?php } ?>