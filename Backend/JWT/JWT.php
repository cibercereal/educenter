<?php

class JWT{
    const ASN1_INTEGER = 0x02;
    const ASN1_SEQUENCE = 0x10;
    const ASN1_BIT_STRING = 0x03;

    public static $leeway = 0;

    public static $timestamp = null;

    public static $supported_algs = array(
        'ES384' => array('openssl', 'SHA384'),
        'ES256' => array('openssl', 'SHA256'),
        'HS256' => array('hash_hmac', 'SHA256'),
        'HS384' => array('hash_hmac', 'SHA384'),
        'HS512' => array('hash_hmac', 'SHA512'),
        'RS256' => array('openssl', 'SHA256'),
        'RS384' => array('openssl', 'SHA384'),
        'RS512' => array('openssl', 'SHA512'),
        'EdDSA' => array('sodium_crypto', 'EdDSA'),
    );

    public static function decode($jwt, $key)
    {       
        
        $timestamp = \is_null(static::$timestamp) ? \time() : static::$timestamp;

        if (empty($key)) {
            fillExceptionAction('TOKEN_CLAVE_VACIA');
        }
        $tks = \explode('.', $jwt);
        
        if (\count($tks) != 3) {
            fillExceptionAction('TOKEN_NUMERO_INCORRECTO_SEGMENTOS');
        }
        
        $headb64 = substr($tks[0], 7);
        $bodyb64 = $tks[1];
        $cryptob64 = $tks[2];
        
        if (null === ($header = static::jsonDecode(static::urlsafeB64Decode($headb64)))) {
            fillExceptionAction('TOKEN_HEADER_NO_VALIDO');
        }
        if (null === $payload = static::jsonDecode(static::urlsafeB64Decode($bodyb64))) {
            fillExceptionAction('TOKEN_PAYLOAD_NO_VALIDO');
        }
        if (false === ($sig = static::urlsafeB64Decode($cryptob64))) {
            fillExceptionAction('TOKEN_SIGN_NO_VALIDO');
        }
        if ($header->alg === 'ES256') {
            $sig = self::signatureToDER($sig);
        }
        if (!static::verify("$headb64.$bodyb64", $sig, $key, $header->alg)) {
            fillExceptionAction('TOKEN_FALLO_VERIFICACION_SIGN');
        }
        if (isset($payload->iat) && $payload->iat > ($timestamp + static::$leeway)) {
            fillExceptionAction('TOKEN_USO_FUTURO');
        }
        if (isset($payload->exp) && ($timestamp - static::$leeway) >= $payload->exp) {
            fillExceptionAction('TOKEN_CADUCADO');
        }
        
        return $payload;
    }

    public static function encode($payload, $key, $alg = 'HS256', $keyId = null, $head = null)
    {
        $header = array('typ' => 'JWT', 'alg' => $alg);
        if ($keyId !== null) {
            $header['kid'] = $keyId;
        }
        if (isset($head) && \is_array($head)) {
            $header = \array_merge($head, $header);
        }
        $segments = array();
        $segments[] = static::urlsafeB64Encode(static::jsonEncode($header));
        $segments[] = static::urlsafeB64Encode(static::jsonEncode($payload));
        $signing_input = \implode('.', $segments);

        $signature = static::sign($signing_input, $key, $alg);
        $segments[] = static::urlsafeB64Encode($signature);

        return \implode('.', $segments);
    }

    public static function sign($msg, $key, $alg = 'HS256')
    {
        if (empty(static::$supported_algs[$alg])) {
            fillExceptionAction('ALGORITMO_NO_SOPORTADO');
        }
        list($function, $algorithm) = static::$supported_algs[$alg];
        switch ($function) {
            case 'hash_hmac':
                return \hash_hmac($algorithm, $msg, $key, true);
        }
    }
    
    private static function verify($msg, $signature, $key, $alg)
    {
        if (empty(static::$supported_algs[$alg])) {
            fillExceptionAction('TOKEN_ALGORITMO_NO_SOPORTADO');
        }

        list($function, $algorithm) = static::$supported_algs[$alg];
        switch ($function) {
            case 'hash_hmac':
            default:
                $hash = \hash_hmac($algorithm, $msg, $key, true);
                if (\function_exists('hash_equals')) {
                    return \hash_equals($signature, $hash);
                }
                $len = \min(static::safeStrlen($signature), static::safeStrlen($hash));

                $status = 0;
                for ($i = 0; $i < $len; $i++) {
                    $status |= (\ord($signature[$i]) ^ \ord($hash[$i]));
                }
                $status |= (static::safeStrlen($signature) ^ static::safeStrlen($hash));

                return ($status === 0);
        }
    }

