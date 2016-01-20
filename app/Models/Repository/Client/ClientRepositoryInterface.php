<?php namespace FutureEd\Models\Repository\Client;

interface ClientRepositoryInterface
{


	public function getClient($user_id, $role = 0);

	public function getTeacher($id, $role);

	public function checkClient($id, $role);

	public function addClient($client);

	public function getClientId($user_id);

	public function getRole($user_id);

	public function verifyClientId($id);

	public function getClientDetails($id);

	public function updateClientDetails($id, $clientData);

	public function updateClient($id, $data);

	public function getClients($criteria = array(), $limit = 0, $offset = 0);

	public function getClientCustomDetails($criteria);

	public function getTeacherDetails($criteria = array(), $limit = 0, $offset = 0);

	public function getClientByUserId($id);

	public function deleteClient($id);

	public function getClassroom($id);

	public function getStudent($id);

	public function getClientToClassroom($id);

	public function getSchoolCode($id);

	public function getClientRole($id);

	public function addClientFromFacebook($data);

	public function getClientByFacebook($facebook_id);

	public function addClientFromGoogle($data);

	public function getClientByGoogleId($google_id);

}