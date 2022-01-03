<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WWS_Admin_Ajax {

	public function __construct() {

		add_action( "wp_ajax_wws_edit_multi_support_person", array( $this, 'edit_multi_support_person' ) );
		add_action( "wp_ajax_nopriv_wws_edit_multi_support_person", array( $this, 'edit_multi_support_person' ) );

		add_action( "wp_ajax_wws_add_multi_support_person", array( $this, 'add_multi_support_person' ) );
		add_action( "wp_ajax_nopriv_wws_add_multi_support_person", array( $this, 'add_multi_support_person' ) );

		add_action( "wp_ajax_wws_admin_qr_generator", array( $this, 'admin_qr_generator' ) );
		add_action( "wp_ajax_nopriv_wws_admin_qr_generator", array( $this, 'admin_qr_generator' ) );

	}


	public function edit_multi_support_person() {
		if ( ! isset( $_GET['action'] ) && 'wws_edit_multi_support_person' !== $_GET['action']) {
			return;
		}

		$person_id  = $_GET['person_id'];
		$setting    = get_option( 'wws_multi_support_persons', array() );

		require_once WWS_PLUGIN_PATH . 'includes/admin/views/multiperson-support/admin-edit-multiperson-support.php';

		wp_die();
	}


	public function add_multi_support_person() {
		if ( ! isset( $_GET['action'] ) && 'wws_add_multi_support_person' !== $_GET['action'] ) {
			return;
		}

		require_once WWS_PLUGIN_PATH . 'includes/admin/views/multiperson-support/admin-add-multiperson-support.php';
		wp_die();
	}


	public function admin_qr_generator() {

		$response = array();

		$support_number = sanitize_text_field( $_POST['support_number'] );
		$pre_message    = sanitize_textarea_field( $_POST['pre_message'] );
		$qr_size        = sanitize_text_field( $_POST['qr_size'] );

		$url = "https://api.whatsapp.com/send?phone={$support_number}";

		$image_name = WWS_QR_Generator::generate( $url, $qr_size );

		$upload_dir = wp_upload_dir();
		$qr         = $upload_dir['baseurl'] . '/wws-qr-images/' . $image_name;

		$response['shortcode']      = "[wws-qr qr='{$image_name}' size='{$qr_size} text='{$pre_message}']";
		$response['generatedQR']    = $qr;
		$response['preMessage']     = $pre_message;

		echo json_encode( $response );

		wp_die();
	}

}  // end of WWS_Admin_Ajax class

$wws_admin_ajax = new WWS_Admin_Ajax;
