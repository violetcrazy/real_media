$document = $(document);

$document.ready(function(){

    function scrollToElement(el, time) {
        var offsetTop = $(el).offset().top;
        $('body,html').animate({
            scrollTop: offsetTop
        },time);
    }

    // scrollToElement('body');



    if  ($('.custom-select').length > 0){

        $('.custom-select').not('.menu').on('click', 'a', function(event){
            event.preventDefault();

            $this = $(this);
            $parent = $this.closest('.custom-select');

            $this.closest('.custom-select').find('li.active').removeClass('active');
            $this.closest('li').addClass('active');

            var val = $this.data('value'),
                text = $this.text();

            $parent.find('.btn .text').text(text);
            $parent.find('input[type="hidden"]').val(val).find('.text').text(text);

        });
    }

    if ($('.fix-frame').length > 0) {
        $('.fix-frame').each(function(){
            $this = $(this);
        });
    }

    if ($('.text-intro .entry').length > 0) {
        $('.text-intro .entry').mCustomScrollbar({
            theme:"minimal"
        });
    }

    if ($('.body-building').length > 0) {
        $('.body-building').mCustomScrollbar({
            theme:"dark-thick",
            axis:"yx"

        });
    }

    if ($('.slider-home').length > 0) {
        $('.slider-home').nivoSlider({
            controlNav: false,
            effect: 'fade'
        });
    };

    if ($('.run-fancybox').length > 0) {
        $('.run-fancybox').fancybox({
        });
    };

    if ($('.tools-view-panorama').length > 0) {
        $('.tools-view-panorama').mousemove(function(e){
            var offset = $(this).offset().left;
            var x = e.pageX - offset;
            var w = $(this).width();
            var wimg = $(this).find('img').width() - w;
            var per = x * 100 / w;

            var trans = wimg  / 100 * per;
            $(this).find('img').css({'left': '-' + trans + 'px' })
        });
    };

    if ($('.description .short').length > 0) {
        $('.description .more-link').click(function(e){
            e.preventDefault();
            $(this).closest('.description').toggleClass('active');
            $text = $(this).find('.link');
            var text = '';
            if ($text.text() === '[- Rút gọn]') {
                text = '[+ Xem thêm]';
            } else if ($text.text() === '[+ Xem thêm]') {
                text = '[- Rút gọn]';
            } else if ($text.text() === '[- Close]') {
                text = '[+ Readmore]';
            } else if ($text.text() === '[+ Readmore]') {
                text = '[- Close]';
            } else {
                text = 'Undefined'
            }
            $text.text(text);
        });
    }

    if ($('.description_eng .short').length > 0) {
        $('.description_eng .more-link').click(function(e){
            e.preventDefault();
            $(this).closest('.description_eng').toggleClass('active');
            $text = $(this).find('.link');
            $text.text( $text.text() === '[- Short]' ? '[+ Read More]' : '[- Short]');
        });
    }

    $('[data-toggle="tooltip"]').tooltip();

    // $('img').each(function(){
    //     $(this).on('error', function(){
    //         var wP = $(this).parent().width();
    //         var src = '';
    //         $(this).attr('data-wp', wP);
    //         // if(wP == 0 || wP < 0) {
    //         //     src = default_image;
    //         // } else if(wP < 51) {
    //         //     src = 'http://cdn.jinn.vn/asset/frontend/img/noimage50.jpg';
    //         // } else if (wP < 101){
    //         //     src = 'http://cdn.jinn.vn/asset/frontend/img/noimage100.jpg';
    //         // } else if (wP == 501){
    //         //     src = 'http://cdn.jinn.vn/asset/frontend/img/noimage500.jpg';
    //         // } else {
    //         //     src = 'http://cdn.jinn.vn/asset/frontend/img/noimage.jpg';
    //         // }
    //         src = default_image;
    //         $(this).attr('src', src);
    //     })
    // })
});


(function($){
    $.unserialize = function(serializedString){
        var str = decodeURI(serializedString);
        var pairs = str.split('&');
        var obj = {}, p, idx, val;
        for (var i=0, n=pairs.length; i < n; i++) {
            p = pairs[i].split('=');
            idx = p[0];

            if (idx.indexOf("[]") == (idx.length - 2)) {
                // Eh um vetor
                var ind = idx.substring(0, idx.length-2)
                if (obj[ind] === undefined) {
                    obj[ind] = [];
                }
                obj[ind].push(p[1]);
            }
            else {
                obj[idx] = p[1];
            }
        }
        return obj;
    };

})(jQuery);
