<?php

class User {

    private $db_conn;
    private $userId;
    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $password;
    private $token;

    function __construct($db) {
        $this->db_conn = $db;        
    }

    function createUser($firstName, $lastName, $email, $username, $password) {
        
        if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($username) && !empty($password)) {
            
            $sql ="SELECT ID FROM users WHERE Email=:email_IN OR Username=:username_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":email_IN", $email);
            $stm->bindParam(":username_IN",$username);

            if(!$stm->execute()) {
                $error = new stdClass();
                $error->message = "Could not execute query";
                $error->code = "0001";
                print_r(json_encode($error));
                die();
            }
            
            $row =  $stm->rowCount();
            if($row > 0) {
                
                $error = new stdClass();
                $error->message = "This user is already registered";
                $error->code = "0002";
                print_r(json_encode($error));
                die();
            }

            $sql = "INSERT INTO users (FirstName, LastName, Email, Username, Password, Role) VALUES(:firstName_IN, :lastName_IN, :email_IN, :username_IN, :password_IN, 'user')";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":firstName_IN", $firstName);
            $stm->bindParam(":lastName_IN", $lastName);
            $stm->bindParam(":email_IN", $email);
            $stm->bindParam(":username_IN", $username);
            $stm->bindParam(":password_IN", $password);

            if(!$stm->execute()) {
                $error = new stdClass();
                $error->message = "Could not execute query";
                $error->code = "0001";
                print_r(json_encode($error));
                die();
            }

            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password; 

            echo "First Name:$this->firstName Last Name:$this->lastName Email:$this->email Username: $this->username Password:$this->password";
            die();

        } else {
            $error = new stdClass();
            $error->message = "All arguments need a value";
            $error->code = "0003";
            print_r(json_encode($error));
            die();
        }
 
    }

    function login($username, $password) {
        $sql = "SELECT ID, FirstName, LastName, Email, Username, Password, Role FROM users WHERE Username=:username_IN AND Password=:password_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":password_IN",$password);
        $stm->bindParam(":username_IN",$username);

        $stm->execute();       

        if($stm->rowCount() == 1) {
            $row = $stm->fetch();
             return $this->createToken($row["ID"], $row["Username"]);
             return $this->checkRole


        }
    }

    function createToken($userId, $username) {

        $checkedToken = $this->checkToken($userId);
        
        if($checkedToken != false) {
            return $checkedToken;
        }

        $token = md5(time() . $userId . $username);
        
        $sql = "INSERT INTO sessions (UserId, Token, LastUsed) VALUES(:userId_IN, :token_IN, :lastUsed_IN)";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":userId_IN",$userId);
        $stm->bindParam(":token_IN",$token);
        $time = time();
        $stm->bindParam(":lastUsed_IN", $time);

        $stm->execute();

        return $token;

    }

    function checkToken($userId) {
        $sql = "SELECT Token, LastUsed FROM sessions WHERE UserId =:userId_IN AND LastUsed > :activeTime_IN LIMIT 1";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":userId_IN", $userId);
        $activeTime = time() - (60 * 60);
        $stm->bindParam(":activeTime_IN",$activeTime);

        $stm->execute();

        $return = $stm->fetch();       
        
        if(isset($return["Token"])) {
            return $return["Token"];
        } else {
            return false;
        }
        
    }

    function validateToken($token)  {
        $sql = "SELECT Token, LastUsed FROM sessions WHERE Token =:token_IN AND LastUsed > :activeTime_IN LIMIT 1";
        $stm  = $this->db_conn->prepare($sql);
        $stm->bindParam(":token_IN", $token);
        $activeTime = time() - (60 * 60);
        $stm->bindParam(":activeTime_IN",$activeTime);

        $stm->execute();

        $return = $stm->fetch();       
        
        if(isset($return["Token"])) {

            $this->updateToken($return["Token"]);
           
            return true;
        } else {
            return false;
        }
        
    }

    function updateToken($token) {
        $sql = "UPDATE sessions SET LastUsed=:lastUsed_IN WHERE Token=:token_IN";
        $stm = $this->db_conn->prepare($sql);
        $time = time();
        $stm->bindParam(":lastUsed_IN", $time); 
        $stm->bindParam(":token_IN", $token);
        $stm->execute(); 
    }

    function checkRole($id) {
        $sql = "SELECT Role FROM users WHERE ID=:id_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":id_IN", $id);
        $stm->execute();
        
        $return = $stm->fetch();

        if(isset($return["Role"])) {
            return $return["Role"];
        } else {
            return false;
        }
    }

    function validateRole($role) {
        $sql = "SELECT Role FROM users WHERE Role=:role_IN";
        $stm = $this-du_conn->prepare($sql);
        $stm->bindParam(":role_IN", $role);
        $stm->execute();

        $return = $stm->fetch();

        if(isset($return["Role"])) {
            $return["Role"] == 
        } else {
            return false
        }
    }

}

?>