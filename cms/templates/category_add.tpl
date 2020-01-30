{include file="header.tpl"}  

<div id="title_edit">Add a category</div>
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="index.php?page=category_add" method="POST">
        <div class="wc_content"><input type="text" name="e_category_name" value="{$e_category_name}" placeholder="Name"/></div><br/><br/><br/>
        <div class="wc_content">
        <div class="wc_header"><input type="submit" class="green_button" value="Add"></div>
    </form>
</div>


</div>
</body>
</html>
