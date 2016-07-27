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

        $('.plant-gallery .slider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 230,
            itemMargin: 0,
            minItems: 4,
            maxItems: 4,
            controlNav: false
        });
    }
)
.on('click','.close', function(){
    $this = $(this);
    $this.closest('.block-info-popup').fadeOut('fast', function(){
        $(this).remove();
    });
})
