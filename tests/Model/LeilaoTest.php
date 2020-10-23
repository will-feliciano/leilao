<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(
        int $qtdLances,
        Leilao $leilao,
        array $valores
    ) {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $index => $valor){
            static::assertEquals($valor, $leilao->getLances()[$index]->getValor());
        }
        static::assertCount($qtdLances, $leilao->getLances());
    }

    public function testLeilaoNaoDeveReceberLanceRepetido()
    {
        $leilao = new Leilao("Gol Quadrado Prata");
        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 1700));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = new Leilao("Opala Marrom");
        $joao = new Usuario("João");
        $maria = new Usuario("Maria");

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));

        $leilao->recebeLance(new Lance($joao, 5000));
        
        static::assertCount(10, $leilao->getLances());
        static::assertEquals(4500, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    public function geraLances()
    {
        $joao = new Usuario("João");
        $rita = new Usuario("Rita");

        $leilao2lances = new Leilao("Fiat Strada 2015");
        $leilao2lances->recebeLance(new Lance($joao, 1500));
        $leilao2lances->recebeLance(new Lance($rita, 2000));

        $leilao1lance = new Leilao("Chevrolet Agile");
        $leilao1lance->recebeLance(new Lance($rita, 3000));

        return [
            "leilao 2 lances" => [2, $leilao2lances, [1500, 2000]],
            "leilao 1 lance" => [1, $leilao1lance, [3000]]
        ];
    }
}