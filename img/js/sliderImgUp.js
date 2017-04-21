
$(document).ready(function($) {
	$('#sliderImgAdd').click(function(event) {
		$('#tab2 table').append($sliderImgItem);
	});

	$('#tab1').on('click', '.delSliderItem', function(event) {
		$(this).parent('td').parent('tr').remove();
	});

	$sliderImgItem= '<tr>'+
        '<td><input type="text" name="position[]"></td>'+
        '<td><input name="text[]" type="text" /></td>'+
        '<td><input type="file" name="thumbs[]"/></td>'+
        '<td><span class="delSliderItem">删除</span></td>'+
    '</tr>';
});



