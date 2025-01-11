<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Hashing\BcryptHasher;

class HashFuncionandoConExitoTest extends TestCase
{
    public function test_password_hash_correcto()
    {
        $password = 'password123';

        $hasher = new BcryptHasher();

        $hashedPassword = $hasher->make($password);

        $this->assertTrue($hasher->check($password, $hashedPassword));
    }

    public function test_password_incorrecto_no_coincide_con_hash()
    {
        $password = 'password123';
        $incorrectPassword = 'wrongpassword456';

        $hasher = new BcryptHasher();

        $hashedPassword = $hasher->make($password);

        $this->assertFalse($hasher->check($incorrectPassword, $hashedPassword));
    }
}
