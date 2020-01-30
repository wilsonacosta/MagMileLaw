{include file="header.tpl"}  

<div id="title_edit">Edit a category: {$e_category_name}</div>
<div id="wc">
		<div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
		<form action="index.php?page=category_edit" method="POST">
				<div class="wc_content"><input type="text" name="e_category_name" value="{$e_category_name}" placeholder="Name"/></div><br/><br/><br/>
				<div class="wc_header"><input type="submit" class="green_button" value="Edit {$e_category_name}"></div>
				
				<input type="hidden" name="id" value="{$e_category_id}" />
		</form>
</div>


</div>
</body>
</html>
