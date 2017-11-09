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
            'required|integer|unique:module_groups,age_group_id,'.$this->id.',id,module_id,'.$this->module_id.',deleted_at,NULL';
        return [
            'age_group_id' => $age_group_id_rules,
            'module_id' => 'required|integer',
            'points_earned' => 'required|integer|min:1|max:9999'
        ];
    }

    public function messages(){

        return [
            'age_group_id.required' => trans('errors.1003',['attribute' => trans('errors.2207')]),
            'module_id.required' => trans('errors.1003',['attribute' => trans('errors.2161')]),
            'age_group_id.integer' => trans('errors.1013',['attribute' => trans('errors.2207')]),
            'module_id.integer' => trans('errors.1013',['attribute' => trans('errors.2161')]),
            'age_group_id.unique' => trans('errors.1007',['attribute' => trans('errors.2207')]),
            'points_earned.required' => trans('errors.1015',['attribute' => trans('errors.2169')]),
            'points_earned.integer' => trans('errors.1016',['attribute' => trans('errors.2169')]),
        ];
    }
}