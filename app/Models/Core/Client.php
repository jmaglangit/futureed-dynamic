<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

	//
	use SoftDeletes;

	protected $table = 'clients';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'street_address',
		'city',
		'state',
		'country',
		'country_id',
		'zip',
		'school_code',
		'account_status',
		'client_role'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'country_id' => 0,
		'account_status' => 'Pending'
	];


	public static function boot()
	{

		parent::boot();

		Client::deleting(function ($admin) {
			$admin->user->delete();
		});
	}

	//-------------relationships
	public function user()
	{
		return $this->belongsTo('FutureEd\Models\Core\User');
	}

	//-------------relationships classroom
	public function classroom()
	{
		return $this->hasMany('FutureEd\Models\Core\Classroom');
	}

	public function school()
	{

		return $this->belongsTo('FutureEd\Models\Core\School', 'school_code', 'code');
	}

	public function student()
	{


		return $this->hasMany('FutureEd\Models\Core\ParentStudent', 'parent_id', 'id');
	}

	//-------------scopes
	public function scopeId($query, $id)
	{

		return $query->where('id', $id);
	}

	public function scopeName($query, $name)
	{

		return $query->where(function ($query) use ($name) {
			$query->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');
		});

	}

	public function scopeEmail($query, $email)
	{

		return $query->whereHas('user', function ($query) use ($email) {
			$query->whereEmail($email);
		});

	}

	public function scopeRole($query, $role)
	{

		$roles = (array)$role;

		return $query->whereIn('client_role', $roles);

	}

	public function scopeTeacher($query)
	{
		return $query->whereClientRole(config('futureed.teacher'));
	}

	public function scopeStatus($query, $status)
	{

		return $query->whereHas('user', function ($query) use ($status) {
			$query->whereStatus($status);
		});

	}

	public function scopeSchool_Name($query, $school_name)
	{

		return $query->whereHas('school', function ($query) use ($school_name) {
			$query->where('name', 'like', "%$school_name%");
		});

	}

	public function scopeRegistrationToken($query, $registration_token)
	{

		return $query->whereHas('user', function ($query) use ($registration_token) {
			$query->where('registration_token', $registration_token);
		});
	}

	public function scopeUserId($query, $user_id)
	{
		return $query->where('user_id', $user_id);
	}

	public function scopeSchoolCode($query, $school_code)
	{
		return $query->where('school_code', $school_code);
	}

	public function scopeClientRoleIn($query, $roles = array())
	{
		return $query->whereIn('client_role', $roles);
	}


}
