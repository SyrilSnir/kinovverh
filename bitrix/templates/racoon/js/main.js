$(function(){
	$('.pop-film')
		.on("mouseenter", function(e){
		 	e.preventDefault();
		 	$(this).find(".pop-film__data").addClass('pop-film__data--hover');
		 })
	 	.on("mouseleave", function(e){
		 	e.preventDefault();
		 	$(this).find(".pop-film__data").removeClass('pop-film__data--hover');
		 });
	 $(".fancy").fancybox();

	  	/*$("#top_slider").swiperight(function() {  
    		$(this).carousel('prev');  
	    });  
		$("#top_slider").swipeleft(function() {  
		    $(this).carousel('next');  
		});  */
	 /*if(screen.availWidth <= 600 && !/m=1/g.test(document.location.search) ){
	 	document.location.href = document.location.href + "?m=1";
	 }else{
	 	if(screen.availWidth > 600 && /m=1/g.test(document.location.search)){
	 		var h = document.location.href.replace(/\?.*$/i,"");
	 		document.location.href = h;
	 	}
	 }*/
	/* $(".datepicker").datepicker({
	 	dayNames: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"] ,
	 	dayNamesMin: ["Пн","Вт","Ср","Чт","Пт","Сб","Вс"],
	 	dateFormat: "dd.mm.yy",
	 	monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрьr","Октябрь","Ноябрь","Декабрь"],
	 	monthNamesShort: ["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],
	 	changeMonth: true,
      	changeYear: true,
      	minDate: "-70y 0",
      	//maxDate: "+1D"
	 });*/

	var rl = 0;
	window.dt = false;
	window.mobile = false;
	function reZoom(rr){
		if(screen.width > 600){
		 	if(dt == false){
		 		if(rr == "000") document.location.reload();
			 	var m = screen.width / (1170 / 100) / 100;
			 	dt = true;mobile = false;
			 	$("meta[name='viewport']").attr("content","width=1170, initial-scale="+m.toFixed(2));
			 	/*<meta name='viewport' content='width=device-width, initial-scale=1'>
		        <meta name='viewport' content='width=1170, user-scalable=yes'>*/
		        $("head").append("<link href=\"/bitrix/templates/racoon/css/dt.css\" rel=\"stylesheet\">");
		 	}
		 	
		 }else{
		 	if(mobile == false){
		 		if(rr == "000") document.location.reload();
		 		dt = false;mobile = true;
		 		$("meta[name='viewport']").attr("content","width=device-width, initial-scale=1");
			 	$("head").append("<link href=\"/bitrix/templates/racoon/css/mobile.css\" rel=\"stylesheet\">");
		 	}
		 }
		 //console.log("rr::" + rr);
		 /*if(rr == "000" && rl != 0) document.location.reload();
		 else if(rr=="000" && rl == 0) rl = 1;*/
	}
	 reZoom(1);
	 window.onresize = function(){reZoom("000");}
	//
	if($(window).width() > 600){
		$('.film-cat__slider').each(function(){
			if($(this).children().length > 6){
				$(this).bxSlider({
				 	minSlides: 3,
					maxSlides: 6,
					slideWidth: 170,
					slideMargin: 30,
					adaptiveHeight: false,
					pager: false,
					moveSlides: 3
				 });
			}
		});
	}else{
		$('.film-cat__slider').bxSlider({
		 	minSlides: 3,
			maxSlides: 6,
			slideWidth: 110,
			slideMargin: 15,
			adaptiveHeight: false,
			pager: false,
			moveSlides: 3
		 });
	}
	
	 // pop film
	 $(".film-cat .pop-film").hover(function(e){
	 	var t = $(this).find(".pop-film__data").html();
	 	var o = $(this).offset();
	 	var oT = o.top;
	 	var oL = o.left + $(this).width();
	 	var popT = $("#f-pop").position().top;
	 	if(oL > window.innerWidth / 2){
	 		oL = oL - 389 - $(this).width();
			$(".pop-film__data-target.right").removeClass('right');
	 		$(".pop-film__data-target").addClass('left');
	 	}else{
	 		$(".pop-film__data-target.left").removeClass('left');
			$(".pop-film__data-target").addClass('right');
	 	}
	 	$(".pop-film__data-target").css({ left:oL, top: oT - popT - 80});
	 	$(".pop-film__data-target").html("<div class='pop-film__data pop-film__data--hover'>" + t + "</div>");
	 	$(".pop-film__data-target").show();
	 });
	 /*$("#f-pop>.container").on("mouseleave", function(e){
		$(".pop-film__data-target").hide();
	 });*/
	 $(".pop-film__data-target, .bx-wrapper").on("mouseleave", function(e){
	 	if(typeof e.toElement != "undefined" && e.toElement.className != "pop-film__data pop-film__data--hover" || e.relatedTarget.className != "pop-film__data pop-film__data--hover")
			$(".pop-film__data-target").hide();
	 });
	 /*$(".cat-subtitle").on("mouseenter", function(){
		$(".pop-film__data-target").hide();
	 });*/
	 $(".pop-film__data pop-film__data--hover").on("mouseleave", function(e){//film-cat
	 	$(".pop-film__data-target").hide();
	 });
	 $(".film-cat").on("mouseleave", function(e){
	 	//console.log(e);
	 	if( typeof e.toElement != "undefined" && e.toElement.className != "pop-film__data pop-film__data--hover" || e.relatedTarget.className != "pop-film__data pop-film__data--hover" ){
	 		//console.log("cn::"+e.toElement.className);
	 		$(".pop-film__data-target").hide();
	 	}
	 });
	
	$(".pop-film").each( function(){
		if($(this).offset().left > window.innerWidth / 2){
			$(this).addClass('pop-film__right');
		}else{
			$(this).addClass('pop-film__left');
		}
	});
	//
	$(".nav-dd .glyphicon ").on("click", function(){
		$(this).siblings('ul.visible-mobile').slideToggle(300);
	})
	// LK
	$(".lk-form .input-group-addon").on("click",".glyphicon-pencil", function(e){
		$(this).removeClass('glyphicon-pencil').addClass('glyphicon-ok').attr('title','Сохранить').after("<i class='glyphicon glyphicon-remove-sign' title='Отменить''></i>");
		$(this).parents(".input-group").find("input").removeAttr('disabled').focus();
	});
	// Сохранить значение
	$("input[name='PERSONAL_BIRTHDAY']").inputmask('dd.mm.yyyy');
	var cInput;
	$(".lk-form .input-group-addon").on("click",".glyphicon-ok", function(e){
		e.preventDefault();
		cInput = this;
		var mInput = $(this).parents(".input-group").find("input");
		var iName = mInput.attr("name");
		var iValue = mInput.val(), err = false;
		
		if(err == false){
			$.post("/lk/", {'name': iName,'value': iValue, 'ajax': 'Y', 'action': 'save'}, function(data){
				alert("Информация сохранена!!!");
				$(cInput).siblings("i").remove();
				$(cInput).parent().siblings("input").attr('disabled', 'disabled');
				$(cInput).removeClass("glyphicon-ok").addClass('glyphicon-pencil').attr('title','Редактировать');
			});
		}else{
			alert("Ошибка: " + errMsg);
		}
	});
	// Отмена
	$(".lk-form .input-group-addon").on("click",".glyphicon-remove-sign", function(e){
		var cIn = $(this).parents(".input-group").children('input');
		cIn.val(cIn.data("default"));
		cIn.attr("disabled",'disabled');
		$(this).siblings('i').remove();
		$(this).removeClass('glyphicon-remove-sign').addClass('glyphicon-pencil').attr("title","Редактировать");
		
		
	});
	// Добавить в популярные
	$("body").on("click","[href='#pop-favorite']", function(e){
		if(typeof $(this).data("id") == 'number'){
			var fId = $(this).data("id");
			$.post("/lk/",{'ajax': 'Y', 'fId': fId, 'action': 'fav'}, function(data){
				console.log(data);
			});
		}
	});
	//Контакты
	$("form.contacts__form").on("submit", function(e){
		var err = false;
		var form = document.forms.contacts__form;
		$(this).find(".error").removeClass("error");
		if(form.name.value.length < 3){
			err = true;
			$(form.name).addClass('error');
		} 
		if(form.msg.value.length < 3){
			err = true;
			$(form.msg).addClass('error');
		}
		if(err == true) return false;
	});
	//menu
	$(".navbar a").not(".dropdown-menu>li>a").each(function(){ 
		var h = $(this).attr("href").replace(/\?.*$/g,"");
		
		if(h != "/" && h != ""){
			var expr = new RegExp(h, 'ig');
			if( h == document.location.pathname){//expr.test(document.location.pathname
				$(this).parent("li").addClass('active');
			}
		}else if(document.location.pathname == "/"){
			$(".navbar a[href='/']").parent("li").addClass('active');
		}
			
	});
	// фильмы меню в центре
	if($(".film-tabs--nav li.active").length > 0){
		var mPl = $(".film-tabs--nav li.active").position().left;
		setTimeout(function(){$(".film-tabs__wrapper").scrollLeft(mPl - 50);}, 300);
	}

	// регистрация
	$("#pop-register form").on("submit", function(e){
		e.preventDefault();
		$(this).find(".error").removeClass('error');
		var form = $(this).serialize();
		var mail = $(this).find("input[name='login']");
		var pass = $(this).find("input[name='pass']");
		var err = false, errMsg = "";
		if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.val())){
			$(mail).addClass('error');
			errMsg += " Введите корректный E-mail адрес";
			err = true;
		} 
		if($(pass).val().length < 6){
			$(pass).addClass('error'); errMsg += " Длинна пароля должна быть больше 6 символов";
		}
		if(err == false){
			$.post("/lk/register.php", form + "&action=register", function(data){
				//$("#pop-register .enter-form__rez").html(data);
				var rez = JSON.parse(data);
				if(rez.TYPE == "OK")
					document.location.href = "/lk/";
				else
					$("#pop-register .enter-form__rez").text(rez.MSG);
			});
		}else{
			$("#pop-register .enter-form__rez").text(errMsg);
		}
		
	});
	//
	$("#pop-pay").on("click",".schet-out", function(){
        var summ = $(this).data("summ");
        var film = $("#pop-pay").data("film");
        var download = $(this).data("download");
        $.post("/lk/schet.php",'summ='+summ+'&film='+film+'&download='+download, function(data){
            var rr = JSON.parse(data);
            if(rr.TYPE == "OK"){
                document.location.href = "?code="+rr.CODE;
                /*$("#pop-pay").modal('hide');
                $("#pop-pay-ok").modal('show');
                $("#pop-pay-ok .pay__new-code").text(rr.CODE);
                $("#pop-pay-ok .pop-pay-ok__view").attr("href","?")*/
            }else{
                console.log(data);
            }
        });
	});
	$(".d-doplata, .f-doplata").on("click", function(e){
		e.preventDefault();
		var doplataUrl = $(this).attr('href');
        var summ = $(this).data("summ");
        var film = $("#pop-pay").data("film");
        $.post("/lk/schet.php",'summ='+summ+'&film='+film+'&doplata=Y', function(data){
            var rr = JSON.parse(data);
            if(rr.TYPE == "OK"){
                document.location.href = doplataUrl;
            }else{
                console.log(data);
            }
        });
    });
setTimeout(function(){setSlider()}, 100);
function setSlider(){
	$("#1top_slider .1carousel-inner").owlCarousel({
		singleItem: true,
		navigation: true,
		autoplayTimeout: 3000,
		responsiveClass: true,
		//Basic Speeds
	    slideSpeed: 800,
	    paginationSpeed : 800,
	    rewindSpeed : 1000,
	 
	    //Autoplay
	    autoPlay : true,
	    stopOnHover : true,
	    navigationText: ["<a class=\"left carousel-control\" href=\"#top_slider\" data-slide=\"prev\"><span class=\"glyphicon  fa fa-arrow-left\" aria-hidden=\"true\"></span><span class=\"sr-only\">Prev</span>",
	    				"<a class=\"right carousel-control\" href=\"#top_slider\" data-slide=\"next\"><span class=\"glyphicon fa fa-arrow-right\" aria-hidden=\"true\"></span><span class=\"sr-only\">Next</span></a>"],
	});
}
});
    	