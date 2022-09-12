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
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * @param UserService $userService
     * @param AuthService $authService
     */
    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    /**
     * Handles user login
     *
     * @param AuthLoginRequest $request
     * @return RedirectResponse
     */
    public function login(AuthLoginRequest $request): RedirectResponse
    {
        //Makes an array with the email and password from request
        $credentials = $request->only('email', 'password');

        //Makes authorization with email and password
        $this->authService->authorizationWithCredentials($credentials);

        //Returns to dashboard if succeeded, if fails back to login page
        return back();
    }

    /**
     * Handles user registration
     *
     * @param AuthRegisterRequest $request
     * @return RedirectResponse
     * @throws UnknownProperties
     */
    public function register(AuthRegisterRequest $request): RedirectResponse
    {
        //Create User DTO from validated request
        $data = new CreateUserDTO($request->validated());

        /** @var User $user */
        $user = $this->userService->create($data);

        //Makes authorization for the new user
        $this->authService->authorizeModel($user);

        //Returns to dashboard
        return back();
    }

    /**
     * Handles user logout
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        //Makes logout
        $this->authService->logout();

        //Returns to main page
        return back();
    }
}
