
$(window).bind('scroll', function () {
    if ($(window).scrollTop() > 100) {
        $('.navbar').addClass('fixed');
    } else {
        $('.navbar').removeClass('fixed');
    }
});



$(window).bind('scroll', function () {
  if ($(window).scrollTop() > 250) {
      $('.profile').addClass('profile-fixed');
  } else {
      $('.profile').removeClass('profile-fixed');
  }
});


$(window).scroll(function() {
    if ($(this).scrollTop() > 600) {
      $(".scrollup").fadeIn();
    } else {
      $(".scrollup").fadeOut();
    }
  })

  $(".scrollup").click(function() {
    $("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
  });

  
