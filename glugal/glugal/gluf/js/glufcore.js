$(document).ready(function(){

	$('body').on('click','.scroll-link',function(e){
		e.preventDefault();
		var $href=$(this).attr('href');

		goToByScroll($href,global_scroll_offset);
	});

    $('body').on('click','.link-submit',function(event){
        event.preventDefault();
        $(this).parents('form').submit();
    });

    $('body').on('click','a.ajax-link, .ajax-links a',function(e){
        e.preventDefault();
        var $query;
        var $href = $(this).attr('href');

        $('.ajax-container').fadeOut(300,function(){
            $('.ajax-container').load($href,{request:'ajax'},function(){
                $('.ajax-container').fadeIn(300,function(){
                    every_page();
                });
            });
        });
    });

    every_page();

});

$(window).load(function(){

    $('#loader-wrapper').fadeOut();

});

var extlinks=function(){
    jQuery("a[href^='http']:not([href*='" + document.domain + "'])").each(function () {
        jQuery(this).attr("target", "_blank");
    });
}

function every_page()
{
    extlinks();

    $(".cb-inline").colorbox({
        inline:true,
        opacity:".5",
        overlayClose:false
    });
}
