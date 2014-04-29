/**
 * Manage challenges js operations
 * author:- Chand Miyan
 */
$(document).ready(function(){
	
	$("#add_location").click(function(){
		jQuery.facebox('<div style="width:450px; margin:20px 0px;" class="txtAlignC"><strong class="upper">Location:</strong><input type="text" class="input mleft5" name="location" id="location" class="mright20"><div class="black_btn2 mleft10"><span class="upper"><input type="button" class="search_btne" value="Add Lcation" id="locationSubmit" /></span></div></div>');	
	});

	// Add location
	$('#locationSubmit').live('click',function(){
		var locationText = jQuery.trim($("#location").val());
	
		var dataString	= "loc=" + locationText;
		if ( (locationText == '') )
		{
			alert("Please Enter location name");
		}
		else
		{ 
			$.ajax({
				type: "POST",
				url : webURL + "admin/challenge/add_location",
				data: dataString,
				cache: false,
				dataType: "html",
				success: function(data){
					$('#ChallengeLocationId').append(new Option(locationText, data));
					$.facebox.close();
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
	
	$(".datepicker").datepicker({ 
		minDate: 0, 
		dateFormat: "mm-dd-yy",
		buttonImage: webURL + "images/cal-icon.gif",
		buttonText: "Choose",
		buttonImageOnly:true,
		beforeShow: function(input, inst) {
			if(input.id == 'ChallengeStartDate' && $('#ChallengeEndDate').val() != '')
			{
				$('#ChallengeStartDate').datepicker("option", 'maxDate', $('#ChallengeEndDate').val());
			}
			else if(input.id == 'ChallengeEndDate' && $('#ChallengeStartDate').val() != '')
			{
				$('#ChallengeEndDate').datepicker("option", 'minDate', $('#ChallengeStartDate').val());
			}
		}
		
	 });
	 
		
	//Ad more fields
	$('#add_more_option').click(function(){
		
		var elmblock = $('.field_options').last().clone();
		$('.field_options').last().after(elmblock);
		var ind = $('.field_options').length - 1;
		$('.field_options').last().find('input').attr('name', 'field[label]['+ind+']').attr('id', 'field_label-'+ind );
		$('.field_options').last().find('select').attr('name', 'field[type]['+ind+']').attr('id', 'field_type-'+ind );
		
		$('.field_options').last().find('input').val('');
		$('.field_options').last().find('select').val('');
		$('#remove_option').show();
	});
	
	$('#remove_option').click(function(){
		if ( $('.field_options').length > 1 )
		{
			$('.field_options').last().remove();
			if ($('.field_options').length == 1 )
			{
				$('#remove_option').hide();
			}
		}
	});
	
	$('#challenge_list').submit(function(){
		var ischecked = $('input[name="challenge_ids[]"]:checked').length;
		if (ischecked == 0)
		{
			alert('Please checked atleat one challenge in order to perform next operation');
			return false;
		}
		if ( $('#action_options').val() == '')
		{
			alert('Please select option');
			return false;
		}
		return confirm('Are you sure you want to perform this action?');
	});
	
	$('#submission_list').submit(function(){
		var ischecked = $('input[name="submission_ids[]"]:checked').length;
		if (ischecked == 0)
		{
			alert('Please checked atleat one submission in order to perform next operation');
			return false;
		}
		if ( $('#action_options').val() == '')
		{
			alert('Please select option');
			return false;
		}
		return confirm('Are you sure you want to perform this action?');
	});
	$(".video_gallery a").colorbox({iframe:true, innerHeight:344, innerWidth:425});
	$(".photo_gallery a").colorbox();
});
