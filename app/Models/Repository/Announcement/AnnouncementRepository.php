<?php

namespace FutureEd\Models\Repository\Announcement;

use FutureEd\Models\Core\Announcement;

class AnnouncementRepository implements AnnouncementRepositoryInterface {

    /**
    *   return the one and only announcement.
    *   @return announcement record.
    */
    public function getAnnouncement(){
        return Announcement::select('announcement',
                             'date_start',
                             'date_end')->first();
    }
    
    /**
    *   Inserts or updates the announcement.
    *   @param $announcement form
    *   @return boolean
    */
    
    public function updateAnnouncement($announcement){
        
        $data = Announcement::first();
        if( is_null($data) )
            $data = new Announcement;
            
        $data->announcement = $announcement["announcement"];
        $data->date_start = $announcement["date_start"];
        $data->date_end = $announcement["date_end"];
        
        return $data->save();
    }
    
}