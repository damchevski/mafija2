$(document).ready(function () {
  $($('.hamburger').parent().attr('data-target')).on('hide.bs.collapse', function () {
    $(this).parent().find('.hamburger').removeClass('hamburger--close');
  });
  $($('.hamburger').parent().attr('data-target')).on('show.bs.collapse', function () {
    $(this).parent().find('.hamburger').addClass('hamburger--close');
  });
  $('.navigation').children('.nav').children('.collapsed').click(function(){
    if($(this).hasClass( "collapsed")){
      $(this).children('.svg').rotate(180);
    }else{
      $(this).children('.svg').rotate(0);
    }
  });
   if(!isMobile()){loadingCricle();}
});
function sidebarAnimateIn(){
  $('.sidebar').css('box-shadow','-5px -3px 30px 18px rgba(0,0,0,0.9)');
  $(".sidebar").animate({left: '0'},function(){
  loadingCricle();
  });
}
function sidebarAnimateOut(){
  $(".sidebar").animate({left: '-'+$(".sidebar").outerWidth(true)},function(){
   $('.progress').children('.progress-right').children('.progress-bar').css('-webkit-transform','rotate(0deg)');
   $('.progress').children('.progress-left').children('.progress-bar').css('-webkit-transform','rotate(0deg)');
   $('.progress').children('.progress-right').children('.progress-bar').css('text-indent','0px');
   $('.progress').children('.progress-left').children('.progress-bar').css('text-indent','0px');
   $('.sidebar').css('box-shadow','none');
   });
}
function loadingCricle() {
  var input = 70;
  var output = (360 * input) / 100;
  if(output <= 180){
    output1 = output;
    output2 = 0;
  }else{
    output1 = 180 ;
    output2= output - 180;
  }
    $('.progress').children('.progress-right').children('.progress-bar').animate({textIndent: output1 },{
        step: function(now,fx) {
          $(this).css('-webkit-transform','rotate('+now+'deg)');
          $(this).css('transform','rotate('+now+'deg)');
          $('.progress').children('.progress-value').children('.num').html(Math.round(((10*now)/36))+'%');
        },
        duration:1500,
        complete: function() {

        }
    },"easein ");
    $('.progress').children('.progress-left').children('.progress-bar').delay(1300).animate({ textIndent: output2 },{
        step: function(now,fx) {
          $(this).css('-webkit-transform','rotate('+now+'deg)');
          $(this).css('transform','rotate('+now+'deg)');
            $('.progress').children('.progress-value').children('.num').html(Math.round(((10*(now+180))/36))+'%');
        },
        duration:1500,
        complete: function() {
              }
    }, "easein ");
}
