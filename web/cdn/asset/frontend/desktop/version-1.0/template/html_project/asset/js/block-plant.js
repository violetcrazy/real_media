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

        var wrapSlider = $('.wrap-image').flexslider({
            animation: "slide",
            animationLoop: false,
            controlNav: false,
            slideshow: false
        });

        $('#goto-slide a').click(function(){
            $this = $(this);
            var i = $this.closest('li').index();
            wrapSlider.flexslider(i);
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
                    var centerY = minY + ((maxY - minY) / 2);
                    html = '<span class="mark-map" id="'+ data_id +'">'+ title +'</span>';
                    $this_each.closest('.block-map').append(html);

                    var left = centerX - ($('#'+data_id).outerWidth() /2),
                        top = centerY - ($('#'+data_id).outerHeight() /2);

                    $('#'+data_id).css({
                        'top': top + 'px',
                        'left': left + 'px'
                    });
                }
            );
        },200)
    }
)
.on('click','.close', function(){
    $this = $(this);
    $this.closest('.block-info-popup').fadeOut('fast', function(){
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
});
