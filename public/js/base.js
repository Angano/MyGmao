$(document).ready(function(){
   $('.menu_item').on('click',function(){
       $(this).find('ul').toggle();
   })
})