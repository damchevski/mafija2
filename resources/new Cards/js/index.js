  var bottom = $('.navbar').position().top +$('.navbar').outerHeight(true);//mestenje na sidebar pod navigacijata
  $('.sidebar').css('top',bottom);
  $(document).ready(function () {

      var i = 0;
      $('#logo').click(function(){
        if(i==0){
          $(".sidebar").animate({left: '0'});
          i=1;
        }else{
          $(".sidebar").animate({left: '-'+$(".sidebar").outerWidth(true)});
          i=0;
        }
      });
      $('.navigation').children('.nav').children('.collapsed').click(function(){
        if($(this).hasClass( "collapsed")){
          $(this).children('.svg').rotate(180);
        }else{
          $(this).children('.svg').rotate(0);
        }
      });
      $($('.hamburger').parent().attr('data-target')).on('hide.bs.collapse', function () {
        $(this).parent().find('.hamburger').removeClass('hamburger--close');
  	});
      $($('.hamburger').parent().attr('data-target')).on('show.bs.collapse', function () {
        $(this).parent().find('.hamburger').addClass('hamburger--close');
  	});

  });
  $(function(){
    function isMobile() {
        if(/Android|webOS|iPhone|iPad|iPod|pocket|psp|kindle|avantgo|blazer|midori|Tablet|Palm|maemo|plucker|phone|BlackBerry|symbian|IEMobile|mobile|ZuneWP7|Windows Phone|Opera Mini/i.test(navigator.userAgent)) {
         return true;
        }
        return false;
    }
    $( ".sidebar" ).on( "swipeleft", function(){
          $(".sidebar").animate({left: '-'+$(".sidebar").outerWidth(true)});
      });
      $(".sidebar-swipe").on( "swiperight", function(){
            $(".sidebar").animate({left: '0'});
        });
    if(isMobile()){
      $('.close').click(function(){
       $(this).parents('.card').animate({left: '-'+$(".card").outerWidth(true)}, "slow",function(){
         $(this).css('display','none');
       });
      });
    }else{
      $('.close').click(function(){
       $(this).parents('.card').fadeOut(600);
      });
    }

});

  // Add slideDown animation to Bootstrap dropdown when expanding.
  $('.dropdown').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // Add slideUp animation to Bootstrap dropdown when collapsing.
  $('.dropdown').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });

var Top5_div1 = document.getElementById("Top5_1");
var Top5_div2 = document.getElementById("Top5_2");
var Top5_div3 = document.getElementById("Top5_3");
var Top5_div4 = document.getElementById("Top5_4");

function Top5_click(item){
  Top5_div1.style.display = "none";
  Top5_div2.style.display = "none";
  Top5_div3.style.display = "none";
  Top5_div4.style.display = "none";

  item.style.display = "block";
}

