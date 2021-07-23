<?php
function executeQuery($conn,$query){
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt;
}