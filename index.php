<?php
session_start();
include_once "funciones.php";
if (!empty($_SESSION['clave'])){
    $clave = $_SESSION['clave'];
}else {
    $clave = generarClave();
    $_SESSION['clave'] = $clave;
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
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<h1>La Clave es <?php foreach ($clave as $item) {
        echo $item . " ";
} ?></h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input  type="Number" name="digito1">
    <input type="Number" name="digito2">
    <input type="Number" name="digito3">
    <input type="Number" name="digito4">
    <button name="enviado" value="si" type="submit">Enviar</button>
</form>
<?php
    if (!empty($_POST['enviado'])){
        $jugada = array($_POST['digito1'],$_POST['digito2'],$_POST['digito3'],$_POST['digito4']);
        $_SESSION['jugada'] = $jugada;
        comprobarJugada($_SESSION['jugada'],$_SESSION['clave']);
        $resultados = $_SESSION['resultados'];
        if (comprobarFinJuego($_SESSION['resultados'])){
            echo "Has Ganado";
        }else {
            foreach ($resultados as $resultado) {
                if ($resultado == 2){
                    echo "Muerto <br>";
                }
                if ($resultado == 1){
                    echo "Tocado <br>";
                }
                if ($resultado == 0){
                    echo "Fallo <br>";
                }
            }
    }
}




?>
</body>
</html>