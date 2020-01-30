<!DOCTYPE html>
<html>
    <head>
        <title>Login to your CMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1">
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="js/sha256.js"></script>
        {literal}
            <script type="text/javascript">
        $( document ).ready(function() {
            $('#login').submit(function() {
               var password = $('#password').val();
               var hashPw = CryptoJS.SHA256(password);
               $('#hash_password').val(hashPw);
             });                
        });
            </script>
        {/literal}
    </head>
    <body>
        <div id="header"><a href="index.php"><img src="img/user_img/{$logo}" alt="CMS"/></a></div>
        <div id="container">

