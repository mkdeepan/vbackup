<?php
require 'Slim/Slim.php';
require 'db.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

/********************
# List of REST API method calls

    1 validateUser(id, password-encypted) returns boolean

    2 invalidateUser() returns void

    3 getHandicapCountByType() returns the count

    4 getProfiles(tagId[]) returns list of profile information for those tag ids

    5 getProfileDetails(tagId) returns the list of profile details for that tag id

    6 getProfileHistory(tagId) returns profile history details for that tag id
********************/


$app->get('/validateUser/:id/:password',function($id,$password) {
    $sql = "SELECT * FROM account where accountId=:id and loginPassword=:password";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->bindParam("password", md5($password));
        $res = $stmt->execute();
        $user = $stmt->rowCount(); 
        $dbCon = null;
        if($user){
        echo '{"user": ' . json_encode('true') . '}';
        }else{
        echo '{"user": ' . json_encode('false') . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/getProfiles', 'getprofiles');

function getprofiles() {

    // $sql = "SELECT p.profileFirstName FROM Profile p join ProfileTagMapping m  left join Tag t on m.profileId = p.profileId and t.tagId = m.tagId  group by t.tagId";
     $sql = "SELECT * FROM Profile P JOIN ProfileTagMapping M ON M.profileId = P.profileId WHERE M.tagId IN ('1', '2')";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->execute();
        //$user = $stmt->fetchObject(); 
        $user  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
       
        echo '{"profiles": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

$app->get('/getProfileDetails/:tagid',function($tagid) {
     //$sql = "SELECT p.profileFirstName FROM Profile p join ProfileTagMapping m  left join Tag t on m.profileId = p.profileId and t.tagId = m.tagId  where  t.tagId=:tagid";
   $sql = "SELECT * FROM Profile P JOIN ProfileTagMapping M ON M.profileId = P.profileId WHERE M.tagId = :tagid";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("tagid", $tagid);
        $stmt->execute();
        $user = $stmt->fetchObject(); 
        $dbCon = null;
       
        echo '{"profile": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});
//under work progress
$app->get('/handicap/:id',function($id) {
     $sql = "SELECT * FROM DisabilityType where disabilityTypeId=:id ";
    try {
        $dbCon = getConnection();
        $items = $dbCon->prepare($sql);
        $items->bindParam("id", $id);
        $items->execute();
        $count = $items -> rowCount();
        $dbCon = null;
       
        echo '{"handicaps": ' . json_encode($count) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/getProfileHistory/:id',function($id) {
     $sql = "SELECT * FROM DisabilityType where disabilityTypeId=:id ";
    try {
        $dbCon = getConnection();
        $items = $dbCon->prepare($sql);
        $items->bindParam("id", $id);
        $items->execute();
        $count = $items -> rowCount();
        $dbCon = null;
       
        echo '{"history": ' . json_encode($count) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->run();
?>
