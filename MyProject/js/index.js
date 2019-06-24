//profile content fixed
$(function(){
    $('.Profile').masonry({
        itemSelector : '.item',
        columnWidth : 240
    });
});
$(function(){
    var $container = $('.Profile');
    $container.imagesLoaded(function(){
        $container.masonry({
            itemSelector : '.item',
            isAnimated: true, 
            columnWidth : 240
        });
    });
});
//orifile content fixed end