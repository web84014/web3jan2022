<?php
ob_start();

wws_time_hours_dropdown(
	array(
		'name'      => 'wws_multi_account[start_hours]',
		'selected'  => esc_html( $setting[$person_id]['start_hours'] ),
	)
)
?>
:
<?php
wws_time_minutes_dropdown(
	array(
		'name'      => 'wws_multi_account[start_minutes]',
		'selected'  => esc_html( $setting[$person_id]['start_minutes'] ),
	)
 );
?>
To
<?php
wws_time_hours_dropdown(
	array(
		'name'      => 'wws_multi_account[end_hours]',
		'selected'  => esc_html( $setting[$person_id]['end_hours'] ),
	)
)
?>
:
<?php
wws_time_minutes_dropdown(
	array(
		'name'      => 'wws_multi_account[end_minutes]',
		'selected'  => esc_html( $setting[$person_id]['end_minutes'] ),
	)
)
?>
<br>
<input type="checkbox" value="mon" name="wws_multi_account[mon]" <?php checked( 'mon', $setting[$person_id]['days']['0'], true ) ?>> <?php esc_html_e( 'Monday', 'wc-wws' ) ?><br>
<input type="checkbox" value="tue" name="wws_multi_account[tue]" <?php checked( 'tue', $setting[$person_id]['days']['1'], true ) ?>> <?php esc_html_e( 'Tuesday', 'wc-wws' ) ?><br>
<input type="checkbox" value="wed" name="wws_multi_account[wed]" <?php checked( 'wed', $setting[$person_id]['days']['2'], true ) ?>> <?php esc_html_e( 'Wednesday', 'wc-wws' ) ?><br>
<input type="checkbox" value="thu" name="wws_multi_account[thu]" <?php checked( 'thu', $setting[$person_id]['days']['3'], true ) ?>> <?php esc_html_e( 'Thursday', 'wc-wws' ) ?><br>
<input type="checkbox" value="fri" name="wws_multi_account[fri]" <?php checked( 'fri', $setting[$person_id]['days']['4'], true ) ?>> <?php esc_html_e( 'Friday', 'wc-wws' ) ?><br>
<input type="checkbox" value="sat" name="wws_multi_account[sat]" <?php checked( 'sat', $setting[$person_id]['days']['5'], true ) ?>> <?php esc_html_e( 'Saturday', 'wc-wws' ) ?><br>
<input type="checkbox" value="sun" name="wws_multi_account[sun]" <?php checked( 'sun', $setting[$person_id]['days']['6'], true ) ?>> <?php esc_html_e( 'Sunday', 'wc-wws' ) ?><br>
<?php
$schedule = ob_get_clean();

$setting_api = new WWS_Admin_Settings_API;

$fields = apply_filters( 'wws_edit_multiperson_settings', array(
	'contact'     => array(
		'title'             => __( 'Support Person Contact', 'wc-wws' ),
		'desc'              => __( 'Enter mobile phone number with the international country code, without "+" character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ),
		'id'                => 'wws_multi_account[contact]',
		'type'              => 'number',
		'class'             => 'regular-text',
		'value'             => $setting[$person_id]['contact'], // WPCS: XSS ok.
		'custom_attributes' => array(
			'step' => '1',
		),
	),
	'name'        => array(
		'title' => __( 'Support Person Name', 'wc-wws' ),
		'desc'  => __( 'Enter support person name', 'wc-wws' ),
		'id'    => 'wws_multi_account[name]',
		'type'  => 'text',
		'class' => 'regular-text',
		'value'     => $setting[$person_id]['name'], // WPCS: XSS ok.
	),
	'title'       => array(
		'title' => __( 'Support Person Title', 'wc-wws' ),
		'desc'  => __( 'Enter support person title/designation.', 'wc-wws' ),
		'id'    => 'wws_multi_account[title]',
		'type'  => 'text',
		'class' => 'regular-text',
		'value'     => $setting[$person_id]['title'], // WPCS: XSS ok.
	),
	'image'       => array(
		'title' => __( 'Support Person Image', 'wc-wws' ),
		'desc'  => __( 'Add support person image', 'wc-wws' ),
		'id'    => 'wws_multi_account[image]',
		'value'     => $setting[$person_id]['image'], // WPCS: XSS ok.
		'type'  => 'file',
	),
	'pre_message' => array(
		'title' => __( 'Support Pre Message', 'wc-wws' ),
		'desc'  => wp_kses_post( sprintf( __( '%s to display current page title in chat.<br>%s to display current page URL in chat.<br>%s to break the line into a new line.', 'wc-wws' ), '<code>{title}</code>', '<code>{url}</code>', '<code>{br}</code>' ) ),
		'id'    => 'wws_multi_account[pre_message]',
		'value'     => $setting[$person_id]['pre_message'], // WPCS: XSS ok.
		'type'  => 'textarea',
		'class' => 'regular-text',
		'css'   => 'height:120px',

	),
	'call_number' => array(
		'title'             => __( 'Support Call Number', 'wc-wws' ),
		'desc'              => __( 'Enter mobile phone number with the international country code, <strong>with "+"</strong> character. Example:  +911234567890 for (+91) 1234567890', 'wc-wws' ),
		'id'                => 'wws_multi_account[call_number]',
		'type'              => 'text',
		'value'  			=> isset( $setting[$person_id]['call_number'] ) ? $setting[$person_id]['call_number'] : '', // WPCS: XSS ok.
		'class'             => 'regular-text',
	),
	'schedule'    => array(
		'title'  => __( 'Schedule', 'wc-wws' ),
		'desc'   => __( 'Schedule by days to show contact person availablity. Time format HH:MM', 'wc-wws' ),
		'type'   => 'custom',
		'custom' => $schedule,
	),
	'hidden_567'  => array(
		'type'  => 'hidden',
		'value' => $person_id,
		'id'  => 'wws_multi_account[key]',
	),
	'hidden_879'  => array(
		'type'  => 'hidden',
		'value' => 'value',
		'id'  => 'wws_edit_multi_account_submit',
	),
), $person_id );

$setting_api->render_form( $fields, array( 'class' => 'wws-admin-edit-multiperson-form' ) );
