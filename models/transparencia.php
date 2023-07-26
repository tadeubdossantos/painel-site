<?php
    class transparencia {

        private static $titulo;
        private static $ano;
        private static $file;
        private static $conn;
        private static $types = ['application/pdf'];
        private static $length = (1024 * 1024 * 10);
        private static $dir = '../../files/';

        public static function setconn($conn) {
            self::$conn = $conn;
       }

        public static function create($data=[]) {
            if(!($arquivo = self::upload($data['arquivo']))) return -1;
            $titulo = $data['titulo'] ?? '';
            $tipoid = $data['tipo'] ?? '';
            $ano = $data['ano'] ?? '';            
            $result = self::$conn->prepare("INSERT INTO transparencia (titulo, tipoid, ano, src) VALUES (?,?,?,?)");
            $result->execute(array($titulo, $tipoid, $ano, $arquivo));
            return $result->rowCount();
        }

        public static function upload($arquivo) {
            if(empty(self::$file = $arquivo ?? [])) return false;
            $encontrou = false;
            foreach(self::$types as $t) 
                if($t == self::$file['type']) {
                    $encontrou = true;
                    break; }
            if(!$encontrou) return false;
            if(self::$file['size'] > self::$length) return false;
            $nome_final = md5(explode('.', self::$file['name'])[0]).date('dmYHis');
            $tipo = explode('.', self::$file['name'])[1];
            $arquivo = self::$dir.$nome_final.'.'.$tipo;
            if(!move_uploaded_file(self::$file['tmp_name'], $arquivo)) return false;
            return $nome_final.'.'.$tipo;
        }

        public static function update($data) {
            $arquivo = '';
            if(!empty($data['arquivo']['name'])) {
                if(!($arquivo = self::upload($data['arquivo']))) return -1;
                $data['id'] = $data['id_transparencia'];
                unlink((self::$dir).(self::read($data)[0]['src'])); }
            $id = $data['id_transparencia'] ?? '';
            $titulo = $data['titulo'] ?? '';
            $tipoid = $data['tipo'] ?? '';
            $ano = $data['ano'] ?? '-';      
            $query = "UPDATE transparencia SET titulo = ?, tipoid = ?, ano = ? ".((!empty($arquivo)) ? ", src = ? " : "")."WHERE id = ? ";
            $result = self::$conn->prepare($query);
            $params = (!empty($arquivo)) ? array($titulo, $tipoid, $ano, $arquivo, $id) : array($titulo, $tipoid, $ano, $id);
            $result->execute($params);
            return $result->rowCount();
        }

        public static function qtd() {
            $query = "SELECT count(*) qtd FROM transparencia";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1) return 0;
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['qtd'];
        }

        public static function pesquisar($data) {
            $conditions = [];
            if(!empty($data['titulo'])) $conditions[] = "tr.titulo like '%".$data['titulo']."%'";
            if(!empty($data['tipo'])) $conditions[] = "tr.tipoid = ".$data['tipo'];
            if(!empty($data['ano'])) $conditions[] = "tr.ano = ".$data['ano'];
            $query = "SELECT tr.id,
                tr.titulo AS titulo, 
                ti.titulo AS titulo_tipo, 
                coalesce(tr.ano, '-') ano, 
                src 
                FROM transparencia tr
                INNER JOIN tipo_transparencia ti ON ti.id = tr.tipoid ";
            $query .= (!empty($conditions)) ? 'WHERE '.implode(' AND ', $conditions).' ' : ' ';
            $query .= "ORDER BY ano DESC";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1)
                return ['result' => false, 'data' => [] ];
            $rows = $result->fetchAll() ?? [];
            return ['result' => true, 'data' => $rows];
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

        public static function read($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            $query = "SELECT * FROM transparencia WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            $row = $result->fetchAll() ?? [];
            return $row;
        }

        public static function delete($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            unlink((self::$dir).(self::read($data)[0]['src']));
            $query = "DELETE FROM transparencia WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->rowCount() ?? 0;
        }

        public static function listar_anos() {
            $query = "SELECT ano FROM transparencia GROUP BY ano ORDER BY ano DESC";
            $result = self::$conn->prepare($query);
            $result->execute();
            $rows = $result->fetchAll() ?? [];
            return $rows;
        }
    }

    
?>