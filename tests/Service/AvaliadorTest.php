<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    /** @var Avaliador */
    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider novoLeilao
     */
    public function testObterMaiorValor(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $valor = $this->leiloeiro->getMaiorValor();

        self::assertEquals(2700, $valor);
    }

    /**
     * @dataProvider novoLeilao
     */
    public function testObterMenorValor(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $valor = $this->leiloeiro->getMenorValor();

        self::assertEquals(1500, $valor);
    }

    /**
     * @dataProvider novoLeilao
     */
    public function testObterMaioresLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);
        
        $maiores = $this->leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(2700, $maiores[0]->getValor());
        static::assertEquals(2300, $maiores[1]->getValor());
        static::assertEquals(2000, $maiores[2]->getValor());
    }

    public function testLeilaoVazioNãoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Não foi possível avaliar o leilão");

        $leilao = new Leilao("Fusca Azul");
        $this->leiloeiro->avalia($leilao);
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Leilão finalizado");

        $leilao = new Leilao("Brasília Amarela");
        $joao = new Usuario("João");
        $rita = new Usuario("Rita");

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($rita, 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
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
            "leiloes" => [$leilao]
        ];
    }    
}