<?php

interface IBaseRepository {
    public function GetAllList() : array;
    public function GetById(int $id) : ?object;
    public function Add(object $entity) : bool;
    public function Update(object $entity) : bool;
    public function Delete(int $id) : bool;
}
?>
