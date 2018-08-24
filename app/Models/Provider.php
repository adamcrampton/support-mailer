<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $fillable = ['provider_name', 'provider_status'];

    // Get all providers.
    public function getProviderList()
    {
    	return Provider::where('provider_status', 1)->get();
    }

    public function getDeletedProviderList()
    {
        return Provider::where('provider_status', 0)->get();
    }

    // Eloquent relationship bindings.
    public function config()
    {
    	return $this->belongsTo('App\Models\Config', 'id');
    }

    public function submissionLog()
    {
    	return $this->hasMany('App\Models\SubmissionLog', 'id');
    }
}
