<?php
class MensagemDTO {
    private $alunoMatricula;
    private $idResponsavel;
    private $idTurma;
    private $idProfessor;
    private $mensagem;
    private $tipoMensagem;

   

    public function getAlunoMatricula() {
        return $this->alunoMatricula;
    }

    public function setAlunoMatricula($alunoMatricula) {
        $this->alunoMatricula = $alunoMatricula;
    }

    public function getIdResponsavel() {
        return $this->idResponsavel;
    }

    public function setIdResponsavel($idResponsavel) {
        $this->idResponsavel = $idResponsavel;
    }

    public function getIdTurma() {
        return $this->idTurma;
    }

    public function setIdTurma($idTurma) {
        $this->idTurma = $idTurma;
    }

    public function getIdProfessor() {
        return $this->idProfessor;
    }

    public function setIdProfessor($idProfessor) {
        $this->idProfessor = $idProfessor;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }
    public function getTipoMensagem() {
        return $this->tipoMensagem;
    }

    public function setTipoMensagem($tipoMensagem) {
        $this->tipoMensagem = $tipoMensagem;
    }


    
}
?>
