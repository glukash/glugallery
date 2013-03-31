//$.cookie.raw = true;
//$.cookie.domain= 'example.com';
$.cookie.json = true;
$.cookie.path = '/';

function set_loader( $message )
{
    if ( $('#loader-wrapper').length )
    {
        $('#loader-wrapper #loader-message').html( $message );
    }
}

(function($) {
    $.fn.glusticky = function(top_offset,limiter_element, limiter_offset, fixed_offset, normal_type){

        //if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
        //    var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
        //    if (ieversion<=7)
        //    return false;
        //}

        if ( typeof fixed_offset == 'undefined' )
        {
            fixed_offset = 0;
        }

        var $sticky = $(this);

        // grab the initial top offset of the navigation
        var sn_offset_top = $sticky.offset().top;
        var sn_offset_left = $sticky.offset().left;
        var sn_height = $sticky.height();

        // our function that decides weather the navigation bar should have "fixed" css position or not.
        var sticky_navigation = function(){

            var scroll_top = $(window).scrollTop(); // our current vertical position from the top
            var sn_end_offset=$(limiter_element).offset().top-fixed_offset-sn_height-limiter_offset;

            // if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
            if (scroll_top > (sn_offset_top-fixed_offset-top_offset) )
            {
                if ( scroll_top>sn_end_offset )
                {
                    //bottom limiter reached
                    $sticky.css({ 'position': 'fixed', 'top':(fixed_offset-(scroll_top-sn_end_offset)-10)+'px', 'left':sn_offset_left+'px'});
                }
                else
                {
                    //fixed scrolling on top or bottom limiters reached
                    $sticky.css({ 'position': 'fixed', 'top':fixed_offset+top_offset+'px', 'left':sn_offset_left+'px'});
                }
            }
            else
            {
                //normal

                if ( typeof normal_type != 'undefined' && normal_type == 'fixed' )
                {
                    $sticky.css({ 'position': 'fixed', 'top':sn_offset_top-scroll_top+'px', 'left':sn_offset_left+'px' });
                }
                else
                {
                    $sticky.css({ 'position': 'static'});
                }
            }
        };

        // run our function on load
        sticky_navigation();

        // and run it again every time you scroll
        $(window).scroll(function() {
            sticky_navigation();
        });

        //reposition fixed elements on window resize
        $(window).resize(function() {
            $sticky.css({ 'position': 'static'});
            sn_offset_top = $sticky.offset().top;
            sn_offset_left = $sticky.offset().left;
            sticky_navigation();
        });

        return true;
    }
})(jQuery);





function glufixedstart(){
    $('.admin-gallery-items.tbody').css({'margin':'0 auto 44px auto'});
}
function glufixedstop(){
    $('.admin-gallery-items.tbody').css({'margin':'61px auto 45px auto'});
}

(function($) {
    $.fn.glufixed = function($zindex,$refresh_type,$delay){

        //if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
        //    var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
        //    if (ieversion<=7)
        //    return false;
        //}

        if ( typeof $refresh_type == 'undefined' || $refresh_type == false )
        {
            $refresh_type = 'static';
        }

        var $fixed = $(this);



        // our function that decides weather the navigation bar should have "fixed" css position or not.
        var fixedize = function(){ /*alert('f');*/

            // grab the initial top offset of the navigation
            $fixed.css({ 'position': $refresh_type});
            glufixedstart();
            var sn_offset_top = $fixed.offset().top;
            var sn_offset_left = $fixed.offset().left;
            var sn_height = $fixed.height();

            $fixed.css({ 'position': 'fixed', 'top':sn_offset_top+'px', 'left':sn_offset_left+'px' });

            if ( typeof $zindex != 'undefined' )
            {
                $fixed.css({ 'z-index': $zindex });
            }
            glufixedstop();

        };

        // run our function on load
        if ( typeof $delay == 'undefined')
        {
            fixedize();
        }
        else
        {
            setTimeout(function (){
                fixedize();
            }, $delay);
        }

        //reposition fixed elements on window resize
        $(window).resize(function() {
            //$fixed.css({ 'position': $refresh_type});
            //sn_offset_top = $fixed.offset().top;
            //sn_offset_left = $fixed.offset().left;
            fixedize();
        });

        return true;
    }
})(jQuery);

function get_json_cookie( $name )
{
    if ( $.cookie( $name ) )
    {
        return $.cookie( $name );
    }
    else
    {
        return new Object();
    }
}

function set_json_cookie( $name, $value, $expires )
{
    if ( typeof $value == 'undefined' )
    {
        $.removeCookie( $name, { path: '/' } ); //with mod rewrite must set path here
        return true;
    }
    else
    {
        if ( typeof $expires == 'undefined' )
        {
            $expires = '';
        }
        $.cookie( $name, $value, { expires: $expires, path: '/' } ); //with mod rewrite must set path here
        return true;
    }
}

var glumsg_object = new Object();

glumsg_object.time = new Object();
glumsg_object.time.counter;
glumsg_object.time.id;

glumsg_object.defaults = new Object();
glumsg_object.defaults.cls='info';
glumsg_object.defaults.tim=false;
glumsg_object.defaults.pos='top';
glumsg_object.defaults.wdt='half';
glumsg_object.defaults.wdo=0;
glumsg_object.defaults.poo=0;

glumsg_object.cookie = 'glumsg';

(function($) {
    /**
     * Summary
     * @param	{String}	$msg	Main content, title of message
     * @param	{String}	$dsc	Additional content, description of message
     * @param	{String}	$class	Class name for background-color
     * @param	{Number}	$time	Time to auto close, 0 - close only after clicking OK button
     * @param	{Dynamic} 	$pos	'top', 'middle', 'bottom' or number value (counting from top of the screen)
     * @param	{Dynamic} 	$width	'full', 'half' or number value
     * @returns	{Boolean}			true
     */
    $.msg = function( $msg,$dsc,$class,$time,$pos,$width ){

        //if msg with timer is shown cant override until closed
        if ( glumsg_object.time.counter>=0 && ( typeof $time === 'undefined' || $time === false ) && $msg !== null )
        {
            return false;
        }

        //close if calling with no params
        if ( typeof $msg == 'undefined' || $msg == null )
        {
            if ( $('#msg-box').is(':animated') )
            {
                $('#msg-box').stop().css({'display':'none','opacity':'1'});
            }
            else
            {
                $('#msg-box').fadeOut(1000);
            }
            glumsg_object.time.counter=-1;
            clearInterval(glumsg_object.time.id);
            return true;
        }

        //classes for bg color
        if ( typeof $class === 'undefined' || $class === false)
        {
            $class = glumsg_object.defaults.cls;
        }
        $('#msg-box').removeClass();
        $('#msg-box').addClass($class);
        if ( typeof $msg != 'undefined' && $msg != '' )
        {
            $('#msg-box #msg-box-msg').html($msg);
            $('#msg-box #msg-box-msg').css({'display':'block'});
        }
        else
        {
            $('#msg-box #msg-box-msg').css({'display':'none'});
        }
        if ( typeof $dsc != 'undefined' && $dsc != '' )
        {
            $('#msg-box #msg-box-dsc').html($dsc);
            $('#msg-box #msg-box-dsc').css({'display':'block'});
        }
        else
        {

            $('#msg-box #msg-box-dsc').css({'display':'none'});

        }

        //time options 0 makes msg waiting for OK click
        glumsg_object.time.counter=-1;
        clearInterval(glumsg_object.time.id);
        if ( typeof $time === 'undefined' || $time === false)
        {
            $time = glumsg_object.defaults.tim;
        }
        if ( typeof $time === 'number' )
        {
            if ( $time == 0 )
            {
                $('#msg-box #msg-box-tmr').css({'display':'block'});
                $('#msg-box #msg-box-tmr').html('OK');
                glumsg_object.time.counter=0;
            }
            else if ( $time > 0 )
            {

                glumsg_object.time.counter=$time;
                $('#msg-box #msg-box-tmr').css({'display':'block'});
                $('#msg-box #msg-box-tmr').html('OK ('+glumsg_object.time.counter+')');
                glumsg_object.time.id = setInterval(function(){
                    $('#msg-box #msg-box-tmr').html('OK ('+(glumsg_object.time.counter-1)+')');
                    glumsg_object.time.counter=glumsg_object.time.counter-1;
                    if (glumsg_object.time.counter<1)
                    {
                        $('#msg-box').stop().fadeOut(300);
                        clearInterval(glumsg_object.time.id);
                        glumsg_object.time.counter=-1;
                    }
                },1000);
            }
            else
            {
                $('#msg-box #msg-box-tmr').css({'display':'none'});
            }
        }
        else
        {
            $('#msg-box #msg-box-tmr').css({'display':'none'});
        }

        //positioning and width
        var win_width = $(window).width();
        var win_height = $(window).height();
        var win_width_half = Math.round(win_width/2);
        var msg_width;
        var msg_left;
        var msg_width_half;
        var win_height_3 = Math.round(win_height/3);
        var msg_height = $('#msg-box').height();
        var msg_height_half = Math.round(msg_height/2);
        var msg_top;

        if ( typeof $width == 'undefined' || $width === false )
        {
            $width = glumsg_object.defaults.wdt;
        }

        if ( $width == 'half' )
        {
            msg_width = win_width_half;
            msg_width_half = Math.round(msg_width/2);
            msg_left = msg_width_half;
        }

        if ( $width == 'full' )
        {
            msg_width = win_width-3;
            msg_left = 1;
        }

        if ( typeof $width == 'number' )
        {
            msg_width = $width;
            msg_width_half = Math.round(msg_width/2);
            msg_left = win_width_half-msg_width_half;
        }

        msg_width = msg_width + glumsg_object.defaults.wdo; //const width offset
        msg_width = msg_width+'px';
        msg_left = msg_left+'px';

        $('#msg-box').css({
            'width':msg_width,
            'left':msg_left
        });

        if ( typeof $pos == 'undefined' || $pos === false )
        {
            $pos = glumsg_object.defaults.pos;
        }

        if ( $pos == 'bottom' )
        {
            $('#msg-box').css({
                'bottom': (0+glumsg_object.defaults.poo)+'px',
                'top':''
            });
        }

        if ( $pos == 'top' )
        {
            $('#msg-box').css({
                'bottom': '',
                'top':(0+glumsg_object.defaults.poo)+'px'
            });
        }

        if ( $pos == 'middle' )
        {
            msg_top = (win_height_3-msg_height_half);

            $('#msg-box').css({
                'bottom': '',
                'top':(msg_top+glumsg_object.defaults.poo)+'px'
            });
        }

        if ( typeof $pos == 'number' )
        {
            msg_top = $pos;

            $('#msg-box').css({
                'bottom': '',
                'top':(msg_top+glumsg_object.defaults.poo)+'px'
            });
        }

        //show msg
        if ( $('#msg-box').is(':animated') )
        {
            $('#msg-box').stop().css({'display':'block','opacity':'1'});
        }
        else
        {
            $('#msg-box').fadeIn();
        }

        return true;
    }

    $.fn.glumsg = function( msg_obj ){

        //create msg div
        var $body = $(this);
        $body.append('<div id="msg-box" class="info"><div id="msg-box-msg"></div><div id="msg-box-dsc"></div><div id="msg-box-tmr"></div></div>');

        //pre styling with no positioning and width
        $('#msg-box').css({
            'position': 'fixed',
            'z-index': 99999,
            'display': 'none',
            'margin': '0 auto',
            'padding': '5px 0',
            'font-size': '12px',
            'line-height': '12px',
            'text-align': 'center',
            'border': '1px solid #A8A8A8'
        });

        $('#msg-box-msg').css({
            'display': 'none',
            'font-weight':'bold',
            //'margin': '5px auto',
            'padding': '5px',
            'text-align': 'center'
        });

        $('#msg-box-dsc').css({
            'display': 'none',
            'font-weight':'normal',
            //'margin': '5px auto',
            'padding': '5px',
            'text-align': 'center'
        });

        $('#msg-box-tmr').css({
            'display': 'none',
            'width': '70px',
            'height': '12px',
            'font-weight':'bold',
            'margin': '5px auto',
            'padding':'5px',
            'text-align': 'center',
            'border':'1px solid #BAB08F'
        });

        //passing new defaults to global default object
        $.extend(glumsg_object.defaults,msg_obj.defaults);
        //$.extend(glumsg_object.cookie,msg_obj.cookie);

        //binding hover event
        if ( typeof msg_obj.hover !== 'undefined' )
        {
            $.each(msg_obj.hover,function(index,element){
                $('body').on('mouseenter',index,function(){
                    $.msg( element.msg,element.dsc,element.cls,element.tim,element.pos,element.wdt );
                }).on('mouseleave',index,function(){
                    $.msg();
                });
            });
        }

        //binding focus event
        if ( typeof msg_obj.focus !== 'undefined' )
        {
            $.each(msg_obj.focus,function(index,element){
                $('body').on('focus',index,function(){
                    $.msg( element.msg,element.dsc,element.cls,element.tim,element.pos,element.wdt );
                }).on('blur',index,function(){
                    $.msg();
                });
            });
        }

        //binding click event
        if ( typeof msg_obj.click !== 'undefined' )
        {
            $.each(msg_obj.click,function(index,element){
                $('body').on('click',index,function(){
                    //if ( typeof element.tim == 'undefined' ) element.tim = false;
                    $.msg( element.msg,element.dsc,element.cls,element.tim,element.pos,element.wdt );
                });
            });
        }

        //binding msg close event
        $('body').on('click','#msg-box-tmr',function(){
			glumsg_object.time.counter=-1;
            $.msg();
		});

        //cursor styling
		$('body').on('mouseover','#msg-box-tmr',function(){
			$(this).css('cursor', 'pointer');
		});

        //check if there is a cookie message
        var cookie_msg = get_json_cookie( glumsg_object.cookie );
        if ( typeof cookie_msg.msg != 'undefined' )
        {
            $.msg( cookie_msg.msg,cookie_msg.dsc,cookie_msg.cls,cookie_msg.tim,cookie_msg.pos,cookie_msg.wdt );
            set_json_cookie( glumsg_object.cookie );
        }
    }
})(jQuery);

function goToByScroll(sid,soffset,stime){
	soffset = (typeof soffset === "undefined") ? 0 : soffset;
	stime = (typeof stime === "undefined") ? 'slow' : stime;
	if (sid.substring(0,1)=="#") //if comes with leading #
	{
		sid=sid.slice(1);
        if ( $('#'+sid).length > 0 )
        {
            sid = '#'+sid;
        }
        else if ( $('.'+sid).length > 0 )
        {
            sid = '.'+sid;
        }
        else if ( $('a[name="'+sid+'"]').length > 0 )
        {
            sid = 'a[name="'+sid+'"]';
        }
	}

    if ( $(sid).length > 0 )
    {
        var sid_offset_top = $(sid).offset().top;
        var total_offset=sid_offset_top+soffset;

        $('html,body').stop().animate({scrollTop: total_offset},stime);
    }
}
