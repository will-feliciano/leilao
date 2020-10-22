<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    /**
     * @dataProvider novoLeilao
     */
    public function testObterMaiorValor(Leilao $leilao)
    {        
        $leiloeiro = new Avaliador();

        $leiloeiro->avalia($leilao);

        $valor = $leiloeiro->getMaiorValor();

        self::assertEquals(2700, $valor);
    }

    /**
     * @dataProvider novoLeilao
     */
    public function testObterMenorValor(Leilao $leilao)
    {
        $leiloeiro = new Avaliador();

        $leiloeiro->avalia($leilao);

        $valor = $leiloeiro->getMenorValor();

        self::assertEquals(1500, $valor);
    }

    /**
     * @dataProvider novoLeilao
     */
    public function testObterMaioresLances(Leilao $leilao)
    {
        $leiloeiro = new Avaliador();

        $leiloeiro->avalia($leilao);
        $maiores = $leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(2700, $maiores[0]->getValor());
        static::assertEquals(2300, $maiores[1]->getValor());
        static::assertEquals(2000, $maiores[2]->getValor());
    }

    public function novoLeilao()
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

        return [
            [$leilao]
        ];
    }    
}