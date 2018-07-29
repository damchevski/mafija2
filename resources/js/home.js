$(function(){
  function getData(val,type){
    $.get(val,{type:type},function(data){
      $('#container').html(data);
      $(window).scrollTop(0);
      var nav = $('.navbar').position().top +$('.navbar').outerHeight(true);
      $('.card-navigation').css('top',(nav )+'px');
      $('.card-navigation').children('ul').children('li').first().css("border-bottom","3px solid #E61924");
          $('.card-navigation').children('ul').children('li').click(function(){
            $('.card-navigation').children('ul').children('li').css("border-bottom","none");
            $(this).css("border-bottom","3px solid #E61924");
            $('.card-columns').css('display','none');
            switch ($(this).attr('id')){
              case '1':
                $("#first").fadeIn("slow");
                break;
              case '2':
                $("#second").fadeIn("slow");
                break;
              case '3':
                $("#last").fadeIn("slow");
                break;
            }
            $(window).scrollTop(0);
          });
      $(".slider").on("input", function(){
        $(this).siblings().text(this.value);
      });
    });
  }
  $('.sub-menu').children('li').click(function(){
    if(isMobile()){sidebarAnimateOut();}
    $('.navigation').children('.nav').children('li').children('.svg').rotate(0);
    $(this).parents('.sub-menu').removeClass('show').addClass('collapse');
    $('.navigation').children('.nav').children('li').addClass('collapsed');
    var val = $(this).children('input').val();
    val1 = val;
    if(val == 'crime'){
      val1 = 'rabota';
    }
    if(val == 'drugs'){
      val1 = 'drinks';
    }
    getData("/mafija2/public/ajax/"+val1,val);
  });
  $('#search').keyup(function(){
       if($(this).val() != ''){
         $.get("/mafija2/public/ajax/search",{key: $(this).val()}, function(data){
           $('.chat .content').html(data);
         });
       }else{
        $('.chat .content').html('');
       }
     });


});
