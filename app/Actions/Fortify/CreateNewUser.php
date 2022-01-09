<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'login' => [
                'required',
                'string',
            //    'max:11',
                Rule::unique(User::class),
            ],
            'email' => [
                'string',
            ],
            'surname' => [
                'required',
                'string',
            ],
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'sex' => [
                'required',
                'int',
            ],
            'birthday' => [
                'required',
                'string',
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'login' => $input['login'],
            'email' => $input['email'],
            'surname' => $input['surname'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'sex' => $input['sex'],
            'birthday' => $input['birthday'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
