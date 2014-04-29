 $(document).ready(function(){
	
// File uploading 
	$('.img-uploader').attr("accept", "image/jpeg").live('change',function () {
		// Validate filetype before uploading. Server-side must additionally validate the MIME-TYPE!
		var filetype = $(this).val().split(".");		
		filetype = filetype[filetype.length - 1].toLowerCase();
		
		if (".gif.jpg.jpeg.png".indexOf(filetype) == -1) 
		{
			$(this).val("");
			alert("Please check the format of your photo and try again. We support these photo formats: JPG, GIF and PNG.");
		} 
		else
		{
			
			input = this;
			var old_source = $('#'+input.id+'-img').attr('src');
			$('#'+input.id+'-img').attr('src',webURL+'images/loader.gif');
			$('#'+input.id+'-img').css({width: '53px', height: '31px'});
			var elm_id = input.id;
			//input.id = input.name = 'uploadfile';
			
			$('<form enctype="multipart/form-data" method="post" id="'+elm_id+'-frm"></form>').append(input).hide().appendTo('body').ajaxForm({
				url: webURL + 'admin/products/upload_image',
				data: { imagename: input.id },
				success: function (data) {
					var dataObj = jQuery.parseJSON(data);
					if ( dataObj.error )
					{
						alert(dataObj.error);
						$('#'+elm_id+'-img').attr('src', old_source);
					
						$('#'+elm_id+'-btn').append(input);
						$('#'+elm_id+'-frm').remove();
					}
					else
					{
						$('#'+elm_id+'-img').attr('src', dataObj.file_temp_url);
						$('.jcrop-holder img').attr('src', dataObj.file_temp_url);
						//Change facebox popup position
						if ( dataObj.width > 1200 )
						{
							$(".uploadProfilePic").css({ 'max-width': '1200px', overflow: 'auto'});
						}
						if ( dataObj.height > 700 )
						{
							$(".uploadProfilePic").css({ 'max-height': '700px', overflow: 'auto'});
						}
						$('#photo-img, .jcrop-holder, .jcrop-holder img').css({width: dataObj.width, height: dataObj.height});
						$('#photo-img').Jcrop({
							minSize: [155,155],
							aspectRatio: 1,
							setSelect: [10,10,155,155],
							onSelect: updateCoordinates,
							onChange: updateCoordinates,
							onRelease: clearCoordinates
						});
						$('#source_file').val(dataObj.file_name);
						$('#crop_save').show();
						$('#facebox').css({ left:$(window).width() / 2 - ($('#facebox .popup').outerWidth() / 2) });
					}
				}
			}).submit();
		}
	});
 });
/**
 * updateCoords function to update the selected image coordinates
 * @param c object
 */
function updateCoordinates(crd)
{
	$('#x').val(crd.x);
	$('#y').val(crd.y);
	$('#w').val(crd.w);
	$('#h').val(crd.h);
};
/**
 * updateCoords function to update the selected image coordinates
 * @param c object
 */
function clearCoordinates()
{
	$('#coordinate_input input').val('');
};