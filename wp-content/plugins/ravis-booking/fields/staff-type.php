<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Page Class Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_staff_type_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $staff_type_meta_fields = array();

    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'staff_box_';
        $this->staff_type_meta_fields = array(
            array(
                'desc'  => esc_html__( 'Check this box if you want to show staff in the staff\'s slider', 'ravis' ),
                'id'    => $prefix.'in_slider',
                'type'  => 'checkbox'
            ),
            array(
                'desc'  => esc_html__( 'Check this box if you want to show staff in the staff tiled list', 'ravis' ),
                'id'    => $prefix.'tile',
                'type'  => 'checkbox'
            )
        );
        
        add_action('add_meta_boxes', array($this, 'add_staff_type_meta_box'));
        add_action('save_post', array($this, 'save_staff_type_meta'));     
    }

    // Add the Meta Box
    function add_staff_type_meta_box() {
        add_meta_box(
            'staff_type_meta_box', // $id
            esc_html__( 'Setting', 'ravis' ),
            array($this, 'show_staff_type_meta_box'), // $callback
            'staff', // $page
            'side', // $context
            'low'); // $priority
    }



    // Show the Fields in the Post Type section
    function show_staff_type_meta_box() 
    {
        global $post;
        
        // Use nonce for verification
        echo '<input type="hidden" name="staff_type_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
             
            // Begin the field table and loop
            echo '<table class="form-table">';
            foreach ($this->staff_type_meta_fields as $field) {
                // get value of this field if it exists for this post
                $meta = get_post_meta($post->ID, $field['id'], true);
                // begin a table row with
                echo '<tr>
                        <td>';
                        switch($field['type']) {
                            // checkbox
                            case 'checkbox':
                                echo '<input type="checkbox" name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" ',$meta ? esc_html( ' checked="checked"' ) : '','/>
                                    <label for="'.esc_attr( $field['id'] ).'">'.esc_html($field['desc']).'</label>';
                            break;
                        } //end switch
                echo '</td></tr>';
            } // end foreach
            echo '</table>'; // end table
    }

    // Save the Data
    function save_staff_type_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['staff_type_meta_box_nonce']) && $_POST['staff_type_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['staff_type_meta_box_nonce'] );
        }

        // verify nonce
        if (!wp_verify_nonce($security_code, basename(__FILE__))) 
            return $post_id;
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        // check permissions
        if ('staff_type' == $_POST['post_type'])
        {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
        }
         
        // loop through fields and save the data
        foreach ($this->staff_type_meta_fields as $field) {
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
$staff_type_meta_box_obj = new Ravis_booking_staff_type_meta_box;