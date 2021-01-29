<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \App\Http\Controllers\DashDonate as API;



class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname', 'lastname', 'email', 'password', 'user_role', 'email_confirm_code', 'is_admin', 'stripe_customer_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	// Get user role
	public function getRole() {
		$role = $this->getAttribute('user_role');
		return $role;
	}

	// Check if user is an admin
	public function isAdmin() {
		$is_admin = $this->getAttribute('is_admin');
		return $is_admin;
	}

	// Get stripe customer ID
	public function getStripeCustomerId() {
		$stripe_customer_id = $this->getAttribute('stripe_customer_id');
		return $stripe_customer_id;
	}

	// Get charities connected to an account
	public function getCharitiesConnected() {
		$charities = API::get_connected_charities($this->attributes['id']);
		return $charities;
	}

}
