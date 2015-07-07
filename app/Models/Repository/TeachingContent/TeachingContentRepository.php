<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 5:04 PM
 */

namespace FutureEd\Models\Repository\TeachingContent;


use FutureEd\Models\Core\TeachingContent;
use League\Flysystem\Exception;

class TeachingContentRepository implements TeachingContentRepositoryInterface{

    /**
     * Add Teaching content.
     * @param $data
     * @return string|static
     */
	public function addTeachingContent($data){

		try{

			return TeachingContent::create($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

    /**
     * Get Teaching contents.
     * @param array $criteria
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getTeachingContents($criteria = [],$limit,$offset){

        $query = new TeachingContent();

        $query = $query->with('learningStyle','mediaType');

        if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $query->count();
        } else {
            if (count($criteria) > 0) {

                if(isset($criteria['teaching_module'])){
                    $query = $query->teachingModule($criteria['teaching_module']);
                }

                if(isset($criteria['learning_style'])){
                    $query = $query->learningStyleId($criteria['learning_style']);
                }
            }

            $count = $query->count();

            if ($limit > 0 && $offset >= 0) {
                $query = $query->offset($offset)->limit($limit);
            }

        }

        return ['total' => $count, 'records' => $query->get()->toArray()];

    }

    /**
     * Delete Teaching content.
     * @param $id
     * @return bool
     */
    public function deleteTeachingContent($id){
        try{
            $result = TeachingContent::find($id);
            return is_null($result) ? false : $result->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update Teaching content.
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateTeachingContent($id,$data){
        try{
            $result = TeachingContent::find($id);
            return is_null($result) ? false : $result->update($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}