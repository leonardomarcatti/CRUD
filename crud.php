<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    include_once('functions.php');
    include_once('classes/endereco.php');
    include_once('classes/telefone.php');
    include_once('classes/clientes.php');
    include_once('classes/email.php');

    use CRUD\classes\TipoLogradouroDAO;
    use CRUD\classes\EstadoDAO;
    use CRUD\classes\TipoTelefoneDAO;

    $tipo_log = new TipoLogradouroDAO($conection);
    $tipo = $tipo_log->getAll();

    $estados = new EstadoDAO($conection);
    $lista_estados = $estados->getAll();

    $telefone = new TipoTelefoneDAO($conection);
    $lista_tipos_telefone = $telefone->getAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="crud.css">
        <title>CRUD</title>
    </head>
    <body>
        <div id=barra class="container-fluid">
            <div class="row justify-content-evenly">
                <div class="col">
                    <a href=""></a>
                </div>
                <div class="col-lg-auto">
                    <img id="user_image" title="<?php echo GetUserImageTitle()?>" src="img/users/<?php echo GetUserImage()?>">
                </div>
                <div class="col-lg">
                    <a href=logout.php id=sair>Sair</a>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="abas" role="tab">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="menu_consulta">Consulta e Alteração</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" data-toggle="tab" role="tab" aria-controls="consulta_clientes" href="#consulta_clientes" id="menu_consulta_clientes" aria-selected="false">Clientes</a>
                </div>
            </li>
            <li class="nav-item dropdown" role="tab">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="menu_cadastro">Cadastro</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" data-toggle="tab" role="tab" aria-controls="clientes" href="#cadastra_clientes" aria-selected="false" id="menu_cadastro_clientes">Clientes</a>
                </div>
            </li>
        </ul>
        <div class="tab-content" id="todas_tabs">
                <div class="tab-pane fade active show" id="consulta_clientes" role="tabpanel" aria-labelledby="consulta_clientes_tab">
                    <div class="container-fluid">
                        <form id="consulta_clientes_form" name="consulta_clientes_form" method="get" action="crud.php">
                            <div class="row g-3 justify-content-center">
                                <div class="col-1">
                                    <label for="consulta_id">ID:</label>
                                    <input type="text" name="consulta_id" id="consulta_id" class="form-control">
                                </div>
                                <div class="col-5">
                                    <label for="consulta_nome">Nome:</label>
                                    <input type="text" name="consulta_nome" id="consulta_nome" class="form-control">
                                </div>
                                <div class="col-2 align-self-end">
                                    <button type="submit" id="btn_consulta" class="btn btn-block btn-outline-success">Consultar</button>
                                    <button type="reset" id="btn_reset_consulta"  class="btn btn-block btn-outline-warning">Limpar</button>
                                </div>
                            </div>
                        </form>
                            <?php 
                                if (isset($_SESSION['flash']) &&  $_SESSION['flash'] != '') { ?>
                                    <h5 id="flash"><?=$_SESSION['flash'];?></h5>
                                    <?php unset($_SESSION['flash']); 
                                }; ?>
                            <?php
                                include_once('tabela_consulta.php');
                            ?>
                    </div>
                </div>
            <div class="tab-pane fade" id="cadastra_clientes" role="tabpanel" aria-labelledby="clientes-tab">
                <div class="container-fluid">
                <form id="cadastra_clientes_form" action="crud.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required=""> 
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="sobre_nome">Sobrenome:</label>
                            <input type="text" name="sobrenome" id="sobrenome" class="form-control" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="masculino" name="sex" class="form-check-input" value="M" required="">
                                <label class="form-check-label" for="masculino">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="feminino" name="sex" class="form-check-input" value="F" required="">
                                <label class="form-check-label" for="feminino">Feminino</label>
                            </div>
                        </div>
                    </div>
                        <fieldset id="endereco_completo">
                            <div class="row">
                                <legend>Endereço</legend>
                                <div class="col-lg-1 col-12">
                                    <label for="logradouro:">Logradouro:</label>
                                    <select class="form-select" id="logradouro" name="logradouro" required="">
                                        <?php
                                            foreach ($tipo as $key => $value) {
                                                echo "<option value=\"" . $value->getID() . "\">" . $value->getNome() . "</option>";
                                            };
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-7 col-12">
                                    <label for="endereco:">Nome:</label>
                                    <input type="text" name="endereco" id="endereco" class="form-control"  required="">
                                </div>
                                <div class="col-lg-1 col-12">
                                    <label for="numero:">Número:</label>
                                    <input type="number" name="numero"  min="0" id="numero" class="form-control" required="">
                                </div>
                                <div class="col-lg-3 col-12">
                                    <label for="complemento:">Complemento:</label>
                                    <input type="text" name="complemento" id="complemento" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-12 ">
                                    <label for="bairro:">Bairro:</label>
                                    <input type="text" name="bairro" id="bairro" class="form-control" required="">
                                </div>
                                <div class="col-lg-5 col-12 ">
                                    <label for="cidade:">Cidade:</label>
                                    <input type="text" name="cidade" id="cidade" class="form-control" required="" >
                                </div>
                                <div class="col-lg-2 col-12">
                                    <label for="estado:">Estado:</label>
                                    <select class="form-select" id="uf" name="estado" required="">
                                        <?php
                                            foreach ($lista_estados as $key => $value) {
                                                echo "<option label=\"" . $value->getNome() . "\" value=\"" . $value->getID() . "\">" . $value->getNome() . "</option>";
                                            };
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="contato">
                            <div class="row form-group">
                                <legend>Contato</legend>
                                <div class="col-lg-1 col-3">
                                    <label for="ddd:">DDD:</label>
                                    <input type="number" name="ddd" id="ddd" class="form-control" pattern="[0-9]{2}" required="">
                                    <small>Formato: XX</small>
                                </div>
                            <div class="col-lg-5 col-9">
                                <label for="telefone:">Telefone:</label>
                                <input type="tel" name="telefone" id="telefone" class="form-control" pattern="[0-9]{4}-[0-9]{4}" required="">
                                <small>Formato: XXXX-XXXX</small>
                            </div>
                            <div class="col-lg-2 col-12">
                                <label for="tipo_telefone:">Tipo:</label>
                                <select class="form-select" id="tipo_telefone" name="tipo_telefone" required="">
                                    <?php 
                                    foreach ($lista_tipos_telefone as $key => $value) { ?>
                                        <option value="<?= $value['id']?>"> <?= $value['tipo']?> </option>;
                                    <?php } ?>                                    
                                </select>
                            </div>
                                <div class="col-lg-4 col-12">
                                    <label for="email">E-mail:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                        </fieldset>
                        <div class="row float-end g-2">
                            <div class="col">
                                <button type="submit" id="submit_clientes" class="btn btn-outline-success">Adicionar</button>
                            </div>
                            <div class="col">
                            <button type="reset" id="reset_cliente"  class="btn btn-outline-warning">Limpar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="crud.js"></script>
    </body>
</html>