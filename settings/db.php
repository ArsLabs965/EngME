<?php
//Функция подключения к БД. данные: ip, login, password, name_db
   function connect(){
    return mysqli_connect('127.0.0.1', 'root', 'database0422!', 'engme');
}
?>