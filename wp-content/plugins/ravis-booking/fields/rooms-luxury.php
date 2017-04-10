<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Room luxury Meta box file
 * It will generate the checkbox that select the room is located in the luxury rooms shortcode
 * or not
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_rooms_luxury_meta_box
{
    
    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'rooms_';
        $this->rooms_luxury_meta_fields = array(
            array(
                'label' => esc_html__('Luxury Room', 'ravis'),
                'desc'  => esc_html__('Check this checkbox if you want to "Luxury Rooms" shortcode shows it.', 'ravis'),
                'id'    => $prefix.'luxury',
                'type'  => 'checkbox',
            )
        );
        add_action('save_post', array($this, 'save_rooms_luxury_meta'));        
        add_action('add_meta_boxes', array($this, 'add_rooms_luxury_meta_box'));
    }

    // Add the Meta Box
    function add_rooms_luxury_meta_box() {
        add_meta_box(
            'rooms_luxury_meta_box', // $id
            esc_html__('luxury Details', 'ravis'),
            array($this, 'show_rooms_luxury_meta_box'), // $callback
            'rooms', // $page
            'side', // $context
            'low'); // $priority
    }    


    // Show the Fields in the Post Type section
    function show_rooms_luxury_meta_box() 
    {
    	global $post;
        
    	// Use nonce for verification
    	echo '<input type="hidden" name="rooms_luxury_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->rooms_luxury_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>
    	                <td>';
    	                switch($field['type']) {
                            case 'checkbox':
                                case 'checkbox':
                                    echo '<input type="checkbox" name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" ',$meta ? esc_html( ' checked="checked"' ) : '','/>
                                        <label for="'.$field['id'].'">'.esc_html($field['desc']).'</label>';
                                break;
                            break;

    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table
    }

    // Save the Data
    function save_rooms_luxury_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['rooms_luxury_meta_box_nonce']) && $_POST['rooms_luxury_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['rooms_luxury_meta_box_nonce'] );
        }
        // verify nonce
        if (!wp_verify_nonce($security_code, basename(__FILE__))) 
            return $post_id;
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        // check permissions
        if ('rooms' == $_POST['post_type'])
        {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
        }


        // loop through fields and save the data
        foreach ($this->rooms_luxury_meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];        
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // end foreach
    }
    
}

$rooms_luxury_meta_box_obj = new Ravis_booking_rooms_luxury_meta_box;