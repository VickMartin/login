<?php

class UsuarioDTO{
    private $id_usuario;
    private $nome;
    private $email;
    private $cpf;
    private $senha;
    private $perfil;
    private $formacao;
    private $dataContratacao;
    private $telefone;
    private $endereco;

    public function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
  
    public function getId_usuario() {
        return $this->id_usuario;
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
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
  
    public function getCpf() {
        return $this->cpf;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }
  
    public function getSenha() {
        return $this->senha;
    }
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }
  
    public function getPerfil() {
        return $this->perfil;
    }
    public function setFormacao($formacao) {
        $this->formacao = $formacao;
    }
  
    public function getFormacao() {
        return $this->formacao;
    }
    public function setDataContratacao($dataContratacao) {
        $this->dataContratacao = $dataContratacao;
    }
  
    public function getDataContratacao() {
        return $this->dataContratacao;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
  
    public function getTelefone() {
        return $this->telefone;
    }
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
  
    public function getEndereco () {
        return $this->endereco;
    }

    
}




?>