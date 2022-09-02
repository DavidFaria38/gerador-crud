<?php 

function redirect($url = "") {
  $js_redirect = '
    <script type="text/javascript">
      console.log("redirecionado para url: \''.$url.'\'");
      window.location=\''.$url.'\';
    </script>';

  exit($js_redirect);
}