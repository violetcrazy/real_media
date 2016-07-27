$document = $(document);
var load = {sending: false};
$document.ready(function(){
    $('.filter-multiple .parent > .entry-item').click(function(){
        $this = $(this).closest('.parent');

        $this.toggleClass('active');
    })
    $('.secondary-list .custom-checkbox input').change(function(){
        if ($(this).is(':checked')) {
            $(this).closest('li').find('.sub-list').find('input').prop('checked', true);
        } else {
            $(this).closest('li').find('.sub-list').find('input').prop('checked', false);
        }
    });
    $('.custom-checkbox .ic-close').click(function(){
        $(this).closest('li').toggleClass('active');
        return false;
    });

    $('.title-filter .arrow').click(function(){
        $this = $(this).closest('.title-filter');
        $this.toggleClass('de-active');
        $this.next('.entry-filter').toggleClass('de-active');
    });

    $('.block-header-tab a').click(function(event){
        event.preventDefault();
        var id = $(this).attr('href');

        $('.wrap-list').removeClass('active');
        $(id).addClass('active');

        $('.block-header-tab a').removeClass('active');
        $(this).addClass('active');
    });

});

