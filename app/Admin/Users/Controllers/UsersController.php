<?php

namespace App\Admin\Users\Controllers;

use App\Admin\Users\Requests\UserStoreRequest;
use App\Admin\Users\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Users\Actions\CreateUserAction;
use Users\DTOs\UserData;
use Users\Actions\UpdateUserAction;
//use Users\{ DTOs\UserData, Actions\CreateUserAction, Actions\UpdateUserAction};

class UsersController
{
    public function index(): View
    {
        return view('admin.users.index');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function create(): View
    {
        $user = new User();
        return view('admin.users.create', compact('user'));
    }

    /*Old store

    public function store(UserStoreRequest $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $data = UserData::fromRequest($request);
        $user = ($createUserAction)($data);
        return redirect()
            ->route('admin.users.edit', $user)
            ->with('status', 'The user has been created successfully.');
    }
*/
    public function store(UserStoreRequest $request): RedirectResponse
    {
        //$data = UserData::fromRequest($request);
        //$user = ($createUserAction)($data);
        //dd($request);
        $user = User::Factory()->create([
            //"remember_token" => $request->_token,
                "firstname" => $request->firstname,
                  "lastname" => $request->lastname,
                  "email" => $request->email,
                  "password" => $request->password,
                "phone" => $request->phone
        ]);
        return redirect()
            ->route('admin.users.edit', $user)
            ->with('status', 'The user has been created successfully.');
    }

    public function update(User $user, UserUpdateRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $data = UserData::fromRequest($request);
        $user = ($updateUserAction)($user, $data);
        return redirect()
            ->route('admin.users.edit', $user)
            ->with('status', 'The user has been updated.');
    }

    public function destroy(User $user): JsonResponse
    {
        $data = [
            'success' => false,
            'message' => "The user with id $user->id does not exist in the system.",
            'status' => 500
        ];

        if ($user->delete()){
            $data = [
                'success' => true,
                'message' => "The user: <strong>$user->fullname</strong> has been deleted.",
                'status' => 200
            ];
        }

        return response()->json($data, $data['status']);
    }
}
