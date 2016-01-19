<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 5:04 PM
 */

namespace FutureEd\Models\Repository\TeachingContent;


use FutureEd\Models\Core\TeachingContent;
use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class TeachingContentRepository implements TeachingContentRepositoryInterface{

    use LoggerTrait;

    protected $module_content;

    public function __construct(
        ModuleContentRepositoryInterface $moduleContentRepositoryInterface
    ){
        $this->module_content = $moduleContentRepositoryInterface;

    }
    /**
     * Add Teaching content.
     * @param $data
     * @return string|static
     */
    public function addTeachingContent($data){

        DB::beginTransaction();

        try{

            $response = TeachingContent::create($data);

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get Teaching contents.
     * @param array $criteria
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getTeachingContents($criteria = [],$limit,$offset){

        DB::beginTransaction();

        try {
            $query = new TeachingContent();

            $query = $query->with('module', 'learningStyle', 'mediaType');

            if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

                $count = $query->count();
            } else {
                if (count($criteria) > 0) {

                    if (isset($criteria['teaching_module'])) {
                        $query = $query->teachingModule($criteria['teaching_module']);
                    }

                    if (isset($criteria['teaching_module_id'])) {
                        $query = $query->teachingModuleId($criteria['teaching_module_id']);
                    }

                    if (isset($criteria['learning_style'])) {
                        $query = $query->learningStyleId($criteria['learning_style']);
                    }
                }

                $count = $query->count();

                if ($limit > 0 && $offset >= 0) {
                    $query = $query->offset($offset)->limit($limit);
                }

            }

            $response = ['total' => $count, 'records' => $query->get()->toArray()];

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete Teaching content.
     * @param $id
     * @return bool
     */
    public function deleteTeachingContent($id){

        DB::beginTransaction();

        try{

            $result = TeachingContent::find($id);

            $this->module_content->deleteModuleContentByContent($id);

            $response = is_null($result) ? false : $result->delete();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Update Teaching content.
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateTeachingContent($id,$data){

        DB::beginTransaction();

		try {

			$result = TeachingContent::find($id);

			$result =  is_null($result) ? false : $result->update($data);

			if($result){

				$response = $this->getTeachingContent($id);
			} else {
                $response = null;
            }

		} catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get Teaching content.
     * @param $id
     * @return Object
     */
    public function getTeachingContent($id){

        DB::beginTransaction();

        try{

            $response = TeachingContent::with('subject','subjectArea','module','learningStyle','mediaType','moduleContent')
                ->find($id);

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get teaching content Id.
     * @param $module_id
     * @return bool
     */
	public function getTeachingContentId($module_id){

        DB::beginTransaction();

        try {

            $response = TeachingContent::teachingModuleId($module_id)->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
	}
}