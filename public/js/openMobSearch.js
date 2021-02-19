$(document).ready(function(){
   let searchIconClick=document.getElementById("searchIcon")
   let displaySearchAdv=document.querySelector(".hidden");
   if (searchIconClick) {
      searchIconClick.addEventListener('click', () => {
         displaySearchAdv.classList.toggle('opened');

      });
   }
});
