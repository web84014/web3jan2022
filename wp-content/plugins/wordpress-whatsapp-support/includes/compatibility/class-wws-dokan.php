<?php
defined( 'ABSPATH' ) || exit;

class WWS_Compatibility_Dokan {

	public function __construct() {
		// Admin actions.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_setting' ) );

		if ( 'yes' === $this->get_setting( 'status' ) ) {
			add_action( 'wws_admin_post_metabox_notice', array( $this, 'admin_post_metabox_notice' ) );

			// Only works for single person layouts.
			if ( $this->is_single_person_layout() ) {

				// For Dokan product level.
				if ( 'yes' === $this->get_setting( 'product_level' ) ) {
					add_action( 'dokan_product_edit_after_options', array( $this, 'edit_product_fields' ), 80, 1 );
					add_action( 'dokan_product_updated', array( $this, 'save_product_fields' ), 50, 2 );

				}

				// For Dokan store level.
				if ( 'yes' === $this->get_setting( 'store_level' ) ) {
					add_action( 'dokan_settings_after_store_phone', array( $this, 'add_store_whatsapp_number_field' ) );
					add_action( 'dokan_store_profile_saved', array( $this, 'save_store_whatsapp_number_field' ) );

					add_action( 'dokan_user_profile_after_phone_number', array( $this, 'add_store_whatsapp_number_field_on_user_edit_page' ), 10, 2 );
					add_action( 'dokan_process_seller_meta_fields', array( $this, 'save_store_whatsapp_number_field_for_user_edit_page' ), 10, 2 );
					add_filter( 'admin_head', array( $this, 'hide_metabox_fields_on_product_page' ) );

					add_filter( 'wws_support_contact_number', array( $this, 'filter_whatsapp_support_contact_number' ), 100 );
				}

				add_filter( 'wws_display_widget_on_current_page', array( $this, 'hide_widget' ), 100 );
			}
		}
	}

	/**
	 * Get Dokan store ID.
	 *
	 * @since 2.2.0
	 * @return int Dokan store ID.
	 */
	public function get_store_id() {
		$author_id  = get_post_field( 'post_author', get_the_ID() );
		$author     = get_user_by( 'id', $author_id );

		return $author->ID;
	}

	/**
	 * Get Dokan store wWhatsApp Support number.
	 *
	 * @since 2.2.0
	 * @param int $store_id Dokan store ID.
	 * @return int|bool WhatsApp Support number else, false.
	 */
	public function get_store_whatsapp_number( $store_id ) {
		if ( ! $store_id ) {
			return false;
		}

		return get_user_meta( $store_id, '_wws_dokan_store_whatsapp_number', true );
	}

	/**
	 * Get Dokan product wWhatsApp Support number.
	 *
	 * @since 2.2.0
	 * @param int $product_id Product ID.
	 * @return int|bool WhatsApp Support number else, false.
	 */
	public function get_product_whatsapp_number( $product_id ) {
		if ( ! $product_id ) {
			return false;
		}

		return get_post_meta( $product_id, '_wws_support_contact_number', true );
	}

	/**
	 * Add plugin sub page.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page(
			'wc-whatsapp-support',
			esc_html__( 'Dokan Multivendor', 'wc-wws' ),
			esc_html__( 'Dokan Multivendor', 'wc-wws' ),
			'manage_options',
			'wc-whatsapp-support_dokan',
			array( $this, 'admin_dokan_page' )
		);
	}

	/**
	 * Register plugin options.
	 *
	 * @return void
	 */
	public function register_setting() {
		register_setting( 'wws_dokan_multivendor_option_group', 'wws_dokan_multivendor_settings', array( $this, 'sanitize_settings' ) );
	}

	/**
	 * Sanitize admin settings.
	 *
	 * @param array $input
	 * @return array
	 */
	public function sanitize_settings( $input ) {
		$input['status']                    = isset( $input['status'] ) ? 'yes' : 'no';
		$input['product_level']             = isset( $input['product_level'] ) ? 'yes' : 'no';
		$input['product_level_hide_widget'] = isset( $input['product_level_hide_widget'] ) ? 'yes' : 'no';
		$input['store_level']               = isset( $input['store_level'] ) ? 'yes' : 'no';
		$input['store_level_hide_widget']   = isset( $input['store_level_hide_widget'] ) ? 'yes' : 'no';

		return $input;
	}

