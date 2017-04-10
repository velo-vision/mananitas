"use strict";
function chosen_drop_down(){
    var winHeight  = jQuery(window).height();
    jQuery('.chosen-container').each(function(){
        var a = ( winHeight - jQuery(this).offset().top) + jQuery(window).scrollTop();
        (a < 240 ) ? jQuery(this).addClass('top-dropdown') : jQuery(this).removeClass('top-dropdown');
    })
};

jQuery(document).ready(function() {
    // Go Up
    jQuery('#go-up-box').on('click',function(){
        jQuery('body,html').animate({
            scrollTop: 0
        }, 1000);
    });

    new WOW().init();

    // Clone the main menu to the mobile menu
    jQuery('#main-menu').clone().appendTo('#mobile-menu-container');

    // Enable Manu menu toggling
    jQuery('#main-menu-handle').on('click', function() {
        jQuery(this).toggleClass('active');
        jQuery('#mobile-menu-container').slideToggle();
    });

    // Main Slider
	jQuery("#main-slider").owlCarousel({
        navigation : !1,
        singleItem : !0,
        addClassActive : !0,
        autoPlay : !0,
        mouseDrag : !1,
        touchDrag : !1,
    });

    // Room Detail Slider
    jQuery("#room-details-slider").owlCarousel({
        navigation : !1,
        singleItem : !0,
        addClassActive : !0,
        autoPlay : !0
    });

    // Booking datepicker
    jQuery("#main-booking-form .input-daterange, #booking-form .input-daterange, .booking-form .input-daterange, .booking-title-box form.booking-form .input-daterange").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
		language : pinar.datePickerLang,
        startDate: new Date()
    });

    // Booking tab Date Picker
    jQuery("#booking-tab-contents .booking-dates").datepicker({
        format: "yyyy-mm-dd",
        startDate: new Date(),
		language : pinar.datePickerLang,
        inputs: jQuery('.booking-date-fields-container')
    }).on('changeDate', function(e){
        var $this = jQuery(e.target);
        $this.find('input[type=hidden]').val(e.format('yyyy-mm-dd'))
    })

    // Chosen Select box
    jQuery("select").chosen();

    // Enable the magnificPopup
    jQuery('.image-main-box').magnificPopup({
        delegate: '.more-details',
        type: 'image',
        removalDelay: 600,
        mainClass: 'mfp-fade',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            titleSrc: 'data-title',
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });

    // Enable isotop for gallery
    var mainContainer = jQuery(".image-main-box");
    mainContainer.isotope({
        transitionDuration: "0.7s"
    });
    mainContainer.imagesLoaded( function() {
        mainContainer.isotope("layout");
        jQuery(".sort-section-container").on( "click", "a", function(e) {
            e.preventDefault();
            jQuery(".sort-section-container a").removeClass("active");
            jQuery(this).addClass("active");
            var filterValue = jQuery(this).attr("data-filter");
            mainContainer.isotope({ filter: filterValue });
        });
    });

    // Service & Staff Slider
    jQuery("#services-box, #staff-slider").owlCarousel({
        items : 3,
        itemsDesktop : [1200,3],
        itemsTablet : [980,2],
        itemsMobile : [480,1],
        navigation : !1,
        pagination : !0
    });

    // Enable isotop for Room Masonry
    var masonryRoomContainer = jQuery(".room-container.room-masonry");
    masonryRoomContainer.imagesLoaded( function() {
        masonryRoomContainer.isotope({
            transitionDuration: "0.7s"
        });
    })

    // Enable isotop for Testimonials
    var mainTestimonialsBox = jQuery("#testimonials-container-box");
    mainTestimonialsBox.imagesLoaded( function() {
        mainTestimonialsBox.isotope({
            transitionDuration: "0.7s"
        });
    })

    // Main Slider
    jQuery("#fullscreen-slider").owlCarousel({
        navigation : !1,
        singleItem : !0,
        addClassActive : !0,
        autoPlay : !0
    });

    chosen_drop_down();

    // Enable Add Testimonials effect
    var addTestimonialBox = jQuery('.add-testimonials-box');
    addTestimonialBox.on('click', '.front-box', function(e) {
        jQuery(this).addClass('hide');
        jQuery(this).siblings('.back-box').removeClass('hide');
    });
    addTestimonialBox.on('click', '.back-box .fa-close', function(e) {
        jQuery(this).parent().addClass('hide');
        jQuery(this).parent().siblings('.front-box').removeClass('hide');
    });

    // Mobile Sort initialize
    jQuery('.sort-handle').on('click',function () {
        jQuery(this).next('ul').slideToggle();
    });

    // Make all list of expand packages inline
    jQuery('#special-packages-type-2').find('.package-details ul').addClass('list-inline');

    // Make the room list view equal height
    jQuery('.room-container.room-list').children('.room-box').each(function() {
        var $this       = jQuery(this),
            detailBox   = $this.children('.details'),
            imgBox      = $this.children('.img-container');
        if(detailBox.outerHeight() > 250){
            imgBox.height(detailBox.outerHeight());
        }
    });

    /**
     * Submit add testimonials by ajax
     */
    jQuery('form.add-testimonials').on('submit', function(e) {
        e.preventDefault();
        var testimonialsForm    = jQuery(this),
            firstName           = testimonialsForm.find(".fname").val(),
            email               = testimonialsForm.find(".email").val(),
            tel                 = testimonialsForm.find(".phone").val(),
            title               = testimonialsForm.find(".testimonial-title").val(),
            testimonials        = testimonialsForm.find(".testimonial").val();

        testimonialsForm.addClass('loading');

        var data = {
            action: "insert_testimonials",
            firstName: firstName,
            email: email,
            tel: tel,
            title: title,
            testimonials: testimonials
        };

        jQuery.post(pinar.ajaxurl, data, function(data){
            var data = JSON.parse(jQuery.trim(data));
            testimonialsForm.removeClass('loading');
            testimonialsForm.html('<div class="respond-message">'+data.message+'</div>');
        });
    });

    /**
     * Text slider
     */
    jQuery('.text-slider').each(function() {
        var textSliderMain  = jQuery(this),
            textItems       = textSliderMain.find('.text-slide-box'),
            itemCount       = textItems.length,
            currentItem     = 0;
        setInterval(function () {
            if(currentItem == itemCount) {
                currentItem = 0;
            }
            textItems.removeClass('active').eq(currentItem).addClass('active');
            currentItem++;
        }, 5000)
        
    });


});

jQuery(window).scroll(function() {
    jQuery(document).scrollTop() > 30 && jQuery("#main-header").addClass("sticky");
    jQuery(document).scrollTop() < 30 && jQuery("#main-header").removeClass("sticky");
    chosen_drop_down();
});

jQuery(window).resize(function() {
    chosen_drop_down();
});