<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Room Price Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_rooms_price_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $rooms_price_meta_fields = array();

    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'rooms_';
        $this->rooms_price_meta_fields = array(
            array(
                'label' => esc_html__( 'Price', 'ravis' ),
                'desc'  => esc_html__( 'Add the Price of the room', 'ravis' ),
                'id'    => $prefix.'price',
                'type'  => 'slider',
                'min'   => '0',
                'max'   => '1000',
                'step'  => '1',
                'unit'  => '$'
            )
        );

        add_action('add_meta_boxes', array($this, 'add_rooms_price_meta_box'));
        add_action('save_post', array($this, 'save_rooms_price_meta'));
        add_action('admin_head', array($this, 'add_slider_scripts'));
    }

    // Add the Meta Box
    function add_rooms_price_meta_box() {
        add_meta_box(
            'rooms_price_meta_box', // $id
            esc_html__( 'Price Details', 'ravis' ),
             array($this, 'show_rooms_price_meta_box'), // $callback
            'rooms', // $page
            'normal', // $context
            'high'); // $priority
    }


    // Show the Fields in the Post Type section
    function show_rooms_price_meta_box() 
    {
    	global $post;
        
    	// Use nonce for verification
    	echo '<input type="hidden" name="rooms_price_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->rooms_price_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>
    	                <th><label for="'.esc_attr($field['id']).'">'.esc_html($field['label']).'</label></th>
    	                <td>';
    	                switch($field['type']) {
                            case 'slider':
                                $value = $meta != '' ? $meta : '0';
                                    echo '<div id="'.esc_attr( $field['id'] ).'-slider"></div>
                                            <input type="text" name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" value="'.esc_attr( $value ).'" size="4" />'. esc_html( $field['unit'] ) .'
                                            <br /><span class="description">'.esc_html($field['desc']).'</span>';
                            break;

    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table
    }

    // Save the Data
    function save_rooms_price_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['rooms_price_meta_box_nonce']) && $_POST['rooms_price_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['rooms_price_meta_box_nonce'] );
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
        foreach ($this->rooms_price_meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];        
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // end foreach
    }

    /**
     * Range Slider function
     */
    function add_slider_scripts()
    {
        global $post;
        $post_ID = isset($post->ID) ? $post->ID : '';
        $output = '<script type="text/javascript">
                    jQuery(function() {';

        foreach ($this->rooms_price_meta_fields as $field)
        { // loop through the fields looking for certain types
            if($field['type'] == 'slider')
            {
                $value = get_post_meta($post_ID, $field['id'], true);
                if ($value == '') $value = $field['min'];
                $output .= '
                    jQuery( "#'.esc_js($field['id']).'-slider" ).slider({
                        value: '.esc_js($value).',
                        min: '.esc_js($field['min']).',
                        max: '.esc_js($field['max']).',
                        step: '.esc_js($field['step']).',
                        slide: function( event, ui ) {
                            jQuery( "#'.esc_js($field['id']).'" ).val( ui.value );
                        }
                    });';
            }
        }
         
        $output .= '});
            </script>';
             
        echo balancetags( $output );
    }

}

$rooms_price_meta_box_obj = new Ravis_booking_rooms_price_meta_box;
