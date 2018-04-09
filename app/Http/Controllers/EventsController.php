<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Hash;
use App\User;
use App\Event;
use App\Auditorium;

class EventsController extends Controller
{
    public function events(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(),[
            'audi_id' => 'required|exists:auditoriums,id',
            'title' => 'required|string',
            'description' => 'string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
        ], [
            'audi_id.required' => 'Auditorium ID is required',
            'title.required' => 'Title is required',
            'start_time.date' => 'Invalid date format',
            'start_time.required' => 'Event start time is required',
            'end_time.date' => 'Invalid date format',
            'end_time.required' => 'Event end time is required',
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

        // Fetch the auditorium
        $audi = Auditorium::where('id',$inputs['audi_id'])->first();

        // Check if the time is available
        $range = [$inputs['start_time'], $inputs['end_time']];
        $events = Event::where('audi_id', $inputs['audi_id'])->whereBetween('start', $range)->count();
        $events_end = Event::where('audi_id', $inputs['audi_id'])->whereBetween('end', $range)->count();

        if ($events > 0 || $events_end > 0)
        {
            $response = ['message' => 'Auditorium Unavailable'];
            return response($response, 422);
        }

        $audi_book = new Event;
        $audi_book->user_id = $auth_user->id;
        $audi_book->audi_id = $inputs['audi_id'];
        $audi_book->audi_name = $audi->name;
        $audi_book->title = $inputs['title'];
        $audi_book->description = $inputs['description'];
        $audi_book->dept = $auth_user->department;
        $audi_book->start = $inputs['start_time'];
        $audi_book->end = $inputs['end_time'];
        $audi_book->save();
        $response = ['message' => 'Auditorium Booked'];
        return response($response,200);

    }

    public function cancel_booking($id, Request $request)
    {
        // Retrieve slug from url
        $request->request->add(['id' => $id]);

        // Validate data
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:events,id',
            'password' => 'required|string',
        ], [
            'id.required' => 'Event ID is required',
            'id.exists' => 'Event does not exist',
            'password.required' => 'Password is required',
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


        // check if the password is correct
        if (Hash::check($inputs['password'], $auth_user->password) == false)
        {
          $response = ['message' => 'Incorrect password'];
          return response($response, 422);
        }

        // Fetch the event
        $event = Event::where('id', $inputs['id'])->first();

        // Cancel Booking
        $event->event_iscancelled = 1;
        $event->save();

        // Response
        $response = ['message' => 'Booking Cancelled'];
        return response($response,200);
    }

    public function timeline(Request $request)
    {
        /*// Validate data
        $validator = Validator::make($request->all(), [
            'time' => 'required|date',
        ], [
            'time.required' => 'Time is required',
            'time.date' => 'Invalid Time',
        ]);

        // Stop if validation fails
        if ($validator->fails())
        {
            $response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
            return response($response, 422);
        }*/
        // Authenticate User
		$auth_user = User::where('id', $request->server('PHP_AUTH_USER'))->first();

        // Store all inputs
        $inputs = $request->all();
        $time=date("Y-m-d H:i:s");

        // Fetch the future events
        $events1 = Event::where('audi_id',1)->where('start', '>' ,$time)->get();
        $events2 = Event::where('audi_id',2)->where('start', '>' ,$time)->get();
        $events3 = Event::where('audi_id',3)->where('start', '>' ,$time)->get();
        $events4 = Event::where('audi_id',4)->where('start', '>' ,$time)->get();

        // Response
        $response = ['Auditorium 1' => $events1, 'Auditorium 2' => $events2, 'Auditorium 3' => $events3, 'Auditorium 4' => $events4];
        return response($response,200);
    }

    public function event_details($id,Request $request)
    {
        // Retrieve slug from url
        $request->request->add(['id' => $id]);

        // Validate data
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:events,id',
        ],[
            'id.required' => 'Event ID is required',
            'id.exists' => 'Invalid Event ID',
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

        // Fetch the event
        $event = Event::where('id', $inputs['id'])->first();

        // Return event as a response
        $response = ['event' => $event];
        return response($response,200);

    }

    public function change_password(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ], [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
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

        // Check if the old password is correct
        if (Hash::check($inputs['old_password'], $auth_user->password) == false)
        {
          $response = ['message' => 'Incorrect password'];
          return response($response, 422);
        }

        // Check if the old password matches with new password
        if ($inputs['old_password'] == $inputs['new_password'])
        {
            $response = ['message' => 'New password matches with the old password'];
            return response($response, 422);
        }

        // Store the new password
        $auth_user->password = Hash::make($inputs['new_password']);
        $auth_user->save();

        $response = ['message' => 'Password changed successfully'];
        return response($response,200);
    }
}
