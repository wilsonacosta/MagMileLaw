{include file="header.tpl"}

<a class="green submenu_item" href="index.php?page=newuser"><i class="ss-icon">plus</i> New user</a>

<table class="table table_header">
    <tr>
        <td class="table_title"><b>Username</b></td>
        <td class="table_content"><b>Email</b></td>
        <td class="table_mod"><b>Last signed in</b></td>
        <td class="table_code"><b>Rights</b></td>
        <td class="table_edit"><b>Edit</b></td>
        <td class="table_active"><b>Active</b></td>
    </tr>
</table>

<ul id="sortable">
    {section name=users loop=$users}
        <li class="list_item" id="{$users[users]['id']}">
            <table class="table">
                <tr>
                    <td class="table_title">{$users[users]['username']}</td>
                    <td class="table_content">{$users[users]['email']}</td>
                    <td class="table_mod">{$users[users]['date']}</td>
                    <td class="table_code">{$users[users]['function']}</td>
                    <td class="table_edit"><div class="delete_button delete_user" id="{$users[users]['id']}"></div><a href="index.php?page=edit_users&editID={$users[users]['id']}" class="edit_button" id="{$users[users]['id']}"></a></td>
                    <td class="table_active"><input type="checkbox" id="{$users[users]['id']}" class="active_user_check" name="active_check" {$users[users]['active']}></td>
                </tr>
            </table>
        </li>
    {/section} 
</ul>

</div>

</body>
</html>
