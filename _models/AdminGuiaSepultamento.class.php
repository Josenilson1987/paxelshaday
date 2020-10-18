<?php

/**
 * AdminClientes.class [ MODEL CONTROLER ]
 * Responável por gerenciar os clientes cadastrados  !
 * 
 * @copyright (c) 2018, Josenilson Pereira
 */
class AdminGuiaSepultamento {

    private $Data;
    private $clientes_id;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'guia_de_sepultamento';

    /**
     * <b>Cadastrar Jornada:</b> Envelope todos os campos, um array atribuitivo e execute esse método
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

    /**
     * <b>Deleta categoria:</b> Informe o ID de uma categoria para remove-la do sistema. Esse método verifica
     * o tipo de categoria e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $clientes_id = Id da categoria
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

        //        DADOS RESPONSÁLVEL PELO FUNERAL:

        $this->Data['data_do_cadastro'] = Check::Name($this->Data['data_do_cadastro']);
        $this->Data['nome_responsavel'] = Check::Name($this->Data['nome_responsavel']);
        $this->Data['cpf_responsavel'] = preg_replace("/[^\d]+/", "", $this->Data['cpf_responsavel']);
        $this->Data['telefone_responsavel'] = preg_replace("/[^\d]+/", "", $this->Data['telefone_responsavel']);
        $this->Data['n_responsavel'] = Check::Name($this->Data['n_responsavel']);
        $this->Data['bairro_responsavel'] = Check::Name($this->Data['bairro_responsavel']);
        $this->Data['cep_responsavel'] = preg_replace("/[^\d]+/", "", $this->Data['cpf_responsavel']);
        $this->Data['parentesco_responsavel'] = Check::Name($this->Data['parentesco_responsavel']);

        //INFORMAÇÕES DO FALECIDO
        $this->Data['nome_falecido'] = Check::Name($this->Data['nome_falecido']);
        $this->Data['cpf_falecido'] = preg_replace("/[^\d]+/", "", $this->Data['cpf_falecido']);
        $this->Data['data_nascimento'] = Check::Name($this->Data['data_nascimento']);
        $this->Data['idade_falecido'] = Check::Name($this->Data['idade_falecido']);
        $this->Data['data_falecimento'] = Check::Name($this->Data['data_falecimento']);
        $this->Data['sexo_falecido'] = Check::Name($this->Data['sexo_falecido']);
        $this->Data['local_do_falecimento'] = Check::Name($this->Data['local_do_falecimento']);

        //INFORMAÇÕES DO  FUNERAL:
        $this->Data['cemiterio_cepultado'] = Check::Name($this->Data['cemiterio_cepultado']);
        $this->Data['cartorio_registrado'] = Check::Name($this->Data['cartorio_registrado']);
        $this->Data['data_cepultamento'] = Check::Name($this->Data['data_cepultamento']);
        $this->Data['protocolo_marcacao'] = Check::Name($this->Data['protocolo_marcacao']);
        $this->Data['valor_servico'] = Check::Name($this->Data['valor_servico']);

        // FORMA DE PAGAMENTO AVISTA 
        $this->Data['tipo_de_pagamento'] = Check::Name($this->Data['tipo_de_pagamento']);


        //FORMA DE PAGAMENTO EM CARTÃO 
        //FORMA DE PAGAMENTO DINHEIRO + CARTÃO 
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro'] = Check::Name($this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro']);
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao'] = Check::Name($this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao']);
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_parcelas'] = Check::Name($this->Data['forma_de_pagamento_dinheiro_e_cartao_parcelas']);
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela'] = Check::Name($this->Data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela']);
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_bandeira'] = Check::Name($this->Data['forma_de_pagamento_dinheiro_e_cartao_bandeira']);
//        $this->Data['forma_de_pagamento_dinheiro_e_cartao_numero'] = preg_replace("/[^\d]+/", "", $this->Data['forma_de_pagamento_dinheiro_e_cartao_numero']);

        $this->Data['taxa_juros'] = Check::Name($this->Data['taxa_juros']);
    }

    //Cadastra os dados no banco!
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

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE clientes_id = :clientes_id", "clientes_id={$this->clientes_id}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> O Cliente {$this->Data["titular_nome"]} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }

}
