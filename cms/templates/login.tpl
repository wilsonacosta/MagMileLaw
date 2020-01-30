{include file="header_login.tpl"}  
<style>
#header {
  max-width: 100%;
  padding-top: 50px;
  text-align: center;
}
#container {
  padding-top: 0px;
  margin-top: 0px;
  max-width: 100%;
}
input#email, input#username, input#password {
  width: 100%;
}
#wc_login {
  width: 275px;
}
</style>
<div id="wc_login">
    <div class="wc_header"><div class="error">{$error|default:''}</div><div class="good">{$e_good|default:''}</div></div>
    <form id="login" action="" method="POST">
    <div class="wc_content">
        <input type="text" name="username" id="username" placeholder="Username" value="{$username|default:''}"/><br/><br/><br/>
        <input type="password" id="password" placeholder="Password"/><br/><br/>
        <input type="hidden" id="hash_password" name="password"/><br/><br/>
        <input type="submit" class="green_button" value="Login">
        <br/><br/><br/><a href="index.php?page=forgot" class="left">Forgot your password?</a>
    </div>
    </form>
</div>


</div>
</body>
</html>
