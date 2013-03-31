
    function auto_confirm( $question )
    {
        if ( $gStatus.auto_confirm )
        {
            return true;
        }
        else
        {
            return confirm( $question );
        }
    }

    function reset_gal_cookie(gname)
    {
        if ( typeof gname == 'undefined' )
        {
            set_json_cookie( 'glugal-cookie', $gStatus, 365 );
        }
        else
        {
            set_json_cookie( 'glugal-cookie-'+gname, $gStatus, 365 );
        }
    }

    function gal_edited(){
        $('.save-button').css({
            'background-color':'#FFC6C6'
        });
    }

    function wrapper_put_img( $container_class, $type, $file, $url, $info )
    {
        $('.'+$container_class+'.'+$type).
            html(
                '<div class="bold font25"><a href="#'+$type+'/'+$file+'" class="mark-green create-img create-img-'+$type+'" title="create '+$type+'">&bull;</a></div><div class="font10">'+$info.wxh+'<br />'+$info.size.human+'</div>'
            );
        $('.'+$container_class+'.'+$type+'-wrapper').
            html(
            '<a href="'+$url+'?timestamp=' + new Date().getTime()+'" class="cb-'+$type+' cboxElement">'+
            '<img class="'+$type+'-img miniature" src="'+$url+'?timestamp=' + new Date().getTime()+'" alt="'+$type+'" />'+
            '</a>'
            );

        $('.admin-gallery-items .id-wrapper, .admin-gallery-items td.src-wrapper a,.admin-gallery-items td.out-wrapper a, .admin-gallery-items td.min-wrapper a').css({'cursor':'move'});
        $('.cb-'+$type+'').colorbox({
            rel:'cb-'+$type+'',
            transition:"elastic",
            opacity:".6",
            maxWidth: '90%',
            maxHeight: '90%',
            overlayClose:false,
            current: "{current} / {total}",
            slideshowStart:"pokaz: włącz",
            slideshowStop:"pokaz: wyłącz",
            slideshowSpeed:"3000"
        });
        return true;
    }

    function wrapper_clean( $container_class, $type, $file  )
    {

        if ( $type != 'src' )
        {
            $('.'+$container_class+'.'+$type).
                html(
                    '<div class="bold font25"><a href="#'+$type+'/'+$file+'" class="mark-red create-img create-img-'+$type+'" title="create '+$type+'">&bull;</a></div>'
                );
        }
        else
        {
            $('.'+$container_class+'.'+$type).
                html(
                    '<div class="mark-red bold font25">&bull;</div>'
                );
        }

        $('.'+$container_class+'.'+$type+'-wrapper').
            html('');

        return true;
    }

    function create_img ( create_link )
    {
        var $self = create_link;
        var $container = $self.parents('td');
        var $container_class = $container.attr('class').split(" ")[0];
        var $href = $self.attr('href');
        var indexOfSlash = $href.indexOf('/');
        var $type = $href.substring(1,indexOfSlash);
        var $file = $href.substring(indexOfSlash+1);
        //var $src;
        var $width = $('.size-'+$type+'-width').val();
        var $height = $('.size-'+$type+'-height').val();
        var $method = $('.size-'+$type+'-method option:selected').attr('value');
        var $enlarge = $('#enlarge-smaller').val();
        //var $result = false;

        $('.'+$container_class+'.'+$type+' div a').removeClass('mark-red mark-green').addClass('mark-orange');
        //$.post(
        //    './create',
        //    {
        //        'data[create][gallery]':g_name,
        //        'data[create][file]':$file,
        //        'data[create][type]':$type,
        //        'data[create][method]':$method,
        //        'data[create][width]':$width,
        //        'data[create][height]':$height
        //    },
        //    function(data){
        //        if ( data.status == 'success' )
        //        {
        //            wrapper_put_img( $container_class, $type, $file, data.url, data.info );
        //            $result = true;
        //        }
        //        else if ( data.status == 'error' )
        //        {
        //            //alert(data.info);
        //            $.msg(data.info,'','error',0);
        //        }
        //    },
        //    'json'
        //);
        $.ajax({
            type: 'POST',
            url: gRootUrl+'create',
            data:
            {
                'data[create][gallery]':g_name,
                'data[create][file]':$file,
                'data[create][type]':$type,
                'data[create][method]':$method,
                'data[create][enlarge]':$enlarge,
                'data[create][width]':$width,
                'data[create][height]':$height
            },
            success:
            function(data){
                if ( data.status == 'success' )
                {
                    wrapper_put_img( $container_class, $type, $file, data.url, data.info );
                    //$result = true;

                    $gCounters.processed++;
                    $.msg('! PROCESSING !','Created '+$gCounters.processed+' of '+$gCounters.elements+'!','success',5,'bottom');
                }
                else if ( data.status == 'error' )
                {
                    $.msg(data.info,'','error',0);
                }
            },
            dataType: 'json',
            async:ajax_async
        });
        return true; //$result;
    }

    function delete_file(delete_link,$type)
    {
        var $self = delete_link;
        var $container = $self.parents('td');
        var $container_class = $container.attr('class').split(" ")[0];
        var $file =  $('.'+$container_class+'.filename-wrapper').find('.img-filename').val();
        //var $result=false;

        $('.'+$container_class+'.'+$type+' div a').removeClass('mark-red mark-green').addClass('mark-orange');
        //$.post(
        //    './delete',
        //    {
        //        'data[delete][gallery]':g_name,
        //        'data[delete][file]':$file,
        //        'data[delete][type]':$type
        //    },
        //    function(data){
        //        if ( data.status == 'success' )
        //        {
        //            wrapper_clean( $container_class, $type, $file  );
        //            $result=true;
        //        }
        //        else if ( data.status == 'error' )
        //        {
        //            alert(data.info);
        //        }
        //    },
        //    'json'
        //);

        $.ajax({
            type: 'POST',
            url: gRootUrl+'delete',
            data:
            {
                'data[delete][gallery]':g_name,
                'data[delete][file]':$file,
                'data[delete][type]':$type
            },
            success:
            function(data){
                if ( data.status == 'success' )
                {
                    wrapper_clean( $container_class, $type, $file  );
                    //$result=true;
                    $gCounters.processed++;
                    $.msg('! PROCESSING !','Deleted '+$gCounters.processed+' of '+$gCounters.elements+'!','success',5,'bottom');
                }
                else if ( data.status == 'error' )
                {
                    $.msg(data.info,'','error',0);
                }
            },
            dataType: 'json',
            async:ajax_async
        });

        return true; //$result;
    }

    function delete_gallery(g_name)
    {
        $('#admin-galleries-list .gallery.'+g_name).addClass('alert');
        $.post(
            gRootUrl+'delete',
            {
                'data[delete][galleryall]':g_name
            },
            function(data){
                if ( data.status == 'success' )
                {
                    $('#admin-galleries-list .gallery.'+g_name).remove();
                    $.msg(data.info,'',data.status,0);
                }
                else if ( data.status == 'error' )
                {
                    $.msg(data.info,'',data.status,0);
                }
            },
            'json'
        );
        return true;
    }

    function gal_sort_view()
    {
        //ALTERNATIVE $('.admin-gallery-items td').not('.min-wrapper').fadeOut();
        $('.admin-gallery-items td').not('.out-wrapper').fadeOut();

        if ( $('.admin-gallery-items.thead').is(':visible') )
        {
            $('.admin-gallery-items.thead').fadeOut(function(){
                $('.admin-gallery-items.tbody tr').addClass('tr-sortable');
            });
        }
        else
        {
            $('.admin-gallery-items.tbody tr').addClass('tr-sortable');
        }

        $('.admin-gallery-items').resizable({
            create: function( event, ui ) {
                $('.admin-gallery-items.tbody').width( $gStatus.view_sort_width );
            },
            resize: function( event, ui ) {
                $gStatus.view_sort_width = $('.admin-gallery-items.tbody').width();
            },
            stop: function( event, ui ) {
                reset_gal_cookie(g_name);
            }
        });

        $('.view-sort').fadeOut(function(){
            $('.view-manage').fadeIn();
        });
        $('.hide-inactive,.show-inactive,.cb-upload').addClass('visibility-hidden');
        $gCurrentStatus.view_mode = 'sort';
        $gStatus.view_mode = 'sort';
        reset_gal_cookie(g_name);
        $('.caption-view').html('View: sort');
        //$('.caption-inactive').html('Inactive: hidden').addClass('alert');
    }

    function gal_manage_view()
    {
        $('.admin-gallery-items').resizable('destroy');
        $('.admin-gallery-items.tbody tr').removeClass('tr-sortable');
        //$('.admin-gallery-items tr').removeClass('tr-sortable'); //ccc
        //$('.admin-gallery-items tr td.min-wrapper').removeClass('td-sortable');
        if ( $gStatus.inactive_hidden == false )
        {
            $(".admin-gallery-items tbody input:checkbox:hidden").not(":checked").parents('tr').fadeIn();
        }

        //ALTERNATIVE $('.admin-gallery-items td').not('.min-wrapper').fadeIn(function(){
        $('.admin-gallery-items td').not('.out-wrapper').fadeIn(function(){
            //$(".admin-gallery-items tbody input:checkbox:visible").not(":checked").parents('tr').find('.min-wrapper img').removeClass('opacity-half-container');
        });

        $('.admin-gallery-items.thead').fadeIn(function(){

            fixetize();

            $('.admin-gallery-items.tbody').width($gCurrentStatus.view_manage_width);
            //$('.admin-gallery-items').width('auto');

            //$('.thead-row-1 th').each(function(index,element){
            //    $(this).width($th_width_array[index]);
            //    //$(this).css({'width':$th_width_array[index]+'px'});
            //});
            //
            //$('.thead-row-2 th').each(function(index,element){
            //    $(this).width($th_width_array[index]);
            //    //$(this).css({'width':$th_width_array[index]+'px'});
            //});
            //
            //$('tbody tr').each(function(index,element){
            //    var $self = $(this);
            //    $self.find('td').each(function(index,element){
            //        $(this).width($th_width_array[index]);
            //        //$(this).css({'width':$th_width_array[index]+'px'});
            //    });
            //});
        });

        $('.view-manage').fadeOut(function(){
            $('.view-sort').fadeIn();
        });
        //$('.hide-inactive,.show-inactive,.cb-upload').removeClass('decoration-line-through');
        $('.hide-inactive,.show-inactive,.cb-upload').removeClass('visibility-hidden');
        $gCurrentStatus.view_mode = 'manage';
        $gStatus.view_mode = 'manage';
        reset_gal_cookie(g_name);
        $('.caption-view').html('View: manage');
        if ( $gStatus.inactive_hidden )
        {
            $('.caption-inactive').html('Inactive: hidden').addClass('alert');
        }
        else
        {
            $('.caption-inactive').html('Inactive: shown').removeClass('alert');
        }
        gal_inactive_hide();
    }

    /* gal_inactive_hide( true ) changes state, gal_inactive_hide() only refresh if state is hidden  */
    function gal_inactive_hide( $set )
    {
        $(".admin-gallery-items tbody input:checkbox").not(":checked").parents('tr').find('td').addClass('opacity-half-container');
        $(".admin-gallery-items tbody input:checkbox:checked").parents('tr').find('td.opacity-half-container').removeClass('opacity-half-container');
        if ( $set || $gStatus.inactive_hidden )
        {
            if ( $gCurrentStatus.view_mode == 'sort' ) return false;

            //colorbox reassing
            $(".admin-gallery-items td.active-wrapper input:checkbox:visible").not(":checked").parents('tr').find('td.src-wrapper a').removeClass('cb-src cboxElement');
            $(".admin-gallery-items td.active-wrapper input:checkbox:visible").not(":checked").parents('tr').find('td.out-wrapper a').removeClass('cb-out cboxElement');
            $(".admin-gallery-items td.active-wrapper input:checkbox:visible").not(":checked").parents('tr').find('td.min-wrapper a').removeClass('cb-min cboxElement');

            $(".admin-gallery-items td.active-wrapper input:checkbox:visible").not(":checked").parents('tr').fadeOut();

            //colorbox reassing
            $(".admin-gallery-items td.active-wrapper input:checkbox:hidden:checked").parents('tr').find('td.src-wrapper a').addClass('cb-src cboxElement');
            $(".admin-gallery-items td.active-wrapper input:checkbox:hidden:checked").parents('tr').find('td.out-wrapper a').addClass('cb-out cboxElement');
            $(".admin-gallery-items td.active-wrapper input:checkbox:hidden:checked").parents('tr').find('td.min-wrapper a').addClass('cb-min cboxElement');

            $(".admin-gallery-items td.active-wrapper input:checkbox:hidden:checked").parents('tr').fadeIn();

            set_colorbox();

            $('.hide-inactive').fadeOut(function(){
                $('.show-inactive').fadeIn(function(){
                });
                $gStatus.inactive_hidden = true;
                reset_gal_cookie(g_name);
                $('.caption-inactive').html('Inactive: hidden').addClass('alert');
            });
        }
        count_active_inactive();
        fixetize();
        return true;
    }

    function gal_inactive_show()
    {
        if ( $gStatus.view_mode == 'sort' ) return false;

        //colorbox reassing
        $(".admin-gallery-items td.active-wrapper input:checkbox:hidden").parents('tr').find('td.src-wrapper a').addClass('cb-src cboxElement');
        $(".admin-gallery-items td.active-wrapper input:checkbox:hidden").parents('tr').find('td.out-wrapper a').addClass('cb-out cboxElement');
        $(".admin-gallery-items td.active-wrapper input:checkbox:hidden").parents('tr').find('td.min-wrapper a').addClass('cb-min cboxElement');
        set_colorbox();

        $(".admin-gallery-items td.active-wrapper input:checkbox:hidden").parents('tr').fadeIn(function(){
            //$(".admin-gallery-items tbody input:checkbox:visible").not(":checked").parents('tr').removeClass('opacity-half-container');
        });
        $('.show-inactive').fadeOut(function(){
            $('.hide-inactive').fadeIn(function(){
            });
            $gStatus.inactive_hidden = false;
            reset_gal_cookie(g_name);
            $('.caption-inactive').html('Inactive: shown').removeClass('alert');
        });
        count_active_inactive();
        fixetize();
        return true;
    }

    /* gals_inactive_hide( true ) changes state, gal_inactive_hide() only refresh if state is hidden  */
    function gals_inactive_hide( $set )
    {
        if ( $set || $gStatus.inactive_hidden )
        {
            //if ( $gCurrentStatus.view_mode == 'sort' ) return false;
            $("#admin-galleries-list input:checkbox:visible").not(":checked").parents('.gallery').fadeOut();
            $("#admin-galleries-list input:checkbox:hidden:checked").parents('.gallery').fadeIn();
            $('.hide-inactive').fadeOut(function(){
                $('.show-inactive').fadeIn(function(){
                });
                $gStatus.inactive_hidden = true;
                reset_gal_cookie();
                $('.caption-inactive').html('Inactive: hidden').addClass('alert');
            });
        }
        return true;
    }

    function gals_inactive_show()
    {
        //if ( $gStatus.view_mode == 'sort' ) return false;
        $("#admin-galleries-list input:checkbox:hidden").parents('.gallery').fadeIn();
        $('.show-inactive').fadeOut(function(){
            $('.hide-inactive').fadeIn(function(){
            });
            $gStatus.inactive_hidden = false;
            reset_gal_cookie();
            $('.caption-inactive').html('Inactive: shown').removeClass('alert');
        });
        fixetize();
        return true;
    }

    function count_active_inactive()
    {
        $gCurrentStatus.count_inactive = $(".admin-gallery-items td.active-wrapper input:checkbox").not(":checked").length;
        $gCurrentStatus.count_active = $(".admin-gallery-items td.active-wrapper input:checkbox:checked").length;
        $gCurrentStatus.count  = $(".admin-gallery-items td.active-wrapper").length;
        $('.header-status-file').html('active: '+$gCurrentStatus.count_active+' inactive: '+$gCurrentStatus.count_inactive);
    }
