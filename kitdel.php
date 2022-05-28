<?php
      session_start();
      include "settings/rootway.php";
  if($_SESSION['user'] == NULL){
      header(rootway());
      exit();
  }
  
  //Подключение к Базе данных
  include "settings/db.php";
  $connection = connect();

  $kit = mysqli_real_escape_string($connection, $_GET['kit']);
  $query = mysqli_query($connection, "SELECT * FROM `kits` WHERE `id` = '$kit'");
            if(($ki = mysqli_fetch_assoc($query))){
                if($ki['whos'] == $_SESSION['user']){
                    mysqli_query($connection, "DELETE FROM `kits` WHERE `id` = '$kit'");
                    header(rootway() . 'kits.php');
                }
            }else{
                exit();
            }
?>
