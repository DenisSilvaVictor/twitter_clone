<?php 

    namespace App\Controller;

    //recursos miniframework
    use MF\Controller\Action;
    use MF\Model\Container;

    //modelos objetos
    use App\Models\Usuario;

    class AuthController extends Action{

        public function logar() {

            if(!empty($_POST['senha']) || !empty($_POST['email'])){
                $usuario = Container::getModel('Usuario');

                $usuario->__set('email', $_POST['email']);
                $usuario->__set('senha', md5($_POST['senha']));

                if($usuario->autenticarUsuario()){
                    session_start();

                    $_SESSION['id'] = $usuario->__get('id');
                    $_SESSION['nome'] = $usuario->__get('nome');

                    header('location: /timeline');
                }else{
                    header('location: /?login=erro_2');
                }
            }else {
                header('location: /?login=erro_1');
            }
        }

        public function deslogar(){
            session_start();
            session_destroy();

            header('location: /');
        }
    }

?>