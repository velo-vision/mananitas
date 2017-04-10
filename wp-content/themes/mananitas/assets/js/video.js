(function(){
    "use strict";
    jQuery(".pinar-video-container").each(function(){
        var container = jQuery(this);
        var sourtPath = container.attr('data-video-path');
        var itemNumber = container.attr('data-video-number');

        var posterImg = sourtPath + itemNumber + '/' + itemNumber + '.jpg';
        var mp4Source = sourtPath + itemNumber + '/' + itemNumber + '.mp4';
        var oggSource = sourtPath + itemNumber + '/' + itemNumber + '.ogg';
        var webmSource = sourtPath + itemNumber + '/' + itemNumber + '.webm';

        var htmlMarkUp = '<video muted autoplay loop preload="auto" poster="'+posterImg+'">' +
            '<source src="'+mp4Source+'" type="video/mp4">' +
            '<source src="'+oggSource+'" type="video/ogg">' +
            '<source src="'+webmSource+'" type="video/webm">' +
            '</video>';
        container.append(htmlMarkUp);
    });

    jQuery('.pinar-video-container').on('click', function(event) {
        event.preventDefault();
        var $this          = jQuery(this),
            videoHeight    = $this.find('video').height();
        if(!$this.hasClass('first-play'))
        {
            $this.addClass('first-play');
        }
        if($this.hasClass('playing'))
        {
            $this.removeClass('playing');
            $this.children('video')[0].pause();
            $this.animate({height: 500});
        }
        else
        {
            $this.addClass('playing');
            $this.children('video')[0].play();
            $this.animate({height: videoHeight});
        }
    });
})(jQuery, window, document)