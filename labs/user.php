<?php
  include "Crud.php";
  include "authenticator.php";
  include_once 'DBConnector.php';
  /**
   *
   */
  class User implements Crud
  {
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;
    private $username;
    private $password;
    //private $fileToUpload;
    //private $utc_timestamp;
    //private $time_zone_offset;
 
    function __construct($first_name, $last_name, $city_name,$username,$password,$fileToUpload,$utc_timestamp,$time_zone_offset)
    {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->city_name = $city_name;
      $this->username = $username;
      $this->password = $password;
      $this->fileToUpload=$fileToUpload;
      $this->utc_timestamp =$utc_timestamp;
      $this->time_zone_offset = $time_zone_offset;
    }

    public static function create(){
      $instance = new self("","","","","");
      return $instance;
    }

    public function setUsername($username)
    {
      $this->username = $username;
    }
 
    public function getUsername()
    {
      return $this->username;
    }

    public function setPassword($password)
    {
      $this->password = $password;
    }
 
    public function getPassword()
    {
      return $this->password;
    }
 
    public function setUserId($user_id)
    {
      $this->user_id = $user_id;
    }
 
    public function getUserId()
    {
      return $this->user_id;
    }

    public function setFileToUpload($fileToUpload)
    {
      $this->fileToUpload = $fileToUpload;
    }
 
    public function getFileToUpload()
    {
      return $this->fileToUpload;
    }
    public function setUtcTimestamp($utc_timestamp){
      $this->utc_timestamp = $utc_timestamp;
    }
     public function getUtcTimestamp(){
      $this->utc_timestamp = $utc_timestamp;
    }
     public function setTimezoneOffset($time_zone_offset){
      $this->time_zone_offset = $offset;
    }
     public function getTimezoneOffset(){
      $this->time_zone_offset = $offset;
 }
    public function save()
    {
      $con= new DBConnector();
      $fn = $this->first_name;
      $ln = $this->last_name;
      $city = $this->city_name;
      $uname = $this->username;
      $this->hashPassword();
      $pass =$this->password;
      $file=$this->fileToUpload;
      $offset = $this->time_zone_offset;
      $utc_timestamp =$this->utc_timestamp;

      $res = mysqli_query($con->conn,"INSERT INTO usere(first_name, last_name, user_city,username,password,fileToUpload,utctimestamp,timezoneoffset) VALUES('$fn', '$ln', '$city', '$uname', '$pass','$file','utc_timestamp','offset')") or die("Error: ". mysqli_error());
 
      return $res;
      $con->closeDatabase();
    }
 
    public function readAll()
    {
      $con=new DBConnector();
      $query = mysqli_query($con->conn,"SELECT * FROM usere");
         return mysqli_fetch_assoc($query);
    }
    public function readUnique()
    {
      return null;
    }
    public function search()
    {
      return null;
    }
    public function update()
    {
      return null;
    }
    public function removeOne()
    {
      return null;
    }
    public function removeAll()
    {
      return null;
    }


    public function valiteForm(){
      $fn = $this->first_name;
      $ln = $this->last_name;
      $city = $this->city_name;
      if($fn == "" || $ln == "" || $city == ""){
        return false;
      }
      return true;
    }


    public function createFormErrorSessions(){
      session_start();
      $_SESSION['form_errors'] = "All fields are required";
    }


    public function hashPassword(){
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }


    public function isPasswordCorrect(){
            $con = new DBConnector;
            $found = false;
            $res = mysqli_query($con->conn,'SELECT * FROM usere') or die("Error" .mysql_error());
       
       while($row = mysqli_fetch_array($res)){
             if(password_verify($this->getPassword(),$row['password']) && $this->getUsername() == $row['username'])
             {
                 $found = true;
             }
       }
      $con->closeDatabase();
      return $found;
    }


    public function login(){
      if ($this->isPasswordCorrect()) {
        header("Location:private_page.php");
      }
    }


    public function createUserSession($username){
      session_start();
      $_SESSION['username'] = $this->getUsername();
    }


    public function logout(){
      session_start();
      unset($_SESSION['username']);
      session_destroy();
      header("Location:lab1.php");
    }
  }
 
?>