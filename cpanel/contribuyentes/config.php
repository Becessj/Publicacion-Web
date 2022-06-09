<?php 
$db_server = 'localhost'; 
$db_name = 'exviskcj_publicacion'; 
$db_user = 'exviskcj_publicacion'; 
$db_password = 'aYR8J^MI^yn#'; 
$no_of_records_per_page = 20; 

$link = mysqli_connect($db_server, $db_user, $db_password, $db_name); 
$query = "SHOW VARIABLES LIKE 'character_set_database'";
if ($result = mysqli_query($link, $query)) {
    while ($row = mysqli_fetch_row($result)) {
        if (!$link->set_charset($row[1])) {
            printf("Error loading character set $row[1]: %s\n", $link->error);
            exit();
        } else {
            // printf("Current character set: %s", $link->character_set_name());
        }
    }
}

?>