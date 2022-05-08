var vowner;
function hideExcept(array, item) {
	for (var i = 0; i < array.length; i++) {
		if (array[i] != item)
		$("." + array[i]).hide();
		else
		$("." + array[i]).fadeIn();
		
	}
}
function getInputValueById(idName) {
	var value = $("#" + idName).val();
	return value;
}
function alert_success(msg) {
	$.message.success({
		message: msg,
		duration: 5000
	})
}
function alert_error(msg) {
	$.message.error({
		message: msg,
		duration: 5000
	})
}
function active(array, item) {
	for (var i = 0; i < array.length; i++) {
		if (array[i] != item) {
			this.color(array[i], "white");
		}
		else {
			var color = "peru";
			this.color(array[i], color);
		}
	}
}
function active_bg(array, item, bgcolor, color) {
	for (var i = 0; i < array.length; i++) {
		if (array[i] == item) {
			$("." + item).css({
				"background": bgcolor,
				"color": color,
				"border-top-left-radius": "5px",
				"border-bottom-left-radius": "5px"
			})
		} else {
			$("." + array[i]).css({
				"background": "#000",
				"color": "white"
			})
		}
	}
}
function active_caret(array, item, color) {
	for (var i = 0; i < array.length; i++) {
		if (array[i] == item) {
			$("." + array[i]).show();
		} else {
			$("." + array[i]).hide();
		}
	}
}
function active_bar(array, item) {
	for (var i = 0; i < array.length; i++) {
		if (array[i] != item) {
			$("." + array[i]).css({
				"border-bottom": "none"
			});
		}
		else {
			$("." + array[i]).css({
				"border-bottom": "5px solid black"
			});
		}
	}
}
function multiHide(className) {
	for (var i = 0; i < className.length; i++) {
		$("." + className[i]).hide();
	}
}

function multiShow(className) {
	for (var i = 0; i < className.length; i++) {
		$("." + className[i]).show();
	}
}

function onClick(className, event, el) {
	$("." + className).click(function () {
		(event == "hide") ? $("." + el).hide() : "";
		(event == "show") ? $("." + el).show() : "";
		(event == "slideUp") ? $("." + el).slideUp() : "";
		(event == "slideDown") ? $("." + el).slideDown() : "";
		(event == "fadeIn") ? $("." + el).fadeIn() : "";
		(event == "fadeOut") ? $("." + el).fadeOut() : "";
	})
}

function hide(className) {
	$("." + className).hide();
}

function show(className) {
	$("." + className).show();
}

function slideUp(className) {
	$("." + className).slideUp();
}

function slideDown(className) {
	$("." + className).slideDown();
}

//font color css function
function color(className, color) {
	$("." + className).css({
		"color": color
	})
}

function fadeIn(className) {
	$("." + className).fadeIn();
}

function fadeOut(className) {
	$("." + className).fadeOut();
}

function innerHTML(className, text) {
	$("." + className).html(text);
}
function setValue(val) {
	this.allowed = val;
}

function getValue() {
	return allowed;
}

function addClass(className, newClass) {
	$("." + className).addClass(newClass);
}
function removeClass(className, remClass) {
	$("." + className).removeClass(remClass);
}

function currentYear() {
	var date = new Date();
	var year = date.getFullYear();
	return year;
}
function inputValue(className) {
	var val = $("." + className).val();
	return val;
}
function isNumeric(data) {
	if (!isNaN(data)) {
		return true;
	} else {
		return false;
	}
}
function errorBorder() {
	$(".regno").css({
		"border": "2px solid red",
		"outline": "none"
	});
}
function successBorder() {
	$(".regno").css({
		"border": "1px solid gray",
		"outline": "none"
	});
}
function empty(data) {
	if (data.length == 0) {
		return true;
	} else {
		return false;
	}
}
function strlen(data) {
	return data.length;
}
function alertBox(header, body) {
	hide("prompt-cancel");
	hide("prompt-confirm");
	show("prompt-ok");
	innerHTML("prompt-header", header);
	innerHTML("prompt-body", body);
	show("prompt");
}

function prompt(header, body, newClass) {
	show("prompt");
	innerHTML("prompt-header", header);
	innerHTML("prompt-body", body);
	addClass("prompt-box", newClass);
}
function month(month) {
	switch (month) {
		case 'Jan': return 'January'; break;
		case 'Feb': return 'February'; break;
		case 'Mar': return 'March'; break;
		case 'Apr': return 'April'; break;
		case 'May': return 'May'; break;
		case 'Jun': return 'June'; break;
		case 'Jul': return 'July'; break;
		case 'Aug': return 'August'; break;
		case 'Sep': return 'September'; break;
		case 'Oct': return 'October'; break;
		case 'Nov': return 'November'; break;
		case 'Dec': return 'December'; break;
	}
}


function regNoVerification(regno) {
	var init = "";
	var array1 = regno.split("/");
	var array2 = array1[1].split(".");
	var curr_year = currentYear();
	var initYear = 2000 + parseInt(array2[1]);
	var allowed = curr_year - initYear;
	setValue(allowed);
	
	if (array1[0].length == 8 && isNumeric(array1[0])) {
		init = array1[0] + "/";
		if (array2[0] == "T") {
			init = init + array2[0] + ".";
			if (array2[1].length == 2 && isNumeric(array2[1])) {
				if (allowed >= 1 && allowed < 4) {
					init = init + array2[1];
				}
			}
		}
	}
	if (init == regno) {
		return true;
	} else {
		return false;
	}
}
function setcookie(cname, cvalue, ctime) {
	var d = new Date();
	d.setTime(d.getTime() + (ctime * 24 * 3600 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}



function getcookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
function preventDefault() {
	$("form").on("submit", function (e) {
		e.preventDefault();
	})
}

function soundAlert(file) {
	var audio = document.createElement("audio");
	audio.setAttribute("src", file);
	audio.play();
}

function number_format(number, decimals) {
	var val = parseFloat(number);
	return val.toFixed(decimals);
}

function OnBodyClickHide(classToHide, classOver) {
	var above_class_over = false;
	var e = true;
	$("." + classOver).mouseover(function () {
		above_class_over = true;
	}).bind("mouseleave", function () {
		above_class_over = false;
	});
	
	$("." + classToHide).click(function () {
		if (!above_class_over) {
			$(this).fadeOut();
			e = false;
		}
	})
	return e;
}

function getWidthOnWindowResize(){
	
	var width = $(window).width();
	$(window).on('resize', function(){
		if ($(this).width() !== width){
			width = $(this).width();
			(width <= 768) ? MOBILE_MEDIA() : (width >= 769 && width <= 991) 
			? TABLET_MEDIA() : DESKTOP_MEDIA();
		}
	});
	(width <= 768) ? MOBILE_MEDIA() : (width >= 769 && width <= 991) 
	? TABLET_MEDIA() : DESKTOP_MEDIA();

	ALL_MEDIA();
}

function click_to_open(tab, url, target, attrType = ''){
	if (attrType != '#' || attrType != 'id'){
		$('.' + tab).click(function(){
			open(url,target)
		})
	}else{
		$('#' + tab).click(function(){
			open(url,target)
		})
	}
}
function visibility(attrName,value){
	//var op = attrName.substring(1,1);
	$(attrName).css('visibility', value);
}


function scrollToBottomAnimate(attrName,duration){
	$(attrName).animate({ scrollTop: $(attrName).prop("scrollHeight")}, duration);
}
function scrollToBottom(attrName){
	$(attrName).scrollTop($(attrName)[0].scrollHeight);
}

//PREVIEW IMAGE TO A TARGETED AREA BEFORE UPLOADED
function previewImage(input, screen) {
	// alert(attr)
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$(screen).attr('src', e.target.result);
		}

    reader.readAsDataURL(input.files[0]); // convert to base64 string
}
}

function previewFileDetails(AttrName, control_row, screen){
    hide(control_row);
    $(AttrName).change(function(e){
        var filename = e.target.files[0].name;
        var filesize = e.target.files[0].size;
        var filetype = e.target.files[0].type;
        var ext = filename.substring(filename.lastIndexOf('.') + 1);
        
        filesize = filesize / (1024 * 1024);
        var size = filesize;
        if(filesize < 1){
            filesize = filesize * 1024;
            filesize = filesize.toFixed(2) + " KB";
        }else{
            filesize = filesize.toFixed(2) + " MB";
        }
        
        if(size <= 2 && (ext == 'jpg' || ext == 'png' || ext == 'JPG' || ext =='PNG')){
            $('#filename').css({
				'color' : 'black'
			}).html(filename);
            $('#filetype').html(filetype);
            $('#filesize').html(filesize);
            previewImage(this, screen);
            slideDown(control_row);
        }else{
            var error = (size > 2) ? "File exceeds the maximum size" : "File type not supported";
            $('.alert-display').css({
				'color' : 'red'
			}).text(error);
			slideUp(control_row);
        }
    })
}

function is_class(attr){
	if(attr == '' || attr == "." || attr == 'class')
		return true;
	else if(attr == "#" || attr == 'id')
		return false;
}

function fadeInActivePage(array, page, attr = ''){
	for(var i = 0; i < array.length; i++){
		if(is_class(attr)){
			if(array[i] == page)
				$("." + page).fadeIn();
			else
				$("." + array[i]).hide();
		}else{
			if(array[i] == page)
				$("#" + page).fadeIn();
			else
				$("#" + array[i]).hide();
		}
	}
}

function menu_button(openBTN, menuBar, closeBTN, direction = 'left'){
	
	$(openBTN).click(function(){
		$(menuBar).css({
			'transform': 'translateX(0)'
		})
		$(closeBTN).removeClass('hide');
		$(closeBTN).addClass('show');
		$(openBTN).removeClass('show');
		$(openBTN).addClass('hide');
	});

	$(closeBTN).click(function(){
		if(direction == 'left'){
			$(menuBar).css({
				'transform': 'translateX(-100%)'
			})
		} else if(direction == 'right'){
			$(menuBar).css({
				'transform': 'translateX(100%)'
			})
		} 
		$(closeBTN).removeClass('show');
		$(closeBTN).addClass('hide');
		$(openBTN).removeClass('hide');
		$(openBTN).addClass('show');
	});
}


function confirm(icon, title, alert, link) {	
	$('.alert-body .icon').addClass('fa-' + icon);
	$('.alert-body .icon-text').html(title);
	$('.alert-body .alert').html(alert);
	$('.alert-body a').attr('href', '/' + link);


	$('.alert-body').css({
		'visibility' : 'visible'
	}).fadeIn();

	$('.notConfirm').click(function() {
		$('.alert-body').css({
			'visibility' : 'hidden'
		}).fadeOut();
	})
}

function visibleFadeIn(el) {
	$(el).css({
		'visibility' : 'visible'
	}).fadeIn();
}

function invisibleFadeOut(el) {
	$(el).css({
		'visibility' : 'hidden'
	}).fadeOut();
}
function visibleSlideDown(el) {
	$(el).css({
		'visibility' : 'visible'
	}).slideDown();
}

function invisibleSlideUp(el) {
	$(el).css({
		'visibility' : 'hidden'
	}).slideUp();
}

function pageLoader (el) {
	document.onreadystatechange = function () {
		var state = document.readyState
		if(state == 'interactive') {
			$(el).css('visibility','visible');
		} else if(state == 'complete') {
			setTimeout(function() {
				$(el).css('visibility', 'hidden');
			}, 1000);
		}
	}
}

function innerSpinnerLoader(el){
	$(el).html("<span class='fa fa-spinner fa-spin'></span>")
}
function spinnerLoaderOut(el, text) {
	$(el).removeClass("fa-spinner");
	$(el).text(text);
}

