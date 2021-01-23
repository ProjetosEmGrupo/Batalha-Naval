<?php

class LoginController extends \HXPHP\System\Controller {

    public function __construct($configs) {
        parent::__construct($configs);
        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true);

    }

    public function indexAction() {
        $this->auth->redirectCheck(true);
        $this->view->setFile('index');
    }

    public function logarAction() {
        $this->auth->redirectCheck(true);
        $this->view->setFile('index');
        $post = $this->request->post();
        if (!empty($post))
            $logarUsuario = User::logar($post);
              
        if ($logarUsuario->status === true) {
            $this->auth->login($logarUsuario->contributor->id, $logarUsuario->contributor->login, $logarUsuario->contributor->schoolings_id);
        } else {
            $this->load('Modules\Messages', 'auth');
            $this->messages->setBlock('alerts');
            $error = $this->messages->getByCode($logarUsuario->code);
            $this->load('Helpers\Alert', $error);
        }
    }

    public function sairAction() {
        return $this->auth->logout();
    }

    public function redefineAction() {
       
        $this->view->setFile('r');
    }

    public function solicitarAction(){
        $this->view->setFile('r');
        $this->load('Modules\Messages', 'password-recovery');
        $this->messages->setBlock('alerts');
        $post = $this->request->post();
        $error = null;
        $sucess = null;
        
            $usuario = User::pesquisar($post['email']);
            if($usuario->status === false){
                $error = $this->messages->getByCode($usuario->code);
            }
            else{

                $this->load('Services\PasswordRecovery', $this->configs->site->url . $this->configs->baseURI . 'recuperar/alterar/' . $usuario->contributor->id .'/' . $usuario->contributor->password);        
                

                $message = $this->messages->messages->getByCode('link-enviado', array('message' => array($usuario->contributor->name, $this->passwordrecovery->link, $this->passwordrecovery->link)));


                $sucess = $this->messages->getByCode('link-enviado'); 
            }   
        if(!is_null($error)){
            $this->load('Helpers\Alert', $error);
        }
        else{
            $this->load('Helpers\Alert', $sucess);          
            echo $message['message'];
            Header( "HTTP/1.1 301 Moved Permanently" );
            echo( '<script language= "JavaScript">location.href="'. $this->configs->site->url . $this->configs->baseURI . 'login/alterar/' . $usuario->contributor->id .'/' . $usuario->contributor->password .'"</script>');
        
        }
    }

    public function redefinirAction($id){
        $this->view->setFile('redefinir');
        $password = $this->request->post();

        
            if($password['password'] == $password['confirmpassword'] && $password['password'] !== ""){
                $alteracao = User::redefinirSenha($id, $password['password']);          
                                        
                $this->view->setFile('index');
                $mensagem = array(
                'success',
                'Sucesso',
                'O senha redefinida com sucesso');
                
                $this->load('Helpers\Alert', $mensagem);

            }
            else{
                $this->view->setVar('id', $id);
                $mensagem = array(
                'danger',
                'Erro',
                'O senhas não coincidem. Por favor digite as senhas novamente');
                
                $this->load('Helpers\Alert', $mensagem);


                 
            }
            
            
            $this->load('Messages\password-recovery', $mensagem);
    }

    public function alterarAction($id, $token){
        $this->view->setFile('redefinir');
        $password = $this->request->post();
        
        if(is_null($password)){ 
        $teste = User::find_by_id($id);
            if($teste->password === $token){
                $this->view->setVar('id', $id);
            }
            else{
                $mensagem = array(
                'danger',
                'Erro',
                'O link de redefinição de senha é inválido');
                $this->view->setFile('blank');
                $this->load('Helpers\Alert', $mensagem);
            }   
        }
    }


}
