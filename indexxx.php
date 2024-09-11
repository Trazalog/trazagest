<?php
//session_destroy();
//session_start();
//session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>trazagest</title>
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="imag/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>

            <form  class="form-horizontal" role="form" action="func_php.php" method="post" onSubmit="return valida()">

                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="user" id="user" class="form-control" value="" placeholder="Introduce tu Usuario">
                </div>

                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="pass" id="pass" class="form-control" value="" placeholder="Introduce tu Contraseña">
                </div>

                <button type="submit" class="btn btn-primary btn-block" style='cursor:pointer'>Entrar</button>
                <br>

               <!-- <i class="fa fa-user-secret" style="color: #f39c12; cursor: pointer; margin-left: 15px;" title="Soporte" ></i>-->

               <button type="button" class="glyphicon glyphicon-phone-alt" style='cursor:pointer' title="Soporte" onclick="soporte()"></button>
                <input type="hidden" name="oper" value="V"/>

            </form><!-- /form -->
        </div>
    </div><!-- /card-container -->
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="funciones_js.js"></script> <!-- link's de las funciones .js -->
<script>
    function Inicio() {
        document.getElementById('user').value = "";
        document.getElementById('user').focus();
        document.getElementById('pass').value = "";
    }

    function soporte(){
       // header("Location:http://www.trazalog.com/soporte/");
         window.location="http://www.trazalog.com/soporte/";
    }
</script>

</html>
