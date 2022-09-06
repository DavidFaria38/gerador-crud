<style>
  .area-login {
    font-family: 'inter';
    color: #78788C;
    line-height: 43.57px;
    font-weight: 300;
  }

  .card {
    border-radius: 12px;
  }

  .card-body-login {
    border-radius: 80px;
    padding: 0px 120px;
  }

  .submit-lente-login {
    position: relative;
    top: 12px;
    right: 20%;
    z-index: 10;
    border: none;
    background: transparent;
    outline: none;
  }

  .submit-line-login {
    position: relative;
  }

  .submit-line-login input {
    width: 100%;
  }

  .links-login {
    position: relative;
    top: -10px;
    margin-bottom: 30px;
    height: 20px;

  }

  #recuperar-senha-login {
    top: 10px;
    font-weight: bold;
    font-size: small;
    color: #00A8FF;
    position: absolute;
  }

  #acessar-login {
    position: absolute;
    top: 2px;
    border-radius: 15px;
  }

  .logo {
    width: 80%;
  }

  .logo-box {
    text-align: center;
    padding-top: 1%;
    padding-bottom: 10%;
    border-radius: 12px;

  }

  img {
    width: 80%;
  }

  #curiosidade-login {
    margin: 0px 100px 0px 0px;
  }

  .curiosidade-login {
    color: #fff !important;
    font-family: report-school, sans-serif;
    font-style: normal;
    font-weight: 600, regular;
    font-size: 28px;
    position: relative;
    line-height: 43.57px;
    margin-bottom: 20px;
  }

  /* CSS Comum Area Login - Fim */

  /* CSS Recuperar Senha - Inicio */
  .corpo-login-recuperar-senha {
    margin-top: 23px;
    margin-bottom: 16px;
    border-radius: 12px;
    background-color: #fff;
  }

  .buttons-recuperar-senha {
    margin-top: 18px;
  }
</style>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Modelo::login</title>
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
  <link rel="stylesheet" href="<?= base_url_assets('aluno-theme/css/login-theme.css') ?>">
  <!-- Icone -->
  <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

</head>

<body class="hold-transition container login-page">
  <div class="row">
  </div>
  <div class="login-box offset-lg-8 ">
    <div class="card">
      <?= form_open(base_url_usuario('login')) ?>
      <div class="card-body card-body-login">
        <div class="row logo-box justify-content-center">
          <h4 class="col-12 area-login">Login Usuário</h4>
          <!-- <img src="<?= base_url_assets('img/peee+datte.png') ?>"> -->
        </div>
        <?= form_validation_errors() ?>
        <?= get_flash_message('login') ?>
        <div class="form-group mb-3">
          <input type="text" maxlength="14" name="usu_cpf" id="usu_cpf" class="form-control" required placeholder="CPF">
        </div>
        <div class="form-group submit-line-login input-group-append">
          <input type="password" maxlength="50" name="usu_senha" id="password" required class="form-control input-gray" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <span class="submit-lente-login">
            <i class="lnr lnr-eye"></i>
          </span>
        </div>
      </div>
      <div class="row links-login">
        <div class="col-4 offset-1">
          <button type="submit" class="btn btn-primary btn-block" id="acessar-login">ACESSAR</button>
        </div>
        <?= form_close() ?>
        <p class="col-8 offset-6 recuperar-senha-login-box">
          <a id="recuperar-senha-login" href="<?= base_url_usuario('recuperar_senha') ?>">ESQUECI MINHA SENHA</a>
        </p>
      </div>
    </div>
  </div>


  <!-- jQuery -->
  <script src="<?= base_url_assets('plugins/jquery/jquery.min.js') ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url_assets('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url_assets('dist/js/adminlte.min.js') ?>"></script>

  <script src="<?= base_url_assets('plugins/inputmask/jquery.inputmask.min.js') ?>"></script>

  <script src="<?= base_url_assets('plugins/jquery-validation/jquery.validate.min.js') ?>"></script>

  <script src="<?= base_url_assets('plugins/jquery-validation/additional-methods.min.js') ?>"></script>

  <script src="<?= base_url_assets('plugins/jquery-validation/validate-cpf.js') ?>"></script>

  <script src="<?= base_url_assets('plugins/jquery-validation/localization/messages_pt_BR.min.js') ?>"></script>

  <script>
    $(function() {
      $('#usu_cpf').inputmask('999.999.999-99');

      $('form').validate({
        rules: {
          usu_cpf: {
            required: true,
            minlength: 14,
            cpf: true
          },
          usu_senha: {
            required: true,
            minlength: 6
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          /*   $(element).addClass('is-invalid'); */
          $(element).attr('style', 'border: solid 0.5px #ff0000;margin-top:2px');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    })
    /* Senha */
    let btn = document.querySelector('.lnr-eye');

    btn.addEventListener('click', function() {

      let input = document.querySelector('#password');

      if (input.getAttribute('type') == 'password') {
        input.setAttribute('type', 'text');
      } else {
        input.setAttribute('type', 'password');
      }

    });
  </script>

</body>

</html>