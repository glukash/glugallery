<script type="text/javascript">
//<![CDATA[
$(window).load(function(){

    var $wdt = 'half';
    var $wdo = 0;

    if ( typeof $gCurrentStatus != 'undefined' && typeof $gCurrentStatus.view_manage_width != 'undefined' && $gCurrentStatus.view_manage_width != 0 )
    {
        $wdt = $gCurrentStatus.view_manage_width;
        $wdo = -1;
    }

    $('body').glumsg({
        'defaults':{
            'cls':'info',
            'tim':false,
            'pos':'bottom',
            'wdt':$wdt,
            'wdo':0, //const width offset
            'poo':0  //const position offset
        },
        'hover':{
            //galleries
            '.gal-thumb-wrapper':{
                'msg':'drag to sort',
                'dsc':'drag to sort galleries'
            },
            '.gal-title':{
                'msg':'edit gallery',
                'dsc':'edit gallery'
            },
            '.gal-del':{
                'msg':'delete gallery',
                'dsc':'delete gallery! all files, including source files will be removed!'
            },
            '.gal-shw':{
                'msg':'show/hide gallery',
                'dsc':'set gallery visibility status!'
            },
            '.count-all span':{
                'msg':'all',
                'dsc':'number of all images in gallery'
            },
            '.count-act span':{
                'msg':'active',
                'dsc':'number of all active images in gallery'
            },
            '.count-ina span':{
                'msg':'inactive',
                'dsc':'number of all inactive images in gallery'
            },
            '.count-ind span':{
                'msg':'indexed',
                'dsc':'number of all indexed images in gallery'
            },
            '.count-uni span':{
                'msg':'unindexed',
                'dsc':'number of all unindexed images in gallery'
            },
            '.count-missrc span':{
                'msg':'missing src files',
                'dsc':'number of missing source files'
            },
            '.count-misout span':{
                'msg':'missing out files',
                'dsc':'number of missing output files'
            },
            '.count-mismin span':{
                'msg':'missing min files',
                'dsc':'number of missing miniature files'
            },

            //gallery
            '.miniature':{
                'msg':'click or drag',
                'dsc':'click to show picture, drag to sort entry'
            },
            '.gallery .inactive-pannel .button':{
                'msg':'show/hide inactive',
                'dsc':'inactive entries can be either hidden or shown<br />out and min files of hidden entries won\'t be processed ( created, deleted, moved )'
            },
            '#gal-upload,#gal-upload-fhd':{
                'msg':'upload new files',
                'dsc':'gallery will be saved automatically after closing upload window'
            },
            '#status-auto-confirm':{
                'msg':'auto confirm',
                'dsc':'if active no confirm dialogs will be shown'
            },
            '#status-enlarge-smaller':{
                'msg':'enlarge if smaller',
                'dsc':'smaller files are resized according to ratio calculated from given dimensions<br />if active smaller files will be enlarged to given dimensions (according to the resize method)'
            },
            '.create-img-out':{
                'msg':'recreate out file',
                'dsc':'recreate out file with selected method and size'
            },
            '.create-img-min':{
                'msg':'recreate min file',
                'dsc':'recreate min file with selected method and size'
            },
            '.create-img-min-all':{
                'msg':'create all min files',
                'dsc':'create all uncreated and recreate created with selected method and size'
            },
            '.create-img-min-unc':{
                'msg':'create uncreated min files',
                'dsc':'create all uncreated with selected method and size'
            },
            '.delete-img-min-all':{
                'msg':'delete all min files',
                'dsc':'delete all min files'
            },
            '.create-img-out-all':{
                'msg':'create all out files',
                'dsc':'create all uncreated and recreate created with selected method and size'
            },
            '.create-img-out-unc':{
                'msg':'create uncreated out files',
                'dsc':'create all uncreated with selected method and size'
            },
            '.delete-img-out-all':{
                'msg':'delete all out files',
                'dsc':'delete all out files'
            },
            '.delete-img-src-all':{
                'msg':'delete all src files',
                'dsc':'delete all src files'
            },

            '.delete-entry':{
                'msg':'delete entry / unindex file',
                'dsc':'delete entry / unindex file,<br />out and min files will be deleted<br />after saving src file will be treated as newly uploaded'
            },
            '.delete-file-out':{
                'msg':'delete out file',
                'dsc':'entry stays untouched',
            },
            '.delete-file-min':{
                'msg':'delete min file',
                'dsc':'entry stays untouched',
            },
            //'.delete-file-out-min':{
            //    'msg':'delete out and min files',
            //    'dsc':'entry stays untouched',
            //},
            //'.delete-file':{
            //    'msg':'delete out, min and src files',
            //    'dsc':'source file will be deleted',
            //},
            '.delete-all':{
                'msg':'delete src, out and min files',
                'dsc':'files will be permanently removed from gallery (can\'t be undone)'
            },
            '.activate-all':{
                'msg':'activate all',
                'dsc':'activate all'
            },
            '.activate-non':{
                'msg':'deactivate all',
                'dsc':'deactivate all'
            },
            '.activate-tog':{
                'msg':'activate toggle',
                'dsc':'activate toggle'
            },
            '#upload-preresize':{
                'msg':'upload preresize',
                'dsc':'resize files before upload<br />files will be preresized to 1920x1080 in browser before upload<br />shortens upload time<br /><br />works only with JPEG files<br />not all browsers support this feature'
            }

        },
        'focus':{
            //galleries
            '#gal-create':{
                'msg':'enter new gallery directory name',
                'dsc':'enter new gallery directory name (use only letters and numbers) and hit save<br />current galleries layout and visibility will be saved<br />new gallery diretory will be created<br />if leaved empty no new gallery directory will be created'
            },

            //gallery
            '#gal-title':{
                'msg':'gallery title',
                'dsc':'enter gallery title'
            },
            '#gal-desc':{
                'msg':'gallery description',
                'dsc':'enter gallery description'
            },
            '#gal-date':{
                'msg':'gallery date',
                'dsc':'enter gallery date'
            },
            '.load-src':{
                'msg':'load or not src files',
                'dsc':'large src files may slow down page loading,<br /> set don\'t load to increase page loading time<br />save required'
            },
            '.size-out-method':{
                'msg':'select method of creating out files',
                'dsc':'normal, background, shrink, crop'
            },
            '.size-min-method':{
                'msg':'select method of creating min files',
                'dsc':'normal, background, shrink, crop'
            },
            '.size-out-width, .size-out-height':{
                'msg':'select width and height of out files',
                'dsc':'real width and height are related to creating method'
            },
            '.size-min-width, .size-min-height':{
                'msg':'select width and height of min files',
                'dsc':'real width and height are related to creating method'
            },
            '.gal-item-title':{
                'msg':'gallery item title',
                'dsc':'enter gallery item title'
            },
            '.gal-item-desc':{
                'msg':'gallery item description',
                'dsc':'enter gallery item description'
            }
        }/*,
        'click':{
            '#gal-title':{
                'msg':'gallery title',
                'dsc':'enter gallery title'
            }
        }*/
    });
});
//]]>
</script>
