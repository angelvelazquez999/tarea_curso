<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Prueba que la validación de datos sea correcta.
     */
    public function test_login_validation()
    {
        $this->expectException(ValidationException::class);

        // Simula una solicitud con datos incompletos
        $data = [
            'email' => 'test@example.com', // Falta la contraseña
        ];

        // Valida los datos manualmente usando la regla de validación

        $validator = Validator::make($data,[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

         if ($validator->fails()) {
        throw new ValidationException($validator);
    }

    }

    /**
     * Prueba que las credenciales sean verificadas correctamente.
     */
    public function test_user_credentials_are_correct()
    {
        // Crea un usuario de prueba con una contraseña hasheada
        $user = User::factory()->make([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'), // Hasheamos la contraseña
        ]);

        // Simula credenciales correctas
        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Verifica si las credenciales coinciden
        $this->assertTrue(Hash::check($credentials['password'], $user->password));
    }

    /**
     * Prueba que el usuario se autentique correctamente.
     */
    public function test_user_can_be_authenticated()
    {
        // Crea un usuario y guárdalo en la base de datos
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Simula credenciales correctas
        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Usa el guard de autenticación para intentar autenticar
        $this->assertTrue(Auth::attempt($credentials));

        // Verifica que el usuario autenticado sea el correcto
        $this->assertEquals(Auth::user()->id, $user->id);
    }
}
