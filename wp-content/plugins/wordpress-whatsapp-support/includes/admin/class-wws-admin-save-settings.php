<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Admin_Save_Settings {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_edit_multi_account_settings' ) );
		add_action( 'admin_init', array( $this, 'save_add_multi_account_settings' ) );
		add_action( 'admin_init', array( $this, 'save_delete_multi_account_settings' ) );
	}

	public function save_edit_multi_account_settings() {
		if ( ! isset( $_POST['wws_edit_multi_account_submit'] ) ) {
			return;
		}

		$setting        = get_option( 'wws_multi_support_persons' );
		$key            = $_POST['wws_multi_account']['key'];
		$post_data      = stripslashes_deep( $_POST['wws_multi_account'] );
		$setting[$key]  = apply_filters( 'wws_save_multi_account_settings', array(
			'contact'       => sanitize_text_field( $post_data['contact'] ),
			'name'          => sanitize_text_field( $post_data['name'] ),
			'title'         => sanitize_text_field( $post_data['title'] ),
			'image'         => esc_url_raw( $post_data['image'] ),
			'pre_message'   => sanitize_textarea_field( $post_data['pre_message'] ),
			'call_number'   => sanitize_text_field( $post_data['call_number'] ),
			'start_hours'   => sanitize_text_field( $post_data['start_hours'] ),
			'start_minutes' => sanitize_text_field( $post_data['start_minutes'] ),
			'end_hours'     => sanitize_text_field( $post_data['end_hours'] ),
			'end_minutes'   => sanitize_text_field( $post_data['end_minutes'] ),
			'days' => array(
				(isset($post_data['mon'])) ? 'mon' : '0',
				(isset($post_data['tue'])) ? 'tue' : '0',
				(isset($post_data['wed'])) ? 'wed' : '0',
				(isset($post_data['thu'])) ? 'thu' : '0',
				(isset($post_data['fri'])) ? 'fri' : '0',
				(isset($post_data['sat'])) ? 'sat' : '0',
				(isset($post_data['sun'])) ? 'sun' : '0',
			),
		), $post_data );

		update_option( 'wws_multi_support_persons', $setting );

	}

	public function save_add_multi_account_settings() {
		if ( ! isset( $_POST['wws_add_multi_account_submit'] ) ) {
			return;
		}

		$setting    = get_option( 'wws_multi_support_persons' );
		$post_data  = stripslashes_deep( $_POST['wws_multi_account'] );
		$setting[]  = apply_filters( 'wws_save_multi_account_settings', array(
			'contact'       => sanitize_text_field( $post_data['contact'] ),
			'name'          => sanitize_text_field( $post_data['name'] ),
			'title'         => sanitize_text_field( $post_data['title'] ),
			'image'         => esc_url_raw( $post_data['image'] ),
			'pre_message'   => sanitize_textarea_field( $post_data['pre_message'] ),
			'call_number'   => sanitize_text_field( $post_data['call_number'] ),
			'start_hours'   => sanitize_text_field( $post_data['start_hours'] ),
			'start_minutes' => sanitize_text_field( $post_data['start_minutes'] ),
			'end_hours'     => sanitize_text_field( $post_data['end_hours'] ),
			'end_minutes'   => sanitize_text_field( $post_data['end_minutes'] ),
			'days' => array(
				(isset($post_data['mon'])) ? 'mon' : '0',
				(isset($post_data['tue'])) ? 'tue' : '0',
				(isset($post_data['wed'])) ? 'wed' : '0',
				(isset($post_data['thu'])) ? 'thu' : '0',
				(isset($post_data['fri'])) ? 'fri' : '0',
				(isset($post_data['sat'])) ? 'sat' : '0',
				(isset($post_data['sun'])) ? 'sun' : '0',
			),
		), $post_data );

		update_option( 'wws_multi_support_persons', $setting );
	}


	public function save_delete_multi_account_settings() {

		if ( ! isset( $_GET['wws_multi_account_delete'] ) )  {
			return;
		}

		if ( ! is_admin() ) {
			return;
		}

		$setting = get_option( 'wws_multi_support_persons' );

		unset( $setting[$_GET['wws_multi_account_delete']] );

		update_option( 'wws_multi_support_persons' , $setting);

		wp_redirect( admin_url( 'admin.php?page=wc-whatsapp-support&tab=manage_support_persons' ) );

		exit;

	}

} // end of class WWS_Admin_Save_Settings

$wws_admin_save_settings = new WWS_Admin_Save_Settings;
