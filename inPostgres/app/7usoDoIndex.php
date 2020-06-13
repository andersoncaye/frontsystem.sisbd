<?php
$search = -1;
if (isset($_POST['search_now'])){
    $inicio = microtime(true);
    $search = 1;

    if ($_POST['search_now'] == 'create1') {
        $r = $database->select("CREATE INDEX i_idCidade_usuario on usuario(idCidade)");
    } else if ($_POST['search_now'] == 'drop1') {
        $r = $database->select("DROP INDEX i_idCidade_usuario");
    }else if ($_POST['search_now'] == 'create2') {
        $r = $database->select("CREATE INDEX i_resumo_dia on resumo_dia(idUsuario)");
    }else if ($_POST['search_now'] == 'drop2') {
        $r = $database->select("DROP INDEX i_resumo_dia");
    }

    //var_dump($r);

    $sql = "
            SELECT e.nome AS nomeestado, u.nome AS nomeusuario, ra.idRegistro, ra.data, af.nome_atividade
            FROM estado e INNER JOIN cidade c on c.idEstado=e.idEstado
            LEFT JOIN usuario u ON u.idCidade=c.idCidade
            LEFT JOIN resumo_dia rd ON rd.idUsuario=u.idUsuario
            LEFT JOIN atividade_resumodia a ON a.idResumoDia=rd.idResumoDia
            LEFT JOIN registro_atividadeFisica ra ON ra.idRegistro=a.idRegistro
            LEFT JOIN atividadeFisica af ON af.idAtividade=ra.idAtividade
            ORDER BY e.nome, u.nome
            ";
    $result = $database->select($sql);
    echo "<br>";
    var_dump($result[0]);
}
?>
<br><br><h1 class="">Usando Index</h1><br><br>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>#Problema</strong>
    <br>7) Exibir a lista de estados e os usuarios vinculados a estes estados. Para cada usuário, mostrar as atividades que o mesmo participou. Exibir o nome do estado, nome do usuário, id do registro da atividade, data e nome da atividade. A consulta deve trazer todos os usuarios que estão vinculados a estados, mesmo aqueles que não estão vinculados a nenhuma atividade. Ordenar pelo nome do estado.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="post" action="<?php echo $URL_ATUAL;?>">
    <div class="form-row">
        <div class="col-md-5 mb-3">
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="alimento" aria-describedby="inputGroupPrepend" value="CREATE INDEX i_idCidade_usuario on usuario(idCidade)" readonly>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="create1" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="alimento" aria-describedby="inputGroupPrepend" value="DROP INDEX i_idCidade_usuario" readonly>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="drop1" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="alimento" aria-describedby="inputGroupPrepend" value="CREATE INDEX i_resumo_dia on resumo_dia(idUsuario)" readonly>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="create2" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" id="validationCustomUsername" name="alimento" aria-describedby="inputGroupPrepend" value="DROP INDEX i_resumo_dia" readonly>
                <div class="input-group-prepend">
                    <button class="btn btn-primary" name="search_now" value="drop2" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="input-group-prepend">
        <button class="btn btn-primary" name="search_now" value="nul" type="submit">Buscar resultados</button>
    </div>
</form>
<?php
if ($search == -1) {
    echo "<br><br><h2>Nada foi encontrado, desculpe!</h2>";
} else {
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
            <th scope="col">NOME ESTADO</th>
            <th scope="col">NOME USUÁRIO</th>
            <th scope="col">ID REGISTRO</th>
            <th scope="col">DATA</th>
            <th scope="col">NOME ATIVIDADE</th>
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
            <td><?php echo $res->nomeestado; ?></td>
            <td><?php echo $res->nomeusuario; ?></td>
            <td><?php echo $res->idregistro; ?></td>
            <td><?php echo $res->data; ?></td>
            <td><?php echo $res->nome_atividade; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
?>