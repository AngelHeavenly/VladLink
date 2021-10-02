<?php
require_once('Json_decode.php');
header("Content-Type:text/html;charset=utf8");
$json = json_decode(file_get_contents('categories.json'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//get_json($json);
echo '<div style="width:400px;float:left; padding:10px; border:1px solid #074776">';
get_json($json);
//view_json($arr, $childrens, $connect);
//mysql_import($arr, $childrens, $connect, $value);
//mysql_import();
mysql_export();
echo '</div><br>';
//var_dump(get_json($json));
//mysql_send($mysqli, $arr, $childrens, $connect);
//mysql_connect();

?>