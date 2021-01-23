<?php

class UsuarioController extends \HXPHP\System\Controller {

    public function __construct($configs) {
        parent::__construct($configs);
       
        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true);
        $this->auth->redirectCheck(true);
        $this->view->setHeader('headerFuncionario');
        
    }

    public function cadastrarAction() {
        $this->auth->redirectCheck(true);
        $this->view->setFile('index');
        $var = $this->request->post();
       
        $cadastrarUsuario = User::cadastrar($var);
        $this->load('Modules\Messages', 'auth');
        if ($cadastrarUsuario->status == true) {
            //trocar tela dps que outras telas(login for feito)
            $mensagem = array('success', 'Sucesso', 'Usuário cadastrado com sucesso.');

            
        }
        else{
            $this->load('Modules\Messages', 'auth');
            $this->messages->setBlock('alerts');
            $mensagem = array('danger', 'Não Foi possivel efetuar seu cadastro. Verifique os erros abaixo.', $cadastrarUsuario->errors);
            //$mensagem = $this->messages->getByCode($cadastrarUsuario->code);
        }
        
       $this->load('Helpers\Alert', $mensagem);   
    }
}

