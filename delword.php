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
  $word = mysqli_real_escape_string($connection, $_GET['word']);
  $query = mysqli_query($connection, "SELECT * FROM `kits` WHERE `id` = '$kit'");
            if(($ki = mysqli_fetch_assoc($query))){
                if($ki['whos'] == $_SESSION['user']){
                    $query = mysqli_query($connection, "SELECT * FROM `words` WHERE `id` = '$word'");
            if(($kis = mysqli_fetch_assoc($query))){
                if($kis['kit'] == $kit){
                mysqli_query($connection, "DELETE FROM `words` WHERE `id` = '$word'");
                header(rootway() . 'words.php?kit=' . $kit);
                }
            }
                    
                }
            }else{
                exit();
            }
?>
