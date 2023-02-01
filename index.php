<?php
session_start();
include_once "funciones.php";
if (empty($_SESSION['clave'])){
    $_SESSION['clave'] = generarClave();
    $_SESSION['resultados'] = array();
    $_SESSION['jugadas'] = array();
}
//https://www.youtube.com/watch?v=2-hTeg2M6GQ
//Como Se juega
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MisterMind</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">


</head>
<body class="bg-black">
<header class="container-fluid bg-black">
        <h1 class="text-center text-white fw-bolder p-3">
            Mastermind
        </h1>
</header>
<div class="container-fluid position-relative d-flex" >
    <h1 id="clave" class="text-white position-absolute top-50 m-auto d-block start-50 translate-middle"><?php foreach ($_SESSION['clave'] as $item) {
            echo $item . " ";
        } ?></h1>
    <img id="cerebroIMG" class="img-fluid w-25 m-auto " src="Images/cerebro.jpg" alt="" srcset="">
</div>

<div class="container mb-5">
    <?php
        if (!empty($_POST['enviado'])){
            $_SESSION['jugada'][]  = array($_POST['digito1'],$_POST['digito2'],$_POST['digito3'],$_POST['digito4']);
            $_SESSION['numJugadas'] = 0;
            $_SESSION['resultados'][] = comprobarJugada($_SESSION['jugada'][count($_SESSION['jugada'])-1],$_SESSION['clave']);
            if (comprobarFinJuego($_SESSION['resultados'][count($_SESSION['resultados'])-1])){
                echo '<div class="container-fluid ">
    <div class="container d-flex justify-content-center flex-column align-items-center">
    <img src="Images/pexels-stefano-lissa-588266.jpg" class="img-fluid w-50">
    <h1 class="text-white">Enhorabuena has descifrado el codigo en '.$_SESSION['numJugadas'].' intentos</h1>
    </div>
</div>';
            }else {
                echo '<h1 class="text-white text-center"> Tus Jugadas </h1>';
                for ($i = 0; $i < count($_SESSION['jugada']); $i++) {

                    if (($_SESSION['numJugadas'] % 4) == 0 ){
                        echo '<div class="container d-flex"> ';
                    }
                    echo '
                <div id="jugadas" class="container-fluid justify-content-center flex-column d-flex align-items-center">
    <h3 class="text-white">Intento nº '.$_SESSION['numJugadas'].'</h3>
    <div class=" justify-content-center d-flex align-items-center gap-2 text-center">
    <input type="Number" value="'.$_SESSION['jugada'][$i][0].'" readonly class="color'.$_SESSION['resultados'][$i][0].'">
    <input type="Number" value="'.$_SESSION['jugada'][$i][1].'" readonly class="color'.$_SESSION['resultados'][$i][1].'">
    <input type="Number" value="'.$_SESSION['jugada'][$i][2].'" readonly class="color'.$_SESSION['resultados'][$i][2].'">
    <input type="Number" VALUE="'.$_SESSION['jugada'][$i][3].'" readonly class="color'.$_SESSION['resultados'][$i][3].'">
    </div>
</div>';
                    if (($_SESSION['numJugadas'] % 4) == 0 ){
                        echo '</div> ';
                    }
                    $_SESSION['numJugadas']++;
                }
            }
        }
    ?>
</div>
</div>


<div class="container-fluid justify-content-center flex-column d-flex align-items-center">
    <h3 class="text-white">Intentalo de Nuevo</h3>
    <form class="container-fluid justify-content-center flex-column d-flex align-items-center" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="container-fluid justify-content-center d-flex align-items-center gap-2 text-center">
        <input type="Number" name="digito1" >
        <input type="Number" name="digito2">
        <input type="Number" name="digito3">
        <input type="Number" name="digito4">
        </div>
        <button class="btn btn-dark " name="enviado" value="si" type="submit">Enviar</button>
    </form>

</div>
</body>
</html>