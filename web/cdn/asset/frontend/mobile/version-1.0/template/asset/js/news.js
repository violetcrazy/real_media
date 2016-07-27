$document = $(document);

$document
    .ready(function(){
        var mySwiper1 = new Swiper (
            '.slides-news  .swiper-container',
            {
              loop: true,
              nextButton: '.slides-news .swiper-button-next',
              prevButton: '.slides-news .swiper-button-prev'
            }
        );
    });
