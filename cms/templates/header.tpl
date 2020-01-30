<!DOCTYPE html>
<html>
    <head>
        <title>Edit your site</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1">
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/fonts/ss-standard.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
        {literal}
            <script type="text/javascript">
        $( document ).ready(function() {
        		
        		//some basic configs
        		window.dropkick_cms_app = {"config": {}};
        		window.dropkick_cms_app.config.base_path = document.location.pathname.replace( '/index.php', '');
        		window.dropkick_cms_app.config.base_url  = document.location.protocol + '//' + document.location.host + window.dropkick_cms_app.config.base_path;
        		
            //setup tinyMCE
            tinymce.init({
								selector: "textarea",
								plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste jbimages responsivefilemanager",
									"textcolor colorpicker"
								],
								
								toolbar1:  "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media responsivefilemanager",
								toolbar2: "fontselect | fontsizeselect | forecolor backcolor",
								
								relative_urls: false,


                force_p_newlines : false,
                height : 300,
                
                //font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                
                
                //responsive filemanager related
                external_filemanager_path: (window.dropkick_cms_app.config.base_path + "/../filemanager/"),
                filemanager_title:         "Responsive Filemanager" ,
                filemanager_access_key:"QFRKKN3tZL2fFStM" ,
                external_plugins:          { "filemanager" : (window.dropkick_cms_app.config.base_path + "/../filemanager/plugin.min.js")}
            });
                
            function NOK(data) {
                if (data.status == "NOK") {
                    $('#dialog').attr("title", "Error");
                    $('#dialog').html(data.message);
                    $( "#dialog" ).dialog({ 
                        buttons: [ { text: "OK", click: function() { location.reload(); } } ] 
                    });    
                };
            };            
             
            $('.delete_div').click(function() {
                var id = $(this).attr("id");
                $.post("libs/ajax.php", { "action": "pageinfo", "id":id },
                function(data){
                    if (data.status == "OK") {
                    $('#dialog').attr("title", "Delete page");
                    $('#dialog').html("Are you sure you want to delete \'" + data.name + "\'?");
                    $( "#dialog" ).dialog({ 
                        buttons: [ {text: "Ok", click: function() { 
                           $.post("libs/ajax.php", { "action": "deletepage", "id":id },
                            function(data2){
                                    if (data2.status == "OK") {
                                        $("#" + id + ".list_item").slideUp();
                                        $("#dialog").dialog( "close" );
                                    };
                                   NOK(data2);        
                            }, "json");    
                                } 
                            }, { text: "Cancel", click: function() { $( this ).dialog( "close" ); } } ] 
                    });
                        }
                    NOK(data);
                }, "json");
            });
                
                $('.delete_user').click(function() {
                var id = $(this).attr("id");
                $.post("libs/ajax.php", { "action": "userinfo", "id":id },
                function(data){
                    if (data.status == "OK") {
                        $('#dialog').attr("title", "Delete user");
                        $('#dialog').html("Are you sure you want to delete \'" + data.name + "\'?");
                        $( "#dialog" ).dialog({ 
                            buttons: [ {text: "Ok", click: function() { 
                                        $.post("libs/ajax.php", { "action": "deleteuser", "id":id },
                                        function(data2){
                                            if (data2.status == "OK") {
                                                $("#" + id + ".list_item").slideUp();
                                                $("#dialog").dialog( "close" );
                                            };
                                            NOK(data2);     
                                        }, "json");    
                                    } 
                                }, { text: "Cancel", click: function() { $( this ).dialog( "close" ); } } ] 
                        });
                    }
                    NOK(data);    
                }, "json");
            });
                
            $('.active_check').click(function() {
                var id = $(this).attr("id");
                $.post("libs/ajax.php", { "action": "activate", "id":id }, "json");
            });
                
             $('.active_user_check').click(function() {
                var id = $(this).attr("id");
                $.post("libs/ajax.php", { "action": "activate_user", "id":id }, function(data){NOK(data)}, "json");
            });
                
             $('.reset_settings').click(function() {
                var id = $(this).attr("id");
                $.post("libs/ajax.php", { "action": "reset_settings"}, function(data){
                    if (data.status == "OK") {
                        location.reload();
                        }
                    NOK(data);
            }, "json");
            });
        });
            </script>
        {/literal}
    </head>
    <body>
        <div id="header"><a href="index.php"><img src="img/user_img/{$logo}" alt="CMS"/></a></div>
            {$imp_message}
        <div id="container">

            <div id="menu">
                {section name=menu loop=$menu}
                	{if (($menu[menu]['rights'] == 'All') || (($menu[menu]['rights'] == 'Admin') && ($acl_role_admin == true)))}
                    <a class="menu_item {$menu[menu]['active']|default:""}" href="index.php?page={$menu[menu]['name_encoded']}"><img src="img/{$menu[menu]['name_encoded']}.png" alt="{$menu[menu]['title']}" /> </a>
                   {/if}
                {/section}
                
                <div class="blue right smallfont">
                	<span class="avatar"><img src="{gravatar email="{$e_email_grav}"}"></span>
                </div>
                <a class="menu_item right" href="index.php?page=logout"><img src="img/logout.png" alt="Logout"/></a>
                 <a class="menu_item right" href="../" target="_blank"><img src="img/view.png" alt="View Site"/></a> 
            </div>

            <div id="dialog" title=""></div>