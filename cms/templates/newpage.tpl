{include file="header.tpl"}  

<div id="title_edit">{$e_name_encoded|default:''}</div>
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="" method="POST">
    <div class="wc_content"><input type="text" class="inputt" name="e_title" value="{$e_title|default:''}" placeholder="Page Title"/></div>
    <br/><br/><br/>
    <div class="wc_content"><textarea name="e_content">{$e_content|default:''}</textarea></div>
    <div class="wc_header"><input type="submit" class="green_button" value="Publish this page"></div>
    </form>
</div>


</div>
</body>
</html>
