
//Modaali funktiot
$(document).ready(function() {

    var modal = $('.bg-modal');


    $('.create').click(function() {
        $(modal).css('display', 'flex');
        modal.show();
    });
    
    $('.modal-close').click(function() {
        modal.hide();
    });


    $('.profile-create').click(function() {
        $(modal).css('display', 'flex');
        modal.show();
    });
    
    $('.modal-close').click(function() {
        modal.hide();
    });

    if (window.location.href.indexOf("error") > -1) {
        $(modal).css('display', 'flex');
        modal.show();
    }

    if (window.location.href.indexOf("edit") > -1) {
        $(modal).css('display', 'flex');
        modal.show();
    }




    $('.create').click(function() {
        if (window.location.href.indexOf("room") > -1) {
            window.location = 'home.php#newpost';
            
        }
    });

});



//----------------------------//
//maximi kuvan suuruus
$( document ).ready(function() {
    $('.bodytext img').css({'height' : 'auto',
                            'max-width' : '100%'
    });
    $('.bodytext-users img').css({'height' : 'auto',
                            'max-width' : '100%'                        
    });
    $('.date-and-users img').css({'height' : 'auto',
                            'max-width' : '100%'
                            
    });
});

//----------------------------//
//navbar ja scroll up funktiot
// $(window).bind('scroll', function () {
//     if ($(window).scrollTop() > 170) {
//         $('.navbar').addClass('fixed');
//     } else {
//         $('.navbar').removeClass('fixed');
//     }
// });

window.onscroll = scrollShowNav;
function scrollShowNav() {
   if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementsByTagName("nav")[0].style.top = "0";
   } else {
      document.getElementsByTagName("nav")[0].style.top = "-50px";
   }
}




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



//----------------------------//
//Edit nappi
  $(document).ready(function() {
    if (window.location.href.indexOf("edit") > -1) {
        $('.edit').css('display', 'none');
    }
});








//----------------------------//
//Käyttäjälista
$(document).ready(function(){
    $(".show-list").on('click', function(){
        $(".user-list-h2").fadeIn("fast");
        $('.table-wrapper').stop().slideDown("normal", function(){
            $('.table-wrapper').css('display', 'flex');
            $(".show-list").hide();
            $(".hide-list").show();
            
        });
        $(".hide-list").on('click', function(){
            $('.table-wrapper').stop().slideUp("normal", function(){
                $('.table-wrapper').css('display', 'none');
                $(".hide-list").hide();
                $(".show-list").show();
                $(".user-list-h2").fadeOut("fast");
            });
        });
    });
});



//----------------------------//
//Piilota/näytä salasana
const pswField = document.getElementById("Password"),
pswFieldVerify = document.getElementById("PasswordVerify"),
toggleBtn = document.querySelector(".field i");

toggleBtn.onclick = () => {
    if(pswField.type === "password"){
        pswField.type = "text";
        pswFieldVerify.type = "text";
        toggleBtn.classList.add("active");
    }
    else{
        pswField.type = "password";
        pswFieldVerify.type = "password";
        toggleBtn.classList.remove("active");
    }
}


//----------------------------//
//TIMEOUT funktio
(function() {
    const idleDurationSecs = 900;
    const redirectUrl = 'logout.php';
    let idleTimeout;

    const resetIdleTimeout = function() {
        if(idleTimeout) clearTimeout(idleTimeout);
        idleTimeout = setTimeout(() => location.href = redirectUrl, idleDurationSecs * 1000);
    };
	
	// eventit joilla voidaan resettaa aika
    resetIdleTimeout();
    window.onmousemove = resetIdleTimeout;
    window.onkeypress = resetIdleTimeout;
    window.click = resetIdleTimeout;
    window.onclick = resetIdleTimeout;
    window.touchstart = resetIdleTimeout;
    window.onfocus = resetIdleTimeout;
    window.onchange = resetIdleTimeout;
    window.onmouseover = resetIdleTimeout;
    window.onmouseout = resetIdleTimeout;
    window.onmousemove = resetIdleTimeout;
    window.onmousedown = resetIdleTimeout;
    window.onmouseup = resetIdleTimeout;
    window.onkeypress = resetIdleTimeout;
    window.onkeydown = resetIdleTimeout;
    window.onkeyup = resetIdleTimeout;
    window.onsubmit = resetIdleTimeout;
    window.onreset = resetIdleTimeout;
    window.onselect = resetIdleTimeout;
    window.onscroll = resetIdleTimeout;

})();











