{include file="header.tpl"}

<article class="pages">
	{if $acl_role_admin or $acl_role_editor == true }
		<p>
			<a class="green submenu_item" href="index.php?page=newpage"><i class="ss-icon">plus</i> New page</a>
		</p>
	{/if}
	
	<br />
	<br />
	<br />
				
	<table class="table table_header">
			<tr>
					<td class="table_title"><b>Title</b></td>
					<td class="table_content"><b>Content</b></td>
					<td class="table_mod"><b>Last modified</b></td>
					{if $acl_role_admin == true or $acl_role_editor == true }
						<td class="table_code"><b>Paste in your site</b></td>
					{/if}
					<td class="table_edit"><b>Edit</b></td>
					<td class="table_active"><b>Active</b></td>
			</tr>
	</table>
	
	<ul class="categories">
		{foreach $categories as $cat}
			<li class="droppable"  data-category_id="{$cat['id']}">
				<h3>{$cat['name']}</h3>
				
				<ul class="page_list">
						{foreach $cat['pages'] as $page}
								<li class="draggable_page ui-widget-content" data-category_id="{$cat['id']}" data-page_id="{$page['id']}">
										<table class="table">
												<tr>
														<td class="table_title">{$page['name']}</td>
														<td class="table_content">{$page['content']}</td>
														<td class="table_mod">{$page['date']}</td>
														{if $acl_role_admin == true or $acl_role_editor == true }
															<td class="table_code"><span class="blue"><i>{$page['code']}</i></span></td>
														{/if}
														<td class="table_edit">
															{if $acl_role_admin == true }
																<div class="delete_button delete_div" id="{$page['id']}"></div>
															{/if}
															<a href="index.php?page=edit&editID={$page['id']}" class="edit_button" id="{$page['id']}"></a>
														</td>
														<td class="table_active"><input type="checkbox" id="{$page['id']}" class="active_check" name="active_check" {$page['active']}></td>
												</tr>
										</table>
								</li>
						{/foreach} 
				</ul>
			</li>
		{/foreach}
	<ul>
	
	<script type="text/javascript" src="js/page/pages.js"></script>
	
	
</article>

</div>

</body>
</html>
