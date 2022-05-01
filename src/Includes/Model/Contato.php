<?php
namespace Includes\Model;

/**
 * @Entity
 */
class Contato {

    /**
     * @Id
     * @GenerateValue
     * @Column(type="integer")
     */
    private int $id;

    /**
     * @Column(type="boolean")
     */
    private string $tipo;

    /**
     * @Column(type="string")
     */
    private string $descricao;

    /**
     * @Column(type="integer")
     */
    private string $idPessoa;

    public function getId(): int {
        return $this->id;
    }

    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getIdPessoa(): int {
        return $this->idPessoa;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
}