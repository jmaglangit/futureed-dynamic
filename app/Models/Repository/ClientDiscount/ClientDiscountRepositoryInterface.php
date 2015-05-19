<?php
namespace FutureEd\Models\Repository\ClientDiscount;

interface ClientDiscountRepositoryInterface {

    public function getClientDiscounts($criteria = array(), $limit = 0, $offset = 0);
    public function getClientDiscount($id);
    public function updateClientDiscount($clientDiscount);
    public function addClientDiscount($clientDiscount);
    public function deleteClientDiscount($id);
}