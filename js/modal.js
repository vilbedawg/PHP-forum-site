var modal = $('.bg-modal');




$('.create').click(function() {
    $(modal).css('display', 'flex');
    modal.show();
});


$('.modal-close').click(function() {
    modal.hide();
});


//piilota div kun painetaan ulkopuolelta
$(document).mouseup(function (e) {
    if ($(e.target).closest(".modal-content").length
                === 0) {
        $(modal).hide();
    }
});

