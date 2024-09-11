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

            <form name="error" action="">

                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-warning"></i> Usuario o Contraseña incorrectos.
                </div>

                <input type="button" value="Aceptar" onClick="Atras();" class="btn btn-primary btn-block">

            </form><!-- /form -->
        </div>
    </div><!-- /card-container -->
</body>
<script>
	function Atras()
	{
		document.error.action = "indexxx.php";
		document.error.submit();
	}
</script>
</html>