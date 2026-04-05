<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as ContractsRegisterResponse;

class RegisterResponse implements ContractsRegisterResponse
{
    public function toResponse($request)
    {
        return redirect()->route('profile.edit');
    }
}
