<?php 
/**
 * ------------------------------------------------------------------------------------------
 * Room Meta box file
 * ------------------------------------------------------------------------------------------
 */

class Ravis_booking_rooms_gallery_meta_box
{
    /**
     * Array of meta data list for the block dates
     * @var array
     */
    public $rooms_gallery_meta_fields = array();
    
    function __construct()
    {
        Ravis_Booking_main::load_plugin_text_domain();
        // Field Array
        $prefix = 'rooms_';
        $this->rooms_gallery_meta_fields = array(
            array(
                'label' => esc_html__( 'Image Gallery', 'ravis' ),
                'desc'  => esc_html__( 'Add the images of the rooms', 'ravis' ),
                'id'    => $prefix.'slideshow_images',
                'type'  => 'gallery'
            )
        );
        
        add_action('save_post', array($this, 'save_rooms_gallery_meta'));
        add_action('add_meta_boxes', array($this, 'add_rooms_gallery_meta_box'));
    }


    // Add the Meta Box
    function add_rooms_gallery_meta_box() {
        add_meta_box(
            'rooms_images_meta_box', // $id
            esc_html__( 'Room Images Gallery', 'ravis' ),
            array($this, 'show_rooms_gallery_meta_box'), // $callback
            'rooms', // $page
            'side'); // $priority

    }

    // Show the Fields in the Post Type section
    function show_rooms_gallery_meta_box() 
    {
    	global $post;
        
    	// Use nonce for verification
    	echo '<input type="hidden" name="rooms_gallery_meta_box_nonce" value="'.esc_attr( wp_create_nonce(basename(__FILE__)) ).'" />';
    	     
    	    // Begin the field table and loop
    	    echo '<table class="form-table">';
    	    foreach ($this->rooms_gallery_meta_fields as $field) {
    	        // get value of this field if it exists for this post
    	        $meta = get_post_meta($post->ID, $field['id'], true);
    	        // begin a table row with
    	        echo '<tr>
    	                <td>';
    	                switch($field['type']) {
    	                    // Gallery
    						case 'gallery':

                                /**
                                 * Required Js Codes
                                 */
    						    echo '
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($){

                                            // Set variables
                                            var $image_slideshow_ids = $(\'#rooms_slideshow_images\');
                                            var $slideshow_images = $(\'#ravis_slideshow_wrapper .slideshow_images\');

                                            // Make images sortable
                                            $slideshow_images.sortable({
                                                cursor: \'move\',
                                                items: \'.image\',
                                                update: function(event, ui) {
                                                    var attachment_ids = \'\';
                                                    $(\'#ravis_slideshow_wrapper ul .image\').css(\'cursor\',\'default\').each(function() {
                                                        var attachment_id = jQuery(this).attr( \'data-attachment_id\' );
                                                        attachment_ids = attachment_ids + attachment_id + \',\';
                                                    });
                                                    $image_slideshow_ids.val( attachment_ids );             
                                                }
                                            });

                                            // Uploading files
                                            var slideshow_frame;

                                            jQuery(\'.add_slideshow_images\').live(\'click\', function( event ){

                                                event.preventDefault();

                                                // If the media frame already exists, reopen it.
                                                if ( slideshow_frame ) {
                                                    slideshow_frame.open();
                                                    return;
                                                }

                                                // Create the media frame.
                                                slideshow_frame = wp.media.frames.downloadable_file = wp.media({

                                                    // Set the title of the modal.
                                                    title: \' '.esc_js(esc_html__( 'Add Images to Slideshow', 'ravis' )).' \',

                                                    // Set the button of the modal.
                                                    button: {
                                                        text: \' '. esc_js(esc_html__( 'Add to slideshow', 'ravis' ) ).' \',
                                                    },

                                                    // Set to true to allow multiple files to be selected
                                                    multiple: true

                                                });

                                                var $el = $(this);
                                                var attachment_ids = $image_slideshow_ids.val();

                                                // When an image is selected, run a callback.
                                                slideshow_frame.on( \'select\', function() {
                                                    var selection = slideshow_frame.state().get(\'selection\');
                                                    selection.map( function( attachment ) {
                                                        attachment = attachment.toJSON();
                                                        if ( attachment.id ) {
                                                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
                                                            $slideshow_images.append(\'\
                                                                <li class="image" data-attachment_id="\' + attachment.id + \'">\
                                                                    <img src="\' + attachment.url + \'" />\
                                                                    <span><a href="#" class="delete_slide" title="'.esc_js(esc_html__( 'Delete image', 'ravis' )).'">X</a></span>\
                                                                </li>\');
                                                        }
                                                    } );
                                                    $image_slideshow_ids.val( attachment_ids );
                                                });

                                                // Finally, open the modal
                                                slideshow_frame.open();

                                            });

                                            // Remove files
                                            $(\'#ravis_slideshow_wrapper\').on( \'click\', \'a.delete_slide\', function() {

                                                $(this).closest(\'.image\').remove();
                                                var attachment_ids = \'\';

                                                $(\'#ravis_slideshow_wrapper ul .image\').css(\'cursor\',\'default\').each(function() {
                                                    var attachment_id = jQuery(this).attr( \'data-attachment_id\' );
                                                    attachment_ids = attachment_ids + attachment_id + \',\';
                                                });

                                                $image_slideshow_ids.val( attachment_ids );
                                                return false;

                                            } );

                                        });
                                    </script>';
                                echo '
                                    <div id="ravis_slideshow_wrapper">
                                        <ul class="slideshow_images clearfix">';
                                            
                                            $slideshow_images = get_post_meta($post->ID,'rooms_slideshow_images', true);
                                            $slideshow_images = str_replace(' ,', '', $slideshow_images);

                                            $attachments = array_filter(explode(',', $slideshow_images));

                                            if ($attachments) {
                                                foreach ($attachments as $attachment_id) {
                                                    if($attachment_id == ' ') continue;
                                                    echo '<li class="image" data-attachment_id="'.esc_attr( $attachment_id ).'">'.wp_get_attachment_image($attachment_id, 'image').'<a href="#" class="delete_slide" title="'.esc_attr( esc_html__( 'Delete image', 'ravis') ).'">X</a></li>';
                                                }
                                            }
                                    echo '        
                                        </ul>
                                        <input type="hidden" id="rooms_slideshow_images" name="rooms_slideshow_images" value="'. esc_attr( $slideshow_images ) .' " />
                                    </div>
                                    <p class="add_images_wrapper hide-if-no-js">
                                        <a href="#" class="add_slideshow_images">'. esc_html__( 'Add slideshow images', 'ravis' ) .'</a>
                                    </p>';
    						break;
    	                } //end switch
    	        echo '</td></tr>';
    	    } // end foreach
    	    echo '</table>'; // end table
    }

    // Save the Data
    function save_rooms_gallery_meta($post_id)
    {
        $security_code = '';
        
        if(isset($_POST['rooms_gallery_meta_box_nonce']) && $_POST['rooms_gallery_meta_box_nonce'] !='')
        {
            $security_code = sanitize_text_field( $_POST['rooms_gallery_meta_box_nonce'] );
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
        foreach ($this->rooms_gallery_meta_fields as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = str_replace(' ,', '', $_POST[$field['id']]);
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // end foreach
    }
}

$rooms_gallery_meta_box_obj = new Ravis_booking_rooms_gallery_meta_box;