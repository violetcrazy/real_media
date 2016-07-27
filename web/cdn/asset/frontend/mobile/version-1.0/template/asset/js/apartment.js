$document = $(document);

$document
    .ready(function(){
        var mySwiper1 = new Swiper (
            '.slides-apartment  .swiper-container',
            {
              loop: true,
              nextButton: '.slides-apartment .swiper-button-next',
              prevButton: '.slides-apartment .swiper-button-prev'
            }
        );
        var mySwiper1 = new Swiper (
            '.slides-project-other  .swiper-container',
            {
              loop: true,
              nextButton: '.slides-project-other  .swiper-button-next',
              prevButton: '.slides-project-other  .swiper-button-prev'
            }
        );
        $('.view-panorama .btn-left').on('click', function(event){
            event.preventDefault();
            $this = $(this).closest('.view-panorama');
            var w = $('.panorama img').width();
            var t = w/200*1000;

            $this
                .find('.panorama')
                .stop(true,true)
                .animate({
                    scrollLeft: w
                }, t)
        });

        $('.view-panorama .btn-right').on('click', function(event){
            event.preventDefault();
            $this = $(this).closest('.view-panorama');
            var w = $('.panorama img').width();
            var t = w/200*1000;

            $this
                .find('.panorama')
                .stop(true,true)
                .animate({
                    scrollLeft: 0
                }, t)
        });
    })
