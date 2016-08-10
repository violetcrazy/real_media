$document = $(document);
$document.ready(
    function(){
        $('.map').maphilight({
            alwaysOn: false
        });

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
                $('.block-map').append(html);
                console.log($('#'+data_id).width() /2);
                var left = centerX - ($('#'+data_id).width() /2),
                    top = centerY - ($('#'+data_id).height() /2);

                $('#'+data_id).css({
                    'top': top + 'px',
                    'left': left + 'px'
                });
            }
        );
    }
)
.on('click','area',
    function(){
        $this = $(this);
        var id_block = $this.data('id');
        alert(id_block);
    }
)
.on('mouseover','area',
    function(){
        var id_block = $(this).data('id');
        $('#'+id_block).addClass('active');
    }
)
.on('mouseout','area',
    function(){
        var id_block = $(this).data('id');
        $('#'+id_block).removeClass('active');
    }
)
;
