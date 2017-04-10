<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Room Price Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_rooms_info_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $rooms_info_meta_fields = array();
    
    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'rooms_';
        $this->rooms_info_meta_fields = array(
            array(
                'label' => esc_html__( 'Short Description', 'ravis' ),
                'desc'  => esc_html__( 'Add a short description about this room to be shown in the room listing pages. Do Not use HTML tags.', 'ravis' ),
                'id'    => $prefix.'short_desc',
                'type'  => 'textarea',
            ),
            array(
                'label' => esc_html__( 'Room Count', 'ravis' ),
                'desc'  => esc_html__( 'Add the count of this kind of room in the hotel like : 30', 'ravis' ),
                'id'    => $prefix.'count',
                'type'  => 'text',
            ),
            array(
                'label' => esc_html__( 'Maximum Guest Count', 'ravis' ),
                'desc'  => esc_html__( 'Add the maximum count of guest can be placed in this room like : 5', 'ravis' ),
                'id'    => $prefix.'max_guest',
                'type'  => 'text',
            ),
            array(
                'label' => esc_html__( 'Minimum Stay', 'ravis' ),
                'desc'  => __( 'Add the minimum stay night for this room like : "2". <br> which means that guests must book this room for 2 or more nights. <br> Leave it blank if the room doesn\'t have minimum stay limitation.', 'ravis' ),
                'id'    => $prefix.'min_stay',
                'type'  => 'text',
            ),
            array(
                'label' => esc_html__( 'Room Size', 'ravis' ),
                'desc'  => esc_html__( 'Add the area of room in "SQF"', 'ravis' ),
                'id'    => $prefix.'room_size',
                'type'  => 'text',
            ),
            array(
                'label' => esc_html__( 'View', 'ravis' ),
                'desc'  => esc_html__( 'Add the view of room', 'ravis' ),
                'id'    => $prefix.'room_view',
                'type'  => 'text',
            )
        );

        add_action('add_meta_boxes', array( $this, 'add_rooms_info_meta_box'));
        add_action('save_post', array( $this, 'save_rooms_info_meta'));
    }

    // Add the Meta Box
    function add_rooms_info_meta_box() {
        add_meta_box(
            'rooms_info_meta_box', // $id
            esc_html__( 'Price info', 'ravis' ),
            array($this, 'show_rooms_info_meta_box'), // $callback
            'rooms', // $page
            'normal', // $context
            'high'); // $priority
    }


    // Show the Fields in the Post Type section
    function show_rooms_info_meta_box() 
    {
        global $post;

    	// Use nonce for verification
    	echo '<input type="hidden" name="rooms_info_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->rooms_info_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>
    	                <th><label for="'.esc_attr( $field['id'] ).'">'.esc_html($field['label']).'</label></th>
    	                <td>';
    	                switch($field['type']) {
                            // text
                            case 'text':
                                echo '<input type="text" name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" value="'.esc_attr( $meta ).'" size="40" />
                                    <br /><span class="description">'.balancetags( $field['desc'] ).'</span>';
                            break;
                            // textarea
                            case 'textarea':
                                echo '
                                    <textarea name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" cols="50" rows="5">'.esc_attr( $meta ).'</textarea>
                                    <br /><span class="description">'.esc_html( $field['desc'] ).'</span>';
                            break;

    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table
    }

    // Save the Data
    function save_rooms_info_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['rooms_info_meta_box_nonce']) && $_POST['rooms_info_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['rooms_info_meta_box_nonce'] );
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
        foreach ($this->rooms_info_meta_fields as $field) {
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

$rooms_info_meta_box_obj = new Ravis_booking_rooms_info_meta_box;