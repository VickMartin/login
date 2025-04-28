<?php

class AdmDTO {
    private $id_Adm;
    private $nome;
    private $email;
    private $senha;
    private $foto;

    public function setIdAdm($id_Adm) {
        $this->id_Adm = $id_Adm;
    }
  
    public function getIdAdm() {
        return $this->id_Adm;
    }
  
    public function setNome($nome) {
        $this->nome = $nome;
    }
  
    public function getNome() {
        return $this->nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
  
    public function getEmail() {
        return $this->email;
    }
   
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }
  
    public function getSenha() {
        return $this->senha;
    }
    public function setFoto($foto) {
        $this->foto = $foto;
    }
  
    public function getFoto() {
        return $this->foto;
    }

    
}
?>