
document.addEventListener('wpcf7mailsent', function(event){
    setTimeout(function(){
        ifwp_floating_labels();
    }, 200);
}, false);
