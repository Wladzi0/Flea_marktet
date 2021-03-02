let searchlost;
window.onbeforeunload = function() {
   searchlost=$('#search').val();


}
window.onload=function(){
    let search=localStorage.getItem("search");
    if (search !== null){
        // alert(searchlost);
        // $('#search').val(searchlost.val());
    }
}
