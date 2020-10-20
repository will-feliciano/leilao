<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

$leilao = new Leilao("Fusca Branco");

$jacy = new Usuario('Jacy');
$will = new Usuario('Will');

$leilao->recebeLance(new Lance($jacy, 1000));
$leilao->recebeLance(new Lance($will, 1800));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$valor = $leiloeiro->getMaiorValor();

$valorEsperado = 1800;

if($valorEsperado == $valor){
    echo "TESTE OK";
} else {
    echo "FALHA NO TESTE";
}