<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use FutureEd\Models\Traits\UserTransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model {


    use SoftDeletes;

	use UserTransactionTrait;

    protected $table = 'students';

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password_image_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'];

	protected $fillable =[
		'user_id',
		'first_name',
		'last_name',
		'gender',
		'birth_date',
		'country_id',
		'country',
		'state',
		'city',
		'avatar_id',
		'password_image_id',
		'parent_id',
		'school_code',
		'grade_code',
		'points',
		'point_level_id',
		'learning_style_id',
		'can_play',
		'status',
		'created_by',
		'updated_by',
		'points_used'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'country_id' => 0,
		'can_play' => 1
	];

	// Accessor
	public function getPointsAttribute($value){

		return ($value) ? $value : 0;
	}



    //-------------relationships
    public function user() {
        return $this->belongsTo('FutureEd\Models\Core\User');
    }

    public function school(){

        return $this->belongsTo('FutureEd\Models\Core\School','school_code','code');
    }

    public function grade(){

        return $this->belongsTo('FutureEd\Models\Core\Grade','grade_code','code');
    }

	public function badge(){

		return $this->belongsTo('FutureEd\Models\Core\StudentBadge','id','student_id');
	}

	public function classroom(){

		return $this->belongsTo('FutureEd\Models\Core\ClassStudent','id','student_id');
	}

	public function parent(){

		return $this->belongsTo('FutureEd\Models\Core\ParentStudent','id','student_id');
	}

	public function avatar(){
		return $this->belongsTo('FutureEd\Models\Core\Avatar');
	}

	public function country(){
		return $this->belongsTo('Webpatser\Countries\Countries');
	}

	//get student with relation to ClassStudent with relation to classroom
	public function studentClassroom(){

		return $this->belongsTo('FutureEd\Models\Core\ClassStudent','id','student_id')->with('classroom');
	}

	public function studentModule() {

	    return $this->hasMany('FutureEd\Models\Core\StudentModule', 'student_id', 'id');

    }


    //-------------scopes
	public function scopeUserId($query, $user_id){

		return $query->where('user_id',$user_id);
	}

    public function scopeName($query, $name) {

        return $query->whereHas('user', function($query) use ($name) {
            $query->where('name','like','%'.$name.'%');
        });

    }

    public function scopeEmail($query, $email) {

        return $query->whereHas('user', function($query) use ($email) {
            $query->where('email','like','%'.$email.'%');
        });

    }

	//TODO: This should be changed...whenever it is called.. parent() in relationship is called.
	public function scopeParent($query, $parent_id){

		return $query->whereHas('parent',function($query) use ($parent_id) {
			$query->where('parent_id', '=', $parent_id);
		});
	}

	public function scopeParentId($query, $parent_id){

		return $query->whereHas('parent',function($query) use ($parent_id) {
			$query->where('parent_id', '=', $parent_id);
		});
	}

	public function scopeClientId($query, $parent_id){

		return $query->where('parent_id',$parent_id);
	}


	public function scopeTeacher($query, $client_id){

		//check if has ClassStudent relation
		return $query->whereHas('studentclassroom',function($query) use ($client_id){

					//check if ClassStudent has Classroom relation
					$query->whereHas('classroom',function($query) use ($client_id){

						$query->where('client_id', '=', $client_id );
					});
		});


	}

	public function scopeToken($query,$reg_token){

		return $query->whereHas('user',function($query) use ($reg_token){
			$query->where('registration_token','=', $reg_token);

		});

	}

	public function scopeId($query, $id)
	{
		return $query->where('id', $id);
	}

	public function scopeSubscription($query){

		//check if has ClassStudent relation
		return $query->whereHas('studentclassroom',function($query) {

			//check if ClassStudent has Classroom relation
			 $query->whereHas('classroom',function($query) {

				//check relation invoice_details
				$query->whereHas('invoiceDetails', function($query){

					//check relation to invoice
					$query->whereHas('invoice', function($query){

						$query->where('date_end','>=', Carbon::now())
						      ->Where('payment_status', '!=', 'Cancelled');

					});

				});

			});
		});

	}

	public function scopeNoConfirmationCode($query){

		//check relation to user
		$query->whereHas('user', function($query){

			$query->where('confirmation_code', '=', NULL)
			      ->where('confirmation_code_expiry','=', NULL);

		});
	}

	public function scopeIsDateRemovedNull($query){

		return $query->whereHas('studentClassroom', function($query){

			$query->where('date_removed', NULL);

		});

	}

	public function scopeGoogleId($query, $google_id){

		return $query->whereHas('user', function ($query) use ($google_id) {

			$query->where('google_app_id', $google_id);
		});
	}

	public function scopeFacebookId($query, $facebook_id){

		return $query->whereHas('user', function($query) use ($facebook_id){

			$query->where('facebook_app_id',$facebook_id);
		});
	}


}
