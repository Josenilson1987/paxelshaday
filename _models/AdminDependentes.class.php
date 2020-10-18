<?php

/**
 * AdminClientes.class [ MODEL CONTROLER ]
 * Responável por gerenciar os clientes cadastrados  !
 * 
 * @copyright (c) 2018, Josenilson Pereira
 */
class AdminDependentes {

    private $Data;
    private $dependentes_id;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'dependentes';

    /**
     * <b>Cadastrar Jornada:</b> Envelope todos os campos, um array atribuitivo e execute esse método
     * para cadastrar a Jornada. 
     * @param ARRAY $data = Atribuitivo
     */
    public function ExeCreate(array $data) {
        $this->Data = $data;
        $this->setData();
        $this->Create();
    }

    /**
     * <b>Atualizar Categoria:</b> Envelope os dados em uma array atribuitivo e informe o id de uma
     * categoria para atualiza-la!
     * @param INT $clientes_id = Id da categoria
     * @param ARRAY $data = Atribuitivo
     */
    public function ExeUpdate($dependentes_id, array $Data) {
        $this->dependentes_id = (int) $dependentes_id;
        $this->Data = $Data;
        $this->setData();
        $this->Update();
    }

    /**
     * <b>Deleta categoria:</b> Informe o ID de uma categoria para remove-la do sistema. Esse método verifica
     * o tipo de categoria e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $clientes_id = Id da categoria
     */
    public function ExeDelete($dependentes_id) {
        $this->$dependentes_id = (int) $dependentes_id;

        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE dependentes_id = :delid", "delid={$this->$dependentes_id}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Oppsss, você tentou remover um cadastro  que não existe no sistema!', WS_INFOR];
        else:
            $delete = new Delete;
            $delete->ExeDelete(self::Entity, "WHERE dependentes_id = :deletaid", "deletaid={$this->$dependentes_id}");


            $this->Result = true;
            $this->Error = ["O ID <b>{$dependentes_id}</b>  foi removido com sucesso do sistema!", WS_ERROR];
            
        endif;
    }
    
  
    
   
   /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não. Para verificar
     * erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com a mensagem e o tipo de erro!
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        $this->Data['cpf_titular'] = Check::Name($this->Data['cpf_titular']);
        $this->Data['lixeira'] = Check::Name($this->Data['lixeira']);
        $this->Data['dependentes_nome'] = Check::Name($this->Data['dependentes_nome']);
        $this->Data['rg'] = preg_replace("/[^\d]+/", "", $this->Data['rg']);
        $this->Data['cpf_dep'] = Check::Name($this->Data['cpf_dep']);
        $this->Data['data_nascimento'] = Check::Name($this->Data['data_nascimento']);
        $this->Data['grau_de_parentesco'] = Check::Name($this->Data['grau_de_parentesco']);
       
        
        
    }

    //Cadastra a jornada no banco!
    private function Create() {

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
        endif;
    }

    //Atualiza Categoria
    private function Update() {
        $Update = new Update;
   
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE dependentes_id = :dependentes_id", "dependentes_id={$this->dependentes_id}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> O Dependente {$this->Data["dependentes_nome"]} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }

}
