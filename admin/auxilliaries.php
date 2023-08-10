<?php
//CREATING THE ADMIN CLASS
class Admin
{
    //DECLARE $conn AS A PRIVATE VARIABLE
    private $conn;
    //DECLARE $table AS A PRIVATE VARIABLE
    private $table;

    //DECLARING CONSTRUCTOR
    public function __construct($conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    //THE CREATE FUNCTION
    public function create($data)
    {
        //DECARE EMPTY ARRAYS
        $fields = array();
        $values = array();
        $params = array();

        //BREAK THE $data OBJECTS AND LOOP THEM TO VARIOUS ARRAYS BASED ON HOW YOU WILL USE IT
        foreach ($data as $key => $value) {
            $fields[] = $key;
            $values[] = ":$key";
            $params[":$key"] = $value;
        }
        //CONCATINATE THE FIELD ARRAY TO CREATE A QUERY
        $sql = "INSERT INTO " . $this->table . "(" . implode(", ", $fields) . ") VALUES(" . implode(", ", $values) . ")";
        $stmt = $this->conn->prepare($sql);
        // BIND PARAMETERS WITH THE HELP OF $param OBJECTS

        foreach ($params as $param => $paramvalue) {
            $stmt->bindValue($param, $paramvalue);
        }

        // EXECUTE THE QUERY
        $result = $stmt->execute();
        if ($result === false) {
            $errorInfo = $stmt->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        return true;
    }
    //THE READ FUNCTION WITH A WHERE CLAUSE
    public function read($searchField, $searchValue)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE $searchField = :$searchField";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":$searchField", $searchValue);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //THE READ FUNCTION WITHOUT A LIMIT
    public function readAll($primaryKey)
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY " . $primaryKey . " DESC ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //THE READ FUNCTION WITH NEWEST AT TOP
    public function readWithLimit($limit, $primaryKey)
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY " . $primaryKey . " DESC LIMIT " . $limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //THE UPDATE FUNCTION
    public function update($id, $data)
    {
        $fields = array();
        $params = array(':id' => $id);
        //BREAK THE $data OBJECTS AND LOOP THEM TO VARIOUS ARRAYS BASED ON HOW YOU WILL USE IT
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        //CONCATINATE THE FIELD ARRAY TO CREATE A QUERY
        $sql = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $param => $paramvalue) {
            $stmt->bindParam($param, $paramvalue);
        }
    }
}

function uploadImage($file, $destinationDirectory)
{
    $validExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $validExtensions)) {
        return false; // Invalid file extension
    }

    $fileName = uniqid('image_') . '.' . $fileExtension;
    $destinationPath = $destinationDirectory . '/' . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
        return $fileName; // Return the generated file name
    }

    return false; // File upload failed
};

// Function to generate a random combination of letters and numbers
function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
};


// Function to get the position name by ID
function get_position_name_by_id($position_id)
{
    // Your database query to fetch the position name based on the position_id
    // For example:
    global $pdo;
    $sql = "SELECT position_name FROM positions WHERE position_id = :position_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':position_id', $position_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the position name was found
    if ($result) {
        return $result['position_name'];
    } else {
        return "Unknown Position";
    }
}
