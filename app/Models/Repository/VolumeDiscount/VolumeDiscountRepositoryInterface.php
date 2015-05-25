<?php
namespace FutureEd\Models\Repository\VolumeDiscount;

interface VolumeDiscountRepositoryInterface {

    public function getVolumeDiscounts($criteria = array(), $limit = 0, $offset = 0);
    public function getVolumeDiscount($id);
    public function updateVolumeDiscount($id,$VolumeDiscount);
    public function addVolumeDiscount($VolumeDiscount);
    public function deleteVolumeDiscount($id);
}