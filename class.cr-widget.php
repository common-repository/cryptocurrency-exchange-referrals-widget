<?php

class CCER_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'CCER_Widget',
			'CryptoCurrency Referrals Widget',
			array(
				'description' => __( 'Add the referral widget to your blog'))
		);
	}

	public function widget($args, $instance) {
		echo $args['before_widget'];
		echo '<h2 class="widget-title">'.$instance['title'].'</h2>';
		echo '<div id="CCER_Widget"></div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( $instance ) {
			$title = $instance['title'];
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

function cc_e_r_w_register_widgets() {
	register_widget( 'CCER_Widget' );
}

add_action( 'widgets_init', 'cc_e_r_w_register_widgets' );

