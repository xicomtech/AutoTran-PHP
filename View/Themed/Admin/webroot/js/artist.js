/*
* Add category and type for artist
* author:- Bhanu Prakash Pandey
*/

$("#addCategory").live('click', function(){
	jQuery.facebox('<div style="width:450px; margin:20px 0px;" class="txtAlignC"><strong class="upper">Category:</strong><input type="hidden" name="parent" id="parentValue" value="0" > <input type="text" class="input mleft5" name="category" id="category" class="mright20"><div class="black_btn2 mleft10"><span class="upper"><input type="button" class="search_btne" value="Add category" id="categorySubmit" /></span></div></div>');	
});

$("#addType").live('click', function(){
	jQuery.facebox('<div style="width:450px;margin:20px 0px;" class="txtAlignC"><strong class="upper">Type:</strong><input class="input mleft5" type="text" name="type" id="type" class="mright20"><div class="black_btn2 mleft10"><span class="upper"><input type="button" value="Add Type" id="typeSubmit" class="search_btne" /></span></div></div>');	
});

$("#addMusicCategory").live('click', function(){
	jQuery.facebox('<div style="width:450px; margin:20px 0px;" class="txtAlignC"><strong class="upper">Category:</strong><input type="hidden" id="parentValue"  name="parent" value="1" > <input type="text" class="input mleft5" name="category" id="category" class="mright20"><div class="black_btn2 mleft10"><span class="upper"><input type="button" class="search_btne" value="Add category" id="categorySubmit" /></span></div></div>');	
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

// Add type
$('#typeSubmit').live('click',function(){
	var typeText = $("#type").val();
	var dataString	= "type=" + typeText;
	if ( (typeText == '') )
	{
		alert("Please Enter type name");
	}
	else
	{ 
		$.ajax({
			type: "POST",
			url : webURL + "admin/artists/add_type",
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