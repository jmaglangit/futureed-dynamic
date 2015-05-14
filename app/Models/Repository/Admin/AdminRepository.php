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

    /**
     * Get list of Administrators
     *
     * @return array
     */
    public function getAdmins(){
        //get list of administrators username, email, roles
        $admin = new Admin();

        return $admin->with('user')->get();

    }

    public function getAdmin($id){

        return Admin::find($id);

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

        return Admin::select('id','user_id')->where('id','=',$id)->get();

    }



}