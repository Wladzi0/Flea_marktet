$(document).ready(function(){
    let btn=document.getElementById("signIn");
    let dropdown=document.getElementById("Dropdown");
    if (btn) {
        btn.addEventListener('click', (event) => {
            dropdown.classList.toggle("show");
            btn.classList.toggle("iconOpen");

        });
    }

});
