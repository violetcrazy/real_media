/* Sử dụng để xóa đi 1 dòng nhập liệu link hữu ích trong phần duyệt tin cho user */
$(document).on('click','.remove-clone',function(){
	$(this).parents('.group-clone').fadeOut('fast',function(){
		$(this).remove();
	});
}); 
/* Sử dụng để thêm 1 dòng nhập liệu của link hữu ích trong phần duyệt tin cho user */
$(document).on('click','.add-clone',function(){
	var el = $(this).data('clone');
	if ( $(this).parent().prev('.group-clone').size() ==0 ){
		$eln = '<div class="form-group group-clone">\
					<label class="col-sm-2 control-label" for="key_seo">\
						Link hữu ích\
					</label>\
					<div class="col-sm-4">\
						 <input type="text" placeholder="Text hiển thị" name="text-link[]" class="form-control limited" maxlength="150">\
					</div>\
					<div class="col-sm-4">\
						 <input type="text" placeholder="Link chủ đích" name="source-link[]" class="form-control limited" maxlength="150">\
					</div>\
					<div class="col-sm-2 text-right">\
						<span class="btn btn-danger remove-clone"><i class="fa fa-times fa fa-white"></i> Xóa</span>\
					</div>\
				</div> ';
	}else {
		$eln = $(this).parent().prev('.group-clone').clone();
	}
	$(this).parent().before($eln);
});
/* Sử dụng để xóa hình ảnh trong bộ sưu tập hình ảnh của user nếu hình  ảnh đó sai phạm */
$(document).on('click','.btn-delete',function(){
	$(this).parents('.frame-th').fadeOut('fast',function(){
		$(this).remove();
	});
});