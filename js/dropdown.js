
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

        