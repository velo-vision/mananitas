<?php
/**
 * ------------------------------------------------------------------------------------------
 * Booking Details Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_details_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $booking_details_meta_fields = array();

    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'pinar_booking_';
        $this->booking_details_meta_fields = array(
            array(
                'label' => esc_html__( 'First Name *', 'ravis' ),
                'id'    => $prefix.'name',
                'type'  => 'text',
                'status'=> 'required',
            ),
            array(
                'label' => esc_html__( 'Last Name *', 'ravis' ),
                'id'    => $prefix.'fname',
                'type'  => 'text',
                'status'=> 'required',
            ),
            array(
                'label' => esc_html__( 'Email *', 'ravis' ),
                'id'    => $prefix.'email',
                'type'  => 'email',
                'status'=> 'required',
            ),
            array(
                'label' => esc_html__( 'Phone *', 'ravis' ),
                'id'    => $prefix.'phone',
                'type'  => 'text',
                'status'=> 'required',
            ),
            array(
                'label' => esc_html__( 'City', 'ravis' ),
                'id'    => $prefix.'city',
                'type'  => 'text',
                'status'=> '',
            ),
            array(
                'label' => esc_html__( 'Address', 'ravis' ),
                'id'    => $prefix.'address',
                'type'  => 'text',
                'status'=> '',
            ),
            array(
                'label' => esc_html__( 'Special Requirements', 'ravis' ),
                'id'    => $prefix.'special_requirements',
                'type'  => 'textarea',
                'status'=> '',
            ),
            array(
                'label' => esc_html__( 'Check in', 'ravis' ),
                'id'    => $prefix.'check_in',
                'desc'  => esc_html__( 'This field is not editable. Please note to date you entered', 'ravis' ),
                'type'  => 'date',
                'status'=> '',
            ),
            array(
                'label' => esc_html__( 'Check out', 'ravis' ),
                'id'    => $prefix.'check_out',
                'desc'  => esc_html__( 'This field is not editable. Please note to date you entered', 'ravis' ),
                'type'  => 'date',
                'status'=> '',
            ),
            array(
                'label' => esc_html__( 'Booking Season', 'ravis' ),
                'id'    => $prefix.'season',
                'desc'  => esc_html__( 'This Field shows that the booking is in which season? "High Season" or "Low Season"', 'ravis' ),
                'type'  => 'read_only',
                'status'=> '',
            ),
        );

        add_action('add_meta_boxes', array($this, 'add_booking_details_meta_box'));
        add_action('save_post', array($this, 'save_booking_details_meta'));
    }


    // Add the Meta Box
    function add_booking_details_meta_box() {
        add_meta_box(
            'booking_details_meta_box', // $id
            esc_html__('Booking Details', 'ravis'), // $title 
            array($this, 'show_booking_details_meta_box'), // $callback
            'booking', // $page
            'normal', // $context
            'high'); // $priority
    }

    // Show the Fields in the Post Type section
    function show_booking_details_meta_box() 
    {
        global $post;

        // Use nonce for verification
        echo '<input type="hidden" name="booking_details_meta_box_nonce" value="'. esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
             
            // Begin the field table and loop
            echo '<table class="form-table">
                <tr>
                    <th>'.esc_html__('Booking ID :', 'ravis').'</th>
                    <td>'.esc_html($post->ID).'</td>
                </tr>';
            foreach ($this->booking_details_meta_fields as $field) {
                // get value of this field if it exists for this post
                $meta = get_post_meta($post->ID, $field['id'], true);
                
                // begin a table row with
                echo '<tr>
                        <th>'.esc_html( $field['label'] ).'</th>
                        <td>';
                        switch($field['type']) {
                            // text
                            case 'text':
                                echo '<input type="text" name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" value="'. esc_attr( $meta ).'" size="40" '.  esc_attr( $field['status'] ) .' />';
                            break;
                            // Email
                            case 'email':
                                echo '<input type="email" name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" value="'. esc_attr( $meta ).'" size="40" '.  esc_attr( $field['status'] ) .'/>';
                            break;
                            // textarea
                            case 'textarea':
                                echo '<textarea name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" cols="60" rows="4" '.  esc_attr( $field['status'] ) .' >'.esc_textarea( $meta ).'</textarea>';
                            break;

							// read_only
                            case 'read_only':
								if ($meta == 1) esc_html_e('High Season', 'ravis');
								elseif ($meta == 2) esc_html_e('Low Season', 'ravis');
								else esc_html_e('Normal Season', 'ravis');
                            break;

                            case 'date':
                                if($meta !='')
                                {
                                    esc_html_e( date("Y-m-d", $meta) );
                                }
                                else
                                {
                                    echo '<input type="text" class="datepicker" name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" value="'. esc_attr( ($meta ? date('Y-m-d',$meta) : "") ).'" size="30" />
                                            <br /><span class="description">'.esc_html($field['desc']).'</span>';
                                    
                                }
                            break;
                        } //end switch
                echo '</td></tr>';
            } // end foreach
            echo '</table>'; // end table
    }

    // Save the Data
    function save_booking_details_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['booking_details_meta_box_nonce']) && $_POST['booking_details_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['booking_details_meta_box_nonce'] );
        }
         
        // verify nonce
        if (!wp_verify_nonce($security_code, basename(__FILE__))) 
            return $post_id;
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        // check permissions
        if ('booking' == $_POST['post_type'])
        {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
        }
         
        // loop through fields and save the data
        foreach ($this->booking_details_meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
            if($field['type'] == 'date')
            {
                $new = strtotime($new);
            }
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                if($field['type'] == 'date') continue;
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // end foreach
    }
}

$booking_details_meta_box_obj = new Ravis_booking_details_meta_box;