<?php

/**
 * AdminClientes.class [ MODEL CONTROLER ]
 * Responável por gerenciar os clientes cadastrados  !
 * 
 * @copyright (c) 2018, Josenilson Pereira
 */
class AdminClientes {

    private $Data;
    private $clientes_id;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'clientes';

    /**
     * <b>Cadastrar clientes:</b> Envelope todos os campos, um array atribuitivo e execute esse método
     * para cadastrar a Jornada. 
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->setData();
        $this->Create();
    }

    /**
     * <b>Atualizar Categoria:</b> Envelope os dados em uma array atribuitivo e informe o id de uma
     * categoria para atualiza-la!
     * @param INT $clientes_id = Id da categoria
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($clientes_id, array $Data) {
        $this->clientes_id = (int) $clientes_id;
        $this->Data = $Data;
        $this->setData();
        $this->Update();
    }

    public function Exelixeira($clientes_id, array $Data) {
        $this->clientes_id = (int) $clientes_id;
        $this->Data = $Data;
        $this->setData2();
        $this->Update();
    }

    /**
     * <b>Deleta o registro:</b> Informe o ID de uma registro para remove-la do sistema. Esse método verifica
     * o tipo de registro e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $clientes_id = Id do registro
     */
    public function ExeDelete($clientes_id) {
        $this->$clientes_id = (int) $clientes_id;

        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE clientes_id = :delid", "delid={$this->$clientes_id}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Oppsss, você tentou remover um cadastro  que não existe no sistema!', WS_INFOR];
        else:
            $delete = new Delete;
            $delete->ExeDelete(self::Entity, "WHERE clientes_id = :deletaid", "deletaid={$this->$clientes_id}");


            $this->Result = true;
            $this->Error = ["A Jornada <b>{$clientes_id}</b> o cliente foi removido com sucesso do sistema!", WS_ERROR];

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
        $this->Data['usuarios_empresa_cnpj'] = Check::Name($this->Data['usuarios_empresa_cnpj']);

        $this->Data['titular_nome'] = Check::Name($this->Data['titular_nome']);
        $this->Data['rg'] = preg_replace("/[^\d]+/", "", $this->Data['rg']);
        $this->Data['cpf_titular'] = preg_replace("/[^\d]+/", "", $this->Data['cpf_titular']);
        $this->Data['estado_civil'] = Check::Name($this->Data['estado_civil']);
        $this->Data['endereco'] = Check::Name($this->Data['endereco']);
        $this->Data['n_endereco'] = Check::Name($this->Data['n_endereco']);
        $this->Data['bairro'] = Check::Name($this->Data['bairro']);
        $this->Data['cep'] = preg_replace("/[^\d]+/", "", $this->Data['cep']);
        $this->Data['estado'] = Check::Name($this->Data['estado']);
        $this->Data['cidade'] = Check::Name($this->Data['cidade']);
        $this->Data['naturalidade'] = Check::Name($this->Data['naturalidade']);
        $this->Data['telefone'] = preg_replace("/[^\d]+/", "", $this->Data['telefone']);
        $this->Data['data_de_nascimento'] = Check::Name($this->Data['data_de_nascimento']);
        $this->Data['nome_do_pai'] = Check::Name($this->Data['nome_do_pai']);
        $this->Data['pai_vivo_falecido'] = Check::Name($this->Data['pai_vivo_falecido']);
        $this->Data['nome_da_mae'] = Check::Name($this->Data['nome_da_mae']);
        $this->Data['mae_viva_falecida'] = Check::Name($this->Data['mae_viva_falecida']);
        $this->Data['profissao'] = Check::Name($this->Data['profissao']);
        $this->Data['religiao'] = Check::Name($this->Data['religiao']);
        $this->Data['nacionalidade'] = Check::Name($this->Data['nacionalidade']);
        $this->Data['tipo_de_plano'] = Check::Name($this->Data['tipo_de_plano']);
        $this->Data['valor_do_plano'] = preg_replace("/[^\d]+/", ",", $this->Data['valor_do_plano']);
        $this->Data['data_primeiro_pagamento'] = Check::Name($this->Data['data_primeiro_pagamento']);
        $this->Data['tipo_de_urna'] = ($this->Data['tipo_de_urna']);
        $this->Data['modelo_de_urna'] = ($this->Data['modelo_de_urna']);
        $this->Data['lixeira'] = Check::Name($this->Data['lixeira']);
    }

    function setData2() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['lixeira'] = Check::Name($this->Data['lixeira'] = 1);
    }

    //Cadastra o cliente no banco!
    private function Create() {

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
        endif;
    }

    //Atualiza cliente
    private function Update() {
        $Update = new Update;

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE clientes_id = :clientes_id", "clientes_id={$this->clientes_id}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> O Cliente {$this->Data["titular_nome"]} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }

}
