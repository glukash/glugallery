<div id="admin-gallery-browse" class="gallery">
    <form id="admin-gallery-form" method="post" action="">
        <div id="fixed-wrapper">
        <div id="admin-gallery-menu">
            <div class="float-right">
                <?php include element('logged'); ?>
                <a href="#info-wrapper" class="clear cb-inline float-right display-block font-bold font16" style="margin:5px; font-family: monospace;">i</a>
            </div>
            <div class="float-left">
                <h2>MENU</h2>
                <a href="galleries" class="button">galleries</a>
            </div>
            <div class="float-left" style="">
                <div class="caption caption-view">View: manage</div>
                <a href="#" class="view-sort button">sort view</a>
                <a href="#" class="view-manage button">manage view</a>
            </div>
            <div class="float-left inactive-pannel" style="">
                <div class="caption caption-inactive">Inactive: shown</div>
                <a href="#" class="hide-inactive button">hide inactive</a>
                <a href="#" class="show-inactive button">show inactive</a>
            </div>
            <div class="float-left" style="padding-top:0px;">

                <select id="upload-preresize" class="font11 display-block" style="margin: 0 0 1px 2px;" name="data[glugal][info][out][method]">
                    <option value="none" <?php /*echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='normal')?'selected="selected"':'';*/ ?>>-</option>
                    <option value="fullhd" <?php /*echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='background')?'selected="selected"':'';*/ ?>>Full HD</option>
                </select>

                <a id="gal-upload-fhd" class="cb-upload cboxElement button" href="<?php echo $gRootUrl.'glugal/vendor/up/index.php?glugal=preresize&amp;td='.$galName; ?>">upload</a>
                <a id="gal-upload" class="cb-upload cboxElement button" href="<?php echo $gRootUrl.'glugal/vendor/up/index.php?td='.$galName; ?>">upload</a>
            </div>
            <div class="float-left">
                <label id="gal-title-label" for="gal-title" class="display-block">Title</label>
                <input id="gal-title" class="display-block" type="text" name="data[glugal][info][title]" value="<?php echo isset($admin_gallery['info']['title'])?$admin_gallery['info']['title']:''; ?>" />
            </div>
            <div class="float-left">
                <label for="gal-date" class="display-block">Date</label>
                <input id="gal-date" class="display-block" type="text" name="data[glugal][info][date]" value="<?php echo isset($admin_gallery['info']['date'])?$admin_gallery['info']['date']:''; ?>" />
            </div>
            <div class="float-left">
                <label id="gal-desc-label" for="gal-desc" class="display-block">Description</label>
                <input id="gal-desc" class="display-block" type="text" name="data[glugal][info][description]" value="<?php echo isset($admin_gallery['info']['description'])?$admin_gallery['info']['description']:''; ?>" />
            </div>
            <div class="float-left" style="padding-top:18px;">
                <a href="#" class="link-submit save-button button">save</a>
            </div>
            <div class="space5 clear"></div>
        </div>

        <table class="admin-gallery-items thead" style="visibility: hidden;">
        <thead>
        <tr class="thead-row-1">
            <th class="id-wrapper">&nbsp;</th>
            <th class="header-status-file filename-wrapper"></th>
            <th class="title-descr-wrapper">&nbsp;</th>
            <th class="active-wrapper">
                <a href="#" class="activate-all">aa</a>
                <a href="#" class="activate-non">da</a>
                <a href="#" class="activate-tog">at</a>
            </th>
            <th class="src-wrapper">
                <select class="load-src font11" name="data[glugal][info][src][load]">
                    <option value="load" <?php echo (isset($admin_gallery['info']['src']['load']) && $admin_gallery['info']['src']['load']=='load')?'selected="selected"':''; ?>>load</option>
                    <option value="dontload" <?php echo (isset($admin_gallery['info']['src']['load']) && $admin_gallery['info']['src']['load']=='dontload')?'selected="selected"':''; ?>>don't load</option>
                </select>
            </th>
            <th class="src">
                <a href="#" id="status-enlarge-smaller" class="link-status gal-edited">ENLARGE</a>
                <input id="enlarge-smaller" type="hidden" name="data[glugal][info][enlarge]" value="<?php echo (isset($admin_gallery['info']['enlarge'])&&$admin_gallery['info']['enlarge']==1)?'1':'0'; ?>" />
            </th>
            <th class="out-wrapper">
                <select class="size-out-method font11" name="data[glugal][info][out][method]">
                    <option value="normal" <?php echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='normal')?'selected="selected"':''; ?>>normal</option>
                    <option value="background" <?php echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='background')?'selected="selected"':''; ?>>background</option>
                    <option value="shrink" <?php echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='shrink')?'selected="selected"':''; ?>>shrink</option>
                    <!--<option value="crop" <?php echo (isset($admin_gallery['info']['out']['method']) && $admin_gallery['info']['out']['method']=='crop')?'selected="selected"':''; ?>>crop</option>-->
                </select>
            </th>
            <th class="out">
                <input type="text" class="size-out-width font11 small-form"  size="4" name="data[glugal][info][out][width]" value="<?php echo isset($admin_gallery['info']['out']['width'])?$admin_gallery['info']['out']['width']:'1080'; ?>" />
                <input type="text" class="size-out-height font11 small-form" size="4" name="data[glugal][info][out][height]" value="<?php echo isset($admin_gallery['info']['out']['height'])?$admin_gallery['info']['out']['height']:'720'; ?>" />
            </th>
            <th class="min-wrapper">
                <select class="size-min-method font11" name="data[glugal][info][min][method]">
                    <option value="normal" <?php echo (isset($admin_gallery['info']['min']['method']) && $admin_gallery['info']['min']['method']=='normal')?'selected="selected"':''; ?>>normal</option>
                    <option value="background" <?php echo (isset($admin_gallery['info']['min']['method']) && $admin_gallery['info']['min']['method']=='background')?'selected="selected"':''; ?>>background</option>
                    <option value="shrink" <?php echo (isset($admin_gallery['info']['min']['method']) && $admin_gallery['info']['min']['method']=='shrink')?'selected="selected"':''; ?>>shrink</option>
                    <!--<option value="crop" <?php echo (isset($admin_gallery['info']['min']['method']) && $admin_gallery['info']['min']['method']=='crop')?'selected="selected"':''; ?>>crop</option>-->
                </select>
            </th>
            <th class="min">
                <input type="text" class="size-min-width font11 small-form"  size="4" name="data[glugal][info][min][width]" value="<?php echo isset($admin_gallery['info']['min']['width'])?$admin_gallery['info']['min']['width']:'150'; ?>" />
                <input type="text" class="size-min-height font11 small-form" size="4" name="data[glugal][info][min][height]" value="<?php echo isset($admin_gallery['info']['min']['height'])?$admin_gallery['info']['min']['height']:'100'; ?>" />
            </th>
            <th class="opt-wrapper">
                <a href="#" id="status-auto-confirm" class="link-status">AC</a>
            </th>
        </tr>
        <tr class="thead-row-2">
            <th class="id-wrapper">No.</th>
            <th class="filename-wrapper">File</th>
            <th class="title-descr-wrapper">Title &amp; Descr </th>
            <th class="active-wrapper">Act&nbsp;Thm</th>
            <th class="src-wrapper">Src</th>
            <th class="src"><a href="#" class="delete-img-src-all">del</a></th>
            <th class="out-wrapper">Out</th>
            <th class="out"><a href="#" class="create-img-out-unc">unc</a>&nbsp;<a href="#" class="create-img-out-all">all</a>&nbsp;<a href="#" class="delete-img-out-all">del</a></th>
            <th class="min-wrapper">Min</th>
            <th class="min"><a href="#" class="create-img-min-unc">unc</a>&nbsp;<a href="#" class="create-img-min-all">all</a>&nbsp;<a href="#" class="delete-img-min-all">del</a></th>
            <th class="opt-wrapper">opt</th>
        </tr>
        </thead><tbody><tr><td colspan="11"></td></tr></tbody>
        </table>
        </div>
        <div class="clear pre-space top"></div>
        <table class="admin-gallery-items tbody" style="visibility: hidden;">
        <tbody><?php $ti=0; ?>
        <?php if (!empty($admin_gallery['items'])): foreach ( $admin_gallery['items'] as $k => $img ): ?>
        <tr class="tbody-row-<?php echo $k+1; ?>">
            <td class="img-<?php echo $k+1; ?> id-wrapper indexed-<?php echo $img['indexed']; ?>">
                <?php echo sprintf("%03d",$k+1); ?>
            </td>
            <td class="img-<?php echo $k+1; ?> filename-wrapper font10">
                <span class="img-filename-label"><?php echo $img['file']; ?></span>
                <input class="img-filename" type="hidden" name="data[glugal][items][<?php echo $k; ?>][file]" value="<?php echo $img['file']; ?>" />
            </td>
            <td class="img-<?php echo $k+1; ?> title-descr-wrapper">
                <input tabindex="<?php echo ++$ti; ?>" class="gal-item-title" type="text" name="data[glugal][items][<?php echo $k; ?>][title]" value="<?php echo hs($img['title']); ?>" />
                <textarea tabindex="<?php echo ++$ti; ?>" class="gal-item-desc" cols="41" rows="3" name="data[glugal][items][<?php echo $k; ?>][description]"><?php echo $img['description']; ?></textarea>
            </td>
            <td class="img-<?php echo $k+1; ?> active-wrapper">
                <input class="active-checkbox-<?php echo $k+1; ?>" type="checkbox" name="data[glugal][items][<?php echo $k; ?>][active]" <?php echo $img['active']?'checked="checked"':''; ?> />
                <input class="thumb-picker" type="radio" name="data[glugal][info][thumb]" value="<?php echo $img['file']; ?>" <?php echo $img['file']==$admin_gallery['info']['thumb']?'checked="checked"':''; ?> />
            </td>
            <td class="img-<?php echo $k+1; ?> src-wrapper">
                <?php if ( $img['src']['exists'] ): ?>
                <a href="<?php echo $img['src']['url']; ?>" class="cb-src">
                <?php if (!isset($admin_gallery['info']['src']['load']) || $admin_gallery['info']['src']['load']=='load'): ?>
                <img class="src-img miniature" src="<?php echo $img['src']['url']; ?>?<?php echo time(); ?>" alt="src" />
                <?php endif; ?>
                </a>
                <?php endif; ?>
            </td>
            <td class="img-<?php echo $k+1; ?> src">
                <?php
                echo $img['src']['exists']?
                '<div class="mark-green bold font25">&bull;</div><div class="font10">'.$img['src']['info']['wxh'].'<br />'.$img['src']['info']['size']['human'].'</div>':
                '<div class="mark-red bold font25">&bull;</div>';
                ?>
            </td>
            <td class="img-<?php echo $k+1; ?> out-wrapper">
                <?php if ( $img['out']['exists'] ): ?>
                <a href="<?php echo $img['out']['url']; ?>" class="cb-out">
                <img class="out-img miniature" src="<?php echo $img['out']['url']; ?>?<?php echo time(); ?>" alt="out" />
                </a>
                <?php endif; ?>
            </td>
            <td class="img-<?php echo $k+1; ?> out">
                <?php
                echo $img['out']['exists']?
                '<div class="bold font25"><a href="#out/'.$img['file'].'" class="mark-green create-img create-img-out" title="create out">&bull;</a></div><div class="font10">'.$img['out']['info']['wxh'].'<br />'.$img['out']['info']['size']['human'].'</div>':
                '<div class="bold font25"><a href="#out/'.$img['file'].'" class="mark-red create-img create-img-out" title="create out">&bull;</a></div>';
                ?>
            </td>
            <td class="img-<?php echo $k+1; ?> min-wrapper">
                <?php if ( $img['min']['exists'] ): ?>
                <a href="<?php echo $img['min']['url']; ?>" class="cb-min">
                <img class="min-img miniature" src="<?php echo $img['min']['url']; ?>?<?php echo time(); ?>" alt="min" />
                </a>
                <?php endif; ?>
            </td>
            <td class="img-<?php echo $k+1; ?> min">
                <?php
                echo $img['min']['exists']?
                '<div class="bold font25"><!--a href="#" class="delete-file font10 color-red link-popup display-block" title="delete file">&#10006;</a--><a href="#min/'.$img['file'].'" class="mark-green create-img create-img-min" title="create min">&bull;</a></div><div class="font10">'.$img['min']['info']['wxh'].'<br />'.$img['min']['info']['size']['human'].'</div>':
                '<div class="bold font25"><a href="#min/'.$img['file'].'" class="mark-red create-img create-img-min" title="create min">&bull;</a></div>';
                ?>
            </td>
            <td class="img-<?php echo $k+1; ?> opt-wrapper">
                <a href="#" class="delete-entry font11 color-orange" title="delete entry">&#10006;</a><br /><br />
                <a href="#" class="delete-file-out font11 color-orange" title="delete out file">&#10006;</a><br />
                <a href="#" class="delete-file-min font11 color-orange" title="delete min file">&#10006;</a><br /><br />
                <!--<a href="#" class="delete-file-out-min font11 color-orange" title="delete out and min file">&#10006;</a><br /><br />-->
                <!--<a href="#" class="delete-file font11 color-red link-popup" title="delete file">&#10006;</a><br />-->
                <a href="#" class="delete-all font11 color-red link-popup" title="delete file and entry">&#10006;</a><br />
            </td>
        </tr>
        <?php endforeach; endif; ?>
        </tbody>
        </table>
        <div class="clear pre-space"></div>
    </form>
    <div style="display:none;">
        <div id="info-wrapper" style="width:800px; padding:20px; background-color: #fff;">
            <h1>INFORMATIONS</h1>
            <ul class="pad-hor-20 align-justify" style="list-style-type: disc; list-style-position: inside;">
                <li class="pad-hor-05">
                    Current gallery directory: <span class="color-dist font-bold"><?php echo $galName; ?></span>
                </li>
                <li class="pad-hor-05">
                    Current gallery path: <span class="color-dist font-bold"><?php echo $galRoot; ?><?php echo $galName; ?></span>
                </li>
                <li class="pad-hor-05">
                    Current gallery url: <span class="color-dist font-bold"><?php echo $galRootUrl; ?><?php echo $galName; ?></span>
                </li>
            </ul>
        </div>
        <div id="gal-desc-popup" style="width:620px; padding:20px; background-color: #fff;">
            <h1>Edit gallery description</h1>
            <div class="pad-hor-20 align-justify" style="">
                <textarea id="gal-desc-area" cols="74" rows="28" style="width:600px; height: 300px;"></textarea>
            </div>
        </div>
        <div id="gal-title-popup" style="width:620px; padding:20px; background-color: #fff;">
            <h1>Edit gallery title</h1>
            <div class="pad-hor-20 align-justify" style="">
                <textarea id="gal-title-area" cols="74" rows="3" style="width:600px; height: 50px;"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
