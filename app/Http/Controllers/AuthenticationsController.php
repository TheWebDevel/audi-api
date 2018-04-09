<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Validator;
use Hash;
use App\Event;
use App\User;


class AuthenticationsController extends Controller
{
    public function index()
    {
        $response = ['name' => 'Audi', 'version' => '1.0'];
        return response($response, 200);
    }

    public function cookie(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'user_auth_token' => 'required|string',
        ], [
            'id.required' => 'User id is required',
            'id.exists' => 'User does not exist',
            'user_auth_token.required' => 'User authentication token is required',
        ]);

        // Stop if validation fails
        if ($validator->fails())
        {
            $response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
            return response($response, 422);
        }

        // Store all inputs
        $inputs = $request->all();

        // Fetch the user
        $user = User::where('id', $inputs['id'])->first();

        // Reject if no user found
        if (count($user) == 0)
        {
            $response = ['message' => 'Invalid User'];
            return response($response, 422);
        }

        // Reject if the credentials is incorrect
        if ($user->user_auth_token != $inputs['user_auth_token'])
        {
            $response = ['message' => 'Invalid token data', 'token' => '', 'user' => ''];
            return response($response, 422);
        }

        // Response
        $response = ['user' => $user];
        return response($response,200);
    }

    public function login(Request $request)
    {

      // Validate data
      $validator = Validator::make($request->all(),[
        'username' => 'required|string|exists:users,username',
        'user_password' => 'required|string',
      ], [
        'username.required' => 'Username is required to log you in',
        'username.exists' => 'Invalid username',
        'user_password.required' => 'Enter the password to log you in',
      ]);

      // If validator fails
      if ($validator->fails())
      {
        $response = ['message' => $validator->messages()->all()[0], 'Validations' => $validator->messages()->all()];
        return response($response, 422);
      }

      // Store all input
      $inputs = $request->all();

      // Get the user
      $user = User::where('username', $inputs['username'])->first();

      // Check the password
      if ($inputs['user_password'] != $user->password)
      {
        $response = ['message' => 'Incorrect password'];
        return response($response, 422);
      }

      // Response
      $response = ['user' => $user];
      return response($response,200);
    }


}