	/**
	 * Admin Dokan settings.
	 *
	 * @return void
	 */
	public function admin_dokan_page() {
		?>
		<style>
			/* Dokan page CSS */
			.wws-dokan-notice {
				font-weight: 700;
				padding: 10px 20px;
				display: inline-block;
			}

			.wws-dokan-notice.wws-dokan-notice--error {
				background-color: #ffe1e5;
				color: #b71c1c;
				border-left: 4px;
				border-left-color: #b71c1c;
				border-left-style: solid;
				border-radius: 5px;
			}
		</style>
		<div class="wrap">
			<h1><?php esc_html_e( 'WordPress WhatsApp Support For Dokan Multivendor', 'wc-wws' ); ?></h1>
			<?php settings_errors(); ?>
			<hr>

			<?php if ( ! $this->is_single_person_layout() ) : ?>
				<div class="wws-dokan-notice wws-dokan-notice--error">
					<p><?php esc_html_e( 'WordPress WhatsApp Support for Dokan is only works with Single Person layouts. Please change the layout to Single Person support from plugin settings. ', 'wc-wws' ); ?></p>
				</div>
			<?php endif; ?>

			<form action="options.php" method="post">
				<?php settings_fields( 'wws_dokan_multivendor_option_group' ); ?>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for=""><?php esc_html_e( 'WhatsApp Support For Dokan', 'wc-wws' ); ?></label>
							</th>
							<td>
								<label>
									<input
										type="checkbox"
										name="wws_dokan_multivendor_settings[status]"
										<?php checked( 'yes', $this->get_setting( 'status' ) ); ?> > <?php esc_html_e( 'Enable/ Disable', 'wc-wws' ); ?>
									<p class="description"><?php esc_html_e( 'You can enable or disable WordPress WhatsApp Support for Dokan vendors.', 'wc-wws' ); ?></p>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

				<hr>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for=""><?php esc_html_e( 'Product Level (Priority 1)', 'wc-wws' ); ?></label>
							</th>
							<td>
								<label>
									<input
										type="checkbox"
										name="wws_dokan_multivendor_settings[product_level]"
										<?php checked( 'yes', $this->get_setting( 'product_level' ) ); ?> > <?php esc_html_e( 'Enable/ Disable', 'wc-wws' ); ?>
									<p class="description"><?php esc_html_e( 'Enable WordPress WhatsApp Support at Dokan product level.', 'wc-wws' ); ?></p>
									<p class="description"><?php esc_html_e( "This feature allow vendors to add WhatsApp Number for customer support from their Dokan's edit product page.", 'wc-wws' ); ?></p>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label><?php esc_html_e( 'Product Level Hide Widget', 'wc-wws' ); ?></label>
							</th>
							<td>
								<label>
								<input
									type="checkbox"
									name="wws_dokan_multivendor_settings[product_level_hide_widget]"
									<?php checked( 'yes', $this->get_setting( 'product_level_hide_widget' ) ); ?> > <?php esc_html_e( 'Enable, if you want to hide widget on product page if product level WhatsApp Support number not set.', 'wc-wws' ); ?>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

				<hr>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for=""><?php esc_html_e( 'Store Level (Priority 2)', 'wc-wws' ); ?></label>
							</th>
							<td>
								<label>
									<input
										type="checkbox"
										name="wws_dokan_multivendor_settings[store_level]"
										<?php checked( 'yes', $this->get_setting( 'store_level' ) ); ?> > <?php esc_html_e( 'Enable/ Disable', 'wc-wws' ); ?>
									<p class="description"><?php esc_html_e( 'Enable WordPress WhatsApp Support at Dokan store level.', 'wc-wws' ); ?></p>
									<p class="description"><?php esc_html_e( "This feature allow vendors to add WhatsApp Number for customer support from their Dokan's store page.", 'wc-wws' ); ?></p>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label><?php esc_html_e( 'Store Level Hide Widget', 'wc-wws' ); ?></label>
							</th>
							<td>
								<label>
								<input
									type="checkbox"
									name="wws_dokan_multivendor_settings[store_level_hide_widget]"
									<?php checked( 'yes', $this->get_setting( 'store_level_hide_widget' ) ); ?> > <?php esc_html_e( 'Enable, if you want to hide widget on product page if store level WhatsApp Support number not set.', 'wc-wws' ); ?>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Display admin metabox notice.
	 *
	 * @return void
	 */
	public function admin_post_metabox_notice() {
		if ( ! $this->is_single_person_layout() ) {
			?>
			<h4><?php esc_html_e( 'WordPress WhatsApp Support for Dokan is only works with Single Person layouts. Please change the layout to Single Person support from plugin settings. ', 'wc-wws' ); ?></h4>
			<hr>
			<?php
		} else {
			?>
			<h4><?php esc_html_e( 'WordPress WhatsApp Support for Dokan is enabled. These settings are managing by the vendors. Admin can also override and change settings for vendors.', 'wc-wws' ); ?></h4>
			<hr>
			<?php
		}
	}

	/**
	 * Display settings on Dokan edit product page for vendors.
	 *
	 * @param int $post_id
	 * @return void
	 */
	public function edit_product_fields( $post_id ) {
		?>
		<div class="dokan-other-options dokan-edit-row dokan-clearfix ">
			<div class="dokan-section-heading" data-togglehandler="dokan_other_options">
				<h2><i class="fa fa-whatsapp" aria-hidden="true"></i> <?php esc_html_e( 'WhatsApp Support', 'wc-wws' ); ?></h2>
				<p><?php esc_html_e( 'You can add your WhatsApp number on your product page.', 'wc-wws' ); ?></p>
				<a href="#" class="dokan-section-toggle">
					<i class="fa fa-sort-desc fa-flip-vertical" aria-hidden="true" style="margin-top: 9px;"></i>
				</a>
				<div class="dokan-clearfix"></div>
			</div>

			<div class="dokan-section-content">

				<div class="dokan-form-group">
					<label for="_wws_support_contact_number" class="form-label"><?php esc_html_e( 'Your WhatsApp Number', 'wc-wws' ); ?></label>
					<input
						type="number"
						name="_wws_support_contact_number"
						id="_wws_support_contact_number"
						class="dokan-form-control"
						min="0"
						step="1"
						value="<?php echo esc_attr( get_post_meta( $post_id, '_wws_support_contact_number', true ) ); ?>">
						<p class="help-block"><?php esc_html_e( 'Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ); ?></p>
				</div>

			</div>
		</div>
		<?php
	}

	/**
	 * Save settings by vendors.
	 *
	 * @param int $post_id
	 * @param array $postdata
	 * @return void
	 */
	public function save_product_fields( $post_id, $postdata ) {
		if ( ! empty( $postdata['_wws_support_contact_number'] ) ) {
			update_post_meta( $post_id, '_wws_support_contact_number', sanitize_textarea_field( $postdata['_wws_support_contact_number'] ) );
		} else {
			delete_post_meta( $post_id, '_wws_support_contact_number' );
		}
	}

	/**
	 * Add WhatsApp number field on Dokan store page.
	 *
	 * @since 2.2.0
	 * @param int $store_id Current user or store ID.
	 * @return void
	 */
	public function add_store_whatsapp_number_field( $store_id ) {
		$store_whatsapp_number = get_user_meta( $store_id, '_wws_dokan_store_whatsapp_number', true );

		?>
		<div class="dokan-form-group">
			<label class="dokan-w3 dokan-control-label" for="wws_dokan_store_whatsapp_number"><?php esc_html_e( 'WhatsApp Number', 'wc-wws' ); ?></label>
			<div class="dokan-w5 dokan-text-left">
				<input
					id="wws_dokan_store_whatsapp_number"
					value="<?php echo esc_attr( $store_whatsapp_number ); ?>"
					name="wws_dokan_store_whatsapp_number"
					placeholder="911234567890"
					class="dokan-form-control input-md"
					type="number">
				<p class="help-block"><?php esc_html_e( 'Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Save WhatsApp number field for Dokan store page.
	 *
	 * @since 2.2.0
	 * @param int $store_id Current user or store ID.
	 * @return void
	 */
	public function save_store_whatsapp_number_field( $store_id ) {
		if ( ! isset( $_POST['wws_dokan_store_whatsapp_number'] ) ) {
			return;
		}

		$store_whatsapp_number = sanitize_text_field( wp_unslash( $_POST['wws_dokan_store_whatsapp_number'] ) );

		update_user_meta( $store_id, '_wws_dokan_store_whatsapp_number', $store_whatsapp_number );
	}

	/**
	 * Add WhatsApp number field on admin user edit page.
	 *
	 * @since 2.2.0
	 * @param array   $store_settings Dokan store settings.
	 * @param WP_User $user           User object.
	 * @return void
	 */
	public function add_store_whatsapp_number_field_on_user_edit_page( $store_settings, $user ) {
		$store_whatsapp_number = get_user_meta( $user->ID, '_wws_dokan_store_whatsapp_number', true );
		?>
		<tr>
			<th><?php esc_html_e( 'WhatsApp Number', 'wc-wws' ); ?></th>
			<td>
				<input
					id="wws_dokan_store_whatsapp_number"
					value="<?php echo esc_attr( $store_whatsapp_number ); ?>"
					name="wws_dokan_store_whatsapp_number"
					placeholder="911234567890"
					class="regular-text"
					type="number">
				<p class="description"><?php esc_html_e( 'Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save WhatsApp number field for admin user edit page.
	 *
	 * @since 2.2.0
	 * @param int $user_id User Id.
	 * @return void
	 */
	public function save_store_whatsapp_number_field_for_user_edit_page( $user_id ) {
		if ( ! isset( $_POST['wws_dokan_store_whatsapp_number'] ) ) {
			return;
		}

		$store_whatsapp_number = sanitize_text_field( wp_unslash( $_POST['wws_dokan_store_whatsapp_number'] ) );

		update_user_meta( $user_id, '_wws_dokan_store_whatsapp_number', $store_whatsapp_number );
	}

	/**
	 * Filter WhatsApp Support contact number.
	 *
	 * @since 2.2.0
	 * @param int $whatsapp_support_number WhatsApp Support number.
	 * @return void
	 */
	public function filter_whatsapp_support_contact_number( $whatsapp_support_number ) {
		if ( is_product() ) {

			// Product level filter.
			if ( 'yes' === $this->get_setting( 'product_level' ) ) {
				$product_whatsapp_number = $this->get_product_whatsapp_number( get_the_ID() );

				if ( $product_whatsapp_number ) {
					return $product_whatsapp_number;
				}
			}

			// Store level filter.
			if ( 'yes' === $this->get_setting( 'store_level' ) ) {
				$store_id              = $this->get_store_id();
				$store_whatsapp_number = $this->get_store_whatsapp_number( $store_id );

				if ( $store_whatsapp_number ) {
					return $store_whatsapp_number;
				}
			}
		}

		return $whatsapp_support_number;
	}

	/**
	 * Hide admin metabox fields.
	 *
	 * @since 2.2.0
	 * @return void
	 */
	public function hide_metabox_fields_on_product_page() {
		if ( 'product' !== get_post_type() ) {
			return;
		}

		if ( 'yes' === $this->get_setting( 'store_level' ) && 'no' === $this->get_setting( 'product_level' ) ) {
			?>
			<style>
				#wwsMetaboxDiv #wws_support_contact_number {
					display: none;
				}
			</style>
			<?php
		}
	}

	/**
	 * Hide widget on the product page.
	 *
	 * @since 2.2.0
	 * @param bool $action True for display. False, for hide.
	 * @return void
	 */
	public function hide_widget( $action ) {
		$is_product_level      = $this->get_setting( 'product_level' );
		$is_store_level        = $this->get_setting( 'store_level' );
		$is_hide_product_level = $this->get_setting( 'product_level_hide_widget' );
		$is_hide_store_level   = $this->get_setting( 'store_level_hide_widget' );

		if ( is_product() ) {
			if ( 'yes' === $is_product_level && 'yes' === $is_hide_product_level ) {
				$product_whatsapp_number = $this->get_product_whatsapp_number( get_the_ID() );

				if ( ! $product_whatsapp_number ) {
					return false;
				}
			}
			if ( 'yes' === $is_store_level && 'yes' === $is_hide_store_level ) {
				$store_id              = $this->get_store_id();
				$store_whatsapp_number = $this->get_store_whatsapp_number( $store_id );

				if ( ! $store_whatsapp_number ) {
					return false;
				}
			}
		}

		return $action;
	}

	/**
	 * Check whether current activate is single person layout or not.
	 *
	 * @since 2.2.0
	 * @return boolean True, if single person layout activated else, false.
	 */
	public function is_single_person_layout() {
		return in_array( get_option( 'wws_layout' ), array( 1, 2, 3, 4, 7 ) );
	}

	/**
	 * Get Dokan settings for WordPress WhatsApp Support.
	 *
	 * @param string $data
	 * @return string
	 */
	private function get_setting( $data ) {
		if ( ! isset( $data ) ) {
			return false;
		}

		$setting = get_option( 'wws_dokan_multivendor_settings' );

		// Default settings.
		$setting['status']                    = isset( $setting['status'] ) ? $setting['status'] : 'no';
		$setting['product_level']             = isset( $setting['product_level'] ) ? $setting['product_level'] : 'yes';
		$setting['product_level_hide_widget'] = isset( $setting['product_level_hide_widget'] ) ? $setting['product_level_hide_widget'] : 'no';
		$setting['store_level']               = isset( $setting['store_level'] ) ? $setting['store_level'] : 'no';
		$setting['store_level_hide_widget']   = isset( $setting['store_level_hide_widget'] ) ? $setting['store_level_hide_widget'] : 'no';

		if ( ! isset( $setting[ $data ] ) ) {
			return false;
		}

		return $setting[ $data ];
	}

}

new WWS_Compatibility_Dokan;
