<?php namespace FutureEd\Models\Repository\ModuleGroup;

use FutureEd\Models\Core\ModuleGroup;

class ModuleGroupRepository implements ModuleGroupRepositoryInterface{

    public function addModuleGroup($data){
        try {
            return ModuleGroup::create($data);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getModuleGroups($criteria = array(), $limit = 0, $offset = 0){

        $moduleGroup = new ModuleGroup();

        $moduleGroup = $moduleGroup->with('ageGroup','module');
        

        if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $moduleGroup->count();
        } else {
            if (count($criteria) > 0) {
                //check relation to subject
                if(isset($criteria['age_group'])){
                    $moduleGroup = $moduleGroup->ageGroupId($criteria['age_group']);
                }
                //check module name
                if(isset($criteria['module_name'])){
                    $moduleGroup = $moduleGroup->moduleName($criteria['module_name']);
                }
            }

            $count = $moduleGroup->count();

            if ($limit > 0 && $offset >= 0) {
                $moduleGroup = $moduleGroup->offset($offset)->limit($limit);
            }

        }

        return ['total' => $count, 'records' => $moduleGroup->get()->toArray()];

    }

    public function getModuleGroup($id){
        return ModuleGroup::with('ageGroup','module')->find($id);
    }

    public function updateModuleGroup($id,$data){
        try{
            return ModuleGroup::find($id)->update($data);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteModuleGroup($id){
        try {
            $moduleGroup = ModuleGroup::find($id);

            return !is_null($moduleGroup) ? $moduleGroup->delete() : false;

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

}