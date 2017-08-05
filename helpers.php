<?php

function view($name, $data = [])
{
    extract($data);

    return require __DIR__."/views/{$name}.view.php";
}

function redirect($path)
{
    header("Location: /{$path}");
}