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
    <div class="wc_header"><div class="error">{$error|default:''}</div><div class="good">{$good|default:''}</div></div>
    <form id="login" action="" method="POST">
    <div class="wc_content">
        <input type="text" name="email" id="email" placeholder="youremail@domain.com"/><br/><br/>
        <input type="submit" class="red_button" value="Send new password">
    </div>
    </form>
</div>


</div>
</body>
</html>
