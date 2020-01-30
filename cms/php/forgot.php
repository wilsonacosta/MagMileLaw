<?php
if (isset($_POST['email'])) {
    $email = addslashes($_POST['email']);    
    if (check_email_address($email ) == false) {
        $smarty->assign('error', "Please fill in a valid email address");
    }
    else {
        $check = R::getRow("SELECT * FROM users WHERE email = '" . $email . "'");
        if (empty($check)) {
            $smarty->assign('error', "Sorry, we don't know this email address");
        }
        else {
            $smarty->assign('good', "An email with further instructions has been sent to " .$email);
            
            $domain = str_replace("www.", "", $_SERVER['SERVER_NAME']);
            $token = hash("sha256", $domain . time() . $check['username'] . uniqid());
            $link = $_SERVER['SERVER_NAME'] . str_replace('forgot', 'reset', $_SERVER['REQUEST_URI']) . '&token=' . $token;

            R::exec("UPDATE users SET request_token = '" . $token . "', request_time = " . time(). " WHERE id = " . $check['id']);
            
            $to      = $email;
            $subject = 'New password request';
            $message = '
            <html>
            <head>
              <title>New password request</title>
            </head>
            <body>
            <p>Hello ' . $check['username'] . ',<br/><br/>
            You have requested a new CMS password. Click on the following link to reset your password<br/><br/>
            <a href="' . $link . '">' . $link . '</a>
            <br/><br/>
            Kind regards,<br/><br/>
            CMS, ' . $domain . '
            </body>
            </html>';
            $headers = 'From: no-reply@' . $domain . "\r\n" .
                'Reply-To: no-reply@' . $domain. "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            mail($to, $subject, $message, $headers);
            
        }
    }
}


$smarty->display('templates/forgot.tpl');

?>