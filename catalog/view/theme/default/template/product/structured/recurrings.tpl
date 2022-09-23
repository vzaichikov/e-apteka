								<?php if ($recurrings) { ?>
									<hr>
									<h3><?php echo $text_payment_recurring; ?></h3>
									<div class="form-group required">
										<select name="recurring_id" class="form-control">
											<option value=""><?php echo $text_select; ?></option>
											<?php foreach ($recurrings as $recurring) { ?>
												<option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
											<?php } ?>
										</select>
										<div class="help-block" id="recurring-description"></div>
									</div>
								<?php } ?>