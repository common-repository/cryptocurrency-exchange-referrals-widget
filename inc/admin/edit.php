<div class="wrapper-ccer">
	<span>&nbsp;</span>
	<h2>Referrals Widget</h2>
</div>
<?php if ( isset( $_GET['alert-updated'] ) ) { ?>
<div class="wrap">
	<div id="message" class="updated">
		<p><strong><?php _e('Settings saved.') ?></strong></p>
	</div>
</div>
<?php } ?>

<div class="wrap">
	<p>Edit or remove your referrals creatives</p>
	<div class="tool-box">
		<form name="cc_e_r_w_form_edit" action="admin.php?page=cc_e_r_w_menu_edit" method="post">
			<input type='hidden' name='ccew_img_attachment_id' id='ccew_img_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
			<input type="hidden" name="cc_e_r_w_form_edit" value="1">
			<?php
			wp_nonce_field( 'cc_e_r_w_form_edit' );	
			?>

			<div class="metabox-holder">
				<div class="postbox" style="width:100%">
					<h3><span>List of your referrals links</span></h3>
					<div class="inside">
						<table class="form-table">
							<tbody>
								<tr>
									<th><label> Title: </label></th>
									<th><label> Link: </label></th>
									<th><label> Image: </label></th>
									<th><label> Description: </label></th>
									<th><label> Delete: </label></th>
								</tr>
								<?php
								foreach ($creatives as $key => $value) {
									?>
									<tr>
										<td><label> <?php echo $value['ccew_title']; ?> </label></td>
										<td><label> <?php echo $value['ccew_link']; ?> </label></td>
										<td><label> <?php echo wp_get_attachment_image($value['ccew_img_attachment_id']); ?> </label></td>
										<td><label> <?php echo $value['ccew_description']; ?> </label></td>
										<td><label> <input type="checkbox" name="check_list[]" value="<?php echo $key;?>"></td>
									</tr>
									<?php
									
								} ?>
								<tr>
									<th></th>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<input type="submit" class="button-primary" value="<?php _e('Save'); ?>">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</from>
	</div>
</div>
