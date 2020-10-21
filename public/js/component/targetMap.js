$(document).ready(function(){

    $('.info-link').on('click',function(){
        $('.modale').css('display','flex');
    });

    $('.boite > .fermer').on('click',function(){
        $('.modale').css('display','none');
    });

});
