<!DOCTYPE html>
<html>

<head>
    <title> </title>
    <link rel="stylesheet" href="home.css ">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="./fontawesome-free-5.11.2-web/css/all.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<style>
    .card {
        width: 190px;
        height: auto;
        margin-left: 2px;
        margin-right: 1px;
    }

    h4 {
        font-size: 25px;
        font-family: ;
    }

    div#alert {
        float: right;
    }

    label {
        font-size: 14px;
    }
</style>

<body>
    <!-- header -->
    <div class="container-fluid header">
        <header>
            Hotel Pet
        </header>
    </div>

    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-12">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="valFunc.php" method="POST">
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Nome Completo*</label><br>
                                <input type="text" name="nome" id="nome" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">Nome de Usuario* </label><br>
                                <input type="text" name="usr" id="usr" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">Endereço* <br> ex:Av.logoali 123</label><br>
                                <input type="text" name="end" id="end" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="username" class="text-info">Cidade*</label><br>
                                <input type="text" name="cidade" id="cidade" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="username" class="text-info">UF</label><br>
                                <input type="text" name="uf" id="uf" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">RG* <br> ex:12.234.345-5</label><br>
                                <input type="text" name="rg" id="rg" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">CPF* <br> ex:123.234.345-56</label><br>
                                <input type="text" name="cpf" id="cpf" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">Telefone* <br> ex:(11)98003-2001</label><br>
                                <input type="text" name="tel" id="tel" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">e-mail* <br> ex:fulanosilva@gmail.com</label><br>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Senha</label><br>
                                <input type="password" name="senha" id="senha" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">Confirmar senha</label><br>
                                <input type="password" name="conf" id="conf" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div align="right">
                                <input type="button" name="voltar" class="btn btn-outline-danger" value="Voltar" onclick="javascript:location.href='index.html'">
                                <input type="reset" name="reset" class="btn btn-outline-warning" value="Limpar">
                                <input type="submit" name="submit" class="btn btn-success" value="Confirmar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>