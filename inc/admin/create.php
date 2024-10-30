<div class="wrapper-ccer">
	<span>&nbsp;</span>
	<h2>Referrals Widget</h2>
</div>
<?php

if ( isset( $_GET['modal'] ) && ($_GET['modal'] == 'done') ) { ?>
<div class="wrap">
	<div id="message" class="updated">
		<p><strong><?php _e('Settings saved.') ?></strong></p>
	</div>
</div>
<?php } ?>

<?php if ( isset( $_GET['modal'] ) && ($_GET['modal'] == 'error') ) { ?>
<div class="wrap">
	<div id="message" class="error">
		<p><strong><?php _e('Error: Please provide the correct information.') ?></strong></p>
	</div>
</div>
<?php } ?>

<div class="wrap">
	<p>Setup all your referrals creatives</p>
	<div class="tool-box">
		<form name="cc_e_r_w_form" action="admin.php?page=cc_e_r_w_start" method="post">
			<input type='hidden' name='ccew_img_attachment_id' id='ccew_img_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
			<input type="hidden" name="cc_e_r_w_form" value="1">
			<?php
			wp_nonce_field( 'cc_e_r_w_form' );	
			?>

			<div class="metabox-holder">
				<div class="postbox" style="width:100%">
					<h3><span>New referral creative</span></h3>
					<div class="inside">
						<table class="form-table">
							<tbody>
								<tr>
									<th><label> Title: <span style="font-size:10px">(required)</span></label></th>
									<td>
										<input type="text" id="ccew_title" name="ccew_title" size="50" placeholder="Place your refereral title..." />
									</td>
								</tr>
								<tr>
									<th><label> Link: <span style="font-size:10px">(required)</span> </label></th>
									<td>
										<input type="text" id="ccew_link" name="ccew_link" placeholder="Add your HTTP referral link..." size="50" />
									</td>
								</tr>
								<tr>
									<th><label> Image: <span style="font-size:10px">(required)</span></label></th>
									<td>
										<div class='image-preview-wrapper'>
											<img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' height='100'>
										</div>
										<input type="file" id="upload_image_button" name="ccew_image" />
									</td>
								</tr>
								<tr>
									<th><label> Description: </label></th>
									<td>
										
										<textarea id="ccew_description" name="ccew_description" rows="8" cols="50%"></textarea>
									</td>
								</tr>
								<tr>
									<th></th>
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
