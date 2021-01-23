<?php 

class RedirecionaController extends \HXPHP\System\Controller
{
	public function __construct($configs) {
        parent::__construct($configs);
        $this->load('Services\Auth', $configs->auth->after_login, $configs->auth->after_logout, true);
        $user_id = $this->auth->getUserId();
    }


    public function indexAction(){
       
    	if ($this->auth->getUserRole() === 4) {
            echo('<script language= "JavaScript">location.href="'. $this->configs->site->url . $this->configs->baseURI .'docente/menu-prova"</script>');
        }
        else{

            echo('<script language= "JavaScript">location.href="'. $this->configs->site->url . $this->configs->baseURI .'aluno/menu-jogo"</script>');
        }
    }
}