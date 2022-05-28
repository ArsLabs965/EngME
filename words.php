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
                }else{
                    exit();
                }
            }else{
                exit();
            }
            $err = 0; //Сбор ошибок при анализе формы
            if(isset($_POST['btn'])){
        
                //Зачистка от инбекций
                $ru = mysqli_real_escape_string($connection, $_POST['ru']);
                $en = mysqli_real_escape_string($connection, $_POST['en']);
        
                if($ru != "" AND $en != ""){
                    $query = mysqli_query($connection, "SELECT * FROM `words` WHERE `eng` = '$en'");
                    if(!($query_clear = mysqli_fetch_assoc($query))){
                        $query = mysqli_query($connection, "SELECT * FROM `words` WHERE `rus` = '$ru'");
                    if(!($query_clear = mysqli_fetch_assoc($query))){
                        mysqli_query($connection, "INSERT INTO `words` (`kit`, `rus`, `eng`) VALUES ('$kit', '$ru', '$en')");  
                        $ru = '';
                        $en = '';
                    }else{
                        $err = 4; //Неверен логин или пароль
                    }
                        
                    }else{
                        $err = 4; //Неверен логин или пароль
                    }
                }else{
                    $err = 1; //Есть незаполненные поля
                }
            }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Управление словами</title>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            <img src="img/logo.png" width="100px" alt="">
        </div>
        <div class="menu" style="float: left;">
            <a href="kits.php">На главную</a>
        </div>
        <div class="menu" style="float: left;">
            <a href="learn.php?kit=<?php echo $kit; ?>">Назад</a>
        </div>
        
        <div class="out" style="float: right;">
           <a href="out.php">Выйти</a>
        </div>
    
    </div>
  
   <div class="center">
        <h1><?php echo $ki['name']; ?></h1>
        <?php
            if($err == 1){
                echo '<p class="red">Запоните все поля!</p>';
            }
            if($err == 4){
                echo '<p class="red">Уже используются данные слова!</p>';
            }
        ?>
                    <form action="" method="post" class="regform">
                    <input value="<?php echo $ru; ?>" placeholder="На Русском" type="text" name="ru" class="input"><br>
                    <input value="<?php echo $en; ?>" placeholder="На Английском" type="text" name="en" class="input"><br>
            <input type="submit" value="Добавить" name="btn" class="btn"><br>
                    </form>
                <br><br>
                <?php
                $colvo = 1;
 $query = mysqli_query($connection, "SELECT * FROM `words` WHERE `kit` = '$kit'");
 while(($wd = mysqli_fetch_assoc($query))){
    ?>

<div class="settings">
    <?php echo $colvo; ?><br><br>
           <a class="grey">Ru:</a> <?php echo $wd['rus']; ?><br>
           <a class="grey">En:</a> <?php echo $wd['eng']; ?><br><br>
           <a href="delword.php?kit=<?php echo $kit; ?>&word=<?php echo $wd['id']; ?>">Удалить</a>
        </div>
<?php
 $colvo++;
 }

                ?>
   </div>

</body>
</html>