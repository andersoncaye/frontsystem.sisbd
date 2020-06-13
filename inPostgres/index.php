<?php
    $URL_ATUAL= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    require 'system/Database.php';
    define('DB_TYPE', 'pgsql');
    define('DB_HOST', 'localhost'); //local
    define('DB_NAME', 'pitaya'); //banco
    define('DB_USER', 'postgres'); //usuario
    define('DB_PASS', 'postgres'); //senha
    $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

?>
<html>
    <header>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="css/fortable.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Our project just needs Font Awesome Solid + Brands -->
        <link href="css/fontawesome-free-5.13.0-web/css/fontawesome.css" rel="stylesheet">
        <link href="css/fontawesome-free-5.13.0-web/css/brands.css" rel="stylesheet">
        <link href="css/fontawesome-free-5.13.0-web/css/solid.css" rel="stylesheet">

    </header>
    <body>
        <div class="container">

            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql" role="button">HOME</a>
            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql=1" role="button">Saldo calórico diário médio do usuário</a>
            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql=2" role="button">Média de proteínas ingeridas diariamente do usuário</a>
            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql=3" role="button">Alimentos cadastrados que estão sendo utilizados</a>
            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql=4" role="button">Usuário de determinado estado que NÃO consome determinado alimento</a>
            <a class="btn btn-primary mt-1" href="http://localhost/frontsystem.sisbd/?sql=7" role="button">Usando Index</a>

            <?php
                if (isset($_GET['sql'])) {
                    if ($_GET['sql'] == 1){
                        include_once 'app/1caloriaPorUsuario.php';
                    } else if ($_GET['sql'] == 2){
                        include_once 'app/2proteinasPorUsuario.php';
                    } else if ($_GET['sql'] == 3){
                        include_once 'app/3alimentosUtilizados.php';
                    } else if ($_GET['sql'] == 4){
                        include_once 'app/4alimentoporEstado.php';
                    } else if ($_GET['sql'] == 7){
                        include_once 'app/7usoDoIndex.php';
                    } else {
                        include_once 'app/home.php';
                    }
                } else if (!isset($_GET['sql'])){
                    include_once 'app/home.php';
                }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>