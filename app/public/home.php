<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Gerador Base</title>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>


</head>

<style>
  body {
    background-color: lightgray;
  }

  table tbody td:first-child {
    width: 10px;
    text-align: center;
  }

  table tbody td:last-child {
    width: 10px;
    text-align: center;
  }
</style>

<body>
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <div class="form-group">
              <div class="col-md-6">
                <label for="select_framework">Selecione o framework</label>
                <select name="select_framework" id="select_framework">
                  <?php foreach (FRAMEWORK_LIST as $key => $framework) { ?>
                    <option value="<?= $framework['name'] ?>"><?= $framework['title'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <hr>

            <div class="form-group">
              <table class="table datatable display cell-border">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tabela</th>
                    <th>Quantidade elementos</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                    <td>
                      <input type="checkbox" name="select_all" id="select_all">
                      <label for="select_all">Selecionar todos</label>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <hr>
            <br>

            <div class="form-group">
              <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary btn-submit btn-lg m-1" title="Gerar somente os itens selecionados.">Gerar Itens</button>
                <a class="btn btn-warning btn-lg m-1" href="<?= BASEURL ?>/create_database" title="Criar banco de dados e tabela do gerador.">CREATE DATABASE</a>
                <a class="btn btn-danger btn-lg m-1" href="<?= BASEURL ?>/trucate_database" title="Limpar/remover dados da tabela do gerador.">TRUNCATE TABLE</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>


<script>
  $(document).ready(() => {
    $.ajax({
      url: '<?= BASEURL ?>/get_tables',
      type: 'post',
      dataType: 'json',
      success: ((response) => {
        console.log(response);

        const list_table_names = response.table_name;

        if(list_table_names.length == 0){
          let tr = document.createElement('tr');
          let td1 = document.createElement('td');
          td1.innerHTML = `Nenhuma tabela foi encontrada`;
          tr.appendChild(td1);
          $('table tbody').append(tr);
        }

        list_table_names.forEach(element => {

          let tr = document.createElement('tr');
          let td1 = document.createElement('td');
          let td2 = document.createElement('td');
          let td3 = document.createElement('td');
          // console.log(element);

          td1.innerHTML = `<input type="checkbox" name="table_selected" id="table_selected">`;
          td2.innerHTML = `${element.gerbas_nomeTabelaDB}`;
          td3.innerHTML = `${element.quantidade_elementos}`;
          tr.appendChild(td1);
          tr.appendChild(td2);
          tr.appendChild(td3);

          $('table tbody').append(tr);
        });
        $('table').DataTable();

      })
    })

    $('input[type=checkbox]').prop('checked', false);
    $('#select_all').change((el) => {
      const $this = $(el.target);
      const selected = $this.prop('checked');
      $('input[type=checkbox]').prop('checked', selected);
    })

    $('.btn-submit').click((ev) => {

      let select_framework = $('#select_framework').val();


      let selected_input = $('tbody input[type=checkbox]');
      let arr_selected_table = [];

      selected_input.each((index, element) => {
        let el = $(element);
        if (el.prop('checked')) {
          let table_name = el.parent().siblings().eq(0).text();
          arr_selected_table.push(table_name)
        }
      });

      if (arr_selected_table.length == 0 || !select_framework) {
        alert('Campos obrigatorios não foram preenchidos');
        return false;
      }
      console.log(arr_selected_table);
      console.log(select_framework);
      $.ajax({
        url: '<?= BASEURL ?>/make',
        type: 'get',
        dataType: 'json',
        data: {
          selectedTables: arr_selected_table,
          frameworkType: select_framework
        },
        success: (response) => {
          console.log(response);
          if (response.error){
            alert(response.error);
          } else {
            alert(response.success);
          }
        }
      });
    })
  });
</script>

</html>