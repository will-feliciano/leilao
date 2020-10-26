<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    /** @var bool */
    private $finalizado = false;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if(!empty($this->lances) && $this->ehDoUltimoUsuario($lance)){
            throw new \DomainException("Usuário não pode propor 2 lances consecutivos");
        }

        $totalLancesUsuario = $this->qtdLancesPorUsuario($lance->getUsuario());

        if($totalLancesUsuario >= 5) {
            throw new \DomainException("Usuário não pode propor mais de 5 lances por leilão");
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    public function finaliza(): void
    {
        $this->finalizado = true;
    }

    public function estaFinalizado(): bool
    {
        return $this->finalizado;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    private function ehDoUltimoUsuario(Lance $lance): bool
    {
        $ultimoLance = $this->lances[count($this->lances) -1];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    private function qtdLancesPorUsuario(Usuario $usuario): int
    {
        return array_reduce(
            $this->lances, 
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario){
                if($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            }, 0
        );
    }
}
