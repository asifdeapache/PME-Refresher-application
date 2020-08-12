<?php
Class Connection {
// credentials for local server  
//private  $server = "mysql:host=localhost;dbname=pmerefdb";
//private  $user = "asifadmin";
//private  $pass = "asif@admin42271";

// credentials for AWS server
/* Connection for AWS
private  $server = "mysql:host=aatu3wqmulzk46.c6izp5gscefo.us-west-2.rds.amazonaws.com;dbname=pmerefdb";
private  $user = "awsasifhossain";
private  $pass = "Asif-aws42271";
*/


/* Connection for InfinityFree 
private  $server = "mysql:host=sql309.epizy.com;dbname=epiz_26132574_ERPMERefDB";
private  $user = "epiz_26132574";
private  $pass = "rguSkMtvvZxfx"; */


/* Connection for 000webhost 
private  $server = "mysql:host=localhost;dbname=id14220222_pmerefdb";
private  $user = "id14220222_asifdeapache";
private  $pass = "Asif@admin42271"; */

/* Connection for local mySQL*/
private  $server = "mysql:host=localhost;dbname=pmerefdb";
private  $user = "asifadmin";
private  $pass = "asif@admin42271"; 

private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
protected $con;
 
  public function openConnection()  {
    try
    {
      $this->con = new PDO($this->server, $this->user,$this->pass,$this->options);
      return $this->con;
    }
    catch (PDOException $e)
    {
      echo "There is some problem in connection: " . $e->getMessage();
    }
  }
  public function closeConnection() {
    $this->con = null;
  }
}
?>