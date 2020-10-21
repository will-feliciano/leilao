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

    public function testObterMaioresLances()
    {
        $leilao = new Leilao("Parati 1998 50km");

        $jacy = new Usuario('Jacy');
        $will = new Usuario("Will");
        $wal = new Usuario("Wal");
        $dani = new Usuario("Dani");

        $leilao->recebeLance(new Lance($jacy, 1500));
        $leilao->recebeLance(new Lance($will, 2000));
        $leilao->recebeLance(new Lance($wal, 2700));
        $leilao->recebeLance(new Lance($dani, 2300));

        $leiloeiro = new Avaliador();

        $leiloeiro->avalia($leilao);
        $maiores = $leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(2700, $maiores[0]->getValor());
        static::assertEquals(2300, $maiores[1]->getValor());
        static::assertEquals(2000, $maiores[2]->getValor());
    }
}