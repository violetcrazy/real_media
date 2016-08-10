$(document).ready(function(){
  CreateMap();
});
function CreateMap(){
    /* Khởi tạo biến tọa mặc định */
    var lat = 10.770329,
        lng = 106.675039;
    var mylat = 0, mylng =0 , error=1;
     /*Khởi tạo map theo tọa độ đã có*/
      var map;
      map = new GMaps({
        el: '#map',
        lat: lat,
        lng: lng
      });
      var path = [];
        polygon = map.drawPolygon({
            paths: path,
            strokeColor: '#BBD8E9',
            strokeOpacity: 1,
            strokeWeight: 3,
            fillColor: '#BBD8E9',
            fillOpacity: 0.6
        });
    /* Lấy vị trí của người dùng nếu trình duyệt có hỗ trợ */
    GMaps.geolocate({
		  success: function(position) {
              console.log(position);
              mylat = position.coords.latitude;
              mylng = position.coords.longitude ;
              error = 0;
		  },
		  error: function(error) {
		    alert('Lỗi vị trí: '+error.message);
		  },
		  not_supported: function() {
		    alert("Trình duyệt của bạn không hỗ trợ lấy vị trị, vui lòng đổi trình duyệt và  thử lại sau. ");
		  },always: function(){
              
            /* nếu có tọa độ của người đăng tin thì sẽ lấy để  khởi tạo map  còn không sẽ lấy giá trị của vị trí hiện tại */
              if ( $('#map').data('lng') != undefined && $('#map').data('lat') != undefined  && $('#map').data('lat') != ""  && $('#map').data('lat') != ""  ){
                    lat = $('#map').data('lat') ;
                    lng = $('#map').data('lng') ;
            /* không lấy dc vị trí user thì sử dụng ko thì sẽ sử dụng giá trị mặc định đầu tiên */
                }else if( error == 0){
                    lat = mylat;
                    lng = mylng;
                }
           
                /*Đánh dấu điểm trên map và cho kéo  thả chọn chính xác vị trí*/
                 map.panTo({lat:lat,lng:lng});
                 map.addMarker({
                      lat: lat,
                      lng: lng,
                      title: '',
                      draggable: true,
                      icon: "assets/images/icon-location-red.png",
                      fences: [polygon],
                      outside: function(m, f){
                            lng = (m.position.B);
                            lat = (m.position.k);
                            $('.lat').val(lat);
                            $('.lng').val(lng);	
                        }
                  });

          }
        /* End GMaps.geolocate */
		}); 
        /* Lấy và đánh dấu địa điểm search trên map */
        $('.get-location').click(function(e){
            e.preventDefault(); 
            GMaps.geocode({
              address: $('.address-input').val(),
              callback: function(results, status) {
                if (status == 'OK') { 
                 var latlng = results[0].geometry.location;
                 map.removeMarkers();
                 map.panTo({lat:latlng.k,lng:latlng.B});
                 map.addMarker({
                      lat: latlng.k,
                      lng: latlng.B,
                      title: '',
                      draggable: true,
                      icon: "assets/images/icon-location-red.png",
                      fences: [polygon],
                      outside: function(m, f){
                            lng = (m.position.B);
                            lat = (m.position.k);
                            $('.lat').val(lat);
                            $('.lng').val(lng);	
                        }
                  });
                 $('.lat').val(latlng.k);
                 $('.lng').val(latlng.B);    
                }
              }
            });
        });
        /* Tạo đánh dấu và lấy vị trí của user qua GPS  đã lấy ở trên đầu */
        $('.get-my-location').click(function(e){
           map.panTo({lat:mylat,lng:mylng});
           map.addMarker({
              lat: mylat,
              lng: mylng,
              title: '',
              draggable: true,
              icon: "assets/images/icon-location-red.png",
              fences: [polygon],
              outside: function(m, f){
                            lng = (m.position.B);
                            lat = (m.position.k);
                            $('.lat').val(lat);
                            $('.lng').val(lng);	
                        }
          });
          map.setCenter(mylat, mylng);
          $('.lat').val(mylat);
          $('.lng').val(mylng);

        });
        
    
};
/*End document load*/
