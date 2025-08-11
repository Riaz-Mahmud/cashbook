<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CommonHelper{

    /**
     * Encrypts an ID.
     *
     * @param int|string $id The ID to be encrypted.
     * @return string The encrypted ID string.
     */
    public static function encodeId($id)
    {
        // Ensure there is an ID to encrypt before proceeding.
        if (empty($id)) {
            return null;
        }
        return Crypt::encrypt($id);
    }

    /**
     * Decrypts an encrypted ID.
     *
     * @param string $encryptedId The encrypted ID string.
     * @return int|string|null The decrypted ID, or null if decryption fails.
     */
    public static function decodeId($encryptedId)
    {
        // Ensure there is an encrypted ID to decrypt.
        if (empty($encryptedId)) {
            return null;
        }

        try {
            // Attempt to decrypt the ID.
            return Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            // If decryption fails (e.g., invalid payload), return null
            // to prevent application errors. You can also log the error here.
            // Log::error("Failed to decrypt ID: " . $e->getMessage());
            return null;
        }
    }
}
