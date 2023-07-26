<?php
    class tipo_transparencia {

        private static $titulo;
        private static $conn;
        

        
        public  static function setconn($conn) {
            self::$conn = $conn;
       }

        public static function listar_tipos() {
            $query = "SELECT id, titulo FROM tipo_transparencia ORDER BY titulo ASC";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1)
                return ['result' => false, 'data' => [] ];
            $rows = $result->fetchAll() ?? [];
            return ['result' => true, 'data' => $rows];
        }

        public static function qtd() {
            $query = "SELECT count(*) qtd FROM tipo_transparencia";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1) return 0;
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['qtd'];
        }

        public static function pesquisar($data) {
            $query = "SELECT 
                tp.id id, 
                tp.titulo titulo,
                (select count(*) qtd_transp from transparencia t where (t.tipoid = tp.id)) qtd_transp
                FROM tipo_transparencia tp ";
            if(!empty($pesquisa = $data['pesquisa'] ?? ''))
                $query .= "WHERE tp.titulo like '%$pesquisa%'";
            $query .= "ORDER BY tp.titulo ASC";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1) 
                return ['result' => false, 'data' => [] ];
            $rows = $result->fetchAll() ?? [];
            return ['result' => true, 'data' => $rows];
        }

        public static function create($data=[]) {
            $query = "INSERT INTO tipo_transparencia (titulo) VALUES (?)";
            $result = self::$conn->prepare($query);
            $result->execute(array( $data['titulo']));
            if($result->rowCount() < 1) return ['result' => false, 'Não foi possível incluir o tipo de transparência!'];
            return ['result' => true, 'msg' => 'Inclusão realizada com sucesso!'];            
        }

        public static function delete($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            $query = "DELETE FROM tipo_transparencia WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->rowCount() ?? 0;
        }

        public static function read($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            $query = "SELECT * FROM tipo_transparencia WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            $row = $result->fetchAll() ?? [];
            return $row;
        }

        public static function update($data) {
            if(empty($id = $data['id_tipotransparencia'] ?? '')) return 0;
            if(empty($titulo = $data['titulo'] ?? '')) return 0;
            $query = "UPDATE tipo_transparencia SET titulo = :titulo WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':titulo', $titulo);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->rowCount();
        }
    }    
?>