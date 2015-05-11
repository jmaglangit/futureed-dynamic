<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:21 AM
 */
namespace FutureEd\Models\Repository\Admin;

use FutureEd\Models\Core\Admin;

class AdminRepository implements  AdminRepositoryInterface {

    public function getAdmins(){

    }

    public function getAdmin($id){

        return Admin::find($id)->first();

    }

    public function addAdmin($admin){

    }

    public function updateAdmin($admin){

    }

    public function deleteAdmin($id){

    }

    public function getAdminId($user_id){

        return Admin::where('user_id','=',$user_id)->pluck('id');
    }

    public function verifyAdminId($id){

        return Admin::where('id','=',$id)->pluck('id');

    }

}