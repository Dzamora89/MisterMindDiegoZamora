<?php
session_start();
include_once "funciones.php";
if (!empty($_SESSION['clave'])){
    $clave = $_SESSION['clave'];
}else {
    $clave = generarClave();
    $_SESSION['clave'] = $clave;
    $_SESSION['numJugadas'] = 0 ;
    $resultados = array();
    $_SESSION['resultados'] = $resultados ;
    $jugadas = array();
    $_SESSION['jugadas'] = $jugadas ;
}

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
    <script src="./JS/miscripts.js" defer></script>


</head>
<body class="bg-black">
<header class="container-fluid bg-black">
        <h1 class="text-center text-white fw-bolder p-3">
            Mastermind
        </h1>
</header>
<div class="container-fluid text-center d-flex justify-content-center align-items-center" >
    <h1 id="clave" class="text-white"><?php foreach ($clave as $item) {
            echo $item . " ";
        } ?></h1>
    <img id="cerebroIMG" class="img-fluid w-25 " src="Images/cerebro.jpg" alt="" srcset="">
</div>

<div class="container-fluid mb-5">
    <?php
        if (!empty($_POST['enviado'])){
            $jugada = array($_POST['digito1'],$_POST['digito2'],$_POST['digito3'],$_POST['digito4']);
            $_SESSION['jugada'] = $jugada;
            $_SESSION['jugadas'][] = $jugada;
            comprobarJugada($_SESSION['jugada'],$_SESSION['clave']);
            $ultimoResultado =$_SESSION['ultimoResultado'];
            print_r($ultimoResultado);
            $resultados[] =  $ultimoResultado;
            if (comprobarFinJuego($_SESSION['ultimoResultado'])){
                echo "Has Ganado";
            }else {
                echo '<h1 class="text-white text-center"> Tus Jugadas </h1>';
                $jugadas = $_SESSION['jugadas'];
                $mostrar = array();
                $i = 0;

                foreach ($jugadas as $jugada) {
                    print_r($resultados);
                    echo '
                <div class="container-fluid justify-content-center flex-column d-flex align-items-center">
    <h3 class="text-white">Intento nº '.$_SESSION['numJugadas'].'</h3>
    <div class="col-4 justify-content-center d-flex align-items-center gap-2 text-center">
    <input type="Number" value="'.$jugada[0].'" readonly>
    <input type="Number" value="'.$jugada[1].'" readonly>
    <input type="Number" value="'.$jugada[2].'" readonly>
    <input type="Number" VALUE="'.$jugada[3].'" readonly>
    </div>
</div>
                ';
                $i++;
                }
            }

        }
    ?>
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

<script src="./node_modules/jquery/dist/jquery.js" ></script>
</body>
</html>