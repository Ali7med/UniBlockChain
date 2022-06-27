<?php

namespace App\Http\Controllers;
require __DIR__ . "/../../../vendor/autoload.php";

use Illuminate\Http\Request;
class EcdsaController extends Controller
{
    public function make()
    {
    //     $privateKey =  PrivateKey::fromPem("
    //     -----BEGIN EC PARAMETERS-----
    //     BgUrgQQACg==
    //     -----END EC PARAMETERS-----
    //     -----BEGIN EC PRIVATE KEY-----
    //     MHQCAQEEIODvZuS34wFbt0X53+P5EnSj6tMjfVK01dD1dgDH02RzoAcGBSuBBAAK
    //     oUQDQgAE/nvHu/SQQaos9TUljQsUuKI15Zr5SabPrbwtbfT/408rkVVzq8vAisbB
    //     RmpeRREXj5aog/Mq8RrdYy75W9q/Ig==
    //     -----END EC PRIVATE KEY-----
    // ");
    $privateKey =  new PrivateKey("secp256k1");

    echo "\n" . $privateKey->toString();
        $publicKey = $privateKey->publicKey();
        $message = "My test message";
        # Generate Signature
        $signature =  Ecdsa::sign($message, $privateKey);
        echo "\n" . $signature->toBase64();
        # Verify if signature is valid
         dd(Ecdsa::verify("My test message", $signature, $publicKey));
    }
}


class PrivateKey {
    function __construct($curve="secp256k1", $openSslPrivateKey=null) {
        if (is_null($openSslPrivateKey)) {
            $config = array(
                "config" => 'C:/xampp/php/extras/openssl/openssl.cnf',
                "digest_alg" => "sha256",
                "private_key_bits" => 2048,
                "private_key_type" => OPENSSL_KEYTYPE_EC,
                "curve_name" => $curve
            );

            $response = openssl_pkey_new($config);
            openssl_pkey_export($response, $openSslPrivateKey, null, $config);

            $openSslPrivateKey = openssl_pkey_get_private($openSslPrivateKey);
        }

        $this->openSslPrivateKey = $openSslPrivateKey;
    }

    function publicKey() {
        $openSslPublicKey = openssl_pkey_get_details($this->openSslPrivateKey)["key"];

        return new PublicKey($openSslPublicKey);
    }

    function toString () {
        return base64_encode($this->toDer());
    }

    function toDer () {
        $pem = $this->toPem();

        $lines = array();
        foreach(explode("\n", $pem) as $value) {
            if (substr($value, 0, 5) !== "-----") {
                array_push($lines, $value);
            }
        }

        $pem_data = join("", $lines);

        return base64_decode($pem_data);
    }

    function toPem () {
        openssl_pkey_export($this->openSslPrivateKey, $out, null);
        return $out;
    }

    static function fromPem ($str) {
        $rebuilt = array();
        foreach(explode("\n", $str) as $line) {
            $line = trim($line);
            if (strlen($line) > 1) {
                array_push($rebuilt, $line);
            }
        };
        $rebuilt = join("\n", $rebuilt) . "\n";
        return new PrivateKey(null, openssl_get_privatekey($rebuilt));
    }

    static function fromDer ($str) {
        $pem_data = base64_encode($str);
        $pem = "-----BEGIN EC PRIVATE KEY-----\n" . substr($pem_data, 0, 64) . "\n" . substr($pem_data, 64, 64) . "\n" . substr($pem_data, 128, 64) . "\n-----END EC PRIVATE KEY-----\n";
        return new PrivateKey(null, openssl_get_privatekey($pem));
    }

    static function fromString ($str) {
        return PrivateKey::fromDer(base64_decode($str));
    }

}


class Ecdsa {
    public static function sign ($message, $privateKey) {
        $signature = null;
        openssl_sign($message, $signature, $privateKey->openSslPrivateKey, OPENSSL_ALGO_SHA256);
        return new Signature($signature);
    }

    public static function verify ($message, $signature, $publicKey) {
        $success = openssl_verify($message, $signature->toDer(), $publicKey->openSslPublicKey, OPENSSL_ALGO_SHA256);
        if ($success == 1) {
            return true;
        }
        return false;
    }
}


class PublicKey {

    function __construct ($pem) {
        $this->pem = $pem;
        $this->openSslPublicKey = openssl_get_publickey($pem);
    }

    function toString () {
        return base64_encode($this->toDer());
    }

    function toDer () {
        $pem = $this->toPem();

        $lines = array();
        foreach(explode("\n", $pem) as $value) {
            if (substr($value, 0, 5) !== "-----") {
                array_push($lines, $value);
            }
        }

        $pem_data = join("", $lines);

        return base64_decode($pem_data);
    }

    function toPem () {
        return $this->pem;
    }

    static function fromPem ($str) {
        $rebuilt = array();
        foreach(explode("\n", $str) as $line) {
            $line = trim($line);
            if (strlen($line) > 1) {
                array_push($rebuilt, $line);
            }
        };
        $rebuilt = join("\n", $rebuilt) . "\n";
        return new PublicKey($rebuilt);
    }

    static function fromDer ($str) {
        $pem_data = base64_encode($str);
        $pem = "-----BEGIN PUBLIC KEY-----\n" . substr($pem_data, 0, 64) . "\n" . substr($pem_data, 64) . "\n-----END PUBLIC KEY-----\n";
        return new PublicKey($pem);
    }

    static function fromString ($str) {
        return PublicKey::fromDer(base64_decode($str));
    }

}


class Signature {

    function __construct ($der) {
        $this->der = $der;
    }

    function toDer () {
        return $this->der;
    }

    function toBase64 () {
        return base64_encode($this->der);
    }

    static function fromDer ($str) {
        return new Signature($str);
    }

    static function fromBase64 ($str) {
        return new Signature(base64_decode($str));
    }
}
