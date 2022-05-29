<?php
      session_start();
      include "settings/rootway.php";
  if($_SESSION['user'] == NULL){
      //header(rootway());
      //exit();
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
            <p id="counter"></p><br>
            Как это переводится?
        <div class="word">
            
        </div>
        <br>
        <br>
        Варианты ответа
        <div class="var" id="v1" onclick="cl(1)">
            
        </div>
        <div class="var" id="v2" onclick="cl(2)">
           
        </div>
        <div class="var" id="v3" onclick="cl(3)">
            
        </div>
        </div>
   </div>
<script src="jquery.js"></script>
<script>
    var en = [];
    var ru = [];
    var asked = [];
    var ng = 0;
    var goed = 0;
    var tr = 0;
    var canclick = 1;
    var fails = [];

    <?php
 $colvo = 0;
 $query = mysqli_query($connection, "SELECT * FROM `words` WHERE `kit` = '$kit'");
 while(($wd = mysqli_fetch_assoc($query))){
     ?>
    en[<?php echo $colvo; ?>] = '<?php echo $wd['eng']; ?>';
    ru[<?php echo $colvo; ?>] = '<?php echo $wd['rus']; ?>';
     <?php
$colvo++;
 }
    ?>



    if(en.length < 3){
        $(".line").html("Слишком мало слов! Минимум 3. Добавьте недостающие слова в меню 'Настройки слов'");
    }else{
        newgen();
    }

    function newgen(){
        if(goed == en.length){
            var fa = 'Не правильно отвеченные слова: <br><br>';
            var fcl = 0;
            for(var i = 0; i < en.length; i++){
                if(fails[i] == 1){
                fa += ru[i];
                fa += '<br>';
                fa += en[i];
                fa += '<br>';
                fa += '<br>';
                fcl++;
                }
            }
            fa += 'Всего: ';
            fa += fcl;
            $(".line").html(fa);
            return 0;
        }
        
        do{
            ng = rand(en.length);
        }while(asked[ng] == 1)
        $(".word").html(ru[ng]);
        $("#counter").html(goed + '/' + en.length);
        var rp = rand(3) + 1;
        tr = rp;
        var olds = -1;
        $("#v" + rp).html(en[ng]);
        $("#v1").css('background-color', 'rgb(113, 215, 255)');
        $("#v2").css('background-color', 'rgb(113, 215, 255)');
        $("#v3").css('background-color', 'rgb(113, 215, 255)');
        canclick = 1;
        for(var i = 1; i < 4; i++){
            if(i == rp){
                continue;
            }
            var rs;
            do{
                rs = rand(en.length);
                if(olds != -1){
                if(olds == rs){
                    rs = ng;
                }
            }else{
              
            }
           
            }while(rs == ng)
            olds = rs;
           
            $("#v" + i).html(en[rs]);
        }
    }

    function cl(nu){
        if(canclick){

        
        if(nu == tr){
            asked[ng] = 1;
            goed++;
            $("#v" + tr).css('background-color', 'Green');
        }else{
            fails[ng] = 1;
            $("#v" + tr).css('background-color', 'Green');
            $("#v" + nu).css('background-color', 'Red');
        }
        canclick = 0;
        setTimeout(newgen, 2000);
    }
    }

    function rand(max) {
  return Math.floor(Math.random() * max);
}
</script>
</body>
</html>