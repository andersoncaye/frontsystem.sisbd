    <?php
        $search = -1;
        if (isset($_POST['search_now']) && $_POST['search_now'] == 'go'){
            $inicio = microtime(true);

            $search = (int)$_POST['search'];
            $command = array(array('$match'=> array('$and'=> array(array('idusuario'=> $search)))), array('$lookup'=> array('from'=> 'resumo_dia', 'localField'=> 'idusuario', 'foreignField'=> 'idusuario', 'as'=> 'resumo_dia')), array('$lookup'=> array('from'=> 'consumo_alimento', 'localField'=> 'resumo_dia.idresumodia', 'foreignField'=> 'idresumodia', 'as'=> 'consumo_alimento')), array('$lookup'=> array('from'=> 'alimento', 'localField'=> 'consumo_alimento.idalimento', 'foreignField'=> 'idalimento', 'as'=> 'alimento')), array('$project'=> array('nome'=> 1, 'data_nascimento'=> 1, 'altura_cm'=> 1, 'media'=> array('$avg'=> array('$multiply'=> array(array('$sum'=> array('$map'=> array('input'=> '$alimento.proteinas_por_porcao', 'as'=> 'p', 'in'=> array('$add'=> array('$cond'=> array('if'=> '$$p.excluded', 'then'=> 0, 'else'=> 1)))))), array('$sum'=> array('$consumo_alimento.numero_porcoes'))))))));
            $result = $connectionDataBase->select('usuario', Database::$typeResearch_AGGREGATE ,$command);
            $y = 0;
            $documents = array();
            foreach ( $result as $document) {
                $documents[$y] = $document;
                $y++;
            }
            var_dump($documents);
        }
    ?>
    <br><br><h1 class="">Média de proteínas ingeridas diariamente do usuário</h1><br><br>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>#Problema</strong>
        <br>2) Qual a média de proteínas ingeridas diariamente do usuário 1234? Mostrar apenas a quantidade média de proteínas ingeridas
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="post" action="<?php echo $URL_ATUAL;?>">
        <div class="col-md-4 mb-3">
            <label for="validationCustomUsername">Usuário</label>
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="search" aria-describedby="inputGroupPrepend" value="1234" required>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="go" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>
    <?php
    if ($search == -1) {
        echo "<br><br><h2>Nada foi encontrado, desculpe!</h2>";
    } else {
        $total = microtime(true) - $inicio;
        $jsonCommand = json_encode($command);
        echo "<br>
            <div class=\"alert alert-success\" role=\"alert\">
                <h4 class=\"alert-heading\">SQL executado</h4>
                <p>$jsonCommand</p>
                <hr>
                <p class=\"mb-0\">Tempo de execução: $total segundos</p>
            </div>
            <br>";
    ?>
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">MÉDIA</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td><?php echo $documents[0]->media; ?></td>
        </tr>
        </tbody>
    </table>
    <?php
        }
    ?>