<?php

require_once 'SpiderSintegraPR.php';

$spider = new SpiderSintegraPR();
$cnpj = '00063744000155';

$resultado = $spider->buscarInformacoes($cnpj);

if (is_array($resultado)) {
    print_r($resultado);
} else {
    echo $resultado;
}
