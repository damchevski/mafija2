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
});
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
