<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Room Services Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_rooms_service_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $rooms_service_meta_fields = array();

    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        add_action('add_meta_boxes', array($this, 'add_rooms_service_meta_box'));
        add_action('save_post', array($this, 'save_rooms_service_meta'));
        add_action('init', array($this, 'init'));    
    }

    // Add the Meta Box
    function add_rooms_service_meta_box() {
        add_meta_box(
            'rooms_service_meta_box', // $id
            esc_html__('Room Services', 'ravis' ), // $title 
            array($this, 'show_rooms_service_meta_box'), // $callback
            'rooms', // $page
            'normal', // $context
            'high'); // $priority
    }

    function init()
    {
        // Field Array
        $prefix = 'rooms_';

        /**
         * Generate the Query for getting the posts
         * @var array   $args
         */
        $args = array(
            'post_type'   => 'service',
            'post_status' => 'publish',
            'order'       => 'DESC',
            'orderby'     => 'date',
            'nopaging'    => true,
        );
        $pinar_services_list  = new WP_Query( $args );

        /**
         * Loading post for making the services_list
         */
        if ( $pinar_services_list->have_posts() ) 
        {
            global $post;
            /**
             * Generating the services_list HTML codes
             */
                        
            /**
             * Loop for getting post data
             */
            while ( $pinar_services_list->have_posts() )
            {
                $pinar_services_list->the_post();
                $all_services[] = array (
                                            'label' => get_the_title(),
                                            'value' => get_the_id()
                                        );
            }
        }

        /**
         * Restore original Post Data
         */
        wp_reset_postdata();

        $this->rooms_service_meta_fields = array(
            array(
                'label'   => esc_html__( 'Services', 'ravis' ),
                'desc'    => esc_html__( 'Select the services which is available for this room.', 'ravis' ),
                'id'      => $prefix.'services_checkboxes',
                'type'    => 'checkbox_group',
                'options' => (isset($all_services) ? $all_services : '')
            )
        );

    }

    // Show the Fields in the Post Type section
    function show_rooms_service_meta_box() 
    {
    	global $post;
    	// Use nonce for verification
    	echo '<input type="hidden" name="rooms_service_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->rooms_service_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>
    	                <td>';
    	                switch($field['type']) {
                            // checkbox_group
                            case 'checkbox_group':
                                echo '
                                <ul class="list-inline">';
                                if($field['options'] != '')
                                {
                                    foreach ($field['options'] as $option) {
                                        echo '
                                        <li>
                                            <input type="checkbox" value="'.esc_attr( $option['value'] ).'" name="'.esc_attr( $field['id'] ).'[]" id="'.esc_attr( $option['value'] ).'"',$meta && in_array($option['value'], $meta) ? esc_html( ' checked="checked"' ) : '',' /> 
                                            <label for="'.esc_attr( $option['value'] ).'">'.esc_html($option['label']).'</label>
                                        </li>';
                                    }                                    
                                }
                                echo '</ul>';
                            break;

    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table
    }

    // Save the Data
    function save_rooms_service_meta($post_id)
    {
        $security_code = '';
            
        if(isset($_POST['rooms_service_meta_box_nonce']) && $_POST['rooms_service_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['rooms_service_meta_box_nonce'] );
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
        foreach ($this->rooms_service_meta_fields as $field) {
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

$rooms_service_meta_box_obj = new Ravis_booking_rooms_service_meta_box;
