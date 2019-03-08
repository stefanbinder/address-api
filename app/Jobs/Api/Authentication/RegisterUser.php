<?php

namespace App\Jobs\Api\Authentication;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;

class RegisterUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param Request $request
     * @return App\Models\User
     */
    public function handle(Request $request)
    {
        $email    = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name', '');

        $pw_hash = Hash::make($password);

        $user = User::create(['email' => $email, 'password' => $pw_hash, 'name' => $name ]);


        return $user;
    }

}
