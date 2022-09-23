<div class="row">
	<div class="col-md-12">
		<div class="sort-row">
			<div class="btn-group btn-group-sm prod-list-view hidden-xs">
				<button type="button" id="grid-view" class="prod-list-view__btn" data-toggle="tooltip" title="<?php echo $button_grid; ?>">
					<svg class="icon prod-list-view__icon prod-list-view__icon--grid">
					<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#grid-view"></use>
				</svg>
			</button>
			<button type="button" id="list-view" class="prod-list-view__btn" data-toggle="tooltip" title="<?php echo $button_list; ?>">
				<svg class="icon prod-list-view__icon prod-list-view__icon--list">
				<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#list-view"></use>
			</svg>
		</button>
	</div>
	
	<?php if (false) { ?>
		<div class="col-md-3 col-sm-6">
			<div class="form-group">
				<a href="<?php echo $compare; ?>" id="compare-total" class="btn btn-link"><?php echo $text_compare; ?></a>
			</div>
		</div>
	<?php } ?>

<?php /*	
	<div class="form-group input-group input-group-sm form-group-select form-group-select--input-limit pull-right">
		<label class="input-group-addon" for="input-limit"><?php echo $text_limit; ?></label>
		<div class="select-wrap">
			<select id="input-limit" class="form-control" onchange="location = this.value;">
				<?php foreach ($limits as $limits) { ?>
					<?php if ($limits['value'] == $limit) { ?>
						<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
					<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
*/ ?>
	<div class="form-group input-group input-group-sm form-group-select form-group-select--input-sort pull-right">
		<label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
		<div class="select-wrap">
			<select id="input-sort" class="form-control" onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
					<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
						<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
					<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
	
</div>
</div>
</div>