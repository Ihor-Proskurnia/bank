<?php

namespace App\Library\ShaHash;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\HashManager;

class ShaHasher extends HashManager implements HasherContract
{
    /**
     * Get information about the given hashed value.
     *
     * @param string $hashedValue
     *
     * @return array
     */
    public function info($hashedValue)
    {
        return [];
    }

    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function make($value, array $options = [])
    {
        $valueWithSalt = env('SHA1_SALT', '') . $value;
        return hash('sha1', $valueWithSalt);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
