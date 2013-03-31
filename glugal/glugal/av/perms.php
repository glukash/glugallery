<div id="login-wrapper">
    <?php include element('logged'); ?>
    <h2 class="float-left padding05"><a href="index">Home</a></h2>
    <div class="login-box">

<!--<h2>PHP &amp; mySQL demo + event order</h2>
<div id="description">
<p>Here is a PHP &amp; mySQL enabled demo. You can use the classes/DB structure included, but those are not thoroughly tested and not officially a part of jstree. In the log window you can also see all function calls as they happen on the instance.</p>
<div id="mmenu" style="height:30px; overflow:auto;">
<input type="button" id="add_folder" value="add folder" style="display:block; float:left;"/>
<input type="button" id="add_default" value="add file" style="display:block; float:left;"/>
<input type="button" id="rename" value="rename" style="display:block; float:left;"/>
<input type="button" id="remove" value="remove" style="display:block; float:left;"/>
<input type="button" id="cut" value="cut" style="display:block; float:left;"/>
<input type="button" id="copy" value="copy" style="display:block; float:left;"/>
<input type="button" id="paste" value="paste" style="display:block; float:left;"/>
<input type="button" id="clear_search" value="clear" style="display:block; float:right;"/>
<input type="button" id="search" value="search" style="display:block; float:right;"/>
<input type="text" id="text" value="" style="display:block; float:right;" />
</div>-->
<a id="get-json" href="#" class="button display-block float-right font11 margin05">Save perms</a>
<!-- the tree container (notice NOT an UL node) -->
<div id="perms-tree" class="perms-tree" style="min-height:200px; padding: 20px;"></div>
<!--<div style="height:30px; text-align:center;">
	<input type="button" style='width:170px; height:24px; margin:5px auto;' value="reconstruct" onclick="$.get('./server.php?reconstruct', function () { $('#demo').jstree('refresh',-1); });" />
	<input type="button" style='width:170px; height:24px; margin:5px auto;' id="analyze" value="analyze" onclick="$('#alog').load('./server.php?analyze');" />
	<input type="button" style='width:170px; height:24px; margin:5px auto;' value="refresh" onclick="$('#demo').jstree('refresh',-1);" />
</div>
<div id='alog' style="border:1px solid gray; padding:5px; height:100px; margin-top:15px; overflow:auto; font-family:Monospace;"></div>
<div id="show-json">dupa</div>-->
<!-- JavaScript neccessary for the tree -->
<script type="text/javascript" class="source below">
$(function () {
$('#get-json').on('click',function(event){
	event.preventDefault();
	var json_get_tree = $("#perms-tree").jstree("json_data").get_json ( -1 );
	$.post(
		gRootUrl+'perms',
		{
			'data[jsondata]':JSON.stringify(json_get_tree)
		},
		function (data){
			if (data == 'success')
			{
				window.location.reload(true);
			}
		},
		'json'
	);
});

var json_tree = <?php echo $json_tree; ?>;

$("#perms-tree")
	//.bind("before.jstree", function (e, data) {
	//	$("#alog").append(data.func + "<br />");
	//})
	.jstree({
		// List of active plugins
		"plugins" : [
			"themes","json_data","ui","crrm","cookies","dnd",/*"search",*/"types","hotkeys","contextmenu"
		],

		// I usually configure the plugin that handles the data first
		// This example uses JSON as it is most common
	        "json_data" : {
	            "data" : json_tree /*[
	                {
	                    "attr" : { "id" : "li.node.id1", "rel" : "drive" },
	                    "data" : {
	                        "title" : "glugal",
	                        "attr" : { "href" : "ass" }
	                    },
						"children" : [
							{
								"data" : "Kerna1",
								"attr" : { "id" : "li.node.id10", "rel" : "folder" },
							},
							{
								"data" : "Start2"
							}
						],
	                }
	            ]*/
	        },
		// Configuring the search plugin
		//"search" : {
		//	// As this has been a common question - async search
		//	// Same as above - the `ajax` config option is actually jQuery's AJAX object
		//	"ajax" : {
		//		"url" : "./server.php",
		//		// You get the search string as a parameter
		//		"data" : function (str) {
		//			return {
		//				"operation" : "search",
		//				"search_str" : str
		//			};
		//		}
		//	}
		//},
		// Using types - most of the time this is an overkill
		// read the docs carefully to decide whether you need types
		"types" : {
			// I set both options to -2, as I do not need depth and children count checking
			// Those two checks may slow jstree a lot, so use only when needed
			"max_depth" : 4,
			//"max_children" : -2,
			// I want only `drive` nodes to be root nodes
			// This will prevent moving or creating any other type as a root node
			"valid_children" : [ "drive" ],
			"types" : {
				// The default type
				"default" : {
					// I want this type to have no children (so only leaf nodes)
					// In my case - those are files
					"valid_children" : "none",
					// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					"icon" : {
						"image" : "./glugal/js/jquery.jstree/_demo/file.png"
					}
				},
				// The `folder` type
				"folder" : {
					// can have files and other folders inside of it, but NOT `drive` nodes
					//"max_children" : 2,
					"valid_children" : [ "default", "folder" ],
					"icon" : {
						"image" : "./glugal/js/jquery.jstree/_demo/folder.png"
					}
				},
				// The `drive` nodes
				"drive" : {
					// can have files and folders inside, but NOT other `drive` nodes
					"max_children" : -1,
					"valid_children" : [ "default", "folder" ],
					"icon" : {
						"image" : "./glugal/js/jquery.jstree/_demo/root.png"
					},
					// those prevent the functions with the same name to be used on `drive` nodes
					// internally the `before` event is used
					"start_drag" : false,
					"move_node" : false,
					"delete_node" : false,
					"remove" : false
				}
			}
		},
		// UI & core - the nodes to initially select and open will be overwritten by the cookie plugin

		// the UI plugin - it handles selecting/deselecting/hovering nodes
		"ui" : {
			// this makes the node with ID node_4 selected onload
			"initially_select" : [ "node_4" ]
		},
		// the core plugin - not many options here
		"core" : {
			// just open those two nodes up
			// as this is an AJAX enabled tree, both will be downloaded from the server
			//"initially_open" : [ "node_2" , "node_3" ]
            "load_open"   : true,
            "strings"     : {
                "loading"     : "Loading ...",
                "new_node"    : "Enter action or role name"
                //multiple_selection : "Multiple selection"
            }
		},
		"contextmenu": { // Could be a function that should return an object like this one
				items:{
				"ccp" : false,"create":false,"cut":false,"copy":false,"paste":false,"rename":false,"remove":false,
				"gcreatea" : {
					"separator_before"	: false,
					"separator_after"	: true,
					"label"				: "Create Action",
					"action"			: function (obj) { this.create(obj, "last", {"attr" : { "rel" : "folder"}}); }
				},
				"gcreater" : {
					"separator_before"	: false,
					"separator_after"	: true,
					"label"				: "Create Role",
					"action"			: function (obj) { this.create(obj, "first", {"attr" : { "rel" : "default"}}); }
				},
				"gcut" : {
					"separator_before"	: true,
					"separator_after"	: false,
					"label"				: "Cut",
					"action"			: function (obj) { this.cut(obj); }
				},
				"gcopy" : {
					"separator_before"	: false,
					"icon"				: false,
					"separator_after"	: false,
					"label"				: "Copy",
					"action"			: function (obj) { this.copy(obj); }
				},
				"gpaste" : {
					"separator_before"	: false,
					"icon"				: false,
					"separator_after"	: false,
					"label"				: "Paste",
					"action"			: function (obj) { this.paste(obj); }
				},
				"grename" : {
					"separator_before"	: true,
					"separator_after"	: false,
					"label"				: "Rename",
					"action"			: function (obj) { this.rename(obj); }
				},
				"gremove" : {
					"separator_before"	: true,
					"icon"				: false,
					"separator_after"	: false,
					"label"				: "Delete",
					"action"			: function (obj) { if(this.is_selected(obj)) { this.remove(); } else { this.remove(obj); } }
				}
				//	}
				//}
				}
			}
	}).bind("loaded.jstree", function (event, data) {
            // you get two params - event & data - check the core docs for a detailed description
            $(this).jstree("open_all");
        });
	//.bind("create.jstree", function (e, data) {
	//	$.post(
	//		"./server.php",
	//		{
	//			"operation" : "create_node",
	//			"id" : data.rslt.parent.attr("id").replace("node_",""),
	//			"position" : data.rslt.position,
	//			"title" : data.rslt.name,
	//			"type" : data.rslt.obj.attr("rel")
	//		},
	//		function (r) {
	//			if(r.status) {
	//				$(data.rslt.obj).attr("id", "node_" + r.id);
	//			}
	//			else {
	//				$.jstree.rollback(data.rlbk);
	//			}
	//		}
	//	);
	//})
	//.bind("remove.jstree", function (e, data) {
	//	data.rslt.obj.each(function () {
	//		$.ajax({
	//			async : false,
	//			type: 'POST',
	//			url: "./server.php",
	//			data : {
	//				"operation" : "remove_node",
	//				"id" : this.id.replace("node_","")
	//			},
	//			success : function (r) {
	//				if(!r.status) {
	//					data.inst.refresh();
	//				}
	//			}
	//		});
	//	});
	//})
	//.bind("rename.jstree", function (e, data) {
	//	$.post(
	//		"./server.php",
	//		{
	//			"operation" : "rename_node",
	//			"id" : data.rslt.obj.attr("id").replace("node_",""),
	//			"title" : data.rslt.new_name
	//		},
	//		function (r) {
	//			if(!r.status) {
	//				$.jstree.rollback(data.rlbk);
	//			}
	//		}
	//	);
	//})
	//.bind("move_node.jstree", function (e, data) {
	//	data.rslt.o.each(function (i) {
	//		$.ajax({
	//			async : false,
	//			type: 'POST',
	//			url: "./server.php",
	//			data : {
	//				"operation" : "move_node",
	//				"id" : $(this).attr("id").replace("node_",""),
	//				"ref" : data.rslt.cr === -1 ? 1 : data.rslt.np.attr("id").replace("node_",""),
	//				"position" : data.rslt.cp + i,
	//				"title" : data.rslt.name,
	//				"copy" : data.rslt.cy ? 1 : 0
	//			},
	//			success : function (r) {
	//				if(!r.status) {
	//					$.jstree.rollback(data.rlbk);
	//				}
	//				else {
	//					$(data.rslt.oc).attr("id", "node_" + r.id);
	//					if(data.rslt.cy && $(data.rslt.oc).children("UL").length) {
	//						data.inst.refresh(data.inst._get_parent(data.rslt.oc));
	//					}
	//				}
	//				$("#analyze").click();
	//			}
	//		});
	//	});
	//});

});
</script>
<script type="text/javascript" class="source below">
// Code for the menu buttons
//$(function () {
//	$("#mmenu input").click(function () {
//		switch(this.id) {
//			case "add_default":
//			case "add_folder":
//				$("#demo").jstree("create", null, "last", { "attr" : { "rel" : this.id.toString().replace("add_", "") } });
//				break;
//			case "search":
//				$("#demo").jstree("search", document.getElementById("text").value);
//				break;
//			case "text": break;
//			default:
//				$("#demo").jstree(this.id);
//				break;
//		}
//	});
//});
</script>
</div>


    </div>
</div>
