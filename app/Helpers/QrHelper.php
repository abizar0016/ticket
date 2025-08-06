<?php

namespace App\Helpers;

class QrHelper
{
    public static function generateEncryptedQrData(array $payload): string
    {
        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

        $json = json_encode($payload);
        $encrypted = openssl_encrypt($json, $method, $key, 0, $iv);

        return base64_encode($encrypted . '::' . $iv);
    }

    public static function generateQrUrl(string $encryptedData): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=L&qzone=1&data=' . urlencode($encryptedData);
    }

    public static function decryptQrData(string $encryptedBase64): ?array
    {
        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');

        list($encrypted, $iv) = explode('::', base64_decode($encryptedBase64), 2);
        $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

        return json_decode($decrypted, true);
    }
}
