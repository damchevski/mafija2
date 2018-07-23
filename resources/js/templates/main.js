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
function countdown(endDate) {
  let days, hours, minutes, seconds;

  endDate = new Date(endDate).getTime();
  i=0;
  if (isNaN(endDate)) {
	return;
  }

  count = setInterval(calculate, 1000);

  function calculate() {
    let startDate = new Date();
    startDate = startDate.getTime();

    let timeRemaining = parseInt((endDate - startDate) / 1000);

    if (timeRemaining >= 0) {
      days = parseInt(timeRemaining / 86400);
      timeRemaining = (timeRemaining % 86400);

      hours = parseInt(timeRemaining / 3600);
      timeRemaining = (timeRemaining % 3600);

      minutes = parseInt(timeRemaining / 60);
      timeRemaining = (timeRemaining % 60);

      seconds = parseInt(timeRemaining);
      console.log(days+':'+hours+':'+minutes+':'+seconds);
      $('#loading').children('h1').children('span').html(seconds);
    }else{
      $("#loading").fadeOut("slow");//tuka loadingot stop
      clearTimeout(count);
    }
  }
}
