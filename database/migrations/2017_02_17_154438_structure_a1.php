<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Auditorium;
use App\User;
use Hash as h;


class StructureA1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('user_auth_token');
          $table->string('username');
          $table->string('password');
          $table->string('department');
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('auditoriums', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('events',function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('audi_id')->unsigned();
            $table->string('audi_name');
            $table->foreign('audi_id')->references('id')->on('auditoriums')->onDelete('cascade');
            $table->string('dept');
            $table->integer('event_iscancelled');
            $table->string('title');
            $table->string('description');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->timestamps();
            $table->softDeletes();
        });

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'principal';
        $user->password = 'saec';
        $user->department = 'Administration';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'director';
        $user->password = 'saec';
        $user->department = 'Administration';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'csehod';
        $user->password = 'saec';
        $user->department = 'CSE';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'ithod';
        $user->password = 'saec';
        $user->department = 'IT';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'mechhod';
        $user->password = 'saec';
        $user->department = 'ME';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'ecehod';
        $user->password = 'saec';
        $user->department = 'ECE';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'eeehod';
        $user->password = 'saec';
        $user->department = 'EEE';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'civilhod';
        $user->password = 'saec';
        $user->department = 'CIVIL';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'mbahod';
        $user->password = 'saec';
        $user->department = 'MBA';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'mcahod';
        $user->password = 'saec';
        $user->department = 'MCA';
        $user->save();

        $user = new User;
        $user->user_auth_token = h::make('saec');
        $user->username = 'mehod';
        $user->password = 'saec';
        $user->department = 'ME PG';
        $user->save();

        $audi = new Auditorium;
        $audi->name = 'Auditorium';
        $audi->save();

        $audi = new Auditorium;
        $audi->name = 'Meeting Hall';
        $audi->save();

        $audi = new Auditorium;
        $audi->name = 'Main Block';
        $audi->save();

        $audi = new Auditorium;
        $audi->name = 'MBA Conference Hall';
        $audi->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('events');
        Schema::drop('auditoriums');
    }
}
