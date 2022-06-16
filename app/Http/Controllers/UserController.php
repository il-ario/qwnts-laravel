<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            $query = User::with('address');

            foreach ($request->get('sort') as $option) {
                if (substr($option, 0, 1) === '-') {
                    $query->orderBy(substr($option, 1), 'DESC');
                } else {
                    $query->orderBy($option, 'ASC');
                }
            }

            $users = $query->get();
        } else {
            $users = User::with('address')->get();
        }

        return response(UserResource::collection($users), 200);
    }

    /**
     * If the validator passes, store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $user = new User;

            $user->setValues($validated);
            
            $user->save();
    
            return response(new UserResource($user), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function show(string $email)
    {
        $user = User::with('address')->where('email', $email)->first();

        return response(new UserResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $email)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $user = User::where('email', $email)->first();

            $user->setValues($validated);
            
            $user->save();
    
            return response(new UserResource($user), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $email)
    {
        $user = User::where('email', $email)->first();

        $user->delete();

        return response(null, 200); 
    }

    /**
     * Custom validator.
     * 
     * @param  Request  $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function validator(Request $request)
    {
        $localPart = '';
        if ($request->has('email')) {
            $localPart = strstr($request->email, '@', true);
        }

        $validator = Validator::make($request->all(), [
            'given_name' => 'required',
            'family_name' => 'required',
            'email' => 'required|unique:users',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'password' => 
                [
                    'required', 
                    function ($attribute, $value, $fail) use ($localPart) {
                        if (preg_match("/{$localPart}/i", $value)) {
                            $fail("The email local part not allowed in the $attribute.");
                        }
                    },
                    Password::min(6)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols() 
                ],
            'address_id' => 'nullable|integer'
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
