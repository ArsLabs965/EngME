<?php
    session_start();
    include "settings/rootway.php";
if($_SESSION['user'] != NULL){
    header(rootway() . 'kits.php');
    exit();
}

//Подключение к Базе данных
include "settings/db.php";
$connection = connect();

$err = 0; //Сбор ошибок при анализе формы
    if(isset($_POST['btn'])){

        //Зачистка от инбекций
        $login = mysqli_real_escape_string($connection, $_POST['login']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        if($login != "" AND $password != ""){
            $query = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");
            if(($query_clear = mysqli_fetch_assoc($query))){
                if($password == $query_clear['password']){
                  //Вход в аккаунт
                $_SESSION['user'] = $login;
                header(rootway() . 'kits.php');
                exit();
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
    <title>EngME</title>
</head>
<body>
    <div class="center">
        <img src="img/logo.png" width="200px" alt="">
        <form action="" method="post" class="regform">
            <?php
                 if($err == 1){
                    echo '<p class="red">Запоните все поля!</p>';
                }
                if($err == 4){
                    echo '<p class="red">Неверен логин или пароль!</p>';
                }
            ?>
            <input placeholder="Логин" value="<?php echo $login; ?>" type="text" name="login" class="input"><br>
            <input placeholder="Пароль" type="password" name="password" class="input"><br>
            <input type="submit" value="Войти" name="btn" class="btn"><br>
        </form>
    </div>
</body>
</html>