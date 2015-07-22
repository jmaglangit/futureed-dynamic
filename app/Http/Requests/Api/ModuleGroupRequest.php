<?php
namespace FutureEd\Http\Requests\Api;

class ModuleGroupRequest extends ApiRequest{
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
        $age_group_id_rules = $this->method() == 'POST' ?
            'required|integer|unique:module_groups,age_group_id,NULL,id,module_id,'.$this->module_id.',deleted_at,NULL' :
            'required|integer';
        return [
            'age_group_id' => $age_group_id_rules,
            'module_id' => 'required|integer',
            'points_earned' => 'required|integer|min:1|max:9999'
        ];
    }

    public function messages(){

        return [
            'age_group_id.required' =>'Age is required.',
            'module_id.required' =>'Module is required.',
            'age_group_id.integer' =>'Age group must be a number.',
            'module_id.integer' =>'Module must be a number.',
            'age_group_id.unique' => 'Age already exist.',
            'points_earned.required' => 'Total Points earned is required.',
            'points_earned.integer' => 'Total Points earned must be a number.'
        ];
    }
}