<?php
defined( 'ABSPATH' ) || exit;

class Plume_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'plume_signup', __( 'Plume Signup', 'plume-newsletter' ), array( 'description' => __( 'A Plume newsletter signup form.', 'plume-newsletter' ) ) );
	}

	public function widget( $args, $instance ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-provided widget markup
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-provided widget markup; title itself is esc_html()'d
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}
		$form_args = array(
			'list'   => ! empty( $instance['list'] ) ? $instance['list'] : get_option( 'plume_newsletter_list_id', '' ),
			'name'   => ! empty( $instance['name'] ),
			'notice' => '',
		);
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Plume_Form::render() escapes all output internally
		echo Plume_Form::render( $form_args );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-provided widget markup
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$list  = isset( $instance['list'] ) ? $instance['list'] : '';
		printf(
			'<p><label>%s <input class="widefat" name="%s" value="%s" /></label></p><p><label>%s <input class="widefat" name="%s" value="%s" /></label></p>',
			esc_html__( 'Title', 'plume-newsletter' ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $title ),
			esc_html__( 'List ID (optional)', 'plume-newsletter' ),
			esc_attr( $this->get_field_name( 'list' ) ),
			esc_attr( $list )
		);
	}

	public function update( $new_instance, $old_instance ) {
		return array(
			'title' => sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : '' ),
			'list'  => sanitize_text_field( isset( $new_instance['list'] ) ? $new_instance['list'] : '' ),
		);
	}
}
