
var slider = {

    'transitionTime': 900,
    'transitionDelay': 7000,
    'instantPeaceTime': 1000,
    'rotateThumbTime': 100,
    'timer':  0, 
    'activePageID': 2,
    'oldTag':  "de", 
    'newTag': "ar",
    'nextTag':  { 'de': 'ar', 'ar': 'it', 'it': 'he', 'he': 'de'},
    'backgroundView': 'off',
    'windowRatio': 1,

    autoTransition: function ( ) {
        $('.tags').trigger('mousein');
        slider.oldTag = slider.nextTag[slider.oldTag];
        slider.newTag = slider.nextTag[slider.newTag];
    },

    /**
     * This function is called every time the viewport's size and/or aspect changes as well as on startup
     */
    cleanup: function ( thumb ) {
        //return;
        // adjust size of background images
        slider.windowRatio = $(window).width() / $(window).height();
        $('.background').find('img').each( function () {
            var thisImg = $(this);
            var newImg = new Image();
            newImg.onload = function() {
                bgImageRatio = newImg.width / newImg.height;
                bgImageDisplayWidth = $(window).height() * bgImageRatio;
                bgImageDisplayHeight = $(window).width() / bgImageRatio;
                if ( bgImageRatio > slider.windowRatio ) {
                    var positionLeft = ( $(window).width() - bgImageDisplayWidth ) / 2;
                    thisImg.css( { 'height': $(window).height(), 'width': 'auto', 'max-width': 'none', 'left': positionLeft, 'top': 0 } );
                } else {
                    var positionTop = ( $(window).height() - bgImageDisplayHeight ) / 2;
                    thisImg.css( { 'width': $(window).width(), 'height': 'auto', 'max-height': 'none', 'top': positionTop, 'left': 0 } );
                }
            }
            newImg.src = thisImg.attr('src');
        });

        // adjust position of hidden content items (trigger actual slide)
        slider.slide( thumb );

        // hide progress gif
        $('body').css( { 'background-image': 'none' });

        //$('main.slide').height( $(window).height() );
        //$('#content').css('padding-top', $('#thumbs').height() ).css('height', $(window).height() );
    },

    slide: function ( thisThumb ) {

        // multiplied with all delays this factor is set to 0 when slide() is called to adjust positions after window size changes
        var delayFactor = 1;

        // if no thumb was passed, set delay factor to 0 and use the active thumb
        if ( !thisThumb ) {
            delayFactor = 0;
            thisThumb = $('.thumb.active').first();
        }

        // if still no thumb (no active thumb!), use the first
        if ( !thisThumb ) {
            thisThumb = $('.thumb:first-child');
        }


        // first of all rotate the thumb!        
        thisThumb.css( {'transform': 'rotate(45deg)', 'transition': slider.rotateThumbTime + 'ms ease-out', 'transition-delay': 'none'}).addClass('active');
        // first of all, stretch the thumb
        thisThumb.css( {'transform': 'scaleX(2)', 'transition': slider.rotateThumbTime+ 'ms ease-out', 'transition-delay': 'none'}).addClass('active');

        // get the active content item
        var activeItem = $('.content-item.active');
        // get page ID
        var thumbID = thisThumb.attr('id');
        var contentID =  thumbID.replace( "thumb", "content");
        var backgroundID = thumbID.replace( "thumb", "background");
        var newPageID = thumbID.replace("thumb_", "");

        // get the first thumb's id and delete body background image (progress gif) if not the first thumb was clicked (i.e. page loaded)
        var firstThumbID = $('.thumb:first-child').attr('id');

        var leftPositionOfClickedThumb = thisThumb.offset().left;
        var leftPositionOfFirstThumb = thisThumb.parent().children('.thumb').first().offset().left;
        var leftPositionOfWindowCenter = $(window).width() / -2;
        var widthOfThumb = $('#'+thumbID).width();

        // get the distance from first thumb to clicked thumb
        var offset = leftPositionOfClickedThumb - leftPositionOfFirstThumb;
        // get the center of the document minus half of the width of one thumb (to align the thumb centered)
        var center = leftPositionOfWindowCenter - ( widthOfThumb / 2 );
        // the translate offset for the thumbs-div is the center position minus the offset of the thumb
        var translation = center - offset;

        var positionHideRight = 0;
        var positionHideLeft = -2 * $(window).width();
        var positionShow = -1 * $(window).width();;
        var positionHide = positionHideLeft;

/*                    var oldLeft = $(this).offset().left;
        var newLeft = ( $(document).width() / 2 ) - ( $(this).width() / 2 ) ;
        var offset = newLeft - oldLeft;
        var thumbsLeft = $('#thumbs').position().left + offset;
*/

        // run animations

        // rotate back active thumb
        $('.thumb.active').not(thisThumb)
                .css({'transform':'rotate(0deg)', 'transition': slider.rotateThumbTime + 'ms ease-out', 'transition-delay': 'none'})
                .attr('title', '')
                .removeClass('active');

        // fade out active background
        $('.background.active').css( {  
                'opacity': 0,
                'transition': slider.transitionTime+'ms ease-in-out',
                'transition-delay': delayFactor * 1 * slider.transitionTime+'ms'
            }).removeClass('active');

        // fade in new background
        $('#'+backgroundID).css( {
                'opacity': 0.8,
                'transition': slider.transitionTime+'ms ease-in-out',
                'transition-delay': delayFactor * 1 * slider.transitionTime+'ms'
            }).addClass('active');

        // move  thumbs-bar to the left or the right
        $('#thumbs').css( { 
                'transform': 'translate('+translation+'px,0)',
                'transition': slider.transitionTime+'ms ease-out',
                'transition-delay': delayFactor * 1 * slider.rotateThumbTime+'ms'
            });

/*        // move in new content
        $('#'+contentID).scrollTop(0).show().css({
                'transform': 'translate( ' + positionShow + 'px, 0)',
                'transition': slider.transitionTime+'ms ease-in-out',
                'transition-delay': delayFactor * 1.5 * slider.transitionTime+'ms'
            }).addClass('active');                

        // move out old content
        $('.content-item.active').css( {
            'transform': 'translate( ' + positionHide + 'px, 0)',
            'transition': slider.transitionTime+'ms ease-in-out',
            'transition-delay': delayFactor * 0.5 * slider.transitionTime+'ms'
        }).removeClass('active');
*/


        $('.content-item').each( function () {

            if ( $(this).attr('id') == contentID ) {
                positionHide = positionHideRight;
                
                // move in new content
                $(this).scrollTop(0).show().css({
                    'transform': 'translate( ' + positionShow + 'px, 0)',
                    'transition': slider.transitionTime+'ms ease-in-out',
                    'transition-delay': delayFactor * 1.5 * slider.transitionTime+'ms'
                }).addClass('active');                

            } else if ( $(this).hasClass('.active') ) {
                $(this).css( {
                    'transform': 'translate( ' + positionHide + 'px, 0)',
                    'transition': slider.transitionTime+'ms ease-in-out',
                    'transition-delay': delayFactor * 0.5 * slider.transitionTime+'ms'
                }).removeClass('active');
            } else {
                $(this).css( {
                    'transform': 'translate( ' + positionHide + 'px, 0)',
                    'transition': 'none',
                    'transition-delay': 'none'
                })
            }
        });

/*
        activeItem.removeClass('active').css( {
                'overflow': 'hidden',
                'transform': 'translate( ' + leftPositionOldContent + 'px, 0)',
                'transition': slider.transitionTime+'ms ease-in-out',
                'transition-delay': 0 * slider.transitionTime+'ms'
            }).on( 'transitionend', function ( ) {
                activeItem.css( {
                        'transform': 'translate( 1000px, 0)',
                        'transition': 'none'
                    });
            });
        $('#'+contentID).css({
                'transform': 'translate( ' + leftPositionCurrentContent + 'px, 0)',
                'transition': slider.transitionTime+'ms ease-in-out',
                'transition-delay': 1 * slider.transitionTime+'ms'
            }).addClass('active');
*/
        slider.activePageID = thumbID.replace( "thumb_", "");

/*                    alert ( 
            "leftPositionOfClickedThumb: " + leftPositionOfClickedThumb  + 
            " :: leftPositionOfFirstThumb: "  + leftPositionOfFirstThumb + 
            " :: leftPositionOfWindowCenter: " + leftPositionOfWindowCenter + 
            " :: widthOfThumb: " + widthOfThumb +
            " :: offset: " + offset + 
            " :: center: " + center + 
            " :: translation: " + translation );
*/
    }    

}



$(document).ready( function () {
    $(window).load( function () {


        // prepare elements for first slide
//        $('#thumbs').css('transform', 'translate('+ $(window).width() + 'px,0)' ).show();
//        $('.content-item').css('transform','translate(' + $(window).width() + 'px, 0' ).show();
        // first of all show background image
        $('.background:first-child').css( {
                'opacity': 1,
                'transition': slider.transitionTime+'ms ease-in-out'
            }).addClass('active');

        // start autotransition 
        window.clearInterval( slider.timer );
        slider.timer = window.setInterval('slider.autoTransition()', slider.transitionDelay );

        // event handler for changing tags (auto transition)
        $('.tags').on('mousein', function () {
            $( '.tag-'+slider.oldTag ).fadeOut(slider.transitionTime);
            $( '.tag-'+slider.newTag ).fadeIn(slider.transitionTime);
        })

        // event handler for changing window size
        $(window).on('resize', function () {
           slider.cleanup();
        })


        // event handler for clicking on the instant-peace-button
        $('main').on('click', '.instant-peace-on', function () {
            //$('body').fullscreen();
            $('#thumbs').css( { 'top': '-100vh', 'transition': 'top ease-in-out ' + slider.instantPeaceTime+'ms' });
            $('#content').css( { 'top': '200vh', 'transition': 'top ease-in-out ' + slider.instantPeaceTime+'ms' });
            $('#instant_peace').addClass('instant-peace-off').removeClass('instant-peace-on');
            //$('#content').fadeOut(slider.instantPeaceTime);
        });

        /* event-handler for esc-key */
        $(document).keyup( function (event) {
            if (event.which==27) {
                 $('.instant-peace-off').trigger('click');
            }
        })

        /**
         * Event handler for click on the background and fade in thumbs and content
         */
        $('main').on('click', '.instant-peace-off', function () {
            $('#thumbs').css( { 'top': '0px', 'transition': 'top ease-in-out ' + slider.instantPeaceTime+'ms' });
            $('#content').css( { 'top': '0', 'transition': 'top ease-in-out ' + slider.instantPeaceTime+'ms' });
            $('#instant_peace').addClass('instant-peace-on').removeClass('instant-peace-off');
//            $('.instant-peace').fadeIn(slider.instantPeaceTime);
            //$.fullscreen.exit();
        });


        /**
         * Event handler for click on thumbnails
         * Slides the thumbs to the left or the right to make the clicked thumb beeing centerd
         * Changes the background image
         * Slides the content for the clicked thumbnail on the screen
         */
        $('.thumb').on('click', function ( e ) {

            slider.slide( $(this) );

        });

        // adjust position and dimensions
        // cleanup() calls the slider.slide() function using the thumb in the parameter (i.e. the first thumb)
        slider.cleanup( $('.thumb:first-child') );

        
    })
})