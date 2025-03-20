<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     *
     *
     * @var list<string>
     */
 protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'last_login',
    ];

    protected $hidden = ['password', 'remember_token'];
    //  protected $fillable = [
    //     'name', 'email', 'password', 'role', 'last_login', 'status'
    // ];

    // protected $hidden = [
    //     'password',
    // ];

    // protected $casts = [
    //     'last_login' => 'datetime',
    // ];
}


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('gst_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
