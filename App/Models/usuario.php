<?php

    namespace App\Models;

    use MF\Model\Model;

    class Usuario extends Model{
    
        private $nome;
        private $email;
        private $senha;
        private $id;

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            $this->$name = $value;

        }
         

        public function adicionarUsuario()
        {
            $query = '
                        INSERT INTO tb_usuarios(nome, email, senha)
                        values(:nome, :email, :senha);
                ';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));

            $this->verificarCadastro();

            $stmt->execute();
        }

        public function getUsuarios($condicao = "1 = 1")
        {
            $query = "
                    SELECT id, nome, email, senha FROM tb_usuarios WHERE $condicao;
                ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(1, $this->__get('nome'));
            $stmt->bindValue(2, $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function verificarCadastro()
        {
            $cond = "
                nome = ? OR email = ?;
            ";

            $usuarios = $this->getUsuarios($cond);

            foreach($usuarios as $key => $us){
                if ($us['nome'] == $this->nome && $us['email'] == $this->email) {
                    return 'nome e email';
                }else if($us['email'] == $this->email){
                    return 'email';
                }else{
                    return 'nome';
                }
            }

        }

        public function autenticarUsuario()
        {
            $cond = '
                nome = ? OR email = ?;
            ';
            
            $usuarios = $this->getUsuarios($cond);

            foreach($usuarios as $key => $usuario){
                if($usuario['email'] == $this->email && $usuario['senha'] == $this->senha){
                    $this->id = $usuario['id'];
                    $this->nome = $usuario['nome'];
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function seguir($id_seguidor, $id_seguido) {

            $seguidos = $this->getSeguidores('tabela');
            $condicao = true;

            foreach($seguidos as $key => $seguido){
                if($seguido['id_usuario_seguido'] == $id_seguido){
                    $condicao = false;
                    break;
                }
            }

            if($condicao){
                $query = "
                    INSERT into 
                    tb_seguidores
                        (id_usuario_seguidor, id_usuario_seguido)
                    VALUES
                        ($id_seguidor, $id_seguido);
                ";

                $stmt = $this->db->exec($query);
            }
        }

        public function getSeguidores($modo){       
            $id_usuario = $this->__get('id');

            if($modo == 'seguindo'){
                $query = "
                    SELECT 
                        COUNT(id_usuario_seguidor) as seguindo
                    from 
                        tb_seguidores 
                    WHERE 
                        id_usuario_seguidor = $id_usuario;
                ";
            }else if($modo == 'seguidores'){
                $query = "
                    SELECT 
                        COUNT(id_usuario_seguido) as seguidores
                    FROM 
                        tb_seguidores 
                    WHERE 
                        id_usuario_seguido = $id_usuario;
                ";
            }else if ($modo == 'tabela') {
                $query = "
                    SELECT 
                        id_usuario_seguido 
                    FROM 
                        tb_seguidores 
                    WHERE 
                        id_usuario_seguidor = $id_usuario;
                ";
                $stmt = $this->db->query($query);

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            $stmt = $this->db->query($query);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function naoSeguir($id_usuario_seguidor, $id_usuario_seguido) {

            $query = "
                DELETE FROM
                    tb_seguidores 
                WHERE 
                    (id_usuario_seguidor = $id_usuario_seguidor) AND (id_usuario_seguido = $id_usuario_seguido);
            ";

            $stmt = $this->db->query($query);

            $stmt->execute();
        }
    }

?>