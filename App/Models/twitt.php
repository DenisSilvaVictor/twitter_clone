<?php

    namespace App\Models;

    use MF\Model\Model;


    class Twitt extends Model {

        private $id_usuario;
        private $id_twitt;
        private $conteudo;
        private $nome_usuario;
        private $date;

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            $this->$name = $value;

        }

        function setTwitt() {
            $query = "
                insert into  
                    tb_twitts(id_usuario, nome_usuario, conteudo_twitt)
                    values(?, ?, ?);
           ";
            
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(1, $this->__get('id_usuario'));
            $stmt->bindValue(2, $this->__get('nome_usuario') );
            $stmt->bindValue(3, $this->__get('conteudo'));

            $stmt->execute();
        }

        public function getTwitt() {
            $query = "
                select 
                    conteudo_twitt, date_twitt , nome_usuario, id_usuario, id_twitt 
                from 
                    tb_twitts 
                ORDER BY 
                    date_twitt DESC;
            ";

            $stmt = $this->db->query($query);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getCountTwitt() {
            $id_usuario = $this->__get('id_usuario');

            $query = "
                select COUNT(id_twitt) as quantidade_twitt from tb_twitts where id_usuario = $id_usuario;
            ";

            $stmt = $this->db->query($query);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function removerTwitt(){
            $id_twitt = $this->__get('id_twitt');

            $query = "
                DELETE FROM tb_twitts WHERE id_twitt = $id_twitt;
            ";

            $this->db->query($query);
        }

    }

?>