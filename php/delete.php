<?php
        include_once 'connection.php';
		
            try {
                $database = new Connection();
                $db = $database->openConnection();
                                
                $sql = "DELETE FROM pmerefmaster WHERE EMP_ID=".$_POST["updEmpID"];

                $statement = $db->prepare($sql);
                $statement->execute();
                
            }
            catch (PDOException $e)
            {
                echo "There is some problem in connection: " . $e->getMessage();
            }
?>