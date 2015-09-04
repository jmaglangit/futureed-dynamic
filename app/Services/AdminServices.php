<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 6:01 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;

class AdminServices {

    public function __construct(AdminRepositoryInterface $admin){
        $this->admin = $admin;
    }

    public function getAdmins(){
        return $this->admin->getAdmins();
    }

    public function getAdmin($id,$role = 'Admin'){
        return $this->admin->getAdmin($id,$role);
    }

    public function addAdmin($admin){
        $this->admin->addAdmin($admin);
    }

    public function deleteAdmin($id){
        $this->admin->deleteAdmin($id);
    }

    public function getAdminId($user_id){

        return $this->admin->getAdminId($user_id);
    }

    public function verifyAdminId($id){

        return $this->admin->verifyAdminId($id);
    }
}