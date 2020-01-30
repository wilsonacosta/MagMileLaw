{include file="header.tpl"}
<style type="text/css">{literal}.table_edit {border-right: 0px;}{/literal}</style>
<a class="green submenu_item" href="index.php?page=category_add"><i class="ss-icon">plus</i> New category</a>

<table class="table table_header">
	<tr>
		<td class="table_name"><b>Name</b></td>
		<td class="table_edit"><b>Edit</b></td>
	</tr>
</table>

<ul id="sortable">
	{section name=categories loop=$categories}
		<li class="list_item" id="{$categories[categories]['id']}">
			<table class="table">
				<tr>
					<td class="table_name">{$categories[categories]['name']}</td>
					<td class="table_edit">
						<a href="index.php?page=category_delete&id={$categories[categories]['id']}" class="delete_button"></a>
						<a href="index.php?page=category_edit&id={$categories[categories]['id']}"   class="edit_button"></a>
					</td>
				</tr>
			</table>
		</li>
	{/section} 
</ul>

</div>

</body>
</html>
