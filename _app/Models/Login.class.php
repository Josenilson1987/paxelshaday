<?php

/**
 * Login.class [ MODEL ]
 * Responável por autenticar, validar, e checar usuário do sistema de login!
 * 
 * @copyright (c) 2018 JOSENILSON PEREIRA 
 */
class Login {

    private $Level;
    private $Usuario;
    private $Senha;
    private $empresa_status;
    private $Error;
    private $Result;

    /**
     * <b>Informar Level:</b> Informe o nível de acesso mínimo para a área a ser protegida.
     * @param INT $Level = Nível mínimo para acesso
     */
    function __construct($Level, $empresa_status) {
        $this->Level = (int) $Level;
        $this->empresa_status = (int) $empresa_status;
    }

    /**
     * <b>Efetuar Login:</b> Envelope um array atribuitivo com índices STRING user [email], STRING pass.
     * Ao passar este array na ExeLogin() os dados são verificados e o login é feito!
     * @param ARRAY $UserData = user [email], pass
     */
    public function ExeLogin(array $UserData) {
        $this->Usuario = (string) strip_tags(trim($UserData['user']));
        $this->Senha = (string) strip_tags(trim($UserData['pass']));
        $this->setLogin();
    }

    /**
     * <b>Verificar Login:</b> Executando um getResult é possível verificar se foi ou não efetuado
     * o acesso com os dados.
     * @return BOOL $Var = true para login e false para erro
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com uma mensagem e um tipo de erro WS_.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /**
     * <b>Checar Login:</b> Execute esse método para verificar a sessão USERLOGIN e revalidar o acesso
     * para proteger telas restritas.
     * @return BOLEAM $login = Retorna true ou mata a sessão e retorna false!
     */
    public function CheckLogin() {
        if (empty($_SESSION['usuario_nome']) || $_SESSION['usuario_nome']['usuario_nivel'] < $this->Level ['empresa_status']):
            unset($_SESSION['usuario_nome']);
            return false;
        else:
            return true;
        endif;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida os dados e armazena os erros caso existam. Executa o login!
    private function setLogin() {

        if (!$this->Usuario || !$this->Senha || !Check::Email($this->Usuario)):
            $this->Error = ['Informe seu E-mail e senha para efetuar o login!', WS_INFOR];
            $this->Result = false;
        elseif (!$this->getUser()):
            $this->Error = ['Os dados informados não são compatíveis!', WS_ALERT];
            $this->Result = false;
        elseif ($this->Result['usuario_nivel'] < $this->Level):
            $this->Error = ["Desculpe {$this->Result['usuario_login']}, você não tem permissão para acessar esta área!", WS_ERROR];
            $this->Result = false;
        elseif ($this->Result['empresa_status'] < $this->empresa_status):
            $this->Error = ["Desculpe {$this->Result['empresa']}, Empresa bloqueado favor entrar em contato com o Adminstrador ", WS_ERROR];
            $this->Result = false;
        else:
            $this->Execute();

        endif;
    }

    //Vetifica usuário e senha no banco de dados!
    private function getUser() {
        //   $this->Senha = md5($this->Senha);
        $read = new Read;
        $read->ExeRead("usuarios", "WHERE usuario_login = :e AND usuario_senha = :p", "e={$this->Usuario}&p={$this->Senha}");

        if ($read->getResult()):
            $this->Result = $read->getResult()[0];
            return true;
        else:
            return false;
        endif;
    }

    //Executa o login armazenando a sessão!
    private function Execute() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['usuario_login'] = $this->Result;
        $_SESSION['usuario_nome'] = $this->Result;
        $_SESSION['usuario_nivel'] = $this->Result;
        $_SESSION['empresa'] = $this->Result;
        $_SESSION['empresa_cnpj'] = $this->Result;

        $this->Error = ["Olá {$this->Result['usuario_nome']}, seja bem vindo(a). Aguarde redirecionamento!", WS_ACCEPT];
        $this->Result = true;
    }

}
