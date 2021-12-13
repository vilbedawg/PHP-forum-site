var modal = $('.bg-modal');




$('.create').click(function() {
    $(modal).css('display', 'flex');
    modal.show();
});

$('.modal-close').click(function() {
    modal.hide();
});




//maximi kuvan suuruus
$( document ).ready(function() {
    $('.bodytext img').css({'height' : 'auto',
                            'max-width' : '100%'
    });
});


$( document ).ready(function() {
    $('.bodytext-users img').css({'height' : 'auto',
                            'max-width' : '100%'                        
    });
});

$( document ).ready(function() {
    $('.date-and-users img').css({'height' : 'auto',
                            'max-width' : '100%'
                            
    });
});




