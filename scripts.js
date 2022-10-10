jQuery(function ($) {
    /*
    jQuery(document).ajaxComplete(function(){
        jQuery('.variations_form').each(function () {
            jQuery(this).wc_variation_form();
            jQuery(this).tawcvs_variation_swatches_form();
        });
    });
    $('body').on('click','.select-option',function (e) {
        e.preventDefault();
        $(this).addClass('selected').siblings('div').removeClass('selected');
        $('select').val($(this).data('value')).trigger('change');
        var $color = $(this).data('value');
        //$('#pa_color').val('green').trigger('change');
        alert($color);
    });
    https://wordpress.org/support/topic/triggering-the-variation-swatches-after-ajax-loading/
    jQuery(document).ajaxComplete(function(){
        jQuery('.archive .variations_form').each(function () {
            jQuery(this).wc_variation_form();
            jQuery(this).tawcvs_variation_swatches_form();
        });
    });
    */

    $('.js-filter input[type="checkbox"]').on('click',function () {
        var colors = [];
        $.each($("input[name='color']:checked"), function(){
            colors.push($(this).val());
        });

        var materials = [];
        $.each($("input[name='material']:checked"), function(){
            materials.push($(this).val());
        });

        var cat = $('.js-reset').data('slug');
        
        var data = {
            action: 'filter_posts',
            colors: colors,
            materials: materials,
            cat: cat,
        }

        $.ajax({
            url: variables.ajax_url,
            type: 'POST',
            data: data,
            success: function (response) {
                //alert(response);
                $('.js-products').html(response);
            }
        });
        
    });

    $('.js-reset').on('click',function(e){
        e.preventDefault();
        
        $.each($("input[name='material']"), function(){
           this.checked = false;
        });
        $.each($("input[name='color']"), function(){
           this.checked = false;
        });
         var cat = $('.js-reset').data('slug');
        var data = {
            action: 'filter_posts',
            colors: '',
            materials: '',
            cat: cat,
        }

        $.ajax({
            url: variables.ajax_url,
            type: 'POST',
            data: data,
            success: function (response) {
                //alert(response);
                $('.js-products').html(response);
            }
        });
    });
});