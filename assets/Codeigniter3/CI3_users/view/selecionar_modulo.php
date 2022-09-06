<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Modelo::Selecionar modulo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url_assets('plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url_assets('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url_assets('dist/css/adminlte.min.css') ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">

  <style>
    .corpo-top {
      top: 0px;
      width: 100%;
      padding-top: 25px;
      z-index: 999;
      background-color: #fff;
      /* background-color: #323232; */
    }

    #nav-top {
      height: 60px;
      width: max-content;
      top: -40px;
      background-color: #fff;
      /* background-color: #323232; */
    }

    .img-top {
      height: 64px;
      position: relative;
      left: -5px;
      top: 50px;
      z-index: 9000;
    }

    #nav-top a {
      color: #000;
    }

    .ajuda-top {
      color: white !important;
      border-radius: 5px;
      background-color: #FFB800;
      padding: 4px;
      font-family: 'Open Sans';
      font-weight: 900, black;
      font-size: 17px;
      position: relative;
      top: 12px;
    }

    .link-nav-top {
      font-family: 'Open Sans';
      font-weight: 900, black;
      position: relative;
      font-size: 17px;
      color: #000;
      padding: 4px;
    }

    .link-nav-top:hover>a {
      background-color: #0080C2;
      align-items: center;
      color: white !important;
      border-radius: 5px;
    }

    .link-menu:hover {
      background-color: #DDF4FF;
    }

    .link-menu>a {
      padding: 15px;
    }

    .link-menu:hover>a {
      background-color: #DDF4FF;
      color: #0080C2;
    }

    #ver-mensagens-top,
    #notification-menu {
      background-color: #A5A5A5;
      border-radius: 5px;
    }

    #ver-notificacoes,
    .ver-mensagem {
      color: #fff !important;
    }

    #card-ver-notificacao:hover,
    .ver-mensagem:hover {
      background-color: #A5A5A5;
      color: #fff;
    }

    #ver-mensagens-top a {
      font-size: 16px;
      padding: 12px 0px;
    }

    #sair-top {
      padding: 0;
      border: 0;
      margin: 0;
    }

    #sair-top li {
      padding: 15px 20px 14px 20px;
    }

    #sair-top:hover {
      background-color: red;
      align-items: center;
    }

    #sair-top:hover li {
      color: #fff;
    }

    /* Menu Mobile - Inicio */
    #menu-toggle-top {
      display: none;
    }

    .menu-icons-top {
      display: none;
    }

    @media screen and (max-width:767px) {

      .img-top {
        top: 20px;
      }

      .menu-icons-top {
        display: block;
      }

      #nav-top {
        display: absolute;
      }

      .menu {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        top: 20px;
        left: -500px;
        width: 100%;
        height: 0%;
        background: #fff;

        overflow: hidden;
        -webkit-transition: height 0.3s ease-out;
        -moz-transition: height 0.3s ease-out;
        -o-transition: height 0.3s ease-out;
        transition: height 0.3s;
      }

      .menu li,
      .ajuda-top {

        display: block;
        width: 100%;
        margin: 0px;
      }

      .nav-item {
        font-family: 'Open Sans', sans-serif;
        font-weight: 900, black;
        margin-top: 50px;
      }

      .menu li a,
      .ajuda-top {

        display: block;
        text-align: center;
        width: 100%;
        color: #000;
        margin: 0px;
      }

      li .ajuda-top {
        padding-top: 10px;
        margin-bottom: 10px;
      }

      .menu .link-menu:hover {
        background-color: #0080C2;
      }


      .menu-icons-top {
        color: #202020;
        width: max-content;
        z-index: 999;
      }

      .menu-icons-top i {
        position: absolute;
        right: 0px;
        top: -25px;
        font-size: 1.3em;
      }

      #menu-toggle-top:checked~label i:nth-child(2) {
        display: block;
      }

      #menu-toggle-top:checked~label i:first-child {
        display: none;
      }

      #menu-toggle-top:not(checked)~label i:first-child {
        display: block;
      }

      #menu-toggle-top:not(checked)~label i:nth-child(2) {
        display: none;
      }

      #menu-toggle-top:checked~ul {
        height: 100%;
      }

      /* Interferencia - Juncao de duas classes */
      .dropdown-mobile-top.show {
        display: contents;
      }

    }

    /* Menu Mobile - Fim */
    /* CSS Top - Fim */
    .main {
      margin-top: 50px;
      max-width: 1200px;
    }

    .header-curso-descricao-selecionarProjeto h3 {
      padding: 10% 0px;
      justify-content: center;
      flex-wrap: nowrap;
      align-items: center;
      display: flex;
    }

    .card-curso-selecionarProjeto {
      margin: 30px 30px;
      box-shadow: 5px 0px 15px #A9A9A9;
      border-radius: 15px;
      border: 0px;
      padding: 0px !important;
      font-size: 1.0rem;
    }

    .header-curso-descricao-selecionarProjeto {
      padding: 10px 15px 10px 15px;
      width: 100%;
      border-radius: 15px 15px 0px 0px;
      color: white;
    }

    #par {
      background: linear-gradient(180deg, #56954C, #cae3df);
    }

    #impar {
      background-color: #00A8FF;
    }

    .main-curso-descricao-selecionarProjeto {
      padding: 15px;
      width: 100%;
      background-color: white;
      border-radius: 0px 0px 15px 15px;
    }

    .card-curso-selecionarProjeto a {
      margin: 5px;
      color: white;
      background-color: #138BDD;
      width: 90%;
      border: 0px;
      padding: 8px;
      font-weight: bold;
      border-radius: 12px;
    }

    .button-acessar-curso-selecionarProjeto:hover {
      background: linear-gradient(0deg, #fff, #D1D1D1);
      background-color: #fff;
      color: #138BDD;
      box-shadow: 5px 6px 15px #A9A9A9;
    }
  </style>


  <div class="container-fluid">
    <div class="row corpo-top">

      <nav id="nav-top" class="col-12 navbar navbar-expand-md navbar-light ">
        <div class="container-fluid">
          <div class="row" style="width:100%">
            <div class="col-2 col-sm-4 col-xs-4">
              <!--"<?= base_url_usuario('selecionar_tipo_usuario') ?>"-->
              <a href="#" class="col-3 navbar-brand">
                <img src="<?= base_url_assets('img/intro_logo_att.png') ?>" alt="PEEE" class="img-top">
              </a>
            </div>
            <div class="col-lg10 col-sm-12 col-xs-12">
              <!-- Menu Mobile - Inicio -->
              <input type="checkbox" id="menu-toggle-top">
              <label for="menu-toggle-top" class=" menu-icons-top">
                <i class="fas fa-align-center"></i>
                <!--Inserindo o incone para abrir meu meu mobile-->
                <i class="fas fa-times-circle"></i>
                <!--Inserindo o incone para fechar meu meu mobile-->
              </label> <!-- Criando a caixa clicavel -->

              <!-- Menu Mobile - Fim -->

              <!-- Right navbar links -->
              <ul class=" nav justify-content-end menu">
                <li class="nav-item">
                  <a class="ajuda-top" href=""><i class="bi bi-question-circle-fill">&nbsp;</i>Ajuda</a>

                </li>

                <li class="link-nav-top nav-item dropdown">
                  <a id="dr opdownSubMenu1 link-perfil" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                    <i class="bi bi-person-fill"> </i><?= session_nome_usuario() ?>
                  </a>
                  <ul id="sair-top" aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow dropdown-mobile-top">
                    <a href="<?= base_url_usuario('logout') ?>">
                      <li class="text-left"><i class="bi bi-box-arrow-left">&nbsp;Sair</i></li>
                    </a>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- Main content -->

      <div class="container-fluid  main">
        <div class="row">
          <?php foreach ($modulos as $index_modulo => $modulo) { ?>
            <div class="col-lg-4 col-sm-12">
              <div class="card  card-curso-selecionarProjeto">
                <div id="impar" class="widget-user-header header-curso-descricao-selecionarProjeto">
                  <h3><?= $modulo['title'] ?></h3>
                </div>
                <div class="main-curso-descricao-selecionarProjeto text-center">
                  <a href="<?= base_url($modulo['name'] . '/autenticar') ?>" class="btn button-acessar-curso-selecionarProjeto">Acessar</a>
                </div>
              </div><!-- /.card -->
            </div>
            <!-- /.col-lg-4 col-sm-12 -->
          <?php } ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url_assets('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url_assets('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url_assets('dist/js/adminlte.min.js') ?>"></script>
</body>

</html>