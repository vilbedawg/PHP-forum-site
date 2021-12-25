
    $(document).ready(function() {
        $(".category-item").click(function(){
                $("#category").val($(this).html());
                $('#categorylist').hide();
                $('.category-item').removeClass('background_selected');
                $(this).addClass('background_selected');
            });


            $(document).on('click', '.list-group-item', function(){
                $("#category").val($(this).html());
                $('#categorylist').hide();            
                $( ".category-item:contains('"+ $(this).html() +"')").addClass('background_selected');  
            });
        
        $('#category').keyup(function() {
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                   url:"search.php",
                   method: "POST",
                   data: {query:query},
                   success:function(data)
                   {
                       $('#categorylist').show();
                       $('#categorylist').html(data);
                   },
                   error:function(data)
                   {
                        $('#categorylist').fadeIn();
                        $('#categorylist').html('Jokin meni vikaan');
                   }
                });
            } else {
                $('#categorylist').hide();
            }

            $(".category-item").each(function () {
                var item = $(this).text();
                if ($("#category").val().indexOf(item) > -1)
                {
                    $(this).removeClass('background_selected');
                    $(this).addClass('background_selected');
                } else {
                    $(this).removeClass('background_selected');
                }
            });
            
        });
    });