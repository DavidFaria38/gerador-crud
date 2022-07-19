<?php

function file_submitted($field_name = 'file')
{
    return array_key_exists($field_name, $_FILES) && $_FILES[$field_name]['name'] != "";
}