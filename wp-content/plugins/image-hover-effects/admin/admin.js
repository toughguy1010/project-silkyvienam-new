jQuery(document).ready(function($) {

    /***** Preview Shortcode Start ********/

    $('.wdo-preview-button').click(function(){
         $('.preview-container').toggle();
    });
    /***** Preview Shortcode End ********/

    $(window).load(function(){
       $('.se-pre-con').fadeOut();
    });

    $('.scrollable').each(function(index, el) { 
        if ($(this).val()==='yes') {
            $(this).closest('.form-table').find('.scorll-style-row').show();
        } else{
            $(this).closest('.form-table').find('.scorll-style-row').hide();
        }
    });

    $('#caption').on('change', '.scrollable', function(event) {
        event.preventDefault();
        if ($(this).val()==='yes') {
            $(this).closest('.form-table').find('.scorll-style-row').show();
        } else{
            $(this).closest('.form-table').find('.scorll-style-row').hide();
        }
    });

    /*Choosing Slider Mode*/

    $('#caption').on('change', '.slidermode', function(event) {
        event.preventDefault();
        if ($(this).val()=='wdo-slider') {
            $(this).closest('.form-table').find('.grid-row').hide();
            $(this).closest('.form-table').find('.slides-row').show();
        }else if($(this).val()==''){
            $(this).closest('.form-table').find('.grid-row').show();
            $(this).closest('.form-table').find('.slides-row').hide();
        };
    });

    $('.slidermode').each(function(index, el) {
        if ($(this).val()==='wdo-slider') {
            $(this).closest('.form-table').find('.grid-row').hide();
            $(this).closest('.form-table').find('.slides-row').show();
        } else{
            $(this).closest('.form-table').find('.grid-row').show();
            $(this).closest('.form-table').find('.slides-row').hide();
        }
    });

    jQuery('.moreimages span').remove();
    jQuery('.preview').hide();
    jQuery('#la-loader').hide();
  jQuery('#la-saved').hide();
    $('.caplightbox').each(function(index, el) {
        if ($(this).val()==='yes') {
            $(this).closest('.form-table').find('.lightbox-content-container').show();
        }else if($(this).val()==='no'){
            $(this).closest('.form-table').find('.lightbox-content-container').hide();           
        };
    });

    $('.capbgtype').each(function(index, el) {
        if ($(this).val()==='image') {
            //$(this).closest('.form-table').find('.bgimagerow')
            $(this).closest('.form-table').find('.bgimagerow').show();
            $(this).closest('.form-table').find('.bgcolorrow').hide();
        }else if($(this).val()==='color'){
            $(this).closest('.form-table').find('.bgcolorrow').show();
            $(this).closest('.form-table').find('.bgimagerow').hide();           
        };
    });

    $('#caption').on('change', '.capbgtype', function(event) {
        event.preventDefault();
        if ($(this).val()=='image') {
            $(this).closest('.form-table').find('.bgcolorrow').hide();
            $(this).closest('.form-table').find('.bgimagerow').show();
        }else if($(this).val()=='color'){
            $(this).closest('.form-table').find('.bgimagerow').hide();
            $(this).closest('.form-table').find('.bgcolorrow').show();
        };
    }); 

    $('#caption').on('change', '.caplightbox', function(event) {
        event.preventDefault();
        if ($(this).val()=='yes') {
            $(this).closest('.form-table').find('.lightbox-content-container').show();
        }else if($(this).val()=='no'){
            $(this).closest('.form-table').find('.lightbox-content-container').hide();
        };
    });

    $('#caption').on('change', '.headoverimage', function(event) {
        event.preventDefault();
        if ($(this).val()=='yes') {
            $(this).closest('.form-table').find('.titlepostion-row').show();
        }else if($(this).val()=='no'){
            $(this).closest('.form-table').find('.titlepostion-row').hide();
        };
    });

    setTimeout(function() {
        jQuery('#faqs-container >.ui-accordion-content').first().addClass('firstelement');
    }, 40);


    setTimeout(function() {
        $('.content').each(function(index, el) {
            $(this).find('.ui-accordion-content').first().addClass('firstelement');
        });
    }, 50);


    var sCounter = jQuery('#caption').find('.fullshortcode:last').attr('id');

    jQuery("div.accordian").accordion({
    heightStyle: "content",
    collapsible: true, 
    changestart: function (event, ui) {
        if ($(event.currentTarget).hasClass("item")) {
            event.preventDefault();
            $(event.currentTarget).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        }
    });
    function create_accordian(str) {
        $( str )
            .accordion({
                header: '> div > h3',
                autoHeight: false,
                collapsible: true
            })
            .sortable({
                axis: 'y',
                handle: 'h3',
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( 'h3' ).triggerHandler( 'focusout' );
                }
            });
    }
    create_accordian('.accordion');
    //    Adding Icmage

     jQuery('#caption').on('click','.addimage',function( event ){
     
        event.preventDefault();
     
     var parent = jQuery(this).closest('.ui-accordion-content').find('.image');
        // Create the media frame.
        la_caption_hover = wp.media.frames.la_caption_hover = wp.media({
          title: 'Select Images for Caption Hover',
          button: {
            text: 'Add Image',
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback. 
        la_caption_hover.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = la_caption_hover.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                
                parent.append('<span><img src="'+attachment.url+'"><span class="dashicons dashicons-dismiss"></span></span>');

            });  
        });
     
        // Finally, open the modal 
        la_caption_hover.open();
    });
    
    // Removing Uploades Image


    jQuery('#caption').on('click', '.dashicons-dismiss', function() {
            jQuery(this).parent('span').remove();
    }); 

    // Cloning Add More Images 

    jQuery('#caption').on('click', '.moreimg', function() { 
            jQuery(this).closest('.content').find('h3:last').css({
                'background': '',
                'color': ''
            });
            var parent = jQuery(this).closest('.content');
            var heading = jQuery(this).closest('.content').find('h3:first').clone(true);
            var heading_text = heading.find('a').text('New Image');
            var content = jQuery(this).closest('.content').find('h3:first').next().clone(true).removeClass('firstelement');
            jQuery(parent).append(heading).append(content);
            // jQuery(parent).append(heading);

            var colorparent = jQuery(this).closest('.content').first().find('.ui-accordion-content').first();
            var headingcolor = jQuery(this).closest('.content').find('.ui-accordion-content').find('.head-color').val();
            var desccolor = jQuery(this).closest('.content').find('.ui-accordion-content').find('.desc-color').val();
            var headingback = jQuery(this).closest('.content').find('.ui-accordion-content').find('.headingbg').val();
            var capborder = jQuery(this).closest('.content').find('.ui-accordion-content').find('.capbordercolor').val();
            var capback = jQuery(this).closest('.content').find('.ui-accordion-content').find('.capbgcolor').val();

            colorparent.find('.wp-picker-container').remove();
            colorparent.find('.insert-picker:eq(0)').append('<input type="text" class="head-color" value="'+headingcolor+'" />');
            colorparent.find('.insert-picker:eq(2)').append('<input type="text" class="desc-color" value="'+desccolor+'" />');

            jQuery('.accordian').accordion('refresh'); 
            colorparent.find('.head-color,.desc-color,.capbgcolor').wpColorPicker();

    });

        jQuery('#caption').on('click', '.addcat', function() { 
            sCounter++;
            jQuery('.addcat').parents().find('#faqs-container').find('h3:first').css({
                'background': '',
                'color': ''
            });
            var parent = jQuery(this).closest('#faqs-container');
            var head = jQuery('.addcat').parents().find('#faqs-container').find('h3:first').clone(true).appendTo(parent);
            var heading_text = head.find('a').text('New Category');
            var content = jQuery('.addcat').parents().find('#faqs-container').find('h3:first').next().clone(true).removeClass('firstelement').appendTo(parent);
            

            jQuery("div.accordian").accordion({
            heightStyle: "content",
            collapsible: true, 
            changestart: function (event, ui) {
                if ($(event.currentTarget).hasClass("item")) {
                    event.preventDefault();
                    $(event.currentTarget).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                }
            });

            var colorappend = jQuery('.addcat').parents().find('#faqs-container').find('.accordian:last').find('.ui-accordion-content');
            
            var headingcolor = jQuery(this).closest('.content').find('.ui-accordion-content').find('.head-color').val();
            var desccolor = jQuery(this).closest('.content').find('.ui-accordion-content').find('.desc-color').val();
            var headingback = jQuery(this).closest('.content').find('.ui-accordion-content').find('.headingbg').val();
            var capborder = jQuery(this).closest('.content').find('.ui-accordion-content').find('.capbordercolor').val();
            var capback = jQuery(this).closest('.content').find('.ui-accordion-content').find('.capbgcolor').val();

            colorappend.find('.wp-picker-container').remove();
            colorappend.find('.insert-picker:eq(0)').append('<input type="text" class="head-color" value="'+headingcolor+'" />');
            colorappend.find('.insert-picker:eq(2)').append('<input type="text" class="desc-color" value="'+desccolor+'" />');

            colorappend.find('.head-color,.desc-color,.capbgcolor').wpColorPicker();
            content.find('button.fullshortcode').attr('id', sCounter);
            jQuery('.accordian').accordion('refresh');

    });

    // Removing Category
        jQuery('#caption #faqs-container').on('click', '.removecat', function(event) {
        var cat_name = jQuery(this).prev('a').text();
        var result = confirm("Want to delete "+cat_name+" ?");
        if (result) {
            if (jQuery(this).closest('.ui-accordion-header').next('#faqs-container > .ui-accordion-content').hasClass('firstelement')) {
                  alert('You can not delete it as it is first element!');
              } else {
                  
                  var head = jQuery(this).closest('.ui-accordion-header');
                  var body = jQuery(this).closest('.ui-accordion-header').next('#faqs-container > .ui-accordion-content');
                  head.remove();
                  body.remove();
              }  
        }
          
        });

    // Removing Add More Images

    jQuery('#caption').on('click','.removeitem',function() {
        var img_name = jQuery(this).prev('a').text();
        var result = confirm("Want to delete "+img_name+" ?");
        if (result) {
            if (jQuery(this).closest('.ui-accordion-header').next('.ui-accordion-content').hasClass('firstelement')) {
                alert('You can not delete it as it is first element!');
            } else {

                var head = jQuery(this).closest('.ui-accordion-header');
                var body = jQuery(this).closest('.ui-accordion-header').next('.ui-accordion-content');
                head.remove();
                body.remove();
            }
        }


            
    });
    jQuery('.head-color,.desc-color,.capbgcolor,.headingbg,.leftbordercolor,.rightbordercolor,.capbordercolor').wpColorPicker();  

    jQuery('#caption').on('click', '.save-meta', function(event) {
        event.preventDefault();     
        jQuery('.se-saved-con').show();
         jQuery('#la-saved').hide();
        var allcats = []; 
          jQuery('.accordian>.content').each(function(index,val) {
            var cats = {};
            cats.cat_name = jQuery(this).find('.catname').val();
            cats.allcapImages = [];
            jQuery(this).find('.ui-accordion-content').each(function(index, val) {
                var images = {};
                images.img_name = jQuery(this).find('.imgname').val();
                images.cat_name = jQuery(this).find('.catname').val();
                images.cap_img = jQuery(this).find('img').attr('src');
                images.cap_head = jQuery(this).find('.capheading').val();
                images.cap_desc = jQuery(this).find('.capdesc').val();
                images.cap_link = jQuery(this).find('.caplink').val();
                images.cap_style = jQuery(this).find('.styleopt').val();
                images.cap_effect = jQuery(this).find('.effectopt').val();
                images.cap_direction = jQuery(this).find('.directionopt').val();
                images.cap_headcolor =  jQuery(this).find('.head-color').val(),
                images.cap_desccolor =  jQuery(this).find('.desc-color').val(),
                images.cap_grid = jQuery(this).find('.capgrid').val();
                images.shortcode = jQuery(this).find('.fullshortcode').attr('id');
                images.counter = jQuery(this).siblings().find('.fullshortcode').attr('id'); 
                cats.allcapImages.push(images);
            });
            allcats.push(cats);
        });
        var data = {
            action : 'la_save_caption_options',
             posts : allcats       
        } 

         jQuery.post(laAjax.url, data, function(resp) {
            // window.location.reload(true);
            jQuery('.se-saved-con').hide();
            jQuery('.overlay-message').show();
            jQuery('.overlay-message').delay(2000).fadeOut();
        });
          
    });

    jQuery('.content').on('click','button.fullshortcode',function(event) {
        event.preventDefault();
        prompt("Copy and use this Shortcode", '[image-caption-hover id="'+jQuery(this).attr('id')+'"]');
    });

    jQuery('.enableprev').click(function() {

        jQuery(this).siblings('.preview').toggle();
    });

});
