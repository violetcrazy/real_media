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
    });
