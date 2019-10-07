$(document).ready(function(){
	$(".status").each(function(){
		switch ($(this).text()) {
			case "published" :
				$(this).replaceWith("publié");
				break;
			case "draft" :
				$(this).replaceWith("brouillon");
				break;
			case "trashed" :
				$(this).replaceWith("corbeille");
				break;
			case "reported" :
				$(this).replaceWith("signalé");
				break;
			case "moderate" :
				$(this).replaceWith("modéré");
				break;
			default :
				$(this).text();
		};
	});

	ScrollToTop=function() {
	  var s = $(window).scrollTop();
	  if (s > 75) {
	    $('.scrollup').fadeIn();
	  } else {
	    $('.scrollup').fadeOut();
	  }
	  $('.scrollup').click(function () {
	      $("html, body").animate({ scrollTop: 0 }, 1000);
	      return false;
	  });
	}
	StopAnimation=function() {
	  $("html, body").bind("scroll mousedown DOMMouseScroll mousewheel keyup", function(){
	    $('html, body').stop();
	  });
	}
	$(window).scroll(function() {
	  ScrollToTop();
	  StopAnimation();
	});

	tinymce.init({
		selector:'editor',
		height: 300,
		toolbar: 'undo redo | fontselect | bold italic underline | alignleft aligncenter alignright alignjustify  | help',
		font_formats: 'Arial=arial,helvetica,sans-serif; Domine=domine'
	});



});
