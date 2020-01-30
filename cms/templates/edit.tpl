{include file="header.tpl"}  

{if $acl_role_admin == true or $acl_role_editor == true }
<div id="title_edit">Paste in your site: <span class="blue"><i>{$e_name_encoded}</i></span></div>{/if}
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="" method="POST">
    <div class="wc_content"><input type="text" class="inputt" name="e_title" value="{$e_title}"/></div><br/><br/><br/>
    <div class="wc_content"><textarea name="e_content">{$e_content}</textarea></div>
    <div class="wc_header"><input type="submit" class="green_button" value="Publish {$e_title}"></div>
    </form>
</div>


</div>
</body>
</html>
