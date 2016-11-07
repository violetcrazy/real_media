$document = $(document);
var load = {
    sending: false
};

$document
    .ready(function() {
        $('.slider-other').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 280,
            itemMargin: 0,
            minItems: 4,
            maxItems: 4,
            controlNav: false
        });

        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 140,
            itemMargin: 0,
            minItems: 5,
            maxItems: 5,
            asNavFor: '#slider'
        });

        $('#slider').flexslider({
            animation: "slide",
            controlNav: true,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            smoothHeight: true
        });


    })
    .on('submit', '#form-request', function(event){
        event.preventDefault();
        $.fancybox({
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'html',
            'href': '<div style="width: 320px" class="popup-inner">\
                        <h3 class="title-popup text-center">Đặt chỗ thành công</h3>\
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta atque voluptatem, sapiente odit aperiam fuga fugiat dolore, harum repellat eum repudiandae autem, maiores, hic.\
                    </div>'
        });
    })
    .on('click', '.item-share', function(event){
        event.preventDefault();
        var href = $(this).attr('href');
        newwindow=window.open(href,'Sahre','height=500,width=300');
        if (window.focus) {newwindow.focus()}
        return false;
    })
    .on('click', '.wrap-slider-big .line', function() {
        if (load.sending === false) {
            load.sending = true;
            var val = $(this).attr('data-id');
            var url = $(this).attr('data-url');

            $.ajax({
                'url': url,
                'type': 'POST',
                'dataType': 'html',
                success: function(data) {
                    $('.body-slider').html(data);
                    $('.body-slider img').load(function(){
                        $('.body-slider #carousel').flexslider({
                            animation: "slide",
                            controlNav: false,
                            animationLoop: false,
                            slideshow: false,
                            itemWidth: 140,
                            itemMargin: 0,
                            minItems: 5,
                            maxItems: 5,
                            asNavFor: '#slider',
                            smoothHeight: true
                        });

                        $('.body-slider #slider').flexslider({
                            animation: "slide",
                            controlNav: false,
                            animationLoop: false,
                            slideshow: false,
                            sync: "#carousel",
                            smoothHeight: true
                        });
                    });

                    load.sending = false;
                }
            });
        }
    });
