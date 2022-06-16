<?php

namespace App\Http\Controllers;

use App\Http\Resources\Address as AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::get();

        return response(AddressResource::collection($addresses), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $addresses = new Address;

            $addresses->setValues($validated);

            $addresses->save();
    
            return response(new AddressResource($addresses), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Custom validator.
     * 
     * @param  Request $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'street' => 'required|min:3',
            'city' => 'required|min:3',
            'postal_code' => 'required|min:3',
            'country_code' => 'required|regex:/^[A-Z]{2}$/',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'user_id' => 'nullable|integer',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
