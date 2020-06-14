<?php
$search = -1;
if (isset($_POST['search_now']) && $_POST['search_now'] == 'go'){
    $inicio = microtime(true);
    $search = 1;
    $estado = strtolower($_POST['estado']);
    $alimento = $_POST['alimento'];
    $sql = "
            SELECT u.nome, u.sexo
            FROM usuario u, cidade c, estado e
            WHERE u.idcidade = c.idCidade AND c.idestado = e.idEstado AND e.UF = '$estado' AND u.nome NOT IN (
            SELECT uu.nome
                      FROM usuario uu, cidade cc, resumo_dia rr, consumo_alimento ca, alimento a, estado e
            WHERE uu.idCidade = cc.idCidade AND uu.idUsuario = rr.idUsuario AND rr.idResumoDia = ca.idResumoDia AND ca.idAlimento = a.idAlimento AND cc.idestado = e.idEstado AND  e.uf = '$estado' AND a.nome_alimento = '$alimento'
            GROUP BY uu.nome)

            ";
    $result = $connectionDataBase->select($sql);
    echo "<br>";
    //var_dump($result[0]);
}
?>
<br><br><h1 class="">Usuário de determinado estado que NÃO consome determinado alimento</h1><br><br>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>#Problema</strong>
    <br>4) Quais são todos os usuários que residem no estado Rio Grande do Sul e NÃO comem carne? Mostrar nome e sexo da pessoa
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="post" action="<?php echo $URL_ATUAL;?>">
    <div class="col-md-4 mb-3">
        <label for="exampleFormControlSelect1">Estado</label>
        <select class="form-control" id="exampleFormControlSelect1" name="estado" required>
            <option>AC</option>
            <option>AL</option>
            <option>AP</option>
            <option>AM</option>
            <option>BA</option>
            <option>CE</option>
            <option>DF</option>
            <option>ES</option>
            <option>GO</option>
            <option>MA</option>
            <option>MT</option>
            <option>MS</option>
            <option>MG</option>
            <option>PA</option>
            <option>PB</option>
            <option>PR</option>
            <option>PE</option>
            <option>PI</option>
            <option>RJ</option>
            <option>RN</option>
            <option selected>RS</option>
            <option>RO</option>
            <option>RR</option>
            <option>SC</option>
            <option>SP</option>
            <option>SE</option>
            <option>TO</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Alimento</label>
        <div class="input-group">
            <input type="text" class="form-control" id="validationCustomUsername" name="alimento" aria-describedby="inputGroupPrepend" value="carne" required>
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
            <th scope="col">NOME</th>
            <th scope="col">SEXO</th>
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
            <td><?php echo $res->nome; ?></td>
            <td><?php
                $sex = 'Feminino';

                if ($res->sexo == 'm')
                    $sex = 'Masculino';

                echo $sex;

                ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
?>