
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ifwp_floating_labels !== 'function'){
    function ifwp_floating_labels(){
        if(jQuery('.ifwp-floating-labels > textarea').length){
            jQuery('.ifwp-floating-labels > textarea').each(function(){
                ifwp_floating_labels_textarea(this);
            });
        }
        if(jQuery('.ifwp-floating-labels > select').length){
            jQuery('.ifwp-floating-labels > select').each(function(){
                ifwp_floating_labels_select(this);
            });
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ifwp_floating_labels_select !== 'function'){
    function ifwp_floating_labels_select(select){
        if(jQuery(select).val() == ''){
            jQuery(select).removeClass('placeholder-hidden');
        } else {
            jQuery(select).addClass('placeholder-hidden');
        }
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ifwp_floating_labels_textarea !== 'function'){
    function ifwp_floating_labels_textarea(textarea){
        jQuery(textarea).height(parseInt(jQuery(textarea).data('element'))).height(textarea.scrollHeight - parseInt(jQuery(textarea).data('padding')));
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ifwp_page_visibility_event !== 'function'){
    function ifwp_page_visibility_event(){
        'use strict';
        var visibilityChange = '';
        if(typeof document.hidden !== 'undefined'){ // Opera 12.10 and Firefox 18 and later support
            visibilityChange = 'visibilitychange';
        } else if(typeof document.webkitHidden !== 'undefined'){
            visibilityChange = 'webkitvisibilitychange';
        } else if(typeof document.msHidden !== 'undefined'){
            visibilityChange = 'msvisibilitychange';
        } else if(typeof document.mozHidden !== 'undefined'){ // Deprecated
            visibilityChange = 'mozvisibilitychange';
        }
        return visibilityChange;
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(typeof ifwp_page_visibility_state !== 'function'){
    function ifwp_page_visibility_state(){
        'use strict';
        var hidden = '';
        if(typeof document.hidden !== 'undefined'){ // Opera 12.10 and Firefox 18 and later support
            hidden = 'hidden';
        } else if(typeof document.webkitHidden !== 'undefined'){
            hidden = 'webkitHidden';
        } else if(typeof document.msHidden !== 'undefined'){
            hidden = 'msHidden';
        } else if(typeof document.mozHidden !== 'undefined'){ // Deprecated
            hidden = 'mozHidden';
        }
        return document[hidden];
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

jQuery(function($){
    if($('.ifwp-floating-labels > textarea').length){
        $('.ifwp-floating-labels > textarea').each(function(){
            $(this).data({
                'border': $(this).outerHeight() - $(this).innerHeight(),
                'element': $(this).height(),
                'padding': $(this).innerHeight() - $(this).height(),
            });
        });
    }
    ifwp_floating_labels();
    if($('.ifwp-floating-labels > textarea').length){
        $('.ifwp-floating-labels > textarea').on('input propertychange', function(){
            ifwp_floating_labels_textarea(this);
        });
    }
    if($('.ifwp-floating-labels > select').length){
        $('.ifwp-floating-labels > select').on('change', function(){
            ifwp_floating_labels_select(this);
        });
    }
    $(document).on(ifwp_page_visibility_event(), ifwp_floating_labels);
});

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
