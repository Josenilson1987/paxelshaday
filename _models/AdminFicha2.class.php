<?php

/**
 * AdminFicha.class [ MODEL CONTROLER ]
 * Responável por adicionar um valor a mais em cada requisito da tabela   !
 * 
 * @copyright (c) 2018, Josenilson Pereira
 */
class AdminFicha2 {

    private $Data;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'ficha_pagamento';

    /**
     * <b>Cadastrar Ficha de pagamento:</b> Envelope todos os campos, um array atribuitivo e execute esse método
     * para cadastrar a ficha. 
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->setData();
        $this->Create();
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
        $this->Data['ano_inicial']= $this->Data['ano_inicial'] + 1 ;
        $this->Data['ano_final'] = $this->Data['ano_final'] + 1 ;
        $this->Data['mes_inicial'] = Check::Name($this->Data['mes_inicial']);
        $this->Data['valor_parcela'] = Check::Name($this->Data['valor_parcela']);
        $this->Data['parcela_01'] = $this->Data['parcela_12'] + 1;
        $this->Data['parcela_02'] = $this->Data['parcela_01'] + 1;
        $this->Data['parcela_03'] = $this->Data['parcela_02'] + 1;
        $this->Data['parcela_04'] = $this->Data['parcela_03'] + 1;
        $this->Data['parcela_05'] = $this->Data['parcela_04'] + 1;
        $this->Data['parcela_06'] = $this->Data['parcela_05'] + 1;
        $this->Data['parcela_07'] = $this->Data['parcela_06'] + 1;
        $this->Data['parcela_08'] = $this->Data['parcela_07'] + 1;
        $this->Data['parcela_09'] = $this->Data['parcela_08'] + 1;
        $this->Data['parcela_10'] = $this->Data['parcela_09'] + 1;
        $this->Data['parcela_11'] = $this->Data['parcela_10'] + 1;
        $this->Data['parcela_12'] = $this->Data['parcela_11'] + 1;
        $this->Data['data_cadastrada'] = Check::Name($this->Data['data_cadastrada']);
        $this->Data['numero_ficha'] ++;
    }

    //Cadastra a ficha no banco!
    private function Create() {

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
        endif;
    }

}