//<![CDATA[
    var ajax_async = true;
    var $global_result=false;
    var g_name = '<?php echo $galName; ?>';
    var $gStatus = new Object();
    $gStatus.inactive_hidden=false;
    $gStatus.auto_confirm=false;
    $gStatus.view_mode = 'manage';
    $gStatus.view_sort_width = 450;
    $.extend( $gStatus, get_json_cookie( 'glugal-cookie-'+g_name ) );

    if ( typeof $gStatus.view_sort_width == 'undefined' )
    {
        $gStatus.view_sort_width = 450;
    }

    var $gCurrentStatus = new Object();
    $gCurrentStatus.view_mode='';

    var $th_width_array = new Array();


    set_loader('LOADING IMAGES');

    var $gCounters={};
    function gCounters( amount )
    {
        $gCounters.elements = amount;
        $gCounters.processed = 0;
    }

    var global_scroll_offset = -117;

$(document).ready(function(){

    //make gallery items sortable
    $(".admin-gallery-items tbody").sortable({
        items:'tr',
        handle: 'td:first-child,td.src-wrapper,td.out-wrapper,td.min-wrapper',
        cursor:'move',

        update: function( event, ui ) {
            gal_edited();
        }
    });

    //set sortable cursor
    $('.admin-gallery-items.tbody .id-wrapper, .admin-gallery-items.tbody td.src-wrapper a,.admin-gallery-items.tbody td.out-wrapper a, .admin-gallery-items.tbody td.min-wrapper a').css({'cursor':'move'});

    //delegate create single img
    $('.admin-gallery-items').on('click','.create-img',function(event){
        event.preventDefault();
        gCounters(1);
        create_img( $(this) );
    });

    //create unc min
    $('.create-img-min-unc').on('click',function(event){
        event.preventDefault();
        gCounters( $('.create-img-min.mark-red:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            $('.create-img-min.mark-red:visible').each(function(index){
                create_img( $(this) );
            });
        }
    });

    //create all min
    $('.create-img-min-all').on('click',function(event){
        event.preventDefault();
        gCounters( $('.create-img-min:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            $('.create-img-min:visible').each(function(index){
                create_img( $(this) );
            });
        }
    });

    //create unc out
    $('.create-img-out-unc').on('click',function(event){
        event.preventDefault();
        gCounters( $('.create-img-out.mark-red:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            $('.create-img-out.mark-red:visible').each(function(index){
                create_img( $(this) );
            });
        }
    });

    //create all out
    $('.create-img-out-all').on('click',function(event){
        event.preventDefault();
        gCounters( $('.create-img-out:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            $('.create-img-out:visible').each(function(index){
                create_img( $(this) );
            });
        }
    });

    //delete all src
    $('.delete-img-src-all').on('click',function(event){
        event.preventDefault();
        gCounters( $('.delete-all:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            //if ( auto_confirm('Delete all src files?') )
            if ( confirm('Delete all src files?') )
            {
                $('.delete-all:visible').each(function(index){
                    delete_file( $(this),'src' );
                });
            }
        }
    });

    //delete all out
    $('.delete-img-out-all').on('click',function(event){
        event.preventDefault();
        gCounters( $('.delete-file-out:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            if ( auto_confirm('Delete all out files?') )
            {
                $('.delete-file-out:visible').each(function(index){
                    delete_file( $(this),'out' );
                });
            }
        }
    });

    //delete all min
    $('.delete-img-min-all').on('click',function(event){
        event.preventDefault();
        gCounters( $('.delete-file-min:visible').length );

        if ( $gCounters.elements == 0 )
        {
            $.msg('No elements to precess!','','info',5);
        }
        else
        {
            if ( auto_confirm('Delete all min files?') )
            {
                $('.delete-file-min:visible').each(function(index){
                    delete_file( $(this),'min' );
                });
            }
        }
    });

    //delete entry
    $('.delete-entry').on('click',function(event){
        event.preventDefault();
        gCounters(2);
        var $self = $(this);
        var $row = $self.parents('tr');
        if ( auto_confirm('Delete entry?') )
        {
            delete_file($self,'min');
            delete_file($self,'out');

            $row.fadeOut(function(){
                $row.remove();
            });
            fixetize();
            gal_edited();
        }
    });

    //delete out file
    $('.delete-file-out').on('click',function(event){
        event.preventDefault();
        gCounters(1);
        var $self = $(this);
        if ( auto_confirm('Delete out file?') )
        {
            delete_file($self,'out');
        }
    });

    //delete min file
    $('.delete-file-min').on('click',function(event){
        event.preventDefault();
        gCounters(1);
        var $self = $(this);
        if ( auto_confirm('Delete min file?') )
        {
            delete_file($self,'min');
        }
    });


    //delete out min
    //$('.delete-file-out-min').on('click',function(event){
    //    event.preventDefault();
    //    gCounters(2);
    //    var $self = $(this);
    //
    //    delete_file($(this),'min');
    //    delete_file($(this),'out');
    //});

    //delete src out min
    //$('.delete-file').on('click',function(event){
    //    event.preventDefault();
    //    gCounters(3);
    //    var $self = $(this);
    //    if ( auto_confirm('Delete file? Entry stays untouched!') )
    //    {
    //        delete_file($(this),'min');
    //        delete_file($(this),'out');
    //        delete_file($(this),'src');
    //    }
    //});

    //delete src out min and entry
    $('.delete-all').on('click',function(event){
        event.preventDefault();
        gCounters(3);
        var $self = $(this);
        var $row = $(this).parents('tr');
        var returned = false;
        if ( auto_confirm('Delete file and entry?') )
        {
            returned = delete_file($(this),'min');
            if ( returned || ajax_async)
            {
              returned = delete_file($(this),'out');
              if ( returned || ajax_async)
              {
                returned = delete_file($(this),'src');
              }
            }

            if ( returned || ajax_async)
            {
                $row.fadeOut(function(){
                    $row.remove();
                });
                fixetize();
                gal_edited();
            }
        }
    });

    //dbl click to change name
    $('.admin-gallery-items.tbody').on('dblclick','.img-filename-label',function(){
        var $self = $(this);
        var $parent_td = $self.parents('td');
        var $filename_input = $parent_td.find('.img-filename');
        $filename_input.attr('type','text');
        $self.hide();
        $parent_td.append('<a href="#" class="img-filename-ok">OK</a>');
    });

    //change name confirm
    $('.admin-gallery-items.tbody').on('click','.img-filename-ok',function(event){
        event.preventDefault();
        var $self = $(this);
        var $parent_td = $self.parents('td');
        var $parent_td_class = $parent_td.attr('class');
        var $index_of_space = $parent_td_class.indexOf(' ');

        var $img_id;
        if ( $index_of_space != -1 )
        {
            $img_id = $parent_td_class.substring(0,$index_of_space);
        }
        else
        {
            $img_id = $parent_td_class;
        }

        var $filename_label = $parent_td.find('.img-filename-label');
        var $filename_input = $parent_td.find('.img-filename');
        var $cur_filename = $parent_td.find('.img-filename-label').html();
        var $new_filename = $filename_input.val();

        $filename_input.attr('type','hidden');
        $filename_label.show();
        $self.remove();
        document.getSelection().removeAllRanges();

        if ( $new_filename != $cur_filename )
        {
            rename_file( $img_id, $cur_filename, $new_filename );
        }
    });

    $('#gal-date').datepicker({
        //showOn: "button",
        //buttonImage: "images/calendar.gif",
        //buttonText: ".",
        //buttonImageOnly: false,
        dateFormat: "yy-mm-dd"
        //timeFormat: "HH:mm"
    });

    $('#gal-desc-label').on('dblclick',function(){
        $.colorbox({
            href:'#gal-desc-popup',
            inline:true,
            onLoad:function(){
                var $input = $('#gal-desc').val();
                $('#gal-desc-area').val( $input );
            },
            onCleanup:function(){
                var $area = $('#gal-desc-area').val();
                $('#gal-desc').val( $area );
            }
        });
    });


    $('#gal-title-label').on('dblclick',function(){
        $.colorbox({
            href:'#gal-title-popup',
            inline:true,
            onLoad:function(){
                var $input = $('#gal-title').val();
                $('#gal-title-area').val( $input );
            },
            onCleanup:function(){
                var $area = $('#gal-title-area').val();
                $('#gal-title').val( $area );
            }
        });
    });

    //switch to sort view
    $('.view-sort').on('click',function(event){
        event.preventDefault();
        gal_sort_view();
    });

    //switch to manage view
    $('.view-manage').on('click',function(event){
        event.preventDefault();
        gal_manage_view();
    });

    //hide inactive
    $('.hide-inactive').on('click',function(event){
        event.preventDefault();
        gal_inactive_hide(true);
    });

    //show inactive
    $('.show-inactive').on('click',function(event){
        event.preventDefault();
        gal_inactive_show();
    });

    //recall gal_inactive_hide() each time any element state change
    $('td.active-wrapper input[type="checkbox"]').on('change',function(){
        gal_inactive_hide();
    });

    //activate all
    $('.activate-all').on('click',function(event){
        event.preventDefault();
        $(".admin-gallery-items td.active-wrapper input:checkbox").prop('checked',true);
        gal_inactive_hide();
        gal_edited();
    });

    //deactivate all
    $('.activate-non').on('click',function(event){
        event.preventDefault();
        $(".admin-gallery-items td.active-wrapper input:checkbox").prop('checked',false);
        gal_inactive_hide();
        gal_edited();
    });

    //activate toggle
    $('.activate-tog').on('click',function(event){
        event.preventDefault();
        $(".admin-gallery-items td.active-wrapper input:checkbox").each(function(){
            if ( $(this).prop('checked') )
            {
                $(this).prop('checked',false);
            }
            else
            {
                $(this).prop('checked',true);
            }
        });
        gal_inactive_hide();
        gal_edited(); // $(this).prop('checked',true/false); doesn't trig change event so manually call gal_edited
    });

    //status-links change
    $('.link-status').on('click',function(event){
        event.preventDefault();
        var $self = $(this);
        var $id = $self.attr('id');
        var $hid_id = $id.substring(7);
        var $hid_val;

        //based on hidden form element
        if ( $('#'+$hid_id).length>0 )
        {
            $hid_val = $('#'+$hid_id).val();
            if ( $hid_val == 0 )
            {
                $('#'+$hid_id).val(1);
                $self.addClass('active');
            }
            else if ( $hid_val == 1)
            {
                $('#'+$hid_id).val(0);
                $self.removeClass('active');
            }
        }
        //based on Statsu Object
        else
        {
            $hid_id = $hid_id.replace('-','_');
            $hid_val = $gStatus[$hid_id];
            if ( $gStatus[$hid_id] == false )
            {
                $gStatus[$hid_id]=true;
                $self.addClass('active');
            }
            else if ( $gStatus[$hid_id] == true )
            {
                $gStatus[$hid_id]=false;
                $self.removeClass('active');
            }
            reset_gal_cookie(g_name);
        }
    });

    //set gal_edited on form elements change
    $('form input, form textarea, form select').not('#upload-preresize').on('change',function(){
        gal_edited();
    });

    $('.gal-edited').on('click',function(){
        gal_edited();
    });

    //blur tr active on clicking in background
    $('#admin-gallery-browse').on('click',function(event){
        if( event.target.id == 'admin-gallery-form' )
        {
            $('.admin-gallery-items.tbody tr').removeClass('row-active');
        }
    });

    $('#upload-preresize').on('change',function(){
        if ( $(this).val() == 'fullhd' )
        {
            $('#gal-upload').hide();
            $('#gal-upload-fhd').show();
        }
        else
        {
            $('#gal-upload-fhd').hide();
            $('#gal-upload').show();
        }
    });

    //document ready

    //status-links check
    if ( $gStatus.auto_confirm==true )
    {
        $('#status-auto-confirm').addClass('active')
    }

    if ( $('#enlarge-smaller').val() == 1 )
    {
        $('#status-enlarge-smaller').addClass('active')
    }

    //hide links
    $('.view-manage').hide();
    $('.show-inactive').hide();
    $('#gal-upload-fhd').hide();

    $('.cb-upload').colorbox({
        iframe:true,
        width:"920px",
        height:"90%",
        onClosed:function(){
            //document.location.reload(true);
            //$('#admin-gallery-form').submit();
            $.msg( '!!! UPLOAD DONE !!!','Uploaded files won\'t be visible until page reloaded or gallery saved!','info',0,'middle','half' );
        }
    });

    //check if any thumb is selected and select first if not
    var thumb_picked=false;
    $('.thumb-picker').each(function(){
        if ( $(this).prop('checked') )
        {
            thumb_picked = true;
        }
    });
    if ( !thumb_picked )
    {
        $('.thumb-picker').eq(0).prop('checked',true);
    }

    //change active/inactive from colorbox
    $('body').on('change','.cb-title-wrapper input[type="checkbox"]',function(){
        var $self_checkbox = $(this);
        var $checkbox_class = $self_checkbox.attr('class');
        var $checkbox_number = $checkbox_class.substring(16);
        $('.admin-gallery-items tr.tbody-row-'+$checkbox_number+' td.active-wrapper input:checkbox').prop('checked',$self_checkbox.prop('checked'));
        gal_inactive_hide();
        gal_edited();
    });
});
function set_colorbox()
{
    //colorbox settings
    $(".cb-src").colorbox({
        rel:'cb-src',
        fixed: true,
        transition:"elastic",
        opacity:".4",
        maxWidth: '90%',
        maxHeight: '90%',
        overlayClose:false,
        current: "{current} / {total}"
        //slideshowStart:"pokaz: włącz",
        //slideshowStop:"pokaz: wyłącz",
        //slideshowSpeed:"3000"

        //onComplete: function(){
        //    var $cbself = $(this);
        //
        //    var $cbnumberclass = $cbself.parents('tr').attr('class');
        //    var $cbnumber = $cbnumberclass.substring(10);
        //
        //    goToByScroll('.img-'+$cbnumber,global_scroll_offset);
        //}
    });

    $(".cb-out").colorbox({
        rel:'cb-out',
        fixed: true,
        //bottom: '5%',
        //left: '5%',
        transition:"elastic",
        opacity:".4",
        maxWidth: '90%',
        maxHeight: '50%',
        overlayClose:false,
        current: "{current} / {total}",
        slideshowAuto: false,
        slideshowStart:"PLAY",
        slideshowStop:"STOP",
        slideshowSpeed:"2000",
        slideshow:true,

        title:function(){
            var $cbself = $(this);

            var $cbnumberclass = $cbself.parents('tr').attr('class');
            var $index_of_first_space = $cbnumberclass.indexOf(" "); //in sort mode there is another class for tr

            var $cbnumber;

            if ( $index_of_first_space == -1 )
            {
                $cbnumber = $cbnumberclass.substring(10);
            }
            else
            {
                $cbnumber = $cbnumberclass.substring(10,$index_of_first_space);
            }

            var $prop = $('.admin-gallery-items tr.tbody-row-'+$cbnumber+' td.active-wrapper input:checkbox').prop('checked');


            var $mirror_checkbox = $('<input class="active-checkbox-'+$cbnumber+'" type="checkbox" '+($prop?'checked="checked"':'')+' />');

            var $cbnumberformated = $cbself.parents('tr').find('td.id-wrapper').html();
            var $cbfilename = $cbself.parents('tr').find('td.filename-wrapper').html();

            var $return_string =    '<span class="cb-title-wrapper">'+
                                    $cbnumberformated+' / '+
                                    $gCurrentStatus.count+
                                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                                    $mirror_checkbox.prop('outerHTML')+
                                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                                    $cbfilename+
                                    '</span>';
            return $return_string;
        },

        onComplete: function(){
            var $cbself = $(this);

            var $cbnumberclass = $cbself.parents('tr').attr('class');
            var $index_of_first_space = $cbnumberclass.indexOf(" "); //in sort mode there is another class for tr

            var $cbnumber;

            if ( $index_of_first_space == -1 )
            {
                $cbnumber = $cbnumberclass.substring(10);
            }
            else
            {
                $cbnumber = $cbnumberclass.substring(10,$index_of_first_space);
            }

            $('.admin-gallery-items.tbody tr').removeClass('row-active');
            $('.admin-gallery-items.tbody tr.tbody-row-'+$cbnumber).addClass('row-active');

            goToByScroll('.img-'+$cbnumber,global_scroll_offset);
        },

        onClosed:function(){
            //$('.admin-gallery-items.tbody tr').removeClass('row-active');
        }


        //alternative method using title and onComplete
        //title:function(){
        //    var $cbself = $(this);
        //    //var $cbnumberclass = $cbself.parents('tr').attr('class');
        //    //var $cbnumber = $cbnumberclass.substring(10);
        //    var $cbnumberformated = $cbself.parents('tr').find('td.id-wrapper').html();
        //    var $cbfilename = $cbself.parents('tr').find('td.filename-wrapper').html();
        //    //var $cbactive = $cbself.parents('tr').find('td.active-wrapper input[type="checkbox"]').prop('checked')==true?'active':'inactive';
        //    var $cbactive = $cbself.parents('tr').find('td.active-wrapper').html();
        //    var $return_string =    '<span class="cb-title-wrapper">'+
        //                            $cbnumberformated+' / '+
        //                            $gCurrentStatus.count+
        //                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
        //                            $cbactive+
        //                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
        //                            $cbfilename+
        //                            '</span>';
        //    return $return_string;
        //},

        //onComplete: function(){
        //    var $cbself = $(this);
        //    var $cbnumberclass = $cbself.parents('tr').attr('class');
        //    var $checkbox_number = $cbnumberclass.substring(10);
        //
        //    var $prop = $('.admin-gallery-items tr.tbody-row-'+$checkbox_number+' td.active-wrapper input:checkbox').prop('checked');
        //
        //    $('.cb-title-wrapper input:radio').remove();
        //    $('.cb-title-wrapper input:checkbox').prop('checked',$prop);
        //}
    });

    $(".cb-min").colorbox({
        rel:'cb-min',
        fixed: true,
        transition:"elastic",
        opacity:".4",
        maxWidth: '90%',
        maxHeight: '90%',
        overlayClose:false,
        current: "{current} / {total}"
        //slideshowStart:"pokaz: włącz",
        //slideshowStop:"pokaz: wyłącz",
        //slideshowSpeed:"3000"
        //onComplete: function(){
        //    var $cbself = $(this);
        //
        //    var $cbnumberclass = $cbself.parents('tr').attr('class');
        //    var $cbnumber = $cbnumberclass.substring(10);
        //
        //    goToByScroll('.img-'+$cbnumber,global_scroll_offset);
        //}
    });

    $('#colorbox').on('mousewheel', function(event, delta) {
        var dir = delta > 0 ? 'Up' : 'Down',
            vel = Math.abs(delta);
        if (dir == 'Down')
        {
            $.colorbox.next();
        }
        else
        {
            $.colorbox.prev();
        }
        return false;
    });

}

function fixetize()
{
    $('.pre-space.top').fadeOut(function(){
        //alert('hd');
        $('#fixed-wrapper').glufixed(1000);
        $('.pre-space.top').fadeIn();
    });
    //$('.admin-gallery-items.thead').glufixed(1000);
    //$('#admin-gallery-menu').glufixed(1000);
}

$(window).load(function(){

    //get table width
    $gCurrentStatus.view_manage_width = $('.admin-gallery-items.tbody').width(); //alert($gCurrentStatus.view_manage_width);

    //fixetize table header
    fixetize();


    //hide inactive
    gal_inactive_hide();

    //if sort view mode in cookie set sort mode
    if ( $gStatus.view_mode == 'sort' )
    {
        gal_sort_view();
    }

    //gallery fadeIn process
    $('.admin-gallery-items.tbody').fadeOut(function(){
        $('.admin-gallery-items.thead').css({'visibility':'visible'});
        $('.admin-gallery-items.tbody').css({'visibility':'visible'});
        $('.admin-gallery-items.tbody').fadeIn();
        count_active_inactive();
    });

    set_colorbox();
});
//]]>
</script>
