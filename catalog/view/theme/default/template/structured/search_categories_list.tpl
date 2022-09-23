<?php if ($top_found_cmas) { ?>
	<div class="row col-md-12" style="margin-bottom:10px;">
		<div class="tags">
			<div class="tags__row">
				<?php foreach ($top_found_cmas as $top_found_cma) { ?>		
					<a href="<? echo $top_found_cma['href']; ?>" class="tags__link subcategory-intersection <? if($top_found_cma['active']) { ?>active<? } ?>" ><? echo $top_found_cma['name']; ?> 
						<?php if (!empty($top_found_cma['count'])) { ?><span class="badge badge-info"><? echo $top_found_cma['count']; ?></span><? } ?>
					</a>				
				<? } ?>				 
			</div>
		</div>
	</div>	
<?php } ?>
