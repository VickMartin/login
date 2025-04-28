<?php

class TurmaDTO {
    private $idAdm;
    private $professorResponsavel;
    private $ano;         
    private $nomeTurma;
    private $turno;
    
    public function setIdAdm($idAdm) {
        $this->idAdm = $idAdm;
    }
  
    public function getIdAdm() {
        return $this->idAdm;
    }
  
    public function setProfessorResponsavel($professorResponsavel) {
        $this->professorResponsavel = $professorResponsavel;
    }
  
    public function getProfessorResponsavel() {
        return $this->professorResponsavel;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }
  
    public function getAno() {
        return $this->ano;
    }
   
    
    public function setNomeTurma($nomeTurma) {
        $this->nomeTurma = $nomeTurma;
    }
  
    public function getNomeTurma() {
        return $this->nomeTurma;
    }
    public function setTurno($turno) {
        $this->turno = $turno;
    }
  
    public function getTurno() {
        return $this->turno;
    }
    
}
?>