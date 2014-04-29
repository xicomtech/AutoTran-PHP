function toggleChecked(status) {
    $("input.checkids").each( function() {
	$(this).attr("checked",status);
    })
}
/**
 * @funtion toggleCheckAll
 * multipurpose function created to check atleast one checked item and toggle check all checkbox
 * 
 */
function toggleCheckAll(checkflag) {
    if(checkflag)             {
	var flag = false;
    }else{
	var flag = 'checked';
    }
        
    $("input.checkids").each( function() {
	if(checkflag)          
	{
	    if($(this).attr('checked'))    
	    {
		flag = true;
	    }
	}else{
	    if(!$(this).attr('checked'))     
	    {
		flag = false;
	    }    
	}
                
    });
    return flag;
}
function checkedValues() {
    var values = new Array();
    
    $("input.checkids").each( function() {
	if($(this).attr('checked'))           
	{
	    values.push($(this).val());
	}      
    });
    return values.join(',');
}
function takeactions(moduleurl)          
{
    var checkSelected = toggleCheckAll(true);
    if(!checkSelected)           
    {
	alert('Please select atleast one item');
	return false;
    }
    var action = $('#actions').val();
    if(action == '')         
    {
	alert('Please Select an action');
    }else{
	if(action=='delete')           
	{
	    if(confirm('Are you sure you want to delete selected items'))        
	    {
		$.ajax({
		    url : webURL+moduleurl+'deleteAll',
		    data : 'id='+checkedValues(),
		    type : 'POST',
		    async : false,
		    success : function(data, textStatus, jqXHR)       
		    {
			if(data == "succes")         
			{
			    window.location = '';
			}else{
			    alert(data);
			    return false;
			}
		    },
		    statusCode: {
			404: function() {
			    alert('page not found');
			}
		    }
		});
	    }
	}else if(action=='enablearticle')          
	{
	    if(confirm('Are you sure you want to enable article creation for users')) 
	    {
		$.ajax({
		    url : webURL+moduleurl+'enablearticle',
		    data : 'id='+checkedValues(),
		    type : 'POST',
		    async : false,
		    success : function(data, textStatus, jqXHR)        
		    {
			if(data == "succes")         
			{
			    window.location = '';
			}else{
			    alert(data);
			    return false;
			}
		    },
		    statusCode: {
			404: function() {
			    alert('page not found');
			}
		    }
		});
	    }
	}else if(action=='disablearticle')        
	{
	    if(confirm('Are you sure you want to disable article creation for users'))      
	    {
		$.ajax({
		    url : webURL+moduleurl+'disablearticle',
		    data : 'id='+checkedValues(),
		    type : 'POST',
		    async : false,
		    success : function(data, textStatus, jqXHR)   
		    {
			if(data == "succes")            
			{
			    window.location = '';
			}else{
			    alert(data);
			    return false;
			}
		    },
		    statusCode: {
			404: function() {
			    alert('page not found');
			}
		    }
		});
	    }
	}
    }
    return false;
        
}
$.fn.fajaxform = function() {
    $(this).livequery('submit', function(e) {
	var $this = $(this);
	$this.block();
	$this.ajaxSubmit( {
	    beforeSubmit: function(formData, jqForm, options) {
		$('input:file', jqForm[0]).each(function(i) {
		    if ($('input:file', jqForm[0]).eq(i).val()) {
			options['extraData'] = {
			    'is_iframe_submit': 1
			};
		    }
		});
		$this.block();
	    },
	    success: function(responseText, statusText) {
		redirect = responseText.split('*');
		if (redirect[0] == 'redirect') {
		    location.href = redirect[1];
		} else if ($this.metadata().container) {
		    $('.' + $this.metadata().container).html(responseText);
		} else {
		    $this.parents('div.js-responses').eq(0).html(responseText);
		}
		$this.unblock();
	    }
	});
	return false;
    });
};
$(document).ready(function() {
    
    $('form.js-ajax-form').fajaxform();
    $('.js-accordion').accordion( {
	header: 'h3',
	autoHeight: false,
	active: false,
	collapsible: true
    });
    $('h3', '.js-accordion').click(function(e) {
	var contentDiv = $(this).next('div');
	if ( ! contentDiv.html().length) {
	    $this = $(this);
	    $this.block();
	    $.get($(this).find('a').attr('href'), function(data) {
		contentDiv.html(data);
		$this.unblock();
	    });
	}
    });
    
    
    
    $('#check_all').live('click',function()     
    {
	var flag = false;
	if($(this).attr('checked'))           
	{
	    var flag = 'checked';
	}
	toggleChecked(flag);
    });
    $("input.checkids").live('click', function() {
	var flag = toggleCheckAll();
	$('#check_all').attr('checked',flag);
    });
    
    
    
    
    
    $('form').validate({
		submitHandler: function(form) {
			var flag = true;
			var editors = $("textarea.tinymce");

			$.each(editors ,function(key,editor)        
			{
			if(!$('#'+editor.id).valid())        
			{
				flag = false;
			}
			})
			if(flag)            
			{
			 form.submit();
			}
		}
        
    });
    $('#toggle-edit-order').live('click',function()      
    {
	$("div.order-value").toggle();
	$("div.order-input").toggle();
	$("tr.update-order").toggle();
    });
        
});
