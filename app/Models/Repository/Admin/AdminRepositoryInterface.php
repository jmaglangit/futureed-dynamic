<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:21 AM
 */
namespace FutureEd\Models\Repository\Admin;

interface AdminRepositoryInterface {

    public function getAdmins($criteria = array(), $limit = 0, $offset = 0);

    public function getAdmin($id, $role='Admin');

	public function getAdminDetail($id);

    public function addAdmin($data);

    public function updateAdmin($id, $data);

    public function deleteAdmin($id);

    public function getAdminId($user_id);

    public function verifyAdminId($id);

	public function getAdminRole($id);

}