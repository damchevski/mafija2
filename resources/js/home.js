$(document).ready(function(){
  function getData(val,type){
    $.get(val,{type:type},function(data){
      $('#container').children('.card-columns').html(data);
    });
  }
  $('.sub-menu').children('li').click(function(){
    if(isMobile()){sidebarAnimateOut();}
    //$('.navigation').children('.nav').children('.collapsed').children('.svg').rotate(0);
    //$(this).parents('.sub-menu').removeClass('collapsing').removeClass('show').addClass('collapse');
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

});
