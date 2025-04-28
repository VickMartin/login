<?php

class AtestadoDTO {
    private $id_atestado;
    private $imagem_atestado;
    private $data_atestado;
    private $id_aluno;
    private $id_responsavel;
    
    // Getters e setters
    public function getIdAtestado() {
        return $this->id_atestado;
    }

    public function setIdAtestado($id_atestado) {
        $this->id_atestado = $id_atestado;
    }

    public function getImagemAtestado() {
        return $this->imagem_atestado;
    }

    public function setImagemAtestado($imagem_atestado) {
        $this->imagem_atestado = $imagem_atestado;
    }

    public function getDataAtestado() {
        return $this->data_atestado;
    }

    public function setDataAtestado($data_atestado) {
        $this->data_atestado = $data_atestado;
    }

    public function getIdAluno() {
        return $this->id_aluno;
    }

    public function setIdAluno($id_aluno) {
        $this->id_aluno = $id_aluno;
    }

    public function getIdResponsavel() {
        return $this->id_responsavel;
    }

    public function setIdResponsavel($id_responsavel) {
        $this->id_responsavel = $id_responsavel;
    }
}

?>
