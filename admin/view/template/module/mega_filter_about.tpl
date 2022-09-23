<?php require DIR_TEMPLATE . 'module/' . $_name . '-header.tpl'; ?>

<table class="table">
	<thead>
		<tr>
			<td colspan="2"><?php echo $heading_title; ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="200"><?php echo $entry_ext_version; ?></td>
			<td><?php echo $ext_version; ?></td>
			<td rowspan="<?php echo ! empty( $plus_version ) ? 6 : 5; ?>" width="50%" style="border-left: 1px solid #dddddd;" class="text-center">
				<h2 style="font-size: 16px; margin: 0; text-decoration: underline; padding: 10px 0;"><?php echo $text_if_something_doesnt_work; ?></h2>
				
				<table style="width: 100%; margin-top: 15px;" class="text-left">
					<tr>
						<td style="width: 50%; vertical-align: top;" class="text-center">
							<center><strong>VQMod</strong> (if you have)</center><br />
							
							To clear the cache of VQMod please remove the following files:<br /><br />

							<code>/vqmod/checked.cache<br />/vqmod/mods.cache</code><br /><br />

							and all files in the folder:<br /><br />

							<code>/vqmod/vqcache</code>
						</td>
						<td style="border-left: 1px solid #dddddd; padding-left: 10px; vertical-align: top;" class="text-center">
							<center><strong>OCMod</strong></center><br />
							
							In Main Menu -&gt; go to -&gt; Extensions -&gt; Modifications -&gt; and click the button CLEAR &amp; REFRESH
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if( ! empty( $plus_version ) ) { ?>
			<tr>
				<td><?php echo $entry_plus_version; ?></td>
				<td>
					<?php echo $plus_version; ?>
					-
					<a href="<?php echo $action_rebuild_index; ?>" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-retweet"></i> <?php echo $text_rebuild_index; ?></a>
				</td>
			</tr>
		<?php } ?>
		<?php if( ! empty( $mfp_language_pack_version ) ) { ?>
			<tr>
				<td><?php echo $entry_language_pack_version; ?></td>
				<td><?php echo $mfp_language_pack_version; ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td><?php echo $entry_email; ?></td>
			<td><?php echo $ext_email; ?></td>
		</tr>
		<tr>
			<td><?php echo $entry_forum; ?></td>
			<td><a href="http://forum.ocdemo.eu" target="_blank">http://forum.ocdemo.eu</a></td>
		</tr>
		<tr>
			<td><?php echo $entry_support; ?></td>
			<td><a href="http://support.ocdemo.eu" target="_blank">http://support.ocdemo.eu</a></td>
		</tr>
		<tr>
			<td><?php echo $entry_documentation; ?></td>
			<td><a href="http://mfp.ocdemo.eu/docs" target="_blank">http://mfp.ocdemo.eu/docs</a></td>
		</tr>
		<tr>
			<td colspan="2" style="border-right: 1px solid #dddddd;"></td>
			<td width="50%" class="text-center">
				<table style="width: 100%;" class="text-left">
					<tr>
						<?php if( $template ) { ?>
							<td style="width: 50%; vertical-align: top; border-right: 1px solid #dddddd;" class="text-center">
								<h2 style="font-size: 14px; margin: 0; padding: 10px 0;">Do you have a conflict with the template <b>"<?php echo $template; ?>"</b> ?</h2>
								<br />
								<a href="<?php echo $template_url; ?>" target="_blank" class="btn btn-primary btn-sm">Click here to check if we have a ready-made solution</a>
							</td>
						<?php } ?>
						<td style="padding-left: 10px; vertical-align: top;" class="text-center"><br />
							<h2 style="margin: 0;"><?php echo $text_need_support; ?></h2>
							<br />
							<a href="http://support.ocdemo.eu" target="_blank" class="btn btn-primary"><?php echo $text_open_ticket; ?></a><br /><br />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
			
<?php require DIR_TEMPLATE . 'module/' . $_name . '-footer.tpl'; ?>