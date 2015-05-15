<?php

namespace FutureEd\Models\Repository\Announcement;

interface AnnouncementRepositoryInterface {
    
    public function getAnnouncement();
    public function updateAnnouncement($announcement);
}