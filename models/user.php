<?php

    class user{
        private static $conn;
        private static $key;

       public static function setconn($conn) {
            self::$conn = $conn;
            self::$key = 'As791243*.*';
       }

        public static function login($data=[]) {
            if(empty($login = $data['login'] ?? '')) 
                return ['result' => false, 'msg' => 'Login não informado! Por favor, informe o login.'];
            if(empty($password = $data['password'] ?? ''))  
                return ['result' => false, 'msg' => 'Senha não informada! Por favor, informe a senha.'];
            $query = "SELECT id, nome, email, login, senha
                FROM users
                WHERE login = :login
                LIMIT 1";
            $result = self::$conn->prepare($query);
            $result->bindParam(':login',  $login);
            $result->execute();
            if($result->rowCount() < 1) 
                return ['result' => false, 'msg' => 'Usuário desconhecido!'];
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if(!password_verify($password, $row['senha']))
                return ['result' => false, 'msg' => 'Senha inválida!'];
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT' ];
            $header = json_encode($header);
            $header = base64_encode($header);
            $payload = [
                'iss' => 'painel-site',
                'aud' => 'http://localhost/painel-site',
                'exp' => time() + (7 * 24 * 60 * 60),
                'id' => $row['id'],
                'nome' => $row['nome'],
                'email' => $row['email']
            ];
            $payload = json_encode($payload);
            $payload = base64_encode($payload);
            $signature = hash_hmac('sha256', "$header.$payload", self::$key, true);
            $signature = base64_encode($signature);
            $token = "$header.$payload.$signature";
            return ['result' => true, 'data' => $row, 'token' => $token];
        }

        public static function validar_token($token) {
            $parts_token = explode('.', $token);
            $header = $parts_token[0] ?? '';
            $payload = $parts_token[1] ?? '';
            $signature = $parts_token[2] ?? '';
            $valid_signature = hash_hmac('sha256', "$header.$payload", self::$key, true);
            $valid_signature = base64_encode($valid_signature);
            if($signature != $valid_signature) return false;
            return true;
        }

        public static function count_users() {
            $result = self::$conn->prepare("SELECT * FROM users");
            $result->execute();
            return $result->rowCount();
        }

        public static function getcurrent($token) {
            $parts_token = explode('.', $token);
            $payload = $parts_token[1] ?? '';
            $dados_token = base64_decode($payload);
            $dados_token = json_decode($dados_token);
            return [
                'id' => $dados_token->id,
                'nome' => $dados_token->nome,
                'email' => $dados_token->email ];
        }

        public static function create($data=[]) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nome, email, login, senha) VALUES (?,?,?,?)";
            $result = self::$conn->prepare($query);
            $result->execute(array( $data['nome'], $data['email'], $data['login'], $data['senha']));
            if($result->rowCount() < 1) return ['result' => false, 'Não foi possível incluir o usuário!'];
            return ['result' => true, 'msg' => 'Inclusão realizada com sucesso!'];            
        }

        public static function pesquisar($data) {
            $query = "SELECT id, nome, email, login
                FROM users ";
            if(!empty($pesquisa = $data['pesquisa'] ?? ''))
                $query .= "WHERE nome like '%$pesquisa%' AND email like '%$pesquisa%' AND login like '%$pesquisa%' ";
            $query .= "ORDER BY nome ASC";
            $result = self::$conn->prepare($query);
            $result->execute();
            if($result->rowCount() < 1) 
                return ['result' => false, 'data' => [] ];
            $rows = $result->fetchAll() ?? [];
            return ['result' => true, 'data' => $rows];
        }

        public static function delete($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            $query = "DELETE FROM users WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->rowCount() ?? 0;
        }

        public static function read($data) {
            if(empty($id = $data['id'] ?? '')) return 0;
            $query = "SELECT * FROM users WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            $row = $result->fetchAll() ?? [];
            return $row;
        }

        public static function update($data) {
            if(empty($id = $data['id_usuario'] ?? '')) return 0;
            if(empty($nome = $data['nome'] ?? '')) return 0;
            if(empty($email = $data['email'] ?? '')) return 0;
            if(empty($login = $data['login'] ?? '')) return 0;
            if(empty($senha = $data['senha'] ?? '')) return 0;
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $query = "UPDATE users SET nome = :nome, email = :email, login = :login, senha = :senha WHERE id = :id";
            $result = self::$conn->prepare($query);
            $result->bindParam(':nome', $nome);
            $result->bindParam(':email', $email);
            $result->bindParam(':login', $login);
            $result->bindParam(':senha', $senha);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->rowCount();
        }
    }
?>