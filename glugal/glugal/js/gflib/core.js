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
		var $self = $(this);
        var $href = $self.attr('href');
		var $loader;

		if ( $self.hasClass('hideable-hide') || $self.parents('.ajax-links').hasClass('hideable-hide') )
		{
			$('.hideable:visible').fadeOut();
		}
		else
		{
			$('.hideable:hidden').fadeIn();
		}

		if ( $self.hasClass('link-loader') || $self.parents('.ajax-links').hasClass('link-loader') )
		{
			$loader = 'link';
		}

		if ( $self.hasClass('main-loader') || $self.parents('.ajax-links').hasClass('main-loader') )
		{
			$loader = 'main';
		}

		if ( $loader == 'link' )
		{
			if ( $('.link-loader-img').length == 0 )
			{
				$self.append('<img class="link-loader-img" alt="*" style="padding: 0 0 0 10px;" src="'+gAppUrl+'img/loaders/loader-link.gif" />');
			}
		}

		if ( $loader == 'main' )
		{
			$('#main-loader').fadeIn();
		}

		$('.ajax-container').fadeOut(300,function(){
            $('.ajax-container').load($href,{request:'ajax'},function(){
                $('.ajax-container').fadeIn(300,function(){
                    every_page(true);
                });
            });
        });

    });

    every_page(false);

});

$(window).load(function(){

    $('#main-loader:visible').fadeOut();

});

var extlinks=function(){
    jQuery("a[href^='http']:not([href*='" + document.domain + "'])").each(function () {
        jQuery(this).attr("target", "_blank");
    });
}

function every_page($ajax_link)
{
    extlinks();

    $(".cb-inline").colorbox({
        inline:true,
        opacity:".5",
        overlayClose:false
    });

	if ( $ajax_link )
	{
		$('#main-loader:visible').fadeOut();
	}

	if ( $('.link-loader-img').length > 0 )
	{
		$('.link-loader-img').remove();
	}

}
