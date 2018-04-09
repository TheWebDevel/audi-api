<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use Validator;
use App\User;
use App\Event;
use Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {

        // Validate data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'start_time' => 'required|date',
            'end_time' => 'required|date'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid E-mail',
            'start_time.required' => 'Start Time is required',
            'start_time.date' => 'Invalid Start Time',
            'end_time.date' => 'Invalid End Time',
            'end_time.required' => 'End Time is required',
        ]);

        // Stop if validation fails
        if ($validator->fails())
        {
            $response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
            return response($response, 422);
        }

        // Authenticate User
		$auth_user = User::where('id', $request->server('PHP_AUTH_USER'))->first();

        // Store all inputs
        $inputs = $request->all();
        $email = $inputs['email'];

        // Fetch the events
        $range = [$inputs['start_time'], $inputs['end_time']];
        $title = Event::where('event_iscancelled',0)->whereBetween('start', $range)->whereBetween('end',$range)->first();
        $content = Event::where('event_iscancelled',1)->whereBetween('start', $range)->whereBetween('end',$range)->first();



        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message) use ($email)
        {
            $message->from('status200ok@gmail.com', 'BookAudi');

            $message->to($email)->subject('Event Report');

        });

    }
    /*public function send(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message)
        {

            $message->from('status200ok@gmail.com', 'BookAudi');

            $message->to('sathishkumar0416@gmail.com');

        });

        return response()->json(['message' => 'Request completed']);
    }*/
}
