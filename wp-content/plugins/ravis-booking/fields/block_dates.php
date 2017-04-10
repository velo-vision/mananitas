<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Block Dates Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_block_dates_meta
{

    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $block_dates_meta_fields = array();


    /**
     * Add required function for Save and adding meta data. Fire the init function up. 
     */
    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        add_action('add_meta_boxes', array($this,'add_block_dates_meta_box'));
        add_action('save_post', array($this,'save_block_dates_meta'));
        add_action('init', array($this, 'init')); 
    }

    /**
     * Init function for generating $block_dates_meta_fields
     * @return array list of metadata 
     */
    public function init()
    {
        /**
         * Generate the Query for getting the posts
         * @var array   $args
         */
        $args = array(
            'post_type'   => 'rooms',
            'post_status' => 'publish',
            'order'       => 'DESC',
            'orderby'     => 'date',
            'nopaging'    => true,
        );
        $yoona_rooms_list  = new WP_Query( $args );

        /**
         * Loading post for making the services_list
         */
        if ( $yoona_rooms_list->have_posts() ) 
        {
            global $post;
            /**
             * Generating the services_list HTML codes
             * @var string   yoona_services_code_list
             */
                        
            $yoona_services_code_list = '';
            /**
             * Loop for getting post data
             */
            while ( $yoona_rooms_list->have_posts() )
            {
                $yoona_rooms_list->the_post();
                $blocked_rooms[] = array (
                                            'label' => get_the_title(),
                                            'value' => get_the_id()
                                        );
            }
        }

        // Field Array
        $prefix = 'block_dates_';
        $this->block_dates_meta_fields = array(
            array(
                'label' => esc_html__( 'From', 'ravis' ),
                'desc'  => esc_html__( 'Select the block date starting date', 'ravis' ),
                'id'    => $prefix.'from',
                'type'  => 'date',
                'class' => 'from'
            ),
            array(
                'label' => esc_html__( 'To', 'ravis' ),
                'desc'  => esc_html__( 'Select the block date ending date', 'ravis' ),
                'id'    => $prefix.'to',
                'type'  => 'date',
                'class' => 'to'
            ),
            array(
                'label'   => esc_html__( 'Select Rooms', 'ravis' ),
                'desc'    => esc_html__( 'Select rooms which is blocked', 'ravis' ),
                'id'      => $prefix.'blocked_rooms',
                'type'    => 'checkbox_group',
                'options' => (isset($blocked_rooms) ? $blocked_rooms : '')
            )
        );

    }

        

    // Add the Meta Box
    public function add_block_dates_meta_box() {
        add_meta_box(
            'block_dates_meta_box', // $id
            esc_html__('Block Dates Information', 'ravis'), // $title 
            array($this, 'show_block_dates_meta_box'), // $callback
            'block_dates', // $page
            'normal', // $context
            'high'); // $priority
    }

    // Show the Fields in the Post Type section
    public function show_block_dates_meta_box() 
    {
    	global $post;

    	// Use nonce for verification
    	echo '<input type="hidden" name="block_dates_meta_box_nonce" value="'. esc_attr( wp_create_nonce(basename(__FILE__)) ) .'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->block_dates_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>';
    	        if($field['type'] != 'checkbox_group')
    	        {
    	         	echo '<th><label for="'. esc_attr( $field['id'] ) .'">'.esc_html($field['label']).'</label></th>';
    	        }
    	            echo '<td '.( $field['type'] == 'checkbox_group' ? esc_attr( 'colspan=2' ) : '').'>';
    	                switch($field['type']) {
    	                    // text
    						case 'text':
    						    echo '<input type="text" name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" value="'. esc_attr( $meta ).'" size="30" />
    						        <br /><span class="description">'.esc_html($field['desc']).'</span>';
    						break;
    						case 'date':
    							echo '<input type="text" class="datepicker '. esc_attr( $field['class'] ).'" name="'. esc_attr( $field['id'] ).'" id="'. esc_attr( $field['id'] ).'" value="'.($meta ?  esc_attr( date('Y-m-d',$meta) ) : "").'" size="30" />
    									<span class="description">'.esc_html($field['desc']).'</span>';
    						break;
    						// checkbox_group
                            case 'checkbox_group':
                                echo '
                                <div class="ravis-meta-field-title"><h4>'.esc_html($field['label']).'</h4><span class="description"> ( '.esc_html($field['desc']).' )</span></div>
                                <ul class="list-inline">';
                                if( $field['options'] !='' )
                                {
                                    foreach ($field['options'] as $option) {
                                        echo '
                                        <li>
                                            <input type="checkbox" value="'. esc_attr( $option['value'] ).'" name="'. esc_attr( $field['id'] ).'[]" id="'. esc_attr( $option['value'] ).'"',$meta && in_array($option['value'], $meta) ? esc_attr(' checked="checked"') : '',' /> 
                                            <label for="'. esc_attr( $option['value'] ).'">'.esc_html($option['label']).'</label>
                                        </li>';
                                    }                                    
                                }
                                echo '</ul>';
                            break;
    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table

    	    echo '
    		<script type="text/javascript">
    		jQuery(document).ready(function(){
    			jQuery(".datepicker" ).datepicker( "destroy" );
    			jQuery(".datepicker.from").datepicker({ 
    	    		dateFormat: "yy-mm-d",
    	    		minDate: 0,
    	    		numberOfMonths: 2,
    	    		onClose: function( selectedDate ) {
    			        jQuery( ".to" ).datepicker( "option", "minDate", selectedDate );
    			    }
    	    	});
    			jQuery(".datepicker.to").datepicker({ 
    	    		dateFormat: "yy-mm-d",
    	    		minDate: 0,
    	    		numberOfMonths: 2,
    	    		onClose: function( selectedDate ) {
    			        jQuery( ".from" ).datepicker( "option", "maxDate", selectedDate );
    			    }
    	    	});
    		})
    		</script>';
    }

    // Save the Data
    public function save_block_dates_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['block_dates_meta_box_nonce']) && $_POST['block_dates_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['block_dates_meta_box_nonce'] );
        }
        // verify nonce
        if (!wp_verify_nonce($security_code, basename(__FILE__))) 
            return $post_id;
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        // check permissions
        if ('block_dates' == $_POST['post_type'])
        {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
        }
         
        // loop through fields and save the data
        foreach ($this->block_dates_meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = ( $field['type'] =='date' ? strtotime($_POST[$field['id']]) : $_POST[$field['id']] );
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // end foreach
    }    
}

$block_dates_meta_obj = new Ravis_booking_block_dates_meta;