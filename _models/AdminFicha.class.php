<?php

/**
 * AdminClientes.class [ MODEL CONTROLER ]
 * Responável por gerenciar os clientes cadastrados  !
 * 
 * @copyright (c) 2018, Josenilson Pereira
 */
class AdminFicha {

    private $Data;
    private $ficha_pagamento_id;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'ficha_pagamento';

    /**
     * <b>Cadastrar Ficha de pagamento:</b> Envelope todos os campos, um array atribuitivo e execute esse método
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
     * @param INT $ficha_pagamento_id = Id da tabela
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($ficha_pagamento_id, array $Data) {
        $this->ficha_pagamento_id = (int) $ficha_pagamento_id;
        $this->Data = $Data;
        $this->setData();
        $this->Update();
    }

    /**
     * <b>Deleta categoria:</b> Informe o ID de uma categoria para remove-la do sistema. Esse método verifica
     * o tipo de categoria e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $clientes_id = Id da categoria
     */
    public function ExeDelete($ficha_pagamento_id) {
        $this->$ficha_pagamento_id = (int) $ficha_pagamento_id;

        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE ficha_pagamento_id = :delid", "delid={$this->$ficha_pagamento_id}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Oppsss, você tentou remover um cadastro  que não existe no sistema!', WS_INFOR];
        else:
            $delete = new Delete;
            $delete->ExeDelete(self::Entity, "WHERE ficha_pagamento_id = :deletaid", "deletaid={$this->$ficha_pagamento_id}");


            $this->Result = true;
            $this->Error = ["A Ficha <b>{$ficha_pagamento_id}</b> foi removido com sucesso do sistema!", WS_ERROR];

        endif;
    }

    public function Exelixeira($clientes_id, array $Data) {
        $this->clientes_id = (int) $clientes_id;
        $this->Data = $Data;
        $this->setData();
        $this->Update();
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

        $this->Data['titular_nome'] = Check::Name($this->Data['titular_nome']);
        $this->Data['cpf_titular'] = Check::Name($this->Data['cpf_titular']);
        $this->Data['n_contrato'] = preg_replace("/[^\d]+/", "", $this->Data['n_contrato']);
        $this->Data['ano_inscricao'] = Check::Name($this->Data['ano_inscricao']);
        $this->Data['ano_inicial'] = Check::Name($this->Data['ano_inicial']);
        $this->Data['ano_final'] = Check::Name($this->Data['ano_final']);
        $this->Data['mes_inicial'] = Check::Name($this->Data['mes_inicial']);
        $this->Data['valor_parcela'] = Check::Name($this->Data['valor_parcela']);
        $this->Data['parcela_01'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_01']);
        $this->Data['parcela_02'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_02']);
        $this->Data['parcela_03'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_03']);
        $this->Data['parcela_04'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_04']);
        $this->Data['parcela_05'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_05']);
        $this->Data['parcela_06'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_06']);
        $this->Data['parcela_07'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_07']);
        $this->Data['parcela_08'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_08']);
        $this->Data['parcela_09'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_09']);
        $this->Data['parcela_10'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_10']);
        $this->Data['parcela_11'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_11']);
        $this->Data['parcela_12'] = preg_replace("/[^\d]+/", ",", $this->Data['parcela_12']);
        $this->Data['data_cadastrada'] = Check::Name($this->Data['data_cadastrada']);
        $this->Data['numero_ficha'] = Check::Name($this->Data['numero_ficha']);
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

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE ficha_pagamento_id = :ficha_pagamento_id", "ficha_pagamento_id={$this->ficha_pagamento_id}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> O Cliente {$this->Data["titular_nome"]} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }

}