    public static function jsonDecode($input)
    {
        if (\version_compare(PHP_VERSION, '5.4.0', '>=') && !(\defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            $obj = \json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            $max_int_length = \strlen((string) PHP_INT_MAX) - 1;
            $json_without_bigints = \preg_replace('/:\s*(-?\d{'.$max_int_length.',})/', ': "$1"', $input);
            $obj = \json_decode($json_without_bigints);
        }

        if ($errno = \json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($obj === null && $input !== 'null') {
            fillExceptionAction('TOKEN_NULL_RESULT_WITH_NON_NULL_INPUT');
        }
        return $obj;
    }

    public static function jsonEncode($input)
    {
        $json = \json_encode($input);
        if ($errno = \json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($json === 'null' && $input !== null) {
            fillExceptionAction('TOKEN_NULL_RESULT_WITH_NON_NULL_INPUT');
        }
        return $json;
    }


    public static function urlsafeB64Decode($input)
    {
        $remainder = \strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= \str_repeat('=', $padlen);
        }
        return \base64_decode(\strtr($input, '-_', '+/'));
    }

    public static function urlsafeB64Encode($input)
    {
        return \str_replace('=', '', \strtr(\base64_encode($input), '+/', '-_'));
    }

    private static function handleJsonError($errno)
    {
        $messages = array(
            JSON_ERROR_DEPTH => 'TOKEN_MAXIMUN_STACK_DEPTH_EXCEEDED',
            JSON_ERROR_STATE_MISMATCH => 'TOKEN_INVALID_OR_MALFORMED_JSON',
            JSON_ERROR_CTRL_CHAR => 'TOKEN_UNEXPECTED_CONTROL_CHARACTER_FOUND',
            JSON_ERROR_SYNTAX => 'TOKEN_SYNTAX_ERROR_MALFORMED_JSON',
            JSON_ERROR_UTF8 => 'TOKEN_MALFORMED_UTF8_CHARACTERS' //PHP >= 5.3.3
        );
        fillExceptionAction(isset($messages[$errno]) ? $messages[$errno] : 'TOKEN_ERROR_TOKEN_INTRODUCIDO');
    }

    private static function safeStrlen($str)
    {
        if (\function_exists('mb_strlen')) {
            return \mb_strlen($str, '8bit');
        }
        return \strlen($str);
    }

    private static function signatureToDER($sig)
    {
        list($r, $s) = \str_split($sig, (int) (\strlen($sig) / 2));

        $r = \ltrim($r, "\x00");
        $s = \ltrim($s, "\x00");

        if (\ord($r[0]) > 0x7f) {
            $r = "\x00" . $r;
        }
        if (\ord($s[0]) > 0x7f) {
            $s = "\x00" . $s;
        }

        return self::encodeDER(
            self::ASN1_SEQUENCE,
            self::encodeDER(self::ASN1_INTEGER, $r) .
            self::encodeDER(self::ASN1_INTEGER, $s)
        );
    }

    private static function encodeDER($type, $value)
    {
        $tag_header = 0;
        if ($type === self::ASN1_SEQUENCE) {
            $tag_header |= 0x20;
        }

        $der = \chr($tag_header | $type);

        $der .= \chr(\strlen($value));

        return $der . $value;
    }


    private static function signatureFromDER($der, $keySize)
    {
        // OpenSSL returns the ECDSA signatures as a binary ASN.1 DER SEQUENCE
        list($offset, $_) = self::readDER($der);
        list($offset, $r) = self::readDER($der, $offset);
        list($offset, $s) = self::readDER($der, $offset);

        // Convert r-value and s-value from signed two's compliment to unsigned
        // big-endian integers
        $r = \ltrim($r, "\x00");
        $s = \ltrim($s, "\x00");

        // Pad out r and s so that they are $keySize bits long
        $r = \str_pad($r, $keySize / 8, "\x00", STR_PAD_LEFT);
        $s = \str_pad($s, $keySize / 8, "\x00", STR_PAD_LEFT);

        return $r . $s;
    }

    private static function readDER($der, $offset = 0)
    {
        $pos = $offset;
        $size = \strlen($der);
        $constructed = (\ord($der[$pos]) >> 5) & 0x01;
        $type = \ord($der[$pos++]) & 0x1f;

        // Length
        $len = \ord($der[$pos++]);
        if ($len & 0x80) {
            $n = $len & 0x1f;
            $len = 0;
            while ($n-- && $pos < $size) {
                $len = ($len << 8) | \ord($der[$pos++]);
            }
        }

        // Value
        if ($type == self::ASN1_BIT_STRING) {
            $pos++; // Skip the first contents octet (padding indicator)
            $data = \substr($der, $pos, $len - 1);
            $pos += $len - 1;
        } elseif (!$constructed) {
            $data = \substr($der, $pos, $len);
            $pos += $len;
        } else {
            $data = null;
        }

        return array($pos, $data);
    }

    public static function verTokensCaducados($tokens){

        $arrayTokensCaducados = array();

        foreach($tokens as $jwt){

            $timestamp = \is_null(static::$timestamp) ? \time() : static::$timestamp;
            $tks = \explode('.', $jwt);
            $bodyb64 = $tks[1];
            $payload = static::jsonDecode(static::urlsafeB64Decode($bodyb64));
            
            if (isset($payload->exp) && ($timestamp - static::$leeway) >= $payload->exp) {
                array_push($arrayTokensCaducados, $jwt);
            }
        }

        return $arrayTokensCaducados;
    }
}
