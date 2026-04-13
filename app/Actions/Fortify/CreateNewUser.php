<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, (new RegisterRequest)->rules())->validate();

        return DB::transaction(function () use ($input) {
            try {
                $user = User::create([
                    'name'     => $input['name'],
                    'email'    => $input['email'],
                    'password' => Hash::make($input['password']),
                ]);

                $user->profile()->save(new Profile);

                return $user;
            } catch (Exception $e) {
                throw ValidationException::withMessages([
                    'email' => '登録処理に失敗しました。時間をおいて再度お試しください。',
                ]);
            }
        });
    }
}
