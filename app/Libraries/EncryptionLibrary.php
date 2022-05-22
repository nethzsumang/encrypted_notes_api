<?php
namespace App\Libraries;

/**
 * EncryptionLibrary
 * @author Kenneth Sumang
 * @version 1.0.0
 * @since 2022.05.22
 */
class EncryptionLibrary
{
    public const K1_LENGTH = 128;
    public const PBKDF2_ITERATIONS = 10000;
    public const PBKDF2_KEY_BYTES = 256;
    public const PBKDF2_ALGO = 'sha256';
    public const ENCRYPTION_ALGO = 'aes-256-cbc';
    public const SALT_BYTES = 64;
    public const IV_BYTES = 16;

    /**
     * Generate keys
     * @param string $password
     * @return array
     */
    public static function generateKeys(string $password) : array
    {
        $salt = openssl_random_pseudo_bytes(self::SALT_BYTES);
        $iv = openssl_random_pseudo_bytes(self::IV_BYTES);
        $k1 = openssl_random_pseudo_bytes(self::K1_LENGTH);

        // Generate 256-bit PBKDF2 key
        $pbkdf2key = openssl_pbkdf2($password, $salt, self::PBKDF2_KEY_BYTES, self::PBKDF2_ITERATIONS, self::PBKDF2_ALGO);

        // Separate k2 and k3 from k1
        $k2 = substr($pbkdf2key, 0, 128);
        $k3 = substr($pbkdf2key, 128, 256);

        // Encrypt k1
        $encryptedK1 = openssl_encrypt($k1, self::ENCRYPTION_ALGO, $k2, OPENSSL_RAW_DATA, $iv);

        return [
            'salt' => bin2hex($salt),
            'iv' => bin2hex($iv),
            'k1' => bin2hex($encryptedK1),
            'k3' => bin2hex($k3)
        ];
    }

    /**
     * Get k1
     * @param string $password
     * @param string $salt
     * @param string $encryptedK1
     * @param string $k3
     * @return string
     */
    public static function getKey(string $password, string $salt, string $encryptedK1, string $dbK3) : string
    {
        // Generate 256-bit PBKDF2 key
        $pbkdf2key = openssl_pbkdf2($password, $salt, self::PBKDF2_KEY_BYTES, self::PBKDF2_ITERATIONS, self::PBKDF2_ALGO);

        // Get k2 from pbkdf2 key
        $k2 = substr($pbkdf2key, 0, 128);
        $k3 = substr($pbkdf2key, 128, 256);

        if ($dbK3 !== bin2hex($k3)) {
            throw new \Exception('Invalid password');
        }

        return openssl_decrypt(hex2bin($encryptedK1), self::ENCRYPTION_ALGO, $k2, OPENSSL_RAW_DATA);
    }

    /**
     * Encrypt content
     * @param string $content
     * @param string $k1
     * @param string $iv
     * @return string
     */
    public static function encryptContent(string $content, string $k1, string $iv) : string
    {
        return bin2hex(openssl_encrypt($content, self::ENCRYPTION_ALGO, hex2bin($k1), OPENSSL_RAW_DATA, hex2bin($iv)));
    }

    /**
     * Decrypts a string
     * @param string $ciphertext
     * @param string $key
     * @return string
     */
    public static function decryptContent($ciphertext, string $k1, string $iv)
    {
        return openssl_decrypt($ciphertext, self::ENCRYPTION_ALGO, hex2bin($k1), OPENSSL_RAW_DATA, hex2bin($iv));
    }
}