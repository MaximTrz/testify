<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // Получаем аутентифицированного пользователя
        $user = $this->guard()->user();

        // Создаём токен Sanctum
        $token = $user->createToken('auth-token')->plainTextToken;

        // Сохраняем токен в сессии (или куках)
        session(['authToken' => $token]);

        // Перенаправляем пользователя
        return $this->authenticated($request, $user)
            ?: redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        // Получаем текущего пользователя
        $user = $request->user();

        // Удаляем токен из сессии
        if ($request->hasSession() && $sessionToken = $request->session()->get('authToken')) {

            [$id, $plainTextToken] = explode('|', $sessionToken, 2);

            // Ищем токен по ID и проверяем, принадлежит ли он пользователю
            $token = $user->tokens()->where('id', $id)->first();

            if ($token) {
                $token->delete();
            } else {
                // Токен не найден или не принадлежит пользователю
                Log::warning('Token not found or does not belong to the user', ['token_id' => $id]);
            }
        }


        // Альтернативно: удалить все токены пользователя
        //$user->tokens()->delete();


        // Выполняем стандартный выход
        $this->guard()->logout();

        // Очищаем сессию
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Перенаправляем пользователя
        return redirect('/');
    }


}
