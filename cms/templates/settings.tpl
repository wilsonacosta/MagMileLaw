{include file="header.tpl"}  

<div id="title_edit">CMS Settings</div>
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="wc_content setting_img"><img src="img/user_img/{$logo}" alt="CMS"/></div>
        
        <div class="wc_header">Change logo:</div><br/>
        <div class="wc_content"><input type="file" name="logo"></div>
        
        <div class="wc_header"><input type="submit" class="green_button" value="Save"> <br/><br/>
        <br/><br/><div class="red_button nrmr reset_settings">RESET</div></div>
    </form>
</div>


</div>
</body>
</html>
