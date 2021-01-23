<?php

class DocenteController extends \HXPHP\System\Controller {
	
	public function __construct($configs) {
		parent::__construct($configs);
		$this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true);
		$this->auth->redirectCheck(false);
    //$this->auth->rolecheck(array(1));
    //$user_id = $this->auth->getUserId();
		$this->view->setHeader('headerFuncionario');
	}
	
	//provas
	public function cadastrarProvaAction($nivel = 1){
		$this->view->setFile('cadastroprova');
		$this->view->setVar('nivel', $nivel);
		$teste = Question::find_all_by_users_id_and_schoolings_id($this->auth->getUserId(), $nivel);    
		$this->view->setVar('questoes', $teste);
		if(count($teste) >=10){
			if(!empty($this->request->post())){
				$post = $this->request->post();
				$postCorreto = array_unique($post);           
				if(count($postCorreto)>=10 and ($nivel<=3 and $nivel>=1)){
					$test = Test::create(array('status'=>0, 'users_id'=>1, 'schoolings_id'=>$nivel, 'description'=>$post['description']));
					$q1 = QuestionTest::create(array('questions_id' => $post['question1'], 'tests_id'=> $test->id));
					$q2 = QuestionTest::create(array('questions_id' => $post['question2'], 'tests_id'=> $test->id));
					$q3 = QuestionTest::create(array('questions_id' =>$post['question3'], 'tests_id'=> $test->id));
					$q4 = QuestionTest::create(array('questions_id' => $post['question4'], 'tests_id'=> $test->id));
					$q5 = QuestionTest::create(array('questions_id' => $post['question5'], 'tests_id'=> $test->id));
					$q6 = QuestionTest::create(array('questions_id' => $post['question6'], 'tests_id'=> $test->id));
					$q7 = QuestionTest::create(array('questions_id' => $post['question7'], 'tests_id'=> $test->id));
					$q8 = QuestionTest::create(array('questions_id' => $post['question8'], 'tests_id'=> $test->id));
					$q9 = QuestionTest::create(array('questions_id' => $post['question9'], 'tests_id'=> $test->id));
					$q10 = QuestionTest::create(array('questions_id' => $post['question10'], 'tests_id'=> $test->id));
					$mensagem = array('success', 'Sucesso', 'Prova Cadastrada com sucesso.');
				}
				else{
					$mensagem = array('danger', 'Erro', 'Você selecionou uma ou mais questões mais de uma vez na prova.');
					$this->view->setVar('post', $post);
				}
			}
		}
		else{
			$mensagem = array('danger', 'Erro', 'Você não possui questões minimo para cadastrar uma prova.');
		}
		if(isset($mensagem)){
			$this->load('Helpers\Alert', $mensagem);    
		}
	}

	public function alterarProvaAction($id,$nivel = 1){
		$this->view->setFile('alterarprova');
		$this->view->setVar('nivel', $nivel);
		$this->view->setVar('id',$id);
		$teste = Question::find_all_by_users_id_and_schoolings_id($this->auth->getUserId(), $nivel);
		$qs = QuestionTest::find_all_by_tests_id($id);	    
		$this->view->setVar('qs', $qs);
		$this->view->setVar('questoes', $teste);
		if(count($teste) >=10){
			if(!empty($this->request->post())){
				$post = $this->request->post();
				$postCorreto = array_unique($post);           
				if(count($postCorreto)>=10 and ($nivel<=3 and $nivel>=1)){
					$test = Test::find($id);
					
					$test->description = $post['description'];
					$test->save();
					QuestionTest::delete_all(array('conditions' => 'tests_id = '. $id));
					$q1 = QuestionTest::create(array('questions_id' => $post['question1'], 'tests_id'=> $id));
					$q2 = QuestionTest::create(array('questions_id' => $post['question2'], 'tests_id'=> $id));
					$q3 = QuestionTest::create(array('questions_id' =>$post['question3'], 'tests_id'=> $id));
					$q4 = QuestionTest::create(array('questions_id' => $post['question4'], 'tests_id'=> $id));
					$q5 = QuestionTest::create(array('questions_id' => $post['question5'], 'tests_id'=> $id));
					$q6 = QuestionTest::create(array('questions_id' => $post['question6'], 'tests_id'=> $id));
					$q7 = QuestionTest::create(array('questions_id' => $post['question7'], 'tests_id'=> $id));
					$q8 = QuestionTest::create(array('questions_id' => $post['question8'], 'tests_id'=> $id));
					$q9 = QuestionTest::create(array('questions_id' => $post['question9'], 'tests_id'=> $id));
					$q10 = QuestionTest::create(array('questions_id' => $post['question10'], 'tests_id'=> $id));
					$mensagem = array('success', 'Sucesso', 'Prova Cadastrada com sucesso.');
					$qs = QuestionTest::find_all_by_tests_id($id);
					$this->view->setVar('qs', $qs);
				}
				else{
					$mensagem = array('danger', 'Erro', 'Você selecionou uma ou mais questões mais de uma vez na prova.');
					$this->view->setVar('post', $post);
				}
			}
		}
		else{
			$mensagem = array('danger', 'Erro', 'Você não possui questões minimo para cadastrar uma prova.');
		}
		if(isset($mensagem)){
			$this->load('Helpers\Alert', $mensagem);    
		}
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
				$usuario->save();
				$this->view->setFile('menustatus');
				$this->view->setVar('count', count(Question::find_all_by_users_id($this->auth->getUserId())));
				$mensagem =	array('success', 'Sucesso', 'Informações do usuário alterada com sucesso.');
				$this->load('Helpers\Alert', $mensagem);
			}
			else{
				$mensagem = array('danger', 'Erro', 'Senhas não coincidem.');
				$this->load('Helpers\Alert', $mensagem);
				$this->view->setVar('post',$post);
			}
		} 
	}

	public function listaProvasAction(){
		$this->view->setFile('listaprovas');
		$this->view->setVar('prova', Test::find_all_by_users_id($this->auth->getUserId()));
	}

	public function excluirProvaAction($id){
		$this->view->setFile('listaprovas');			
		$prova = Test::find($id);
		$prova->status = 2;
		$prova->save();
		$mensagem = array('success', 'Sucesso', 'Prova excluida com sucesso.');	
		$this->load('Helpers\Alert', $menssagem);
		$this->view->setVar('prova', Test::find_all_by_users_id($this->auth->getUserId()));
	}

	public function ativaProvaAction($id){
		$this->view->setFile('listaprovas');
		$prova = Test::find($id);		
		$remove = Test::find_by_status_and_schoolings_id(1, $prova->schoolings_id);
		$prova->status = 1;
		if(isset($remove->status)){
			$remove->status = 0;
			$remove->save();	
		}		
		$prova->save();
		$mensagem = array('success', 'Sucesso', 'Prova ativada com sucesso.');	
		$this->load('Helpers\Alert', $mensagem);
		$this->view->setVar('prova', Test::find_all_by_users_id(1));
	}

	public function menuProvaAction(){
		$this->view->setFile('menuProva');
	}

	public function menuStatusAction(){
		$this->view->setFile('menuStatus');
		$this->view->setVar('count', count(Question::find_all_by_users_id($this->auth->getUserId())));
	}

	public function menuGrupoAction(){
		$this->view->setFile('menugrupo');
	}


	public function listaPerguntasAction(){
		$this->view->setfile('listaperguntas');
		$this->view->setVar('questoes', Question::find_all_by_users_id($this->auth->getUserId()));
	}

	public function cadastrarPerguntaAction(){
		$this->view->setFile('cadastropergunta');
		$this->view->setVar('disciplinas', Discipline::all());
		$post = $this->request->post();
		if(!empty($post)){
			$post = array_merge($post, ['users_id'=> $this->auth->getUserId()]);
			$retorno = Question::create($post);
			if (empty($retorno->errors->errors)) {
				$mensagem = array('success', 'Sucesso', 'Pergunta Cadastrada.');
			}
			else{
				$mensagem = array('danger', 'Erro', 'Houve um erro ao cadastrar a pergunta.');
			}
			$this->load('Helpers\Alert', $mensagem);
		}
	}
	public function alterarPerguntaAction($id){
		$this->view->setFile('alterarperguntas');
		$this->view->setVar('disciplinas', Discipline::all());
		$this->view->setVar('questao', Question::find($id));
  //$pergunta = Question::find($id);
  //$this->view->setVar('pergunta', $pergunta);
		$post = $this->request->post();
		if(!empty($post)){

			$pergunta = Question::find($id);
			$pergunta->question = $post['question'];
			$pergunta->alt1 = $post['alt1'];
			$pergunta->alt2 =  $post['alt2'];
			$pergunta->alt3 =  $post['alt3'];
			$pergunta->alt4 =  $post['alt4'];
			$pergunta->answer =  $post['answer'];
			$pergunta->disciplines_id =  $post['disciplines_id'];
			$pergunta->save();
			$this->view->setFile('listaperguntas');
			$this->view->setVar('questoes', Question::find_all_by_users_id($this->auth->getUserId()));
			$mensagem = array('success', 'Sucesso', 'Pergunta alterada com sucesso.');
			$this->load('Helpers\Alert', $mensagem);
		}
	}

 
	public function adicionarUsuarioAction(){
		$this->view->setFile('menugrupo');
		$post = $this->request->post();
		$busca = User::find_all_by_login($post['usuario']);		
		if(!empty($busca)){
			if (empty(GroupUser::find_all_by_users_id($busca[0]->id)) && $busca[0]->schoolings_id != 4) {
				$adiciona = GroupUser::create(array('users_id' => $busca[0]->id, 'admin_id' => $this->auth->getUserId()));
				$mensagem = array('success', 'Sucesso', 'Usuario adicionado ao grupo com sucesso.');	
			}
			else{
				$mensagem = array('danger', 'Erro', 'Usuario já participa de um grupo.');				
				$this->view->setVar('post',$post['usuario']);
			}			
		}
		else{
			$mensagem = array('danger', 'Erro', 'Usuario não encontrado.');
			$this->view->setVar('post',$post['usuario']);
		}
		$this->load('Helpers\Alert', $mensagem);
	}

	public function listaMembrosAction(){
		$this->view->setFile('listamembros');
		$lista = GroupUser::find_all_by_admin_id($this->auth->getUserId());
		$this->view->setVar('lista',$lista);
	}

	public function pesquisaMembrosAction(){
		$this->view->setFile('listamembros');
		$sql = 'select * from group_users where admin_id = '.$this->auth->getUserId().' and users_id = (select id from users where login like "%'.$this->request->post('barra').'%")';
		$lista = GroupUser::find_by_sql($sql);
		$this->view->setVar('lista', $lista);
	}

	public function excluirMembroAction($id){
		Group::delete_all(array('conditions' => 'users_id = '. $id));
		GroupUser::delete_all(array('conditions' => 'users_id = '. $id));
		$this->view->setFile('listamembros');
		$lista = GroupUser::find_all_by_admin_id($this->auth->getUserId());
		$this->view->setVar('lista',$lista);
		$mensagem = array('success', 'Sucesso', 'Usuario removido com sucessox.');
		$this->load('Helpers\Alert', $mensagem);
	}


}



























