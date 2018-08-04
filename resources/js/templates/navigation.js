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
    $('.search').children('input').focus(function(){
      $('.expand').css('left','265px');
      $('.simplebar-scroll-content').scrollTop(2000);
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
  $(".chat").animate({right: '0'},function(){
    $('.cover').css('display','block');
  });
}
function chatAnimateOut(){
  $('.cover').css('display','none');
  $(".chat").animate({right: '-'+$(".chat").outerWidth(true)});
}
function sidebarAnimateIn(){
  $(".sidebar").animate({left: '0'},function(){
    $('.cover').css('display','block');
  });
}
function sidebarAnimateOut(){
  $('.cover').css('display','none');
  $(".sidebar").animate({left: '-'+$(".sidebar").outerWidth(true)});
}
