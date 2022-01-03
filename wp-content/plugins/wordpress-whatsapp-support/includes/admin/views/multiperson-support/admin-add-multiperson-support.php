<?php

ob_start();

wws_time_hours_dropdown(
	array(
		'name'     => 'wws_multi_account[start_hours]',
		'selected' => '00',
	)
);
?>
:
<?php

wws_time_minutes_dropdown(
	array(
		'name'     => 'wws_multi_account[start_minutes]',
		'selected' => '00',
	)
);
?>
To
<?php

wws_time_hours_dropdown(
	array(
		'name'     => 'wws_multi_account[end_hours]',
		'selected' => '23',
	)
);
?>
:
<?php

wws_time_minutes_dropdown(
	array(
		'name'     => 'wws_multi_account[end_minutes]',
		'selected' => '59',
	)
);
?>
<br>
<input type="checkbox" value="mon" name="wws_multi_account[mon]" checked="checked"> <?php esc_html_e( 'Monday', 'wc-wws' );?><br>
<input type="checkbox" value="tue" name="wws_multi_account[tue]" checked="checked"> <?php esc_html_e( 'Tuesday', 'wc-wws' );?><br>
<input type="checkbox" value="wed" name="wws_multi_account[wed]" checked="checked"> <?php esc_html_e( 'Wednesday', 'wc-wws' );?><br>
<input type="checkbox" value="thu" name="wws_multi_account[thu]" checked="checked"> <?php esc_html_e( 'Thursday', 'wc-wws' );?><br>
<input type="checkbox" value="fri" name="wws_multi_account[fri]" checked="checked"> <?php esc_html_e( 'Friday', 'wc-wws' );?><br>
<input type="checkbox" value="sat" name="wws_multi_account[sat]" checked="checked"> <?php esc_html_e( 'Saturday', 'wc-wws' );?><br>
<input type="checkbox" value="sun" name="wws_multi_account[sun]" checked="checked"> <?php esc_html_e( 'Sunday', 'wc-wws' );?><br>
<?php
$schedule = ob_get_clean();

$setting_api = new WWS_Admin_Settings_API;

$fields = apply_filters( 'wws_add_multiperson_settings', array(
	'contact'     => array(
		'title'             => __( 'Support Person Contact', 'wc-wws' ),
		'desc'              => __( 'Enter mobile phone number with the international country code, without "+" character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ),
		'id'                => 'wws_multi_account[contact]',
		'type'              => 'number',
		'class'             => 'regular-text',
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
	),
	'title'       => array(
		'title' => __( 'Support Person Title', 'wc-wws' ),
		'desc'  => __( 'Enter support person title/designation.', 'wc-wws' ),
		'id'    => 'wws_multi_account[title]',
		'type'  => 'text',
		'class' => 'regular-text',
	),
	'image'       => array(
		'title' => __( 'Support Person Image', 'wc-wws' ),
		'desc'  => __( 'Add support person image', 'wc-wws' ),
		'id'    => 'wws_multi_account[image]',
		'type'  => 'file',
	),
	'pre_message' => array(
		'title' => __( 'Support Pre Message', 'wc-wws' ),
		'desc'  => wp_kses_post( sprintf( __( '%s to display current page title in chat.<br>%s to display current page URL in chat.<br>%s to break the line into a new line.', 'wc-wws' ), '<code>{title}</code>', '<code>{url}</code>', '<code>{br}</code>' ) ),
		'id'    => 'wws_multi_account[pre_message]',
		'value' => '{br}' . PHP_EOL . 'Page Title: {title}{br}' . PHP_EOL . 'Page URL: {url}',
		'type'  => 'textarea',
		'class' => 'regular-text',
		'css'   => 'height:120px',
	),
	'call_number' => array(
		'title'             => __( 'Support Call Number', 'wc-wws' ),
		'desc'              => __( 'Enter mobile phone number with the international country code, <strong>with "+"</strong> character. Example:  +911234567890 for (+91) 1234567890', 'wc-wws' ),
		'id'                => 'wws_multi_account[call_number]',
		'type'              => 'text',
		'class'             => 'regular-text',
	),
	'schedule'    => array(
		'name'     => 'eee',
		'title'  => __( 'Schedule', 'wc-wws' ),
		'desc'   => __( 'Schedule by days to show contact person availablity. Time format HH:MM', 'wc-wws' ),
		'type'   => 'custom',
		'custom' => $schedule,
	),
	'hidden_879'  => array(
		'type'  => 'hidden',
		'value' => 'value',
		'name'  => 'wws_add_multi_account_submit',
	),
) );

$setting_api->render_form( $fields, array( 'class' => 'wws-admin-add-multiperson-form' ) );
