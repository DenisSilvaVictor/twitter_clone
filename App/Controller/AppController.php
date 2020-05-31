<?php 

    namespace App\Controller;

    //recursos miniframework
    use MF\Controller\Action;
    use MF\Model\Container;

    //modelos objetos
    use App\Models\Usuario;
    use App\Models\Twitt;

    class AppController extends Action{

        public function timeLine() {
            session_start();

            if(isset($_SESSION['nome']) && isset($_SESSION['id'])){ 
                $twitt = Container::getModel('twitt');
                $usuario = Container::getModel('usuario');
                $usuario->__set('id', $_SESSION['id']);
                $twitt->__set('id_usuario', $_SESSION['id']);

                $this->viewObj->quantidadeTwitts = $twitt->getCountTwitt()['quantidade_twitt'];
                $this->viewObj->quantidadeSeguindo = $usuario->getSeguidores('seguindo')['seguindo'];
                $this->viewObj->quantidadeSeguidores = $usuario->getSeguidores('seguidores')['seguidores'];
                $this->viewObj->nome_usuario = $_SESSION['nome'];
                $this->viewObj->id_usuario = $_SESSION['id'];
                $this->viewObj->twitts = $twitt->getTwitt();             

                foreach($this->viewObj->twitts as $key => $value){

                    $value['date_twitt'] = explode(' ', $value['date_twitt'])[0];
                    //retirando horas das datas
                    $this->viewObj->twitts[$key]['date_twitt'] = explode(' ', $value['date_twitt'])[0];

                }

                $this->render('timeline', 'layoutApp');
            }else{
                header('location: /');
            }
        }

        public function twittar() {
            if(!empty($_POST['conteudo'])){
                session_start();
                
                $twitt = Container::getModel('twitt');
                
                $twitt->__set('id_usuario', $_SESSION['id']);
                $twitt->__set('nome_usuario', $_SESSION['nome']);
                $twitt->__set('conteudo', $_POST['conteudo']);

                $twitt->setTwitt();
                header('location: /timeline');
            }else{
                header('location: /timeline');
            }
        }

        public function seguir() {
            session_start();

            $twitt = Container::getModel('twitt');
            $usuario = Container::getModel('usuario');
            $usuario->__set('id', $_SESSION['id']);
            $twitt->__set('id_usuario', $_SESSION['id']);

            if(isset($_POST['quemseguir'])){
                $nome = $_POST['quemseguir'];
            }else{
                $nome = '';
            }        

            $this->viewObj->nome_usuario = $_SESSION['nome'];
            $this->viewObj->id_usuario = $_SESSION['id'];          
            $this->viewObj->usuarios = $usuario->getUsuarios("nome like '%$nome%' order by nome ASC");

            if(isset($_GET['id_seguido'])){
                $usuario->seguir($this->viewObj->id_usuario, $_GET['id_seguido']);  
            } 

            if(isset($_GET['nao_seguir'])){
                $usuario->naoSeguir($this->viewObj->id_usuario, $_GET['nao_seguir']);
            }

            $this->viewObj->quantidadeTwitts = $twitt->getCountTwitt()['quantidade_twitt'];
            $this->viewObj->quantidadeSeguindo = $usuario->getSeguidores('seguindo')['seguindo'];
            $this->viewObj->quantidadeSeguidores = $usuario->getSeguidores('seguidores')['seguidores'];
            $this->viewObj->AllSeguindo = $usuario->getSeguidores('tabela');
            
            $this->render('seguir','layoutApp');
        }

        public function remover() {
            if(isset($_GET['id_twitt'])){
                $twitt = Container::getModel('twitt');
                $twitt->__set('id_twitt', $_GET['id_twitt']);

                $twitt->removerTwitt();
                header('location: /timeline?remover=sucesso');
            }else{
                header('location: /timeline');
            }
        }

    }

?>