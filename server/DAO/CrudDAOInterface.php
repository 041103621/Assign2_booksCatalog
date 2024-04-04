<?php
interface CrudDAOInterface
{
    public  function insert($object);
    public  function update($object);
    public  function delete($id);
    public  function findById($id);
    public  function findAll();
}
