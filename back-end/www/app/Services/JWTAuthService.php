<?php
 
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
 
class JWTAuthService 
{
    public function __construct(
        private UserRepository $userRepository
    ){}
    
    /**
     * Summary of register
     * @param array $data
     * @return array{token: mixed, user: \Illuminate\Database\Eloquent\Model|mixed|\Illuminate\Http\JsonResponse}
     */
    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        $user = $this->userRepository->create($userData);
        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Summary of login
     * @param array $credentials
     * @throws \Exception
     * @return array
     */
    public function login(array $credentials): array
    {
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return ['error' => 'Login ou senha inválido'];
            }

            // Get the authenticated user.
            $user = auth()->user();
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return compact('token');
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return ['error' => 'Não foi possível validar seu acesso'];
        }
    }
}