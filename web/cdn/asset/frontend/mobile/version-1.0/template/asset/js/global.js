$document = $(document);

$document
    .ready(function(){

        $('.btn-close-menu').on('click', function(){
            $('body').removeClass('open-menu');
        });

        $('.header-site .block-left').on('click', function(){
            $('body').addClass('open-menu');
        });

        $('.menu-sidebar a').on('click', function(){
            $this = $(this);
            if ($this.next('.sub-menu').size() > 0 ) {
                $this.closest('li').toggleClass('active');
            }
        });

        if ($('.description .short').length > 0) {
            $('.description .more-link').click(function(e){
                e.preventDefault();
                $(this).closest('.description').toggleClass('active');
                $text = $(this).find('.link');
                $text.text( $text.text() === '[-Rút gọn]' ? '[+Xem thêm]' : '[-Rút gọn]' );
            });
        }

        if ($('.info-payment').length > 0) {

            $('.show-content').on('click', function(event){
                event.preventDefault();
                $(this)
                    .addClass('active')
                    .siblings('.item')
                        .removeClass('active');

                var id = '#' + $(this).attr('id');
                $('.info-payment')
                    .find(id)
                    .addClass('show')
                    .siblings('.description')
                        .removeClass('show');
            });
        }

        if ($('.fancybox-run').length > 0) {
            var w = $(window).width();
            $('.fancybox-run').fancybox({
                maxWidth  : 950,
                fitToView : false,
                width     : '100%',
                autoSize  : false,
                autoHeight: true
            });
        }

        $('img').each(function(){
            $(this).on('error', function(){
                var wP = $(this).parent().width();
                var src = '';
                $(this).attr('data-wp', wP);
                if(wP == 0 || wP < 0) {
                    src = 'http://cdn.jinn.vn/asset/frontend/img/noimage.jpg';
                } else if(wP < 51) {
                    src = 'http://cdn.jinn.vn/asset/frontend/img/noimage50.jpg';
                } else if (wP < 101){
                    src = 'http://cdn.jinn.vn/asset/frontend/img/noimage100.jpg';
                } else if (wP == 501){
                    src = 'http://cdn.jinn.vn/asset/frontend/img/noimage500.jpg';
                } else {
                    src = 'http://cdn.jinn.vn/asset/frontend/img/noimage.jpg';
                }
                $(this).attr('src', src);
            })
        })
    })
