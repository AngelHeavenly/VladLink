<?php
/* Имеющиеся функции: mysql_to_connect() - подключение к БД
* get_json($json) - на входе требует JSON данные. Обрабатывает JSON данные и формирует запрос.
* mysql_import($query) - Импорт в Базу данных. Использует запрос формируемый в функции get_json($json)
* mysql_export() - экспорт значений из Базы данных. Тут же формирует желаемый результат в два файла.
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
                
                mysql_import($query); 
            } }
            $query.=   "
                INSERT INTO `catalog` ( `name`, `childrens`, `alias`)
                VALUES ('".$arr["name"]."','".$childrens["name"]."','".$arr["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$arr["name"]."';
                INSERT INTO `second_advent` ( `name`, `childrens`, `alias`)
                VALUES ('".$childrens["name"]."','".$childrens["childrens"]."','".$childrens["alias"]."') ON DUPLICATE KEY UPDATE `name`='".$childrens["name"]."';";
                mysql_import($query); 

                /* В случае если данных для третьей таблицы нет, то будет хотя бы такой запрос. Он дозаполнит оставшиеся таблицы до конца.
                * Пока у меня нет представления как правильно делать таблицы имеющие дочерние таблицы.
                * Это было бы проще если бы у каждой таблицы был дополнительный id, который бы показал, что, например "catalog" имеет дочернюю таблицу "second_advent" и в таблице "catalog"
                * имелся бы id_parent (по умолчанию NULL) со значением связуемой таблицы. Т.е. следующего вида Таблица "catalog" со столбцами `id`, `id_parent`, `name`, `alias` и таблица "second_advent" со стобцами `id`, `name`,`alias`,
                * где `catalog.id_parent` = `second_advent.id`. А это значит, у "second_advent" было бы несколько id которые имеют например id=1, name=создание, id=1, name=Список, id=1, name=Поиск . 
                * То в id_parent = 1, которые будут иметь не только Создание, но и Список, и Поиск, т.к. у них id = 1 и так с остальными таблицами, которые имели бы дочерние записи.
                * Если это было бы так, то запрос был примерно следующего вида 
                * INSERT INTO `catalog` ( `name`, `childrens`, `alias`)
                * VALUES ('".$arr["name"]."','".$childrens["name"]."','".$arr["alias"]."')
                * JOIN `second_advent` WHERE `catalog.id_parent` = `second_advent.id`;
                * Не совсем уверен что такой запрос правильный, потому привёл примерный запрос, который может сработать.
                * Если бы имелся именно дополнительный id_parent, то не нужно было бы использовать "ON DUPLICATE KEY UPDATE `name`='..."
                * Поскольку потребуется лишь сгруппировать необходимые значения.
                */
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
    Неплохо было бы ещё и экранировать запросы от лишних символов, но для ТЗ это избыточно. 
    В реальном проекте здесь была бы брешь. А именно SQL-инъекция. Когда злоумышленник может вставить в переменную запрос SQL
    */
    return 0;}
    
function mysql_export() {
        //подключение и экспорт данных в бд
        $mysqli =& mysql_to_connect();
        $query =   "SELECT catalog.id, catalog.name, catalog.alias, second_advent.name AS name_2, second_advent.alias AS alias_2 FROM `catalog` 
        JOIN `second_advent`
        JOIN `third_advent`";
        /*$query_2 = "SELECT catalog.id, catalog.name, catalog.alias, second_advent.name, second_advent.alias FROM `catalog` 
        * JOIN `second_advent` WHERE catalog.id_parent = second_advent.id
        * JOIN `third_advent` WHERE second_advent.id_parent = third_advent.id";
        * $query_2 был бы предпочтительный запрос, будь мы имея всё тот же id_parent в categories.json
        */

        if ($result=mysqli_query($mysqli, $query)) 
        {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "{$row['name']} /{$row['alias']}<br>";
                //Здесь из-за неверно составленной таблицы будет очень много дубликатов. Что нежелательно для реального проекта.
            }
        }
        else { echo "<br>Get error!  (". mysqli_errno($mysqli). ")" .mysqli_error($mysqli)."<br>"; }
        mysqli_close($mysqli); 
        return 0; 
    /* Учитывая, что не могу правильно определить таблицы при декодировании JSON
    * В этой функции должен быть код примерно следующего вида:
    * if ($result=mysqli_query($mysqli, $query)) 
        {
            while ($row = mysqli_fetch_assoc($result)) {
               $Value[] = "{$row['catalog'.'name']} /{$row['catalog'.'alias']}<br>
                    {$row['second_advent'.'name']} /{$row['catalog'.'alias']}/{$row['second_advent'.'alias']}<br>
                    {$row['third_advent'.'name']} /{$row['catalog'.'alias']}/{$row['second_advent'.'alias']}/{$row['third_advent'.'alias']}<br>"; 
                $str = implode("\n", $Value);
                file_put_contents('data.txt', '$str', FILE_APPEND);
            }
            
        }
    */
    }


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
