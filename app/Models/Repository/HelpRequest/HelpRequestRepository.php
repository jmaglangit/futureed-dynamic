<?php namespace FutureEd\Models\Repository\HelpRequest;

use FutureEd\Models\Core\HelpRequest;

class HelpRequestRepository implements HelpRequestRepositoryInterface{

    /**
     * Add record in storage
     * @param $data
     * @return object
     */
    public function addHelpRequest($data){
        try{
            return HelpRequest::create($data)->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Retrieve specific record in storage.
     * @param $id
     * @return array|null|string
     */

    public function getHelpRequest($id){
        try{
            $result = HelpRequest::with('classroom','module','subject','subjectArea','student')->find($id);
            return is_null($result) ? null : $result->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Search or list records
     * @param array $criteria
     * @param int $limit
     * @param int $offset
     *
     */
    public function getHelpRequests($criteria = array(), $limit = 0, $offset = 0){
        $query = new HelpRequest();

        $query = $query->NotRejected();

        if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
            $count = $query->count();
        } else {
            if(count($criteria) > 0) {
                if(isset($criteria['module'])) {
                    $query = $query->moduleName($criteria['module']);
                }
                if(isset($criteria['subject'])) {
                    $query = $query->subjectName($criteria['subject']);
                }
                if(isset($criteria['subject_area'])) {
                    $query = $query->subjectAreaName($criteria['subject_area']);
                }
                if(isset($criteria['status'])) {
                    $query = $query->status($criteria['status']);
                }
                if(isset($criteria['student'])) {
                    $query = $query->studentName($criteria['student']);
                }
                if(isset($criteria['title'])) {
                    $query = $query->title($criteria['title']);
                }
                if(isset($criteria['link_type'])) {
                    $query = $query->linkType($criteria['link_type']);
                }
            }
            $count = $query->count();

            if($limit > 0 && $offset >= 0) {
                $query = $query->offset($offset)->limit($limit);
            }
        }
        $query = $query->with('classroom','module','subject','subjectArea','student');
        $query = $query->orderBy('title', 'asc');

        return ['total' => $count, 'records' => $query->get()->toArray()];
    }

    /**
     * Update specific record
     * @param $id
     * @param $data
     * @return bool|int|string
     */
    public function updateHelpRequest($id,$data){
        try{
            $result = HelpRequest::find($id);
            return !is_null($result) ? $result->update($data) : false;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Delete specific record.
     * @param  $id
     * @return boolean
     */
    public function deleteHelpRequest($id){
        try{
            $result = HelpRequest::find($id);
            return !is_null($result) ? $result->delete() : false;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}