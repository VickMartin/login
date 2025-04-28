<?php

class AlunoDTO {
    private $nome;
    private $matricula;
    private $ano_ingresso;
    private $data_nascimento;
    private $tipo_sanguineo;
    private $deficiencia;
    private $alergia;
    private $nome_mae;
    private $id_responsavel;
    private $id_turma;
    private $foto;

    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getNome() {
            return $this->nome;
        }


    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getMatricula() {
            return $this->matricula;
        }

    public function setAnoIngresso($ano_ingresso) {
            $this->ano_ingresso = $ano_ingresso;
    }    
    public function getAnoIngresso() {
            return $this->ano_ingresso;
        }

    public function setTipoSanguineo($tipo_sanguineo) {
                $this->tipo_sanguineo = $tipo_sanguineo;
        }

    public function getTipoSanguineo() {
                return $this->tipo_sanguineo;
        }

    public function setDataNascimento($data_nascimento) {
            $this->data_nascimento = $data_nascimento;
        }

    public function getDataNascimento() {
            return $this->data_nascimento;
        }

    
    public function setDeficiencia($deficiencia) {
            $this->deficiencia = $deficiencia;
        }
    public function getDeficiencia() {
                return $this->deficiencia;
        }    

    public function setAlergia($alergia) {
        $this->alergia = $alergia;
    }
    public function getAlergia(){
        return $this->alergia;
    }


    public function setNomeMae($nome_mae) {
        $this->nome_mae = $nome_mae;
    }
    public function getNomeMae() {
        return $this->nome_mae;
        }


    public function setIdResponsavel($id_responsavel) {
        $this->id_responsavel = $id_responsavel;
    }
    public function getIdResponsavel() {
        return $this->id_responsavel;
    }
    public function setIdTurma($id_turma) {
        $this->id_turma = $id_turma;
    }
    public function getIdTurma() {
        return $this->id_turma;
    }
    public function setFoto($foto) {
        $this->foto = $foto;
    }
    public function getFoto() {
        return $this->foto;
    }

 
    
}
?>