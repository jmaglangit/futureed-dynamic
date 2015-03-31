<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace FutureEd\Models\Repository\User;

interface UserRepositoryInterface {

    public function getUsers();

    public function getUser($id);

    public function getUserByType($id,$type);

    public function addUser($user);

    public function updateUser($user);

    public function deleteUser($id);

    public function checkUserName($username,$user_type);

    public function checkEmail($email,$user_type);

    public function getLoginAttempts($id);

    public function accountActivated($id);

    public function accountLocked($id);

    public function accountDeleted($id);

    public function addLoginAttempt($id);

    public function resetLoginAttempt($id);

    public function lockAccount($id);

    public function getEmail($id);

    public function setAccessToken($access_token);

    public function getAccessToken($id);

}