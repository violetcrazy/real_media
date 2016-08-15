$document = $(document);
var load = {sending: false};
$document.ready(
    function(){

        $('.slider-other').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 350,
            itemMargin: 0,
            minItems: 3,
            maxItems: 3,
            controlNav: false
        });

        $('.gallery-slide').flexslider({
            animation: "slide",
            animationLoop: true,
            itemWidth:  $('.gallery-slide').width() / 4,
            itemMargin: 0,
            minItems: 4,
            maxItems: 4,
            controlNav: false
        });

        $('.map').maphilight({
            alwaysOn: false
        });

        setTimeout(function(){
            $('#map-tag area').each(
                function(){
                    $this_each = $(this);
                    var title = $this_each.attr('title'),
                        data_id =  $this_each.data('id'),
                        coords = $.trim($this_each.attr('coords')).split(','),
                        i = 0,
                        maxX = parseInt(coords[0]),
                        minX = parseInt(coords[0]),
                        maxY = parseInt(coords[1]),
                        minY = parseInt(coords[1]);

                    for (i = 0; i < coords.length; i ++) {
                        var vl = parseInt(coords[i]);
                        if (i % 2 == 0){
                            // X
                            maxX = (vl > maxX) ? vl : maxX;
                            minX = (vl < minX) ? vl : minX;
                        } else {
                            // Y
                            maxY = (vl > maxY) ? vl : maxY;
                            minY = (vl < minY) ? vl : minY;
                        }
                    };

                    var centerX = minX + ((maxX - minX) / 2);
                    var centerY = minY - 10;
                    html = '<span class="mark-map" id="'+ data_id +'">'+ title +'</span>';
                    $('.block-map').append(html);
                    var left = centerX - ($('#'+data_id).outerWidth() /2),
                        top = centerY - $('#'+data_id).outerHeight();

                    $('#'+data_id).css({
                        'top': top + 'px',
                        'left': left + 'px'
                    });
                }
            );
        },200)
    }
)
.on('click','area', function(){
    $this = $(this);
    var href = $this.data('href');
    // window.location.href = href;

})
.on('click','area', function(){
    $this = $(this);
    var id_block = $this.data('id');
    $('.wrap-image').find('.popup-map').remove();

    if (load.sending === false){
        load.sending = true;
        $.ajax({
            url: url_ajax_quick_view,
            data: { id: id_block},
            dataType: 'html',
            success: function(data){
                $('.wrap-image').append(data);
                $('.wrap-image').find('.popup-map').fadeIn('fast');
                $('.slider-popup').flexslider({
                    animation: "slide",
                    animationLoop: false,
                    itemWidth: 111.333,
                    itemMargin: 0,
                    minItems: 3,
                    maxItems: 3,
                    controlNav: false
                });
                load.sending = false;
            }
        });
    }
})
.on('click','.close', function(){
    $this = $(this);
    $this.closest('.popup-map').fadeOut('fast', function(){
        $(this).remove();
    });
})
.on('mouseover','area',function(){
    var id_block = $(this).data('id');
    $('#'+id_block).addClass('active');
    $('body').addClass('mouse');
})
.on('mouseout','area',function(){
    $('body').removeClass('mouse');
    var id_block = $(this).data('id');
    $('#'+id_block).removeClass('active');
})
.on('click', '#load-small-gallery', function(e){
    e.preventDefault();
    var page = $(this).data('page');
    page = page + 1;
    if (load.sending == false) {
        load.sending = true;
        $.ajax({
            url: 'ajax-small-gallery.html',
            data: {page: page},
            success: function(data){
                $('.block-small-gallery ul').append(data);
                load.sending = false;
            }
        });
    }
});
