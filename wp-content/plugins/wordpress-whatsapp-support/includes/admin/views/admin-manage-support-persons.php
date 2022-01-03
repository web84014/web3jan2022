<?php ob_start(); ?>
<div id="wws-manage-support-persons-table">
	<table class="wp-list-table widefat striped">
		<thead>
			<tr>
				<th>#</th>
				<th><?php esc_html_e( 'Name', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Title', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Contact Number', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'wc-wws' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $sr = 1; ?>
			<?php foreach ( get_option( 'wws_multi_support_persons', array() ) as $key => $value) : ?>
				<tr>
					<td><?php echo $sr; // WPCS:XXS ok. ?></td>
					<td><?php echo esc_html( $value['name'] ) ?></td>
					<td><?php echo esc_html( $value['title'] ); ?></td>
					<td><?php echo esc_html( $value['contact'] ); ?></td>
					<td>
						<a href="#" data-multi-account-key="<?php echo esc_attr( $key ) ?>" class="button wws_edit_multi_account_show_popup"><?php esc_html_e( 'Edit', 'wc-wws' ) ?></a>&nbsp;<a href="?wws_multi_account_delete=<?php echo esc_attr( $key ) ?>" class="button button-link-delete"><?php esc_html_e( 'Delete', 'wc-wws' ) ?></a>
					</td>
				</tr>
				<?php $sr++; ?>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<th>#</th>
				<th><?php esc_html_e( 'Name', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Title', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Contact Number', 'wc-wws' ); ?></th>
				<th><?php esc_html_e( 'Actions', 'wc-wws' ); ?></th>
			</tr>
		</tfoot>
	</table>
	<a href="#" name="<?php esc_html_e('Add Support Person', 'wc-wws') ?>" class="button button-primary wws_add_multi_account_show_popup"><?php esc_html_e( 'Add Support Person', 'wc-wws' ) ?></a>
</div>
<?php
$multi_support_persons = ob_get_clean();

// Single support person layout
$single_support_person_layouts = apply_filters( 'wws_single_support_person_layouts', array(
	1, 2, 3, 4, 7
) );

if ( in_array( get_option( 'wws_layout' ), $single_support_person_layouts ) ) {
	return apply_filters( 'wws_manage_single_support_person_settings', array(
		'wws_contact_number'       => array(
			'title'     => __( 'Support Contact Number', 'wc-wws' ),
			'desc_tip'  => __( 'Enter mobile phone number with the international country code, without + character. Example:  911234567890 for (+91) 1234567890', 'wc-wws' ),
			'id'        => 'wws_contact_number',
			'type'      => 'text',
			'class'     => 'regular-text',
		),
		'wws_support_person_image' => array(
			'title'     => __( 'Support Person Image', 'wc-wws' ),
			'desc_tip'  => __( 'Upload support person image', 'wc-wws' ),
			'id'        => 'wws_support_person_image',
			'type'      => 'file',
			'class'     => 'regular-text',
			'css'       => 'width:240px;'
		),
	) );
}

//  Group invitation layout
if ( get_option( 'wws_layout' ) == '5' ) {
	return apply_filters( 'wws_manage_group_support_person_settings', array(
		'wws_group_id' => array(
			'title'     => __( 'Support Group ID', 'wc-wws' ),
			'desc_tip'  => __( 'Enter your WhatsApp group chat ID', 'wc-wws' ),
			'id'        => 'wws_group_id',
			'type'      => 'text',
			'class'     => 'regular-text',
		),
	) );
}

// Multi support person layout
$multi_support_person_layouts = apply_filters( 'wws_multi_support_person_layouts', array(
	6, 8
) );

if ( in_array( get_option( 'wws_layout' ), $multi_support_person_layouts ) ) {
	return apply_filters( 'wws_manage_multi_support_person_settings', array(
		array(
			'title'     => __( 'Multi Support Person Settings', 'wc-wws' ),
			'type'      => 'custom',
			'custom'    => $multi_support_persons,
		),
		'wws_multi_support_person_randomize' => array(
			'title'             => __( 'Multi Support Randomize', 'wc-wws' ),
			'desc'              => __( 'Enable/ Disable', 'wc-wws' ),
			'desc_tip'          => __( 'You can rotate or randomize the multi support person order.', 'wc-wws' ),
			'id'                => 'wws_multi_support_person_randomize',
			'default'           => 'no',
			'type'              => 'checkbox',
		),
		'wws_multi_support_person_hide_unavailable' => array(
			'title'             => __( 'Multi Support Hide Unavailable', 'wc-wws' ),
			'desc'              => __( 'Enable/ Disable', 'wc-wws' ),
			'desc_tip'          => __( 'You can hide or show unavailable support person.', 'wc-wws' ),
			'id'                => 'wws_multi_support_person_hide_unavailable',
			'default'           => 'no',
			'type'              => 'checkbox',
		),
	) );
}
