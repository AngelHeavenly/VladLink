<?php
//require_once('dbconnect.php');

//$json = json_decode(file_get_contents('categories.json'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//var_dump($json[0]);
//echo $json. "<br>";
/*foreach($json as $arr)
{
    foreach($arr['childrens'] as $childrens)
    {
        //echo "<br> {$arr['id']}, {$arr['name']}, {$arr['childrens']}, {$arr['alias']}<br>";
        //echo "<br> {$arr['id']}, {$arr['name']}, {$childrens['id']}, {$childrens['name']}, {$childrens['childrens']}, {$childrens['alias']}, {$arr['alias']}<br>";
        if(empty($childrens['childrens']) === false)
        {
        foreach($childrens['childrens'] as $connect)
        {
            echo "<br> {$arr['id']}, {$arr['name']}, {$arr['alias']},<br>
            {$childrens['id']}, {$childrens['name']}, {$childrens['childrens']}, {$childrens['alias']},<br>
                {$connect['id']}, {$connect['name']}, {$connect['childrens']}, {$connect['alias']} <br>";
        }
    }
    else
    {
        echo "<br>
        <ul>
        <li>{$arr['id']}, {$arr['name']} /{$arr['alias']}</li> 
        <li>{$childrens['id']}, {$childrens['name']}/{$childrens['alias']}</li>
        </ul><br>";
    }
   }
   */
  function mysql_to_connect(){
    //соединение с БД
    $mysqli = mysqli_connect("localhost", "root", "DtK1py0PnPdRZd[k", "categories");
    if (mysqli_connect_errno($mysqli))
    { echo "Не удалось подключиться к серверу MySQL: " . mysqli_connect_error(). " "; }
    //else { echo "Mysql connect!"; }
    return $mysqli;
  }

function get_json($json) {
    //Декодирование и отображение 

    echo "<ul>";
    foreach($json as $arr) {
        echo "<li>{$arr['name']} /{$arr['alias']}</li>";

        if(empty($arr['childrens'])==false){
            foreach($arr['childrens'] as $childrens) {
            echo "
                    <ul>
                    <li>{$childrens['name']} /{$arr['alias']}/{$childrens['alias']}</li>
                    </ul>";
            if(empty($childrens['childrens'])==false){
                foreach($childrens['childrens'] as $connect) {
            $query =   "
                INSERT INTO `catalog` ( `name`, `childrens`, `alias`)
                VALUES ('".$arr["name"]."','".$childrens["name"]."','".$arr["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$arr["name"]."';
                INSERT INTO `second_advent` ( `name`, `childrens`, `alias`)
                VALUES ('".$childrens["name"]."','".$childrens["childrens"]."','".$childrens["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$childrens["name"]."';
                INSERT INTO `third_advent` ( `name`, `childrens`, `alias`)
                VALUES ('".$connect["name"]."','".$connect["childrens"]."','".$connect["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$connect["name"]."';";
                echo "
                        <ul>
                        <ul><li>{$connect['name']} /{$arr['alias']}/{$childrens['alias']}/{$connect['alias']}</li></ul>
                        </ul>";
                
                //mysql_import($query); 
            } }
            $query.=   "
                INSERT INTO `catalog` ( `name`, `childrens`, `alias`)
                VALUES ('".$arr["name"]."','".$childrens["name"]."','".$arr["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$arr["name"]."';
                INSERT INTO `second_advent` ( `name`, `childrens`, `alias`)
                VALUES ('".$childrens["name"]."','".$childrens["childrens"]."','".$childrens["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$childrens["name"]."';";
                //mysql_import($query); 
            } } } 

    echo "</ul>";
    return 0;
}




function mysql_import($query) {
    //подключение и ввод данных в бд
    $mysqli =& mysql_to_connect();
    if(mysqli_multi_query($mysqli, $query)==false)
    { echo "<br>Get error!  (". mysqli_errno($mysqli). ")" .mysqli_error($mysqli)."<br>"; }
    //else { echo "<br> В таблицах введены новые данные! <br>"; }

    //Оставил для отладки и проверки реализации запроса. Порой бывают странные случаи, когда запрос вроде бы прошёл, но в БД записей нет
    mysqli_close($mysqli); 
    /*
    Неплохо было бы ещё и экранировать запрос от лишних символов, но для ТЗ это избыточно. 
    В реальном проекте здесь была бы брешь. А именно SQL-инъекция. Когда злоумышленник может вставить в переменную запрос SQL
    */
    return 0;}
    
function mysql_export() {
        //подключение и экспорт данных в бд
        $mysqli =& mysql_to_connect();
        $query =   "SELECT `name`, `alias` FROM `catalog` JOIN `second_advent` ";
        $query_2 = "SELECT `name`, `alias` FROM `second_advent`;";
        $query_3 = "SELECT `name`, `alias` FROM `third_advent`;";

        if ($result=mysqli_query($mysqli, $query)) 
        {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "{$row['name']} /{$row['alias']}<br>"; 
            }
        }
        else { echo "<br>Get error!  (". mysqli_errno($mysqli). ")" .mysqli_error($mysqli)."<br>"; }
        mysqli_close($mysqli); 
        return 0; }

/*function view_json($arr, $childrens, $connect) {
    if(empty($connect)){return;}
    echo "<ul>";
    while($arr!=null)
    {
        echo "<li>{$arr['name']} /{$arr['alias']}
                <li>{$childrens['name']} /{$arr['alias']}/{$childrens['alias']}</li>
                    <li>{$connect['name']} /{$arr['alias']}/{$childrens['alias']}/{$connect['alias']}</li>
              </li>";
    }
    echo "</ul>";
   
    }*/
   
   
    //$query =   "INSERT INTO `catalog` (`id`, `name`, `childrens`, `alias`) 
    //VALUES ('".$arr['id']."','".$arr['name']."','".$arr['childrens']."','".$arr['alias']."')";
//if ($res = mysqli_query($mysqli, $query))
//{
   // echo $res;
//}
//else
//{
   //echo "Get error!  (". mysqli_errno($mysqli). ")" .mysqli_error($mysqli)."<br>";
//}
//}
//mysqli_close($mysqli);
?>