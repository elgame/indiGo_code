$(function(){
	panel.init();
});


var panel = (function($){
	var objr = {};

	function activeMenu(){
		//highlight current / active link
		$('ul.main-menu li a').each(function(){
			//var url = String(window.location).split("?");
			var url = String(window.location).replace(base_url, ''), url1 = url.split('/'), url2 = url.split("?"),
			link = $($(this))[0].href.replace(base_url, ''), link1 = link.split('/');
			if(link==url || (link1[0]==url1[0] && link1[1]==url1[1]) || link==url2[0])
				$(this).parents('li').addClass('active');
		});
		$('ul.main-menu > li.active > a').click();
	};

	function animeMenu(){
		//animating menus on hover
		$('ul.main-menu li:not(.nav-header,.submenu)').hover(function(){
			$(this).animate({'margin-left':'+=5'},300);
		},
		function(){
			$(this).animate({'margin-left':'-=5'},300);
		});
	};

	function boxBtns(){
		$('.btn-close').click(function(e){
			e.preventDefault();
			$(this).parent().parent().parent().fadeOut();
		});
		$('.btn-minimize').click(function(e){
			e.preventDefault();
			var $target = $(this).parent().parent().next('.box-content');
			if($target.is(':visible')) $('i',$(this)).removeClass('icon-chevron-up').addClass('icon-chevron-down');
			else 					   $('i',$(this)).removeClass('icon-chevron-down').addClass('icon-chevron-up');
			$target.slideToggle();
		});
	};

	objr.menu = function(id){
		var obj = $("#subm"+id);
		if (obj.is(".hide"))
			obj.attr('class', 'show');
		else
			obj.attr('class', 'hide');
	};

	objr.init = function(){
		activeMenu();
		animeMenu();
		boxBtns();
	};

	return objr;
})(jQuery);




/**
 * Obj para crear un loader cuando se use Ajax
 */
var loader = {
	create: function(){
		$("body").append('<div id="ajax-loader" class="corner-bottom8">Cargando...</div>');
	},
	close: function(){
		$("#ajax-loader").remove();
	}
};
