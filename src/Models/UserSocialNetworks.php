<?php

namespace Viviniko\User\Models;

use Viviniko\Support\Database\Eloquent\Model;

class UserSocialNetworks extends Model
{
    protected $tableConfigKey = 'user.social_networks_table';

	public $timestamps = false;

	protected $fillable = ['facebook', 'twitter', 'google_plus', 'dribbble', 'linked_in', 'skype'];
}
