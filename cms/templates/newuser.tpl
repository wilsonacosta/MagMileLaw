{include file="header.tpl"}  

<div id="title_edit">New user</div>
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="" method="POST">
        <div class="wc_content"><input type="text" name="e_username" value="{$e_username|default:''}" placeholder="Username"/></div><br/><br/><br/>
        <div class="wc_content"><input type="text" name="e_email"    value="{$e_email|default:''}"    placeholder="Email"/></div><br/><br/><br/>
        <div class="wc_content"><input type="password" name="e_password" placeholder="Password"/></div><br/><br/><br/>
        <div class="wc_content"><input type="password" name="e_password2" placeholder="Retype Password"/></div>
        <div class="wc_content"><br/><br/><br/>
            <select name="e_rights">
                <option value="Admin"  {$e_admin|default:''}>Admin</option>
                <option value="Editor" {$e_editor|default:''}>Editor</option>
                <option value="User"   {$e_user|default:''}>User</option>
            </select> 
        </div>
        <div class="wc_header"><input type="submit" class="green_button" value="Save"></div>
    </form>
</div>


</div>
</body>
</html>
