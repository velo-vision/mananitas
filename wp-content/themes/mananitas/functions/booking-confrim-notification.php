<?php
if(!function_exists('ravis_fn_confirm_booking_notification'))
{
    function ravis_fn_confirm_booking_notification( $ID, $post ) {
        global $wpdb, $pinar_opt;
        if(isset($pinar_opt['pinar-email-notification']) && $pinar_opt['pinar-email-notification'] == '1')
        {

            $post_id                    = $post->ID;
            $guest_email                = get_post_meta( $post_id, 'pinar_booking_email', true );
            $guest_name                 = get_post_meta( $post_id, 'pinar_booking_name', true );
            $guest_fname                = get_post_meta( $post_id, 'pinar_booking_fname', true );
            $guest_check_in             = get_post_meta( $post_id, 'pinar_booking_check_in', true );
            $guest_check_out            = get_post_meta( $post_id, 'pinar_booking_check_out', true );
            $guest_phone                = get_post_meta( $post_id, 'pinar_booking_phone', true );
            $guest_city                 = get_post_meta( $post_id, 'pinar_booking_city', true );
            $guest_address              = get_post_meta( $post_id, 'pinar_booking_address', true );
            $guest_special_requirements = get_post_meta( $post_id, 'pinar_booking_special_requirements', true );

            $email_sender               = (!empty($pinar_opt['pinar-email-sender']) ? $pinar_opt['pinar-email-sender'] : get_option('admin_email'));
            $subj                       = esc_html__( 'Your Booking is confirmed. Booking ID is : ', 'pinar' ).$post_id;
            $headers                    = "MIME-Version: 1.0" . "\r\n";
            $headers                    .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers                    .= 'From: "'.get_bloginfo('name').'" <'.$email_sender.'>';

            $mail_tmpl_shortcodes = array(
                '[guest-name]',
                '[guest-family-name]',
                '[guest-email]',
                '[guest-tel]',
                '[guest-city]',
                '[guest-address]',
                '[guest-special-requirement]',
                '[guest-check-in]',
                '[guest-check-out]',
                '[user-booking-id]'
            );
            $mail_tmpl_replace    = array(
                $guest_name,
                $guest_fname,
                $guest_email,
                $guest_phone,
                $guest_city,
                $guest_address,
                $guest_special_requirements,
                date( 'Y-m-d', $guest_check_in ),
                date( 'Y-m-d', $guest_check_out ),
                $post_id
            );

            $body                 = str_replace($mail_tmpl_shortcodes, $mail_tmpl_replace, $pinar_opt['pinar-users-email-template']);

            wp_mail( $guest_email, $subj, $body, $headers );
        }

        // Update the status of booking in ravis_booking table
        $table_name   = $wpdb->prefix . 'ravis_booking';
        $update_table = $wpdb->update(
            $table_name,
            array(
                'confirmed' => 1
            ),
            array(
                'booking_id' => $post_id
            ),
            array('%d'),
            array('%d')
        );
    }
    add_action( 'publish_booking', 'ravis_fn_confirm_booking_notification', 10, 2 );

}