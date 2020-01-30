{include file="header.tpl"}  

<div id="title_edit">My account</div>
<div id="wc">
    <div class="wc_header"><div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form action="" method="POST">
        <div class="wc_content"><input type="text" name="e_username" value="{$e_username}" placeholder="username"/></div><br/><br/>
        <div class="wc_content"><input type="text" name="e_email" value="{$e_email}" placeholder="email"/></div><br/><br/>
        <div class="wc_content"><input type="password" name="e_password" placeholder="Password"/></div><br/><br/>
        <div class="wc_content"><input type="password" name="e_password2" placeholder="Retype Password"/></div><br/><br/>
        <div class="wc_header"><input type="submit" class="green_button" value="Save"></div>
    </form>
</div>


</div>
</body>
</html>
