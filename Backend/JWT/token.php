<?php

define('SERVER', "http://localhost");
define('SECRET_KEY', 'PDP22');  /// secret key, clave secreta con la que se generan los token
define('ALGORITHM', 'HS256');

require_once "./JWT/JWT.php";

class MiToken {

    public static function devuelveToken($tokenFront) {
        $secretKey = base64_decode(SECRET_KEY);
        $DecodedDataArray = JWT::decode($tokenFront, $secretKey);
        $payload = $DecodedDataArray;
        return $payload;
    }

    public static function generateToken($usuarioDatos) {
        
        $tokenId = base64_encode(random_bytes(32));
        $issuedAt = time();
        $expire = $issuedAt + 7200; // 2 horas para la expiración del token
        $serverName = SERVER;
        
        $datos = [
            'contrasena' => $usuarioDatos["password"],
            'usuario' => $usuarioDatos["user"],
            'rol' => $usuarioDatos["role"]
        ];

        $payload = [
            'iat' => $issuedAt,     // cuando se genero el token
            'jti' => $tokenId,      // identificador del token
            'iss' => $serverName,   // servidor
            'exp' => $expire,       // tiempo de expiración
            'data' => $datos        //datos del usuario para el payload
        ];

        $secretKey = base64_decode(SECRET_KEY);

        $jwt = JWT::encode(
                        $payload,
                        $secretKey
                        
        );

        $tokenJWT = 'Bearer '.$jwt;

        return $tokenJWT;
    }

    public static function verTokenCaducados($tokens){
            $tokensCaducados = JWT::verTokensCaducados($tokens);
        return $tokensCaducados;
    }
}
