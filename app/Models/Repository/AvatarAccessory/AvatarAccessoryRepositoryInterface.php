<?php

namespace FutureEd\Models\Repository\AvatarAccessory;


interface AvatarAccessoryRepositoryInterface {
    public function getAvatarAccessories($student_id);
    public function buyAvatarAccessory($avatar_accessory);
}