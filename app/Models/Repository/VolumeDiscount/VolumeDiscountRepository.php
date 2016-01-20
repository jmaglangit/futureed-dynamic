<?php
namespace FutureEd\Models\Repository\VolumeDiscount;

use FutureEd\Models\Core\VolumeDiscount;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class VolumeDiscountRepository implements VolumeDiscountRepositoryInterface {

    use LoggerTrait;

    /**
     * Display a listing of VolumeDiscounts.
     *
     * @param	array	$criteria
     * @param	int		$limit
     * @param	int		$offset
     *
     * @return array
     */
    public function getVolumeDiscounts($criteria = array(), $limit = 0, $offset = 0) {

        DB::beginTransaction();

        try {

            $volumeDiscounts = new VolumeDiscount();

            $count = 0;

            if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

                $count = $volumeDiscounts->count();

            } else {

                if (count($criteria) > 0) {
                    if (isset($criteria['min_seats'])) {
                        $volumeDiscounts = $volumeDiscounts->minSeats($criteria['min_seats']);
                    }
                }

                $count = $volumeDiscounts->count();

                if ($limit > 0 && $offset >= 0) {
                    $volumeDiscounts = $volumeDiscounts->offset($offset)->limit($limit);
                }

            }

            $volumeDiscounts = $volumeDiscounts->orderBy('min_seats', 'asc');

            $response = ['total' => $count, 'records' => $volumeDiscounts->get()->toArray()];

        } catch (\Exception $e) {
            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }

    /**
     * Display specific VolumeDiscount by id.
     *
     * @param	int	$id
     *
     * @return object
     */
    public function getVolumeDiscount($id){

        DB::beginTransaction();
        try{

            $response = VolumeDiscount::find($id);

        }catch (\Exception $e){
            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }
        DB::commit();

        return $response;
    }

    /**
     * Update specific VolumeDiscount.
     *
     * @param  array	$volumeDiscount
     *
     * @return object
     */
    public function updateVolumeDiscount($id,$volumeDiscount){

        DB::beginTransaction();

        try {

            $result = VolumeDiscount::find($id);

            $response = !is_null($result) ? $result->update($volumeDiscount) : false;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * @param $volumeDiscount
     * @return array|bool
     */
    public function addVolumeDiscount($volumeDiscount){

        DB::beginTransaction();

        try{

            $response = VolumeDiscount::create($volumeDiscount)->toArray();

        }catch(\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete specific VolumeDiscount.
     * @param $id
     * @return bool
     * @internal param id $volumeDiscount
     */
    public function deleteVolumeDiscount($id){

        DB::beginTransaction();

        try{

            $result = VolumeDiscount::find($id);

            $response = !is_null($result) ? $result->delete() : false;

        }catch(\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     *  Get rounded off discount to be used in invoice discount.
     *  @param $min_seats int
     *  @return object
     */
    public function getRoundedOffDiscount($min_seats){

        DB::beginTransaction();
        try{

            $response = VolumeDiscount::floorMinSeats($min_seats)->orderBy('id', 'desc')->first();

        }catch(\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }
}