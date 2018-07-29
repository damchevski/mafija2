$(function(){
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
    $('.search').children('input').focus(function(){
      $('.expand').css('left','265px');
      $('.simplebar-scroll-content').scrollTop(1000);
    });
    $('.content').on('click','li',function(){
      var username = $(this).children('span').first().html();
      if($(this).parents('ul').hasClass("friends")){
        $('.expand').children('button').first().html("DELETE <input type='hidden' value='"+username+"'>").removeClass('add').removeClass('confirm').addClass('friends');
      }else if ($(this).parents('ul').hasClass("people")){
        $('.expand').children('button').first().html("ADD <input type='hidden' value='"+username+"'>").removeClass('friends').removeClass('confirm').addClass('add');
      }else{
        $('.expand').children('button').first().html("CONFIRM <input type='hidden' value='"+username+"'>").removeClass('friends').removeClass('add').addClass('confirm');
        $('.expand').children('button:nth-child(2)').html('').css('display','none');//voa eke bide za poziciaj
      }
      $('.expand').css('top', $(this).position().top + 4).css('left','265px');
      $(".expand").animate({left: '50px'});
    });
    $(".expand").children('button').first().click(function() {
      if($(this).hasClass("add")){
      var val = $(this).children('input').val();
      $.get("/mafija2/public/add/friend",{username:val},function(data){
        $('#container').children('.container').html(data);
      });
      }else if($(this).hasClass("confirm")){
        var val = $(this).children('input').val();
        $.get("/mafija2/public/confirm/friend",{username:val},function(data){
          $('#container').children('.container').html(data);
        });
      }else if ($(this).hasClass("friends")){
        var val = $(this).children('input').val();
        $.get("/mafija2/public/delete/friend",{username:val},function(data){
          $('#container').children('.container').html(data);
        });
      }
      $('.expand').css('left','265px');
    });
});
function chatAnimateIn(){
  $('.chat').css('box-shadow','-5px -3px 30px 18px rgba(0,0,0,0.9)');
  $(".chat").animate({right: '0'},300);
}
function chatAnimateOut(){
  $(".chat").animate({right: '-'+$(".chat").outerWidth(true)},300,function(){
   $('.chat').css('box-shadow','none');
   });
}
function sidebarAnimateIn(){
  $('.sidebar').css('box-shadow','0px -3px 30px 18px rgba(0,0,0,0.9)');
  $(".sidebar").animate({left: '0'},300,function(){
  loadingCricle();
});
}
function sidebarAnimateOut(){
  $(".sidebar").animate({left: '-'+$(".sidebar").outerWidth(true)},300,function(){
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
