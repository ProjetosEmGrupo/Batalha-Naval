<?php

class AlunoController extends \HXPHP\System\Controller {

    public function __construct($configs){
        parent::__construct($configs);
        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true);
        $user_id = $this->auth->getUserId();
        $this->auth->redirectCheck(false);
        $this->view->setHeader('headerAluno');
    }

    public function cadastroApontamentoAction($id_projeto){
        $this->view->setFile('apontamentohoras');
        $this->view->setVar('projeto', $id_projeto);
        $post = $this->request->post();
        if(!empty($post)){
            $teste = date('d-m-Y');
            $post['date_entry'] = DATE('Y-m-d'). " " . $post['entry']. ":00";
            $post['date_exit'] = DATE('Y-m-d'). " ". $post['exit'] .":00"; 
            $post['project_id'] = $id_projeto;
            $post['contributor_id'] = $this->auth->getUserId();
            unset($post['entry']);
            unset($post['exit']);
            $sql  = Pointer::create($post);
        }   
        else{

        }
    }

    public function menuJogoAction(){
        $this->view->setFile('menu-jogo');
        //$this->view->setVar('adm', );        
    }

    public function menuStatusAction(){
        $this->view->setFile('menustatus');
    }

    public function alterarUsuarioAction(){
        $this->view->setFile('alterarInformacoes');
        $this->view->setVar('usuario', User::find($this->auth->getUserId()));
        $post = $this->request->post();
        if(!empty($post)){
            if($post['password'] == $post['confirmpassword']){
                $password = \HXPHP\System\Tools::hashHX($post['password']);
                $post = array_merge($post, $password);
                unset($post['confirmpassword']);
                $usuario = User::find($this->auth->getUserId());
                $usuario->name = $post['name'];
                $usuario->login = $post['login'];
                $usuario->password = $password['password'];
                $usuario->salt = $password['salt'];
                $usuario->schoolings_id = $post['nivel'];
                $usuario->save();
                $this->view->setFile('menustatus');
                $mensagem = array('success', 'Sucesso', 'Informações do usuário alterada com sucesso.');
                $this->load('Helpers\Alert', $mensagem);
            }
            else{
                $mensagem = array('danger', 'Erro', 'Senhas não coincidem.');
                $this->load('Helpers\Alert', $mensagem);
                $this->view->setVar('post',$post);
            }
        } 
    }

    public function provaAction(){
        $this->view->setFile('prova');
        $prova = Test::find_by_schoolings_id_and_status_and_users_id($this->auth->getUserRole(), 1, GroupUser::find_by_users_id($this->auth->getUserId())->admin_id);
        
        if(!empty($prova)){
            $qt = QuestionTest::find_all_by_tests_id($prova->id);
            $this->view->setVar('prova', $qt);
        }
        else{
            $mensagem = array('danger', 'Erro', 'Prova Inexistente');
            $this->load('Helpers\Alert', $mensagem);

        }
        $post = $this->request->post();
        if(!empty($post)){

            $i = 0;
            if($post['q0'] == Question::find($qt[0]->questions_id)->answer){
                $i++;
            }
            if($post['q1'] == Question::find($qt[1]->questions_id)->answer){
                $i++;
            }
            if($post['q2'] == Question::find($qt[2]->questions_id)->answer){
                $i++;
            }
            if($post['q3'] == Question::find($qt[3]->questions_id)->answer){
                $i++;
            }
            if($post['q4'] == Question::find($qt[4]->questions_id)->answer){
                $i++;
            }
            if($post['q5'] == Question::find($qt[5]->questions_id)->answer){
                $i++;
            }
            if($post['q6'] == Question::find($qt[6]->questions_id)->answer){
                $i++;
            }
            if($post['q7'] == Question::find($qt[7]->questions_id)->answer){
                $i++;
            }
            if($post['q8'] == Question::find($qt[8]->questions_id)->answer){
                $i++;
            }
            if($post['q9'] == Question::find($qt[9]->questions_id)->answer){
                $i++;
            }

            $mensagem = array('info', 'Prova Concluida', 'Você acertou '.$i.' questões.');
            $this->view->setFile('menu-jogo');
            $this->load('Helpers\Alert', $mensagem);
        }
    }


    public function jogoAction(){
        $this->view->setFile('menu-jogo');
        //cookies 
        ///bomba
        //tests_id
        //user
        //acerto
        $pontuacao = (10000 - (($_COOKIE['bomba'] - 17) * 100)) * 0.1 * $_COOKIE['acerto'];

        $jogo = Group::create(array('pontuacao'=> ceil($pontuacao), 'users_id' => $this->auth->getUserId(), 'tests_id'=>$_COOKIE['tests_id']));
        $mensagem = array('Info', 'Jogo Finalizado', 'Pontuação: '.ceil($pontuacao).'<br>Bombas usadas: '.$_COOKIE['bomba'].'<br>Acertos na prova: '.$_COOKIE['acerto']);
        $this->load('Helpers\Alert', $mensagem);

    }

    public function provaJogoAction(){
        $this->view->setFile('provajogo');
        $prova = Test::find_by_schoolings_id_and_status_and_users_id($this->auth->getUserRole(), 1,  GroupUser::find_by_users_id($this->auth->getUserId())->admin_id);
        if(!empty($prova)){
            $qt = QuestionTest::find_all_by_tests_id($prova->id);
            $this->view->setVar('prova', $qt);
        }
        else{
            $mensagem = array('danger', 'Erro', 'Prova Inexistente');
            $this->load('Helpers\Alert', $mensagem);

        }
        $post = $this->request->post();
        if(!empty($post)){   
            $i = 0;
            if($post['q0'] == Question::find($qt[0]->questions_id)->answer){
                $i++;
            }
            if($post['q1'] == Question::find($qt[1]->questions_id)->answer){
                $i++;
            }
            if($post['q2'] == Question::find($qt[2]->questions_id)->answer){
                $i++;
            }
            if($post['q3'] == Question::find($qt[3]->questions_id)->answer){
                $i++;
            }
            if($post['q4'] == Question::find($qt[4]->questions_id)->answer){
                $i++;
            }
            if($post['q5'] == Question::find($qt[5]->questions_id)->answer){
                $i++;
            }
            if($post['q6'] == Question::find($qt[6]->questions_id)->answer){
                $i++;
            }
            if($post['q7'] == Question::find($qt[7]->questions_id)->answer){
                $i++;
            }
            if($post['q8'] == Question::find($qt[8]->questions_id)->answer){
                $i++;
            }
            if($post['q9'] == Question::find($qt[9]->questions_id)->answer){
                $i++;
            }
            $mensagem = array('info', 'Prova Concluida', 'Você acertou '.$i.' questões.');
            $this->view->setFile('menu-jogo');
            $this->load('Helpers\Alert', $mensagem);
            setcookie('tests_id',$prova->id, time()+3600, '/');
            $teste = $this->auth->getUserId();
            $user = User::find($teste);
            setcookie('user',$user->name, time()+3600, '/');
            setcookie('acerto',$i, time()+3600, '/');
            echo('<script language= "JavaScript">location.href="'. $this->configs->site->url . $this->configs->baseURI .'batalhanaval/jogo.php"</script>');
        }
    }

    public function rankingGrupoAction(){
        $this->view->setFile('ranking');
        $sql = 'SELECT id , tests_id, users_id, max(pontuacao) as p FROM `groups` where users_id = (select users_id from group_users where admin_id = '. GroupUser::find_by_users_id($this->auth->getUserId())->admin_id.' )  group by users_id ORDER by pontuacao desc ';
        $lista = Group::find_by_sql($sql);
        $this->view->setVar('lista', $lista);
    }

    public function desisteJogoAction(){
        $this->view->setFile('menu-jogo');
        $jogo = Group::create(array('pontuacao'=> ceil(0), 'users_id' => $this->auth->getUserId(), 'tests_id'=>$_COOKIE['tests_id']));
    }


}


