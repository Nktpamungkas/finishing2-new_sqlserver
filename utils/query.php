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

        echo "Data inserted successfully!";
        
    } catch (Exception $e) {
        // Handle the exception and echo the error message
        echo "Error: " . $e->getMessage();
    }
}

function updateTable($conn,$table,$data) {

}

function deleteTable($conn,$table,$data){

}

function resultSelect($data){
    
}