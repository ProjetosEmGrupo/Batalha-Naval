<?php 

class User extends \HXPHP\System\Model
{

 static $validates_presence_of = array(
    array('name', 'message' => 'O campo nome é um campo obrigatório.'),
    array('login', 'message' => 'O campo login é um campo obrigatório.'),    
    array('password', 'message' => 'Senhas diferentes. Por favor confira-os.')
);
   //Validando campos únicos 
 static $validates_uniqueness_of = array(
    array(
        array('login'), 'message' => 'Já existe um Usuário com esse login'),
);

 public static function cadastrar(array $post){
    $callbackOBJ = new \stdclass;
    $callbackOBJ->contributor = null;
    $callbackOBJ->status = false;
    $callbackOBJ->errors = array();


    if($post['confirmpassword'] != $post['password']){        
        $password = array('password' => null, 'salt' => null);
        $post = array_merge($post, $password);
    }
    else{            
        $password = \HXPHP\System\Tools::hashHX($post['password']);
        $post = array_merge($post, $password);
    }
    unset($post['confirmpassword']);

    $cadastrar = self::create($post);    
    if($cadastrar->is_valid()){
        $callbackOBJ->contributor = $cadastrar;
        $callbackOBJ->status = true;
        return $callbackOBJ;
    }
    $errors =  $cadastrar->errors->get_raw_errors();
    foreach ($errors as $field => $message) {
        array_push($callbackOBJ->errors, $message[0]);               
    }
    return $callbackOBJ;
    }//fim metodo

    public static function logar(array $post){
        $callbackOBJ = new \stdclass;
        $callbackOBJ->contributor= null;
        $callbackOBJ->status = false;
        $callbackOBJ->code = null;
        $contributor = self::find_by_email($post['email']);
        if(!is_null($contributor)){
            $password = \HXPHP\System\Tools::hashHX($post['password'], $contributor->salt);        
            if($password['password'] === $contributor->password){

                $callbackOBJ->contributor = $contributor;
                $callbackOBJ->status = true;

            }
            else{
                $callbackOBJ->code = 'dados-incorretos';
                return $callbackOBJ;
            }
        }        
        else{
            $callbackOBJ->code = 'usuario-inexistente';
        }
        return $callbackOBJ;
    }

    public static function redefinirSenha($id, $password){
        $callbackOBJ = new \stdclass;
        $callbackOBJ->contributor = null;
        $callbackOBJ->status = false;
        $callbackOBJ->code = null;
        $contributor = self::find_by_id($id);  
        if(!is_null($contributor)){
            $password = \HXPHP\System\Tools::hashHX($password); 
            $contributor->password = $password['password'];
            $contributor->salt = $password['salt'];
            $contributor->save(false);
            $callbackOBJ->contributor = $contributor;
            $callbackOBJ->code = array('success', 'Redenifição feita com sucesso!', 'Senha Alterada com sucesso.');
            $callbackOBJ->status = true;
        }
        else{
            $callbackOBJ->code = array('danger', 'Erro', 'Falha ao alter a senha!');
        }                    
        return $callbackOBJ;
    }

    public static function validar($id, $token){
        $callbackOBJ = new \stdclass;
        $callbackOBJ->status = false;
        $callbackOBJ->code = null;
        $usuario = self::find_by_id($id);
        $password = \HXPHP\System\Tools::hashHX($usuario->password, $usuario->salt);  
        if($password['password'] === $token){
            $password = \HXPHP\System\Tools::hashHX($password);
            $usuario->password = $password['password'];
            $usuario->salt = $password['salt'];
            $usuario->save(false);
            $callbackOBJ->user = $usuario;
            $callbackOBJ->status = true;
        }
        else{
            $callbackOBJ->code = "token-invalido";
        }
        return  $callbackOBJ;
    }

    public static function pesquisar($email){
        $callbackOBJ = new \stdclass;
        $callbackOBJ->status = false;
        $callbackOBJ->code = null;
        if(!is_null($email)){
            $contributor = self::find_by_email($email); 
            $callbackOBJ->contributor = $contributor;
            $callbackOBJ->status = true;
        }   
        else{
            $callbackOBJ->code = "nenhum-usuario-encontrado";
        }     
        return $callbackOBJ;
    }//fim metodo

    
}



