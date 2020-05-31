<?php 

    namespace App\Controller;

    //recursos miniframework
    use MF\Controller\Action;
    use MF\Model\Container;

    //modelos objetos
    use App\Models\Usuario;

    class IndexController extends Action{

        public function index()
        {
            $this->render('index');
        }

        public function inscreverse()
        {
            $this->render('inscreverse');
        }

        public function cadastrar()
        {
            if(empty($_POST['nome']) || empty($_POST['senha']) || empty($_POST['email'])){
                header('location: /inscreverse?erro=erro1');
            }else{
                $usuario = Container::getModel('usuario');
                $twitt = Container::getModel('twitt');

                $usuario->__set('nome', $_POST['nome']);
                $usuario->__set('senha', md5($_POST['senha']));
                $usuario->__set('email', $_POST['email']);

                if(!$usuario->verificarCadastro()){
                    $usuario->adicionarUsuario();

                }else{
                    $erro = $usuario->verificarCadastro();
                    header("location: /inscreverse?erro=$erro");
                }
            }
            $this->render('cadastrar');
        }
        
    }

?>