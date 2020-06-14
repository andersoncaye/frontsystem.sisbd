    <?php
        $search = -1;
        if (isset($_POST['search_now']) && $_POST['search_now'] == 'go'){
            $inicio = microtime(true);

            $search = $_POST['search'];
            $sql = "
            SELECT u.nome, u.data_nascimento, u.altura_cm, AVG(a.kcal_por_porcao * ca.numero_porcoes)
            FROM usuario u, consumo_alimento ca, resumo_dia rd, alimento a
            WHERE u.nome = '$search' AND u.idusuario = rd.idusuario AND ca.idresumodia = rd.idresumodia AND ca.idalimento = a.idalimento
            GROUP BY u.idusuario
    
            ";
            $result = $connectionDataBase->select($sql);
            //var_dump($result[0]);
        }
    ?>
    <br><br><h1 class="">Saldo calórico diário médio do usuário</h1><br><br>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>#Problema</strong>
        <br>1) Qual o saldo calórico diário médio do usuário 1234? Mostrar o nome, data de nascimento, altura e média do saldo calórico.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="post" action="<?php echo $URL_ATUAL;?>">
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
            <th scope="col">DATA NASCIMENTO</th>
            <th scope="col">ALTURA (cm)</th>
            <th scope="col">MÉDIA</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td><?php echo $result[0]->nome; ?></td>
            <td><?php echo date('d.m.Y', strtotime($result[0]->data_nascimento)); ?></td>
            <td><?php echo $result[0]->altura_cm; ?></td>
            <td><?php echo $result[0]->avg; ?></td>
        </tr>
        </tbody>
    </table>
    <?php
        }
    ?>