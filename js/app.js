
//Modaali funktiot
$(document).ready(function() {

    var modal = $('.bg-modal');


    $('.create').click(function() {
        $(modal).css('display', 'flex');
        modal.show();
    });
    
    $('.modal-close').click(function() {
        modal.hide();
        $(".category-item").removeClass("background_selected");
    });


    $('.profile-create').click(function() {
        $(modal).css('display', 'flex');
        modal.show();
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
            window.location = 'home.php?show=Etusivu#newpost';
        }
    });

});



//JULKAISUJEN HAKU 
$(document).on('click', function(e) {
    var searchbar = $(this).find('#post-search');
    if($(e.target).is('.search')){
        $(searchbar).focus();
        $(searchbar).keyup(function() {
            var postquery = $(this).val();
                if(postquery != '')
                {
                    $.ajax({
                       url:"search.php",
                       method: "POST",
                       data: {
                           postquery:postquery
                        },
                       success:function(data)
                       {
                           $('.post-category-list').show();
                           $('.post-category-list').html(data);
                           $('.post-row').on('click', function() {
                              var postNum = $(this).attr('id');
                            window.location = "view.php?room="+postNum;
                           });
                       },
                       error:function()
                       {
                            $('.post-category-list').fadeIn();
                            $('.post-category-list').html('Jokin meni vikaan');
                       }
                    });
                } else {
                    $('.post-category-list').hide();
                }
                
            });
    }else {
        $(searchbar).val('');
        $('.post-category-list').hide();
    }
    
});



//KATEGORIA HAKU
$(".category-item").click(function () {
  $("#category").val($(this).html());
  $("#categorylist").hide();
  $(".category-item").removeClass("background_selected");
  $(this).addClass("background_selected");
});

$(document).on("click", ".list-group-item", function () {
  $("#category").val($(this).html());
  $("#categorylist").hide();
  $(".category-item:contains('" + $(this).html() + "')").addClass(
    "background_selected"
  );
});

$("#category").keyup(function () {
  var query = $(this).val();
  if (query != "") {
    $.ajax({
      url: "search.php",
      method: "POST",
      data: { query: query },
      success: function (data) {
        $("#categorylist").show();
        $("#categorylist").html(data);
      },
      error: function () {
        $("#categorylist").fadeIn();
        $("#categorylist").html("Jokin meni vikaan");
      },
    });
  } else {
    $("#categorylist").hide();
  }

  $(".category-item").each(function () {
    var item = $(this).text();
    if ($("#category").val().indexOf(item) > -1) {
      $(this).removeClass("background_selected");
      $(this).addClass("background_selected");
    } else {
      $(this).removeClass("background_selected");
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
    $('.room-header-p img').css({'height' : 'auto',
                            'max-width' : '100%'
                            
    });
});

//----------------------------//
//navbar ja scroll up funktiot
$(window).bind('scroll', function () {
    if ($(window).scrollTop() > 240) {
        $('.current-user-parent').stop().animate({
            "font-size": "24px"
          }, 100);
        $('.navbar-menu-hidden').stop().slideDown(200);
        $('.navbar-menu-hidden').css({'display' : 'flex',
                                    'position' : 'fixed',
                                    'top' : '40px'
                                });
        $('.navbar-menu').hide();
        
      
        
    } else if ($(window).scrollTop() < 100) {
        $('.navbar-menu-hidden').stop().hide();   
        $('.navbar-menu').show();
        $('.current-user-parent').stop().animate({
            "font-size": "38px"
          }, 100);
                            
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




function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  }

  window.addEventListener("click", function(event) {
      if (!event.target.matches('.dropbtn', '.drop-icons')) {
          var dropdowns = document.getElementsByClassName("dropdown-content");
          var i;
          for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
          }
          }
      }
  });




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











