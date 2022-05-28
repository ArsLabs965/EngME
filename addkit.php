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

$err = 0;
  if(isset($_POST['btn'])){

    //Зачистка от инбекций
    $name = mysqli_real_escape_string($connection, $_POST['name']);

    if($name != ""){
        $query = mysqli_query($connection, "SELECT * FROM `kits` WHERE `name` = '$name' AND `whos` = '$_SESSION[user]'");
        if(!($query_clear = mysqli_fetch_assoc($query))){
            mysqli_query($connection, "INSERT INTO `kits` (`name`, `whos`) VALUES ('$name', '$_SESSION[user]')");
            header(rootway() . 'kits.php');
            exit();
           
            
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
    <title>Добавить набор</title>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            <img src="img/logo.png" width="100px" alt="">
        </div>
        <div class="menu" style="float: left;">
            <a href="kits.php">На главную</a>
        </div>

        <div class="out" style="float: right;">
           <a href="out.php">Выйти</a>
        </div>
    
    </div>
    <div class="center">
        <h1>Новый набор карточек</h1>
        <?php
            if($err == 1){
                echo '<p class="red">Запоните все поля!</p>';
            }
            if($err == 4){
                echo '<p class="red">Такое имя уже используется</p>';
            }
        ?>
        <form action="" method="post" class="regform">
        <input value="<?php echo $name; ?>" placeholder="Имя нового набора" type="text" name="name" class="input"><br>
        <input type="submit" value="Добавить" name="btn" class="btn"><br>
        </form>
    </div>

</body>
</html>