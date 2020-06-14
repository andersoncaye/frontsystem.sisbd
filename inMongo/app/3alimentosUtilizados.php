    <?php
        $search = -1;
        //if (isset($_POST['search_now']) && $_POST['search_now'] == 'go'){
            $inicio = microtime(true);

            //$search = $_POST['search'];
            $sql = "
            SELECT a.nome_alimento, a.carboidratos_por_porcao, a.proteinas_por_porcao,
            a.gorduras_por_porcao, a.kcal_por_porcao
            FROM alimento a
            WHERE a.idalimento IN (
            SELECT
            ca.idalimento
            FROM
            consumo_alimento ca
            GROUP BY ca.idalimento
            )
            ORDER BY a.kcal_por_porcao

            ";
            $result = $connectionDataBase->select($sql);
            echo "<br>";
            //var_dump($result[2]);
        //}
    ?>
    <br><br><h1 class="">Alimentos cadastrados que estão sendo utilizados em pelo menos uma dieta</h1><br><br>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>#Problema</strong>
        <br>3) Quais são todos os alimentos cadastrados que estão sendo utilizados em pelo menos uma dieta? Ordená-los por quantidade de calorias. Mostrar nome do alimento, carboidratos por porção, proteínas por porção, gorduras por porção e calorias por porção
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!--
    <form method="post" action="<?php //echo $URL_ATUAL;?>">
        <div class="col-md-4 mb-3">
            <label for="validationCustomUsername">Usuário</label>
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="search" aria-describedby="inputGroupPrepend" value="usuario 1234" required>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="go" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>
    -->
    <?php
    /*if ($search == -1) {
        echo "<br><br><h2>Nada foi encontrado, desculpe!</h2>";
    } else {*/
        $total = microtime(true) - $inicio;
        echo "<br>
            <div class=\"alert alert-success\" role=\"alert\">
                <h4 class=\"alert-heading\">SQL executado</h4>
                <p>$sql</p>
                <hr>
                <p class=\"mb-0\">Tempo de execução: $total segundos</p>
            </div>
            <br>";
    ?>
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NOME ALIMENTO</th>
            <th scope="col">CARBOIDRATOS POR PORÇÃO</th>
            <th scope="col">PROTEINAS POR PORÇÃO</th>
            <th scope="col">GOSRDURAS POR PORÇÃO</th>
            <th scope="col">KCAL POR PORÇÃO</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach ($result as $res){
            $i++;
        ?>
        <tr>
            <th scope="row"><?php echo $i; ?></th>
            <td><?php echo $res->nome_alimento; ?></td>
            <td><?php echo $res->carboidratos_por_porcao; ?></td>
            <td><?php echo $res->proteinas_por_porcao; ?></td>
            <td><?php echo $res->gorduras_por_porcao; ?></td>
            <td><?php echo $res->kcal_por_porcao; ?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>