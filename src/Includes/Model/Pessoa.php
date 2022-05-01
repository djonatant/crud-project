<?php
namespace Includes\Model;

/**
 * @Entity
 */
class Pessoa {

    /**
     * @Id
     * @GenerateValue
     * @Column(type="integer")
     */
    private int $id;

    /**
     * @Column(type="string")
     */
    private string $nome;

    /**
     * @Column(type="string")
     */
    private string $cpf;

    public function getId(): int {
        return $this->id;
    }

    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

}