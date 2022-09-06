<?php

function vd($element, $die = FALSE)
{
  var_dump('<pre>', $element, '</pre>');
  if ($die) {
    die;
  }
}
