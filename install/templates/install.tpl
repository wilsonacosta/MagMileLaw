{include file="header.tpl"}  

<div id="wc">
    <form action="" method="POST">
        <div class="wc_header">
            <h1>Welcome to Dropkick CMS</h1>
        </div>
        <div class="wc_content">
            <p><b>Let's get started and install this badboy.</b> <br/><br/>Database config check:</p>
            <div class="error">{$e_error|default:''}</div><div class="good">{$e_good|default:''}</div>
        </div>
        <div class="wc_content">
            <br/><br/>Create an admin account below.
            <form action="" method="POST">
                <div class="wc_header">Username</div>
                <div class="wc_content"><input type="text" name="e_username" value="{$e_username|default:''}"/></div>
                <div class="wc_header">Email</div>
                <div class="wc_content"><input type="text" name="e_email" value="{$e_email|default:''}"/></div>
                <div class="wc_header">Password</div>
                <div class="wc_content"><input type="password" name="e_password"/></div>
                <div class="wc_header">Retype Password</div>
                <div class="wc_content"><input type="password" name="e_password2"/></div>
                <br/><br/>
                <input type="submit" class="green_button next" value="Next">
                </div>
            </form>
        </div>
        </body>
        </html>
