<table class="table">	
	<tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $entry_code; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $entry_code_help; ?></span>
         </td>
		<td>
            <div class="col-xs-3">
                <select name="previousnextproduct[Enabled]" class="PreviousNextProductEnabled form-control">
                    <option value="true" <?php echo (empty($data['previousnextproduct']['Enabled']) || $data['previousnextproduct']['Enabled'] == 'true') ? 'selected=selected' : ''?>><?php echo $text_enabled; ?></option>
                    <option value="false" <?php echo (empty($data['previousnextproduct']['Enabled']) || $data['previousnextproduct']['Enabled'] == 'false') ? 'selected=selected' : ''?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
		</td>
	</tr>
    <tr>    
    	<td><h5><strong><span class="required">*</span><?php echo $entry_sort_by; ?></strong></h5></td>
        <td>
            <div class="col-xs-3">
                <select name="previousnextproduct[SortBy]" class="form-control">
                    <option value="p.sort_order;ASC"><?php echo $value_default; ?></option>
                    <option value="pd.name;ASC"><?php echo $value_name_asc; ?></option>
                    <option value="pd.name;DESC"><?php echo $value_name_desc; ?></option>
                    <option value="p.price;ASC" selected="selected"><?php echo $value_price_asc; ?></option>
                    <option value="p.price;DESC"><?php echo $value_price_desc; ?></option>
                    <option value="rating;DESC"><?php echo $value_rating_asc; ?></option>
                    <option value="rating;ASC"><?php echo $value_rating_desc; ?></option>
                    <option value="p.model;ASC"><?php echo $value_model_asc; ?></option>
                    <option value="p.model;DESC"><?php echo $value_model_desc; ?></option>
                 </select>
             </div>
        </td>
    </tr>
    <tr>
    	<td><h5><strong><span class="required">*</span><?php echo $entry_position; ?></strong></h5></td>
        <td>
            <div class="col-xs-3">
                <select name="previousnextproduct[Position]" class="form-control">
                    <option value="left" selected="selected"><?php echo $value_position_left; ?></option>
                    <option value="center"><?php echo $value_position_center; ?></option>
                    <option value="right"><?php echo $value_position_right; ?></option>
                 </select>
             </div>
        </td>
    </tr>
    <tr>
		<td><h5><strong><span class="required">*</span><?php echo $entry_design; ?></strong></h5></td>     
        <td>
            <div class="col-xs-3">
                <select name="previousnextproduct[Design]" class="form-control">
                    <option value="standard" selected="selected"><?php echo $value_design_standard; ?></option>
                    <option value="silver"><?php echo $value_design_silver; ?></option>
                    <option value="nodesign"><?php echo $value_design_nodesign; ?></option>
                 </select>
             </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">*</span><?php echo $text_display_images; ?></strong></h5>
         </td>
		<td>
            <div class="col-xs-3">
                <select name="previousnextproduct[DisplayImages]" class="PreviousNextProductDisplayImages form-control">
                    <option value="true" <?php echo (empty($data['previousnextproduct']['DisplayImages']) || $data['previousnextproduct']['DisplayImages'] == 'true') ? 'selected=selected' : ''?>><?php echo $text_enabled; ?></option>
                    <option value="false" <?php echo (empty($data['previousnextproduct']['DisplayImages']) || $data['previousnextproduct']['DisplayImages'] == 'false') ? 'selected=selected' : ''?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
		</td>
	</tr>
     <tr>	
    	<td><h5><strong><span class="required">*</span><?php echo $entry_custom_css; ?></strong></h5></td>
        <td>
            <div class="col-xs-4">
                <textarea name="previousnextproduct[CustomCSS]" class="form-control" placeholder="Enter your custom CSS here" cols="50" rows="5"><?php echo !empty($data['previousnextproduct']['CustomCSS']) ? $data['previousnextproduct']['CustomCSS'] : ''; ?></textarea>
                </td>
            </div>
    </tr>
</table>

<script type="text/javascript">
	$("select[name='previousnextproduct[SortBy]'] option[value='<?php echo $data['previousnextproduct']['SortBy']; ?>']").attr('selected', true);
	$("select[name='previousnextproduct[Position]'] option[value='<?php echo $data['previousnextproduct']['Position']; ?>']").attr('selected', true);
	$("select[name='previousnextproduct[Design]'] option[value='<?php echo $data['previousnextproduct']['Design']; ?>']").attr('selected', true);
</script>