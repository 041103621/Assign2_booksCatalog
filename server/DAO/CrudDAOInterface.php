<?php
/**
 * Interface CrudDAOInterface
 * This interface outlines the standard CRUD operations for a Data Access Object (DAO).
 */
interface CrudDAOInterface
{
	/**
     * Inserts a new record into the database based on the object's properties.
     *
     * @param mixed $object The object containing the data to be inserted.
     * @return mixed The result of the insert operation, typically an insert ID or a status array.
     */
    public  function insert($object);
	    /**
     * Updates an existing record in the database matching the object's ID with the object's current property values.
     *
     * @param mixed $object The object containing data to update, with a unique identifier to match against a database record.
     * @return mixed The result of the update operation, usually a boolean or a status array.
     */
    public  function update($object);
	/**
     * Deletes a record from the database corresponding to the provided identifier.
     *
     * @param mixed $id The unique identifier of the record to be deleted.
     * @return mixed The result of the delete operation, often a boolean or a status array.
     */
    public  function delete($id);
	    /**
     * Retrieves a single record from the database that matches the provided identifier.
     *
     * @param mixed $id The unique identifier of the record to retrieve.
     * @return mixed The fetched record, or null if no matching record is found.
     */
    public  function findById($id);
	    /**
     * Retrieves all records from the associated table in the database.
     *
     * @return array An array of all records from the database table.
     */
    public  function findAll();
}
