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
        switch($this->method())
        {
			case 'POST':
				switch ($this->route()->getName()) {

					case 'parent-student.add.existing.student':
						return [
							'email' => 'required|email',
							'client_id' => 'required|integer'];
						break;
					case 'parent-student.confirm.student':
						return [
							'client_id' => 'required|integer',
							'invitation_code' => 'required|integer'];
						break;
					case 'parent-student.add.student':
						return [
							'student_id' => 'required|integer|exists:students,id,deleted,NULL',
							'parent_id' => 'required|integer',
							'order_id' => 'required',
							'price' => 'required|numeric',
							'subject_id' => 'required|integer'
						];
						break;
					case 'parent-student.add.student.by.email':
						return [
							'email' => 'required|email',
							'parent_id' => 'required|integer',
							'order_id' => 'required',
							'price' => 'required|numeric',
							'subject_id' => 'required|integer'];
						break;
					case 'parent-student.add.student.by.username':
						return [
							'username' => 'required',
							'parent_id' => 'required|integer',
							'order_id' => 'required',
							'price' => 'required|numeric',
							'subject_id' => 'required|integer'
							];
						break;
				}

			case 'PUT':
				switch ($this->route()->getName()) {
					case 'parent-student.pay.subscription':
						return [
							'parent_id' => 'required|integer',
							'order_date' => 'required|date_format:Ymd',
							'subscription_id' => 'required|integer',
							'date_end' => 'required|numeric',
							'total_amount' => 'required|numeric',
							'discount_type' => 'in:Client,Volume,',
							'discount_id' => 'integer',
							'discount' => 'numeric',
//							'order_no' => 'required',
							'subject_id' => 'required|integer'
							];
						break;
					default:
						$student_id = $this->__get('id');
						$student = Student::find($student_id);
						$student_id = NULL;

						if ($student) {

							$student_id = $student->user_id;
						}

						return [
							'username' => 'required|min:' . config('futureed.username_min') . '|max:' . config('futureed.username_max') . '|alpha_num|unique:users,username,' . $student_id . ',id,user_type,' . config('futureed.student') . ',deleted_at,NULL',
							'first_name' => 'required|regex:' . config('regex.name') . '|max:64',
							'last_name' => 'required|regex:' . config('regex.name') . '|max:64',
							'gender' => 'required|alpha|in:Male,Female',
							'birth_date' => 'required|date_format:Ymd',
							'country_id' => 'required|integer',
							'state' => 'string',
							'city' => 'required|string'
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
            'client_id.required' => trans('errors.1003',['attribute' => trans('errors.2176')]),
            'client_id.integer' => trans('errors.1013',['attribute' => trans('errors.2176')]),
            'country_id.required' => trans('errors.1003',['attribute' => trans('errors.2154')]),
            'subscription_id.required' => trans('errors.1003',['attribute' => trans('errors.2199')]),
            'subscription_id.integer' => trans('errors.1013',['attribute' => trans('errors.2199')]),
            'parent_id.required' => trans('errors.1003',['attribute' => trans('errors.2208')]),
            'parent_id.integer' => trans('errors.1013',['attribute' => trans('errors.2208')]),
            'order_id.required' => trans('errors.1003',['attribute' => trans('errors.2209')]),
            'order_id.integer' => trans('errors.1013',['attribute' => trans('errors.2209')]),
            'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
            'subject_id.integer' => trans('errors.1013',['attribute' => trans('errors.2155')]),
        ];
    }
}