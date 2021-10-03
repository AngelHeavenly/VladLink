<?php
require_once('Json_decode.php');
header("Content-Type:text/html;charset=utf8");
$json = json_decode(file_get_contents('categories.json'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo '<div style="width:400px;float:left; padding:10px; border:1px solid #074776">';
get_json($json);
mysql_export();
echo '</div><br>';

?>
