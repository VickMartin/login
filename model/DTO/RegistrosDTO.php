<?php
class RegistrosDTO {
    private $id_registro;      // ID do registro
    private $id_aluno;         // ID do aluno
    private $id_responsavel;   // ID do responsável
    private $documento;        // Nome do arquivo (documento)
    private $tipo_documento;   // Tipo de documento (relatório ou notas)
    private $datetime;         // Data e hora do registro

    // Getters e Setters

    public function getIdRegistro() {
        return $this->id_registro;
    }

    public function setIdRegistro($id_registro) {
        $this->id_registro = $id_registro;
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

    public function getDocumento() {
        return $this->documento;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function getTipoDocumento() {
        return $this->tipo_documento;
    }

    public function setTipoDocumento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
    }
}
?>
