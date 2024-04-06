<?php
/**
 * The SqlHelper class offers a convenient way to execute database queries and operations,
 * incorporating the logic for prepared statements and parameter binding. It encapsulates
 * details of database interaction, enabling concise and secure SQL statement execution.
 */
class SqlHelper
{
	// Holds the database connection
    private $conn;
   /**
     * Constructor initializes the class with a database connection.
     * 
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
   /**
     * Executes an SQL query with optional parameter binding and returns the result.
     * 
     * @param string $sql The SQL statement to execute.
     * @param array $params Parameters to bind to the SQL statement (optional).
     * @param bool $isSelect Determines if the query expects a result set (true for SELECT queries).
     * @return mixed An array of all rows for SELECT, or the number of affected rows for non-SELECT queries.
     * @throws Exception If preparation or execution of the query fails.
     */
    public function executeQuery($sql, $params = [], $isSelect = true)
    {
        // Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }
        // Bind parameters if provided
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }
        // Handle SELECT queries
        if ($isSelect) {
            $result = $stmt->get_result();
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $stmt->close();
            return $rows;
        } else {
			// Handle non-SELECT queries
            $affectedRows = $stmt->affected_rows;
            $stmt->close();
            return $affectedRows;
        }
    }
    /**
     * Creates an object from a database row, dynamically setting properties based on the row's columns.
     * 
     * @param string $className The name of the class to instantiate.
     * @param array $row Associative array representing a database row.
     * @return object An instance of the specified class with properties set from the row.
     * @throws Exception If the specified class does not exist.
     */
    public static function createObjectFromRow($className, $row) {
        // Ensure the class exists
		if (!class_exists($className)) {
            throw new Exception("Class $className does not exist.");
        }
        // Instantiate the class
        $object = new $className();
        foreach ($row as $key => $value) {
			// Construct a setter method name from the column name
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            // If the setter exists, call it with the value
			if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }
        return $object;
    }
}
