let searchlost;
window.onbeforeunload = function() {
   searchlost=localStorage.setItem("search", $('#search').val());


}
window.onload=function(){
    let search=localStorage.getItem("search");
    if (search !== null){
        alert(searchlost);
        // $('#search').val(searchlost.val());
    }
}
