<div id="admin-gallery-browse" class="galleries">
    <form id="admin-gallery-form" method="post" action="">
        <div id="fixed-wrapper">
        <div id="admin-gallery-menu">
            <div class="float-right">
                <?php include element('logged'); ?>
                <a href="#info-wrapper" class="clear cb-inline float-right display-block font-bold font16" style="margin:5px; font-family: monospace;">i</a>
            </div>
            <div class="float-left">
                <h2>MENU</h2>
                <a href="index" class="button">home</a>
            </div>
            <div class="float-left" style="visibility: hidden;">
                <div class="caption caption-view">View: manage</div>
                <a href="#" class="view-sort button">sort view</a>
                <!--<a href="#" class="view-manage">manage view</a>-->
            </div>
            <div class="float-left inactive-pannel" style="">
                <div class="caption caption-inactive">Inactive: shown</div>
                <a href="#" class="hide-inactive button">hide inactive</a>
                <a href="#" class="show-inactive button">show inactive</a>
            </div>
            <div class="float-left <?php echo !gHasRole('admin')?'display-none':''; ?>">
                <label for="gal-create" class="display-block w300">Enter new gallery directory name</label>
                <input id="gal-create" class="display-block w300" type="text" name="data[glugal][create]" value="" />
            </div>
            <div class="float-left" style="padding-top:18px;">
                <a href="#" class="link-submit save-button button">save</a>
            </div>
            <div class="space5 clear"></div>
        </div>
        </div>
        <div class="clear pre-space top"></div>
        <div id="admin-galleries-list" style="visibility: hidden;">
            <?php $c=0; ?>
            <?php foreach ( $admin_galleries as $gkey=>$gallery ): ?>
                <?php $c++; ?>
                <div class="gallery <?php echo $gallery['dir']; ?> <?php /*echo !gAllowed( '/gallery/'.$gkey )?'display-none':'';*/ ?>">
                    <div class="gal-dir"><?php echo $gallery['dir']; ?>&nbsp;<a href="#<?php echo $gallery['dir']; ?>" class="gal-del">x</a></div>
                    <div class="gal-title">
                        <?php if ( isne( $gallery['info']['title'] ) ): ?>
                            <a href="gallery/<?php echo $gallery['dir']; ?>"><?php echo $gallery['info']['title']; ?></a>
                        <?php else: ?>
                            <a href="gallery/<?php echo $gallery['dir']; ?>">edit</a>
                        <?php endif; ?>
                    </div>
                    <div class="gal-date">
                        <?php echo isne($gallery['info']['date'])?$gallery['info']['date']:''; ?>
                    </div>
                    <ul class="gal-count">
                        <li class="count-all">[<span><?php echo $gallery['gallery']['count']['all']; ?></span></li>
                        <!--<li class="count-ind"><?php echo $gallery['gallery']['count']['indexed']; ?></li>-->
                        <li class="count-uni"><span><?php echo $gallery['gallery']['count']['unindexed']; ?></span>]</li>
                        <li class="count-act">[<span><?php echo $gallery['gallery']['count']['active']; ?></span></li>
                        <li class="count-ina"><span><?php echo $gallery['gallery']['count']['inactive']; ?></span>]</li>
                        <li class="count-missrc cnt<?php echo $gallery['gallery']['count']['missrc']; ?>">[<span><?php echo $gallery['gallery']['count']['missrc']; ?></span></li>
                        <li class="count-misout cnt<?php echo $gallery['gallery']['count']['misout']; ?>"><span><?php echo $gallery['gallery']['count']['misout']; ?></span></li>
                        <li class="count-mismin cnt<?php echo $gallery['gallery']['count']['mismin']; ?>"><span><?php echo $gallery['gallery']['count']['mismin']; ?></span>]</li>
                    </ul>
                    <div class="gal-thumb-wrapper">
                        <?php if ( isne( $gallery['info']['thumburl'] ) ): ?>
                            <img class="gal-thumb" src="<?php echo $gallery['info']['thumburl']; ?>" alt="<?php echo $gallery['info']['title']; ?>" />
                        <?php else: ?>
                            <div class="gal-thumb blank">X</div>
                        <?php endif; ?>
                    </div>
                    <input type="hidden"   name="data[glugal][galleries][<?php echo $gallery['dir']; ?>][dir]" value="<?php echo $gallery['dir']; ?>" />
                    <input class="gal-shw" type="checkbox" name="data[glugal][galleries][<?php echo $gallery['dir']; ?>][shw]" value="1" <?php echo $gallery['shw']?'checked="checked"':''; ?> />
                </div>
            <?php endforeach; ?>
            <div class="clear"></div>
        </div>
    </form>
    <div style="display:none;">
        <div id="info-wrapper" style="width:800px; padding:20px; background-color: #fff;">
            <h1>INFORMATIONS</h1>
            <ul class="pad-hor-20 align-justify" style="list-style-type: disc; list-style-position: inside;">
                <li class="pad-hor-05">
                    Galleries base path: <span class="color-dist font-bold"><?php echo $galRoot; ?></span>
                </li>
                <li class="pad-hor-05">
                    Galleries base url: <span class="color-dist font-bold"><?php echo $galRootUrl; ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[

    var $gStatus = new Object();
    $gStatus.inactive_hidden=false;
    $gStatus.view_width = 738;
    $.extend( $gStatus, get_json_cookie( 'glugal-cookie' ) );

$(document).ready(function(){

    set_loader('LOADING GALLERIES');

    $('.show-inactive').hide();

    $('#admin-gallery-form').on('submit',function(){
        $('#gal-create').val( $('#gal-create').val().trim() )
        if ( $('#gal-create').val() != '' )
        {
            var gcv = $('#gal-create').val();
            if ( gcv == 'gallery' )
            {
                $.msg('Wrong gallery name!','The word gallery is forbiden!','error',10);
                return false;
            }
            if (gcv.match(/^[0-9a-zA-Z]+$/))
            {
                return true;
            }
            else
            {
                $.msg('Wrong gallery name!','Use letters and numbers only!','error',10);
                return false;
            }
        }
        else
        {
            return true;
        }
    });

    $('.gal-del').on('click',function(event){
        event.preventDefault();
        var $gal_name = $(this).attr('href').substring(1);
        if ( confirm('Do you want to delete gallery?') )
        {
            if ( confirm('Do you realy want to delete gallery?') )
            {
                if ( confirm('All files including surce files will be removed!') )
                {
                    delete_gallery($gal_name);
                }
            }
        }
    });

    $('form input, form textarea, form select').not('#auto-confirm').on('change',function(){
        gal_edited();
    });

    $('.hide-inactive').on('click',function(event){
        event.preventDefault();
        gals_inactive_hide(true);
    });

    $('.show-inactive').on('click',function(event){
        event.preventDefault();
        gals_inactive_show();
    });

    $('#admin-galleries-list .gallery input[type="checkbox"]').on('change',function(){
        gals_inactive_hide();
    });

});

function fixetize()
{
    $('.pre-space.top').fadeOut(function(){
        $('#fixed-wrapper').glufixed(1000);
        $('.pre-space.top').fadeIn();
    });
    //$('.admin-gallery-items.thead').glufixed(1000);
    //$('#admin-gallery-menu').glufixed(1000);
}

$(window).load(function(){

    $('#admin-galleries-list').resizable({
        create: function( event, ui ) {
            $('#admin-galleries-list').width( $gStatus.view_width );
        },
        resize: function( event, ui ) {
            $gStatus.view_width = $('#admin-galleries-list').width();
        },
        stop: function( event, ui ) {
            reset_gal_cookie();
        }
    });
    $("#admin-galleries-list").sortable({
        items:'.gallery',
        handle: '.gal-thumb-wrapper',
        cursor:'move',

        update: function( event, ui ) {
            gal_edited();
        }
    });
    $("#admin-galleries-list .gal-thumb-wrapper").css({'cursor':'move'});

    $('#admin-galleries-list .gallery .gal-thumb').each(function(){
        var $h = $(this).height();
        var $ch = $('.gal-thumb-wrapper').height();
        var $p = $ch - $h;
        var $p2 = Math.floor($p/2);
        $(this).css({'padding-top':$p2+'px'});
    });

    gals_inactive_hide();

    $('#admin-galleries-list').fadeOut(function(){
        $('#admin-galleries-list').css({'visibility':'visible'});
        $('#admin-galleries-list').fadeIn();
    });

    fixetize();
});
//]]>
</script>
