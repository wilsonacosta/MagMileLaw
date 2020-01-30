<?php
error_reporting(0);
require('cms/libs/redbean.php');
require('config.php');

if (!$mysqliConnection) {
    echo 'Oh oh, database connection failed. If you have installed Dropkick already, check your settings in config.php.<br/> Otherwise, browse to the install folder.';
}

function getter($get) {
    if (!file_exists($get)) {
        echo 'Could not find ' . $get . ' in this folder';
    } else {
        $explode = explode('.', $get);

        if ($explode[1] == "php") {
            ob_start();
            include($get);
            $html = ob_get_clean();
        } else {
            $html = file_get_contents($get);
        }

        preg_match_all("|<\!--\{[^>]+\}-->|U", $html, $tags);
        foreach ($tags[0] as $k => $v) {
            $tag_id = str_replace("<!--{", "", str_replace("}-->", "", $v));
            $data = R::getRow("SELECT * FROM divs WHERE name_encoded = '" . $tag_id . "' AND active = TRUE");
            $html = str_replace($v, stripslashes(htmlspecialchars_decode(html_entity_decode($data['content']))), $html); 
        }
        echo $html;
    }
}

if (empty($_GET['page'])) {
    if (file_exists('index.html')) {
        $get = 'index.html';
        getter($get);
    } else {
        if (file_exists('index.php')) {
            $get = 'index.php';
            getter($get);
        } else {
            echo 'Please put an index.html in your root';
        }
    }
} else {
    getter($_GET['page']);
}
?>