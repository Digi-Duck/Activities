<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Services\FilesService;
use App\Models\UserRoleAdmin;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    public function __construct(protected FilesService $fileService)
    {
        
    }
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phonenumber' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_role' => 'required|numeric',
            'image' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
        ]);
        if ($user->user_role === '3') {
            UserRoleStudent::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'phone_number' => $request->phonenumber,
                'img_path' => $this->fileService->base64Upload($request->image, 'userImage'),
            ]);
        } elseif ($user->user_role === '2') {
            UserRolePresenter::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'phone_number' => $request->phonenumber,
                'img_path' => $this->fileService->base64Upload($request->image, 'userImage'),
            ]);
        } else {
            UserRoleAdmin::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
