<?php defined( 'ABSPATH' ) || exit; ?>

<div id="wws-layout-8" class="wws-popup-container wws-popup-container--position">

	<?php if ( 'yes' === get_option( 'wws_gradient_status' ) ) : ?>
		<div class="wws-gradient wws-gradient--position"></div>
	<?php endif; ?>

	<!-- Popup -->
	<div class="wws-popup" data-wws-popup-status="0">

		<!-- Popup header -->
		<div class="wws-popup__header">

			<!-- Popup close button -->
			<div class="wws-popup__close-btn wws--bg-color wws--text-color wws-shadow">
				<?php echo WWS_Icons::get( 'close' ); ?>
			</div>
			<div class="wws-clearfix"></div>
			<!-- .Popup close button -->

		</div>
		<!-- .Popup header -->

		<!-- Popup body -->
		<div class="wws-popup__body">

			<!-- Popup support -->
			<div class="wws-popup__support-wrapper  wws-shadow">
				<div class="wws-popup__support">
					<div class="wws-popup__support-about wws--bg-color wws--text-color">
						<?php echo esc_textarea( apply_filters( 'wws_about_support_text', get_option( 'wws_about_support_text' ) ) ) ?>
					</div>
				</div>
			</div>
			<div class="wws-clearfix"></div>
			<!-- .Popup support -->

			<!-- Popup support person -->
			<div class="wws-popup__support-person-container wws-shadow">

				<?php do_action( 'wws_action_plugin' ) ?>

				<div class="wws-popup__support-person-wrapper">

				<?php
					// If multi person randomize is on.
					if ( 'yes' === get_option( 'wws_multi_support_person_randomize' ) ) {
						$multi_support_persons = wws_shuffle_assoc( get_option( 'wws_multi_support_persons' ) );
					} else {
						$multi_support_persons = get_option( 'wws_multi_support_persons' );
					}

					foreach ( $multi_support_persons as $m_account_id => $m_account) :

					$pre_message = str_replace(
							array( '{title}', '{url}', '{br}' ),
							array( get_the_title(), get_permalink(), '%0A',
						), $m_account['pre_message']
					);

					$start_time = $m_account['start_hours'] . $m_account['start_minutes'];
					$end_time   = $m_account['end_hours'] . $m_account['end_minutes'];

					$wws_availablity = wws_multi_account_availablity( $m_account['days'], $start_time, $end_time );

					// Hide unavailable support person.
					if ( 'yes' === get_option( 'wws_multi_support_person_hide_unavailable' ) && ! $wws_availablity ) {
						continue;
					}
					?>

					<?php if ( $wws_availablity == true ) : ?>

						<div class="wws-popup__support-person">

							<a class="wws-popup__support-person-link wws-popup__send-btn"
								href="javascript:;"
								data-wws-number="<?php echo esc_html( $m_account['contact'] ); ?>"
								data-wws-pre-msg="<?php echo esc_html( $pre_message ); ?>"
								data-wws-name="<?php echo esc_html( $m_account['name'] ); ?>"
								data-wws-id="<?php echo intval( $m_account_id ) ?>"
								data-ga-analytics-label="Multi Person - <?php echo esc_html( $m_account['name'] ); ?>">
								<div class="wws-popup__support-person-img-wrapper">

									<?php if ( $m_account['image'] ) : ?>
										<img class="wws-popup__support-person-img" src="<?php echo esc_url( $m_account['image'] ) ?>" alt="WeCreativez WhatsApp Support" width="54">
									<?php else: ?>
										<img class="wws-popup__support-person-img" src="<?php echo esc_url( WWS_PLUGIN_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="54">
									<?php endif; ?>

									<div class="wws-popup__support-person-available"></div>
								</div>
								<div class="wws-popup__support-person-info-wrapper">
									<div class="wws-popup__support-person-name"><?php echo esc_html( $m_account['name'] ) ?></div>
									<div class="wws-popup__support-person-title"><?php echo esc_html( $m_account['title'] ) ?></div>
									<div class="wws-popup__support-person-status"><?php echo esc_html( get_option( 'wws_support_person_available_text' ) ); ?></div>
								</div>
							</a>

						<?php if ( isset( $m_account['call_number'] ) && '' !== $m_account['call_number'] ) : ?>

							<div class="wws-popup__support-person-cta" data-wws-agent-call="<?php echo esc_attr( $m_account['call_number'] ); ?>">
								<img src="<?php echo WWS_PLUGIN_URL . '/assets/img/phone.svg' ?>" alt="//">
							</div>

						<?php endif; ?>

						</div>

					<?php else : ?>

						<a href="javascript:;">
							<div class="wws-popup__support-person">
								<div class="wws-popup__support-person-img-wrapper">
									<?php if ( $m_account['image'] ) : ?>
										<img class="wws-popup__support-person-img" src="<?php echo esc_url( $m_account['image'] ) ?>" alt="WeCreativez WhatsApp Support" width="54">
									<?php else: ?>
										<img class="wws-popup__support-person-img" src="<?php echo esc_url( WWS_PLUGIN_URL . 'assets/img/user.svg' ); ?>" alt="WeCreativez WhatsApp Support" width="54">
									<?php endif; ?>
									<div class="wws-popup__support-person-away"></div>
								</div>
								<div class="wws-popup__support-person-info-wrapper">
									<div class="wws-popup__support-person-name"><?php echo esc_html( $m_account['name'] ) ?></div>
									<div class="wws-popup__support-person-title"><?php echo esc_html( $m_account['title'] ) ?></div>
									<div class="wws-popup__support-person-status"><?php echo esc_html( get_option( 'wws_support_person_not_available_text' ) ); ?></div>
								</div>
							</div>
						</a>

					<?php endif; ?>

				<?php endforeach; ?>

			</div>

			</div>
			<!-- .Popup support person -->

		</div>
		<!-- .Popup body -->

	</div>
	<!-- .Popup -->

	<!-- .Popup footer -->
	<div class="wws-popup__footer">

		<!-- Popup open button -->
		<div class="wws-popup__open-btn wws--bg-color wws--text-color wws-shadow">
			<?php echo WWS_Icons::get( 'whatsapp' ); ?> <span><?php echo esc_html( apply_filters( 'wws_trigger_button_text', get_option( 'wws_trigger_button_text' ) ) ) ?></span>
		</div>
		<div class="wws-clearfix"></div>
		<!-- .Popup open button -->

	</div>
	<!-- Popup footer -->

</div>
