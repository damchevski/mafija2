$(document).ready(function(){

});
$(window).on('load', function(){
    $(".wrap").delay(2500).fadeOut("slow");
    status(1);
});
function isMobile() {
    if(/Android|webOS|iPhone|iPad|iPod|pocket|psp|kindle|avantgo|blazer|midori|Tablet|Palm|maemo|plucker|phone|BlackBerry|symbian|IEMobile|mobile|ZuneWP7|Windows Phone|Opera Mini/i.test(navigator.userAgent)) {
     return true;
    }
    return false;
}
function status(val){
  $.get("/mafija2/public/status",{val:val});
}
