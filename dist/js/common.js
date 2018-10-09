function Common(){

}

Common.prototype.setSuccessMsg = function(msg){
    $('#success_msg').html(msg);
    $('#success_alert').fadeIn('slow');
    setTimeout(function(){
        $('#success_alert').fadeOut('slow');
    }, 2000);
};

Common.prototype.setSuccessMsgReload = function(msg){
    $('#success_msg').html(msg);
    $('#success_alert').fadeIn('slow');
    setTimeout(function(){
        window.location.reload();
    }, 2000);
};

Common.prototype.setErrorMsg = function(msg){
    $('#fail_msg').html(msg);
    $('#fail_alert').fadeIn('slow');
    setTimeout(function(){
        $('#fail_alert').fadeOut('slow');
    }, 2000);
};

Common.prototype.postCall = function(url, data, reload, callback){
    if (typeof reload === 'undefined') reload = false;
	if (typeof callback === 'undefined') callback = false;
    $.post(url, data, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
			if(callback != false)
				callback(json.message);
			else{
				if(reload)
					ObjCommon.setSuccessMsgReload(json.message);
				else
					ObjCommon.setSuccessMsg(json.message);
			}
        }else if(json.message == 'validation'){
            ObjCommon.setErrorMsg(json.error[0]);
        }else{
            ObjCommon.setErrorMsg(json.message);
        }
    });
};

Common.prototype.postCallFlashMsg = function(url, data, reload, callback){
    if (typeof reload === 'undefined') reload = false;
	if (typeof callback === 'undefined') callback = false;
    $.post(url, data, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
			if(callback != false){
				ObjCommon.setSuccessMsg(json.message);
				callback(json.message);
			}else{
				if(reload)
					ObjCommon.setSuccessMsgReload(json.message);
				else
					ObjCommon.setSuccessMsg(json.message);
			}
        }else if(json.message == 'validation'){
            ObjCommon.setErrorMsg(json.error[0]);
        }else{
            ObjCommon.setErrorMsg(json.message);
        }
    });
};

Common.prototype.postCallFlashMsgData = function(url, data, reload, callback){
    if (typeof reload === 'undefined') reload = false;
	if (typeof callback === 'undefined') callback = false;
    $.post(url, data, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
			if(callback != false){
				ObjCommon.setSuccessMsg(json.message);
				callback(json.data);
			}else{
				if(reload)
					ObjCommon.setSuccessMsgReload(json.message);
				else
					ObjCommon.setSuccessMsg(json.message);
			}
        }else if(json.message == 'validation'){
            ObjCommon.setErrorMsg(json.error[0]);
        }else{
            ObjCommon.setErrorMsg(json.message);
        }
    });
};

Common.prototype.postFileUpload = function(url, id, form_data, callback, multiple){
	var object_data = false;
    if (typeof multiple === 'undefined') multiple = false;
	if (typeof form_data === 'undefined') form_data = false;
	if (typeof form_data === 'object' && form_data.profile){
		object_data = form_data;
		form_data = false;
	}

    // match anything not a [ or ]
    var regexp = /^[^[\]]+/;
    var fileInput = $('#'+id);
    var fileInputName = regexp.exec( fileInput.attr('name') );

    // make files available
    var data = new FormData();
    var files = document.getElementById(id).files;
    if(multiple){
        $.each(files, function(i, file) {
            data.append(fileInputName+'['+i+']', file);
        });
    }else
        data.append(fileInputName, files[0]);

    $('.progress').removeClass('hide');
	if(form_data){
		$.each(form_data,function(key,input){
			data.append(input.name,input.value);
		});
	}
	
	if(object_data){
		for ( var key in object_data ) {
			data.append(key, object_data[key]);
		}
	}

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();

            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    $('#progress-bar').attr('aria-valuenow', percentComplete);
                    $('#progress-bar').css({'width' : percentComplete + '%'});
                    $('#sr-only').html(percentComplete + '% Complete');

                    if (percentComplete === 100) {
                        $('#progress-bar').attr('aria-valuenow', 0);
                        $('#progress-bar').css({'width' : '0%'});
                        $('.progress').addClass('hide');
                    }

                }
            }, false);

            return xhr;
        },
        type: 'POST',
        data: data,
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            var json = jQuery.parseJSON(data);
            if(json.status == 'ok'){
                ObjCommon.setSuccessMsgReload(json.message);
			}else if(json.status == 'success'){
				callback(json.message);
			}else if(json.status == 'failed'){
				ObjCommon.setErrorMsg(json.message);
				callback(false);
            }else if(json.message == 'validation'){
                ObjCommon.setErrorMsg(json.error);
            }else{
                ObjCommon.setErrorMsg(json.message);
            }
        }
    });
};

Common.prototype.getCallStatus = function(url, callback){
    $.get(url, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
			ObjCommon.setSuccessMsg(json.message);
            callback(true);
        }else{
            ObjCommon.setErrorMsg(json.message);
            callback(false);
        }
    });
};

Common.prototype.getCall = function(url, callback){
    $.get(url, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
            callback(json.message);
        }else{
            ObjCommon.setErrorMsg(json.message);
            callback(false);
        }
    });
};

Common.prototype.getCallNoFlash = function(url, callback){
    $.get(url, function(response, status){
        var json = jQuery.parseJSON(response);
        if(json.status == 'ok'){
            callback(json.message);
        }else{
            callback(false);
        }
    });
};

Common.prototype.addFormValid = function(form, rules, messages){
    form.validate({
        rules:
            rules,
        messages:
            messages,
        highlight: function(element) {
 $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
 $(element).closest('.form-group').removeClass('has-error');
 $(element).closest('.form-group').children('label.error').remove();
        }
    });
};

Common.prototype.addHorizontalFormValid = function(form, rules, messages){
    form.validate({
        rules:
            rules,
        messages:
            messages,
        highlight: function(element) {
 $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
 $(element).closest('.form-group').removeClass('has-error');
 $(element).closest('.form-group').children('div').children('label.error').remove();
        }
    });
};

Common.prototype.checkAll = function(checkAll, check){
	$('input[name="'+checkAll+'"]').click(function(){
		var state = $(this).prop('checked');
		$('input[name="'+check+'"]').prop('checked', state);
	});
}

Common.prototype.icheckAll = function(checkAll, check){
	var checkAll = $('input[name="'+checkAll+'"]');
    var checkboxes = $('input[name="'+check+'"]');
	checkAll.on('ifChecked ifUnchecked', function(event) {        
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
}

var ObjCommon = new Common();