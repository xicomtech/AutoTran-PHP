/*
* Add category and type for artist
* author:- Bhanu Prakash Pandey
*/

$("#addCategory").live('click', function(){
	jQuery.facebox('<div style="width:450px; margin:20px 0px;" class="txtAlignC"><strong class="upper">Category:</strong><input type="hidden" name="parent" id="parentValue" value="2" > <input type="text" class="input mleft5" name="category" id="category" class="mright20"><div class="black_btn2 mleft10"><span class="upper"><input type="button" class="search_btne" value="Add category" id="categorySubmit" /></span></div></div>');	
});

// Add category
$('#categorySubmit').live('click',function(){
	var categoryText = $("#category").val();
	var parent = $("#parentValue").val();
	var dataString	= "category=" + categoryText +"&parent=" + parent;
	if ( (categoryText == '') )
	{
		alert("Please Enter category name");
	}
	else
	{ 
		$.ajax({
			type: "POST",
			url : webURL + "admin/artists/add_category",
			data: dataString,
			cache: false,
			dataType: "html",
			success: function(mydata){
				$.facebox.close();
				window.location.reload();
			},
			statusCode: {
				404: function() {
					alert('page not found');
			}
			}
		});
	}
	return false;
});
