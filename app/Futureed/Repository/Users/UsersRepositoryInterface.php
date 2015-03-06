<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace App\Futureed\Repository\Users;

interface UsersRepositoryInterface {

    public function getUsers();

    public function getUser($id);

    public function addUser($user);

    public function updateUser($user);

    public function deleteUser($id);


}