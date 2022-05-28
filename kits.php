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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Наборы слов</title>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            <img src="img/logo.png" width="100px" alt="">
        </div>
        <div class="menu" style="float: left;">
            <a href="addkit.php">Добавить набор карточек</a>
        </div>

        <div class="out" style="float: right;">
           <a href="out.php">Выйти</a>
        </div>
    
    </div>
    <div class="content">
        <?php
            $query = mysqli_query($connection, "SELECT * FROM `kits` WHERE `whos` = '$_SESSION[user]'");
            while(($query_clear = mysqli_fetch_assoc($query))){
                ?>
                    <div class="kit">
                        <a href="learn.php?kit=<?php echo $query_clear['id']; ?>"><?php echo $query_clear['name']; ?></a>
                    </div>
                <?php
            }
        ?>  
    </div>

</body>
</html>