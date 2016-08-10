$(document).ready(function(){
    $('.new1 .navigation .title').hover(function(){
        var index = $(this).index();
        $('.new1 .entry').css({
            'top':  - index * 465 + 'px'
        })
    }, function(){})
})