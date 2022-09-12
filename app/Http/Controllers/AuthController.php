<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\import\CreateUserDTO;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AuthController extends Controller
{
    protected UserService $userService;

    protected AuthService $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    /**
     * @param AuthLoginRequest $request
     * @return RedirectResponse
     */
    public function login(AuthLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $this->authService->authorizationWithCredentials($credentials);

        return back();
    }

    /**
     * @param AuthRegisterRequest $request
     * @return RedirectResponse
     * @throws UnknownProperties
     */
    public function register(AuthRegisterRequest $request): RedirectResponse
    {
        $data = new CreateUserDTO($request->validated());

        /** @var User $user */
        $user = $this->userService->create($data);

        $this->authService->authorizeModel($user);

        return back();
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        return back();
    }
}
