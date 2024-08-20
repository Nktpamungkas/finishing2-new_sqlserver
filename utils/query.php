<?php

function insertIntoTable($conn, $table, $data) {
    try {

        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        $columns = array_keys($data);

        $columnsList = implode(", ", $columns);

        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        
        $sql = "INSERT INTO $table ($columnsList) VALUES ($placeholders)";
        
        $values = array_values($data);

        $stmt = sqlsrv_prepare($conn, $sql, $values);
        
        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        
        if (!sqlsrv_execute($stmt)) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // echo "Data inserted successfully!";
        
    } catch (Exception $e) {
        // Handle the exception and echo the error message
        echo "Error: " . $e->getMessage();
    }
}

function updateTable($conn, $table, $data, $conditions) {
    try {
        // Loop through the data array to check for empty strings and set them to null
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        // Build the SET part of the SQL statement
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "$key = ?";
        }
        $setClause = implode(", ", $setClauses);

        // Build the WHERE part of the SQL statement
        $conditionClauses = [];
        $conditionValues = [];
        foreach ($conditions as $key => $value) {
            $conditionClauses[] = "$key = ?";
            $conditionValues[] = $value;
        }
        $whereClause = implode(" AND ", $conditionClauses);

        // Combine all values (data + conditions) for the prepared statement
        $values = array_merge(array_values($data), $conditionValues);

        // Prepare the SQL statement
        $sql = "UPDATE $table SET $setClause WHERE $whereClause";

        // Prepare the statement
        $stmt = sqlsrv_prepare($conn, $sql, $values);

        if ($stmt === false) {
            // Handle prepare error
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Execute the statement
        if (!sqlsrv_execute($stmt)) {
            // Handle execution error
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        echo "Record updated successfully!";
        
    } catch (Exception $e) {
        // Handle the exception and echo the error message
        echo "Error: " . $e->getMessage();
    }
}

function deleteTable($conn, $table, $conditions) {
    try {
        // Build the WHERE part of the SQL statement
        $conditionClauses = [];
        $conditionValues = [];
        foreach ($conditions as $key => $value) {
            $conditionClauses[] = "$key = ?";
            $conditionValues[] = $value;
        }
        $whereClause = implode(" AND ", $conditionClauses);

        // Prepare the SQL statement
        $sql = "DELETE FROM $table WHERE $whereClause";

        // Prepare the statement
        $stmt = sqlsrv_prepare($conn, $sql, $conditionValues);

        if ($stmt === false) {
            // Handle prepare error
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Execute the statement
        if (!sqlsrv_execute($stmt)) {
            // Handle execution error
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        echo "Record(s) deleted successfully!";
        
    } catch (Exception $e) {
        // Handle the exception and echo the error message
        echo "Error: " . $e->getMessage();
    }
}

function resultSelect($data) {
    $updatedData = [];

    foreach ($data as $key => $value) {

        if ($value instanceof DateTime) {
            if ($value->format('H:i:s') === '00:00:00') {
                $updatedData[$key] = $value->format('Y-m-d');
            } else {
                $updatedData[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        elseif (is_float($value)) {
            $updatedData[$key] = number_format($value, 2, '.', '');
        }

        elseif (is_int($value)) {

            $updatedData[$key] = number_format($value);
        }

        elseif($value==='0000-00-00 00:00:00'){
            $updatedData[$key] = NULL;
        }

        elseif(empty($value)){
            $updatedData[$key] = NULL;
        }

        else {
            $updatedData[$key] = $value; // Leave other types unchanged
        }
    }

    return $updatedData;
}

/*
HOW TO USE
=======================================================================
1. Insert Into Table

    $data = [
        'name' => 'John Doe',
        'email' => '', // This will be converted to NULL
        'age' => 30
    ];

    insertIntoTable($conn, 'users', $data);

=======================================================================

2. Update Table

    $data = [
        'name' => 'John Doe',
        'email' => '', // This will be converted to NULL
        'age' => 30
    ];

    $conditions = [
        'id' => 1,
        'status' => 'active'
    ];

    updateTable($conn, 'users', $data, $conditions);

=======================================================================

3. Delete Table

    $conditions = [
        'id' => 1,
        'status' => 'inactive'
    ];

    deleteTable($conn, 'users', $conditions);

=======================================================================

4. ResultSelect

    while ($row_data = resultSelect(sqlsrv_fetch_array($stmt))


*/