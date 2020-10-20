<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{   
    public function testObterMaiorValor()
    {
        $leilao = new Leilao("Fusca Branco");

        $jacy = new Usuario('Jacy');
        $will = new Usuario('Will');

        $leilao->recebeLance(new Lance($jacy, 1000));
        $leilao->recebeLance(new Lance($will, 1800));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $valor = $leiloeiro->getMaiorValor();

        self::assertEquals(1800, $valor);
    }

    public function testObterMenorValor()
    {
        $leilao = new Leilao("Fusca Branco");

        $jacy = new Usuario('Jacy');
        $will = new Usuario('Will');

        $leilao->recebeLance(new Lance($jacy, 1000));
        $leilao->recebeLance(new Lance($will, 1800));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $valor = $leiloeiro->getMenorValor();

        self::assertEquals(1000, $valor);
    }
}