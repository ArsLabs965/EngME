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

            }else{
                exit();
            }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Учим слова</title>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            <img src="img/logo.png" width="100px" alt="">
        </div>
        <div class="menu" style="float: left;">
            <a href="kits.php">На главную</a>
        </div>
        <?php
            if($ki['whos'] == $_SESSION['user']){
                ?>
                    <div class="menu" style="float: left;">
            <a href="words.php?kit=<?php echo $kit; ?>">Настройки слов</a>
        </div>
        <div class="menu" style="float: left;">
            <a href="kitdel.php?kit=<?php echo $kit; ?>">Удалить этот набор</a>
        </div>
                <?php
            }
        ?>

        <div class="out" style="float: right;">
           <a href="out.php">Выйти</a>
        </div>
    
    </div>
  
   <div class="center">
        <h1><?php echo $ki['name']; ?></h1>
        <br><br>
        <div class="line">
            Как это переводится?
        <div class="word">
            Тестовое слово
        </div>
        <br>
        <br>
        Варианты ответа
        <div class="var">
            This
        </div>
        <div class="var">
           that
        </div>
        <div class="var">
            or it
        </div>
        </div>
   </div>

</body>
</html>