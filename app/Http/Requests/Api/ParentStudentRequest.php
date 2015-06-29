<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;
use FutureEd\Models\Core\Student;

class ParentStudentRequest extends ApiRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method)
        {
            case 'POST':
                switch($this->route()->getName()){

                    case 'parent-student.add.existing.student':
                        return ['email'    =>   'required|email',
                            'client_id'    =>   'required|integer'];
                        break;
                    case 'parent-student.confirm.student':
                        return ['client_id'        =>   'required|integer',
                            'invitation_code'  =>   'required|integer'];
                        break;
                    case 'parent-student.add.student.by.email':
                        return ['email'    =>   'required|email',
                            'parent_user_id'    =>   'required|integer',
                            'order_id' => 'required',
                            'price' => 'required|numeric'];
                        break;
                    case 'parent-student.add.student.by.username':
                        return ['username'    =>   'required',
                            'parent_user_id'  =>   'required|integer',
                            'order_id' => 'required',
                            'price' => 'required|numeric'];
                        break;
                }

            case 'PUT':
                switch($this->route()->getName()){
                    case 'parent-student.pay.subscription':
                        return ['parent_user_id' =>   'required|integer',
                            'order_date'  =>   'required|date_format:Ymd',
                            'subscription_id'  =>   'required|integer',
                            'date_start'  =>   'required|date_format:Ymd',
                            'date_end'  =>   'required|date_format:Ymd',
                            'total_amount'  =>   'required|numeric',
                            'discount_type'  =>   'in:Client,Volume,',
                            'discount_id'  =>   'integer',
                            'discount' => 'numeric',
                            'order_no' => 'required'];
                        break;
                    default:
                        $student_id = $this->__get('id');
                        $student = Student::find($student_id);
                        $student_user_id = NULL;

                        if($student){

                            $student_user_id = $student->user_id;
                        }

                        return[
                            'username' => 'required|min:'.config('futureed.username_min').'|max:'.config('futureed.username_max').'|alpha_num|unique:users,username,'.$student_user_id.',id,user_type,'.config('futureed.student').',deleted_at,NULL',
                            'first_name'    => 'required|regex:'.config('regex.name').'|max:64',
                            'last_name'     => 'required|regex:'.config('regex.name').'|max:64',
                            'gender'        => 'required|alpha|in:Male,Female',
                            'birth_date'    => 'required|date_format:Ymd',
                            'country_id'    => 'required|integer',
                            'state'         => 'string',
                            'city'          => 'required|string'
                        ];
                }
        }
    }

    /**
     * Get the validation rules custom messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_id.required' =>'Client is required.',
            'client_id.integer' =>'Client must be a number.',
            'country_id.required' => 'Country is required.',
            'subscription_id.required' => 'Subscription is required.',
            'subscription_id.integer' => 'Subscription must be a number.',
            'parent_user_id.required' => 'Parent is required.',
            'parent_user_id.integer' => 'Parent must be a number.',
            'order_id.required' => 'Order is required.',
            'order_id.integer' => 'Order must be a number.'
        ];
    }
}