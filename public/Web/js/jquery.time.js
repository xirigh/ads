//Samfea Soft Time

(function($){

$.fn.countdown=function(){

	var data="";

	var _DOM=null;

	var TIMER;

	createdom =function(dom){

		_DOM=dom;

		data=$(dom).attr("data");

		data = data.replace(/-/g,"/");

		data = Math.round((new Date(data)).getTime()/1000);

		$(_DOM).append("<span class='countdownday'></span>天<span class='countdownhour'></span>时<span class='countdownmin'></span>分<span class='countdownsec'></span>秒")

		reflash();

	};

	reflash=function(){

		var	range  	= data-Math.round((new Date()).getTime()/1000),

					secday = 86400, sechour = 3600,

					days 	= parseInt(range/secday),

					hours	= parseInt((range%secday)/sechour),

					min		= parseInt(((range%secday)%sechour)/60),

					sec		= ((range%secday)%sechour)%60;

		if (sec < 0){

			$(_DOM).html("期限已到，请联系对方！")

		}else{

			$(_DOM).find(".countdownday").html(days);

			$(_DOM).find(".countdownhour").html(nol(hours));

			$(_DOM).find(".countdownmin").html(nol(min));

			$(_DOM).find(".countdownsec").html(nol(sec));

		}

	};

	TIMER = setInterval( reflash,1000 );

	nol = function(h){

					return h>9?h:'0'+h;

	}

	return this.each(function(){

		var $box = $(this);

		createdom($box);

	});

}

})(jQuery);

$(function(){

	$(".r-time").each(function(){

		$(this).countdown();

	});

});