<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Modelo::Recuperar Senha</title>
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

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?= base_url_usuario('login') ?>"><b>PEEE</b> Gestão</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <?= form_open(base_url_usuario('recuperar_senha')) ?>
        <?= form_validation_errors() ?>
        <?= get_flash_message('recuperar_senha') ?>
        <div class="input-group mb-3">
          <input type="text" maxlength="14" required name="usr_cpf" id="usr_cpf" class="form-control" placeholder="CPF">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Recuperar a senha</button>
          </div>
          <!-- /.col -->
        </div>
        <?= form_close() ?>

        <p class="mt-3 mb-1">
          <a href="<?= base_url_usuario('login') ?>">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

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

  <script>
    $(function() {
      $('#usr_cpf').inputmask('999.999.999-99');

      $('form').validate({
        rules: {
          usr_cpf: {
            required: true,
            minlength: 14,
            cpf: true
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    })
  </script>

</body>

</html>