







$(document).ready(function(){

    $('.sub-btn').click(function(){
        $(this).next('.container-sub-menu').slideToggle();
        $(this).find('.menu-arrow').toggleClass('rotate');
        
    });

});

function test(){
    alert('s');
}