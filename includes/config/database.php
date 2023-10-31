<?php

function conectarDB(): mysqli
{
  $db = new mysqli("localhost", "root", "", "bienesraices_crud");
  if (!$db) {
    echo "Erro no se pudo conectar";
    exit;
  }

  return $db;
}
