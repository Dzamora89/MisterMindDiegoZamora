<?php
session_start();
include_once "funciones.php";
if (empty($_SESSION['clave'])){
    $_SESSION['clave'] = generarClave();
    $_SESSION['resultados'] = array();
    $_SESSION['jugadas'] = array();
    $_SESSION['numJugadas'] = 0;
}
//https://www.youtube.com/watch?v=2-hTeg2M6GQ
//Como Se juega
//Pones el Raton encima del cerebro para que se muestre el codigo.
//Luego tienes que introducir los diferentes numero y darle al boton enviar.
//Si has acertado numero y posicion se te mostrara el numero con un cuadrado Verde
//Si solo has acertado numero y No posicion se mostrara en amarillo.
//Los numeros de la clave no se pueden repetir.

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
    <!-- Con esto se escribe la Clave detras del cerebo -->
    <h1 id="clave" class="text-white position-absolute top-50 m-auto d-block start-50 translate-middle"><?php foreach ($_SESSION['clave'] as $item) {
            echo $item . " ";
        } ?></h1>
    <img id="cerebroIMG" class="img-fluid w-25 m-auto " src="Images/cerebro.jpg" alt="" srcset="">
</div>

<div class="container mb-5">
    <?php
    //Esta parte del codigo se ejecuta una vez se envia el formulario por primera vez
        if (!empty($_POST['enviado'])){
            $_SESSION['jugada'][]  = array($_POST['digito1'],$_POST['digito2'],$_POST['digito3'],$_POST['digito4']);
            $_SESSION['numJugadas']++;
            $_SESSION['resultados'][] = comprobarJugada($_SESSION['jugada'][count($_SESSION['jugada'])-1],$_SESSION['clave']);
            // Aqui es donde comprobamos si el juego ha terminado o tenemos que hacer el intento
            if (comprobarFinJuego($_SESSION['resultados'][count($_SESSION['resultados'])-1])){
                echo '<div class="container-fluid ">
    <div class="container d-flex justify-content-center flex-column align-items-center">
    <h1 class="text-white">Enhorabuena has descifrado el codigo en '.$_SESSION['numJugadas'].' intento/s</h1>
    <img src="Images/pexels-stefano-lissa-588266.jpg" class="img-fluid w-50" alt="Ganador">
    
    </div>
</div>';
                session_unset();
                unset($_POST);
            }else {
                echo '<h1 class="text-white text-center"> Tus Jugadas </h1>';
                //Esto muestra las jugadas que se han realizado anteriormente.
                for ($i = 0; $i < count($_SESSION['jugada']); $i++) {
                    if (($i % 4) == 0 ){
                        echo '<div class="container d-flex"> ';
                        $numeroDiv = 0;
                    }
                    echo '
                <div id="jugadas" class="container-fluid justify-content-center flex-column d-flex align-items-center">
    <h3 class="text-white">Intento nº '.$i +1 .'</h3>
    <div class=" justify-content-center d-flex align-items-center gap-2 text-center">
    <input type="Number" value="'.$_SESSION['jugada'][$i][0].'" readonly class="color'.$_SESSION['resultados'][$i][0].'">
    <input type="Number" value="'.$_SESSION['jugada'][$i][1].'" readonly class="color'.$_SESSION['resultados'][$i][1].'">
    <input type="Number" value="'.$_SESSION['jugada'][$i][2].'" readonly class="color'.$_SESSION['resultados'][$i][2].'">
    <input type="Number" VALUE="'.$_SESSION['jugada'][$i][3].'" readonly class="color'.$_SESSION['resultados'][$i][3].'">
    </div>
</div>';
                    $numeroDiv++;
                    if (($numeroDiv % 4) == 0 ){
                        echo '</div> ';
                    }

                }
            }
        }
    ?>
</div>
</div>

<!-- Y Aqui tenemos el formulario de envio -->
<div class="container-fluid justify-content-center flex-column d-flex align-items-center">
    <h3 class="text-white">Introduce tu secuencia</h3>
    <form class="container-fluid justify-content-center flex-column d-flex align-items-center" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="container-fluid justify-content-center d-flex align-items-center gap-2 text-center">
            <!-- Los input se limitan a numeros entre el 0 y 9 con el HTML -->
        <input class="text-black" tabindex="1" type="Number" name="digito1" min="0" max="9" required>
        <input tabindex="2" type="Number" name="digito2" min="0" max="9" required>
        <input tabindex="3" type="Number" name="digito3" min="0" max="9" required>
        <input tabindex="4" type="Number" name="digito4" min="0" max="9" required>
        </div>
        <button tabindex ="5" class="btn btn-dark mt-3 " name="enviado" value="si" type="submit">Enviar</button>
    </form>
</div>
</body>
</html>