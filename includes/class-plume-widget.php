<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Plume_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'plume_signup', __( 'Plume Signup', 'plume-newsletter' ), array( 'description' => __( 'A Plume newsletter signup form.', 'plume-newsletter' ) ) );
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo Plume_Form::render( array( // phpcs:ignore WordPress.Security.EscapeOutput -- render escapes internally
			'list'   => ! empty( $instance['list'] ) ? $instance['list'] : get_option( 'plume_newsletter_list_id', '' ),
			'name'   => ! empty( $instance['name'] ),
			'notice' => '',
		) );
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$list  = isset( $instance['list'] ) ? $instance['list'] : '';
		printf(
			'<p><label>%s <input class="widefat" name="%s" value="%s" /></label></p><p><label>%s <input class="widefat" name="%s" value="%s" /></label></p>',
			esc_html__( 'Title', 'plume-newsletter' ), esc_attr( $this->get_field_name( 'title' ) ), esc_attr( $title ),
			esc_html__( 'List ID (optional)', 'plume-newsletter' ), esc_attr( $this->get_field_name( 'list' ) ), esc_attr( $list )
		);
	}

	public function update( $new, $old ) {
		return array(
			'title' => sanitize_text_field( isset( $new['title'] ) ? $new['title'] : '' ),
			'list'  => sanitize_text_field( isset( $new['list'] ) ? $new['list'] : '' ),
		);
	}
}
