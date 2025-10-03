<?php

namespace App\Actions\Checkins;

use Illuminate\Support\Facades\Log;

class DecryptTicketCode
{
    public function handle(string $encryptedCode): string
    {
        $decoded = base64_decode($encryptedCode);
        $parts = explode('::', $decoded, 2);

        if (count($parts) !== 2) {
            throw new \Exception('Format kode tiket tidak valid');
        }

        $encryptedData = $parts[0];
        $iv = base64_decode($parts[1]);

        $key = env('QR_ENCRYPTION_KEY');
        if (strlen($key) !== 32) {
            throw new \Exception('Kunci enkripsi tidak valid');
        }

        $decrypted = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, 0, $iv);
        if ($decrypted === false) {
            throw new \Exception('Gagal mendekripsi kode tiket.');
        }

        return $decrypted;
    }
}
