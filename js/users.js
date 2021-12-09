const searchBar = document.querySelector(".search-toolbar .search input"),
search = document.querySelector(".search"),
searchBtn = document.querySelector(".search-toolbar .search button"),
usersList = document.querySelector(".search-toolbar .users-list");


search.addEventListener('click', () =>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
});


