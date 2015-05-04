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
$app->get('/users/:id',function($id) {
    $sql = "SELECT * FROM account";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $user = $stmt->fetchObject(); 
        $dbCon = null;
       
        echo '{"user": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/defaultImage', function () {
    $sql = "SELECT * FROM Image";
    //echo $id.$pwd; exit;
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->execute();
        $img = $stmt -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        echo '{"image": ' . json_encode($img) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/validateUser',function() {

    global $app;
	
	$request = $app->request();
        $body = $request->getBody();
        $input = json_decode($body); 
	//var_dump($input);
	$id = $input->id; 
	$pwd = $input->password; 

    $sql = "SELECT * FROM account where LoginName=:id and loginPassword=:password";
    //echo $id.$pwd; exit;
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->bindParam("password", md5($pwd));
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

$app->post('/getProfiles',function() {
    global $app;
        $request = $app->request();
        $body = $request->getBody();
        $input = json_decode($body); 
	
	$users = $input->ids; 

        if(!empty($users)){
           $sql = "SELECT P.*,M.*, CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds FROM Profile P JOIN ProfileTagMapping M ON M.profileId = P.profileId WHERE M.tagId IN ('".implode("','",$users)."')";
        }else{
           $sql = "SELECT P.*,M.*, CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds FROM Profile P JOIN ProfileTagMapping M ON M.profileId = P.profileId";   
        }

    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->execute();
        //$user = $stmt->fetchObject(); 
        $user  = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($user as $usr){
        	//var_dump($usr); 
        	$usr_id = $usr->tagId;
        	$sql_i = "select  DISTINCT D.disabilityId, D.disabilityName, D.disabilitySeverity, DT.disabilityTypeDescription from DisabilityReactionSymptomsMapping DRM
join ProfileTagMapping PT on PT.profileId = DRM.profileId
join Disability D on D.disabilityId = DRM.disabilityId
join DisabilityType DT on DT.disabilityTypeId = D.disabilityTypeId
where PT.tagId = '".$usr_id."'";


         $dis = $dbCon->prepare($sql_i);
         //$dis->bindParam("id", $usr_id);
         $dis->execute();
         //$disability = '"disability" :'. json_encode($dis -> fetchAll(PDO::FETCH_OBJ));
         $disability = $dis -> fetchAll(PDO::FETCH_OBJ);
         $dis_arr = array('disability'=>$disability);
         //var_dump($dis_arr); exit;
         $merged[] = array_merge((array)$usr,(array)$dis_arr);
         //echo json_encode($merged); exit;
        }
       
        $dbCon = null;
       
        echo '{"profiles": ' . json_encode($merged) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/getProfileDetails',function() {
   
   global $app;
   $request = $app->request();
   $body = $request->getBody();
   $input = json_decode($body);

   $tagid = $input->id; 

   $sql = "SELECT P.*,M.*,CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds FROM Profile P JOIN ProfileTagMapping M ON M.profileId = P.profileId WHERE M.tagId = :tagid";
   $sql2 = "select DISTINCT D.disabilityId, D.disabilityName, D.disabilitySeverity, DT.disabilityTypeDescription from DisabilityReactionSymptomsMapping DRM
join ProfileTagMapping PT on PT.profileId = DRM.profileId
join Disability D on D.disabilityId = DRM.disabilityId
join DisabilityType DT on DT.disabilityTypeId = D.disabilityTypeId
where PT.tagId = :tagid";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("tagid", $tagid);
        $stmt->execute();
        $user = $stmt->fetchObject(); 

        $dis = $dbCon->prepare($sql2);
        $dis->bindParam("tagid", $tagid);
        $dis->execute();
        $disability = $dis -> fetchAll(PDO::FETCH_OBJ);

        $dbCon = null;
       
        echo '{"profiledetail": ' . json_encode($user) . ',"disability": ' . json_encode($disability) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});


$app->get('/allergyCounts',function() {
     $sql = "select count(P.profileId) as profileCount, count(distinct DRM.profileId) as allergyCount from Profile P join ProfileTagMapping PM on PM.profileId=P.profileId join DisabilityReactionSymptomsMapping DRM on PM.profileId = DRM.profileId";
    try {
        $dbCon = getConnection();
        $aller = $dbCon->prepare($sql);
        $aller->execute();
        $allergy = $aller -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
       
        echo '{"allergy": ' . json_encode($allergy) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});


$app->get('/handicaps',function() {
     $sql = "select DT.disabilityTypeDescription,dummy.disabilityId,count(*) as count from (select disabilityReactionSymptomsMapping, disabilityId from DisabilityReactionSymptomsMapping where disabilityId IN (select disabilityId from Disability group by disabilityTypeId ) group by profileId, disabilityId) as dummy join Disability D on D.disabilityId = dummy.disabilityId join DisabilityType DT on DT.disabilityTypeId = D.disabilityTypeId group by dummy.disabilityId";
    try {
        $dbCon = getConnection();
        $items = $dbCon->prepare($sql);
        $items->execute();
        $handicap = $items -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
       
        echo '{"handicaps": ' . json_encode($handicap) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/getProfileHistory',function() {
    
    global $app;
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);

    $id = $input->id; 

    $sql1 = "select P.*,M.*,CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds from Profile P join ProfileTagMapping M on P.profileId = M.profileId where M.tagId = :id";
    $sql2 = "select * from DisabilityReactionSymptoms DR join DisabilityReactionSymptomsMapping DRM on DR.disabilityReactionSymptomsId = DRM.disabilityReactionSymptomsId join ProfileTagMapping PT on PT.profileId = DRM.profileId where PT.tagId = :id";
    $sql3 = "select  DISTINCT D.disabilityId, D.disabilitySeverity, D.disabilityName, DT.disabilityTypeDescription from DisabilityReactionSymptomsMapping DRM
join ProfileTagMapping PT on PT.profileId = DRM.profileId
join Disability D on D.disabilityId = DRM.disabilityId
join DisabilityType DT on DT.disabilityTypeId = D.disabilityTypeId
where PT.tagId = :id";

    try {
        $dbCon = getConnection();
        $prof = $dbCon->prepare($sql1);
        $prof->bindParam("id", $id);
        $prof->execute();
        $profile = $prof -> fetchObject();
       
        $his = $dbCon->prepare($sql2);
        $his->bindParam("id", $id);
        $his->execute();
        $history = $his -> fetchAll(PDO::FETCH_OBJ);

        $dis = $dbCon->prepare($sql3);
        $dis->bindParam("id", $id);
        $dis->execute();
        $disability = $dis -> fetchAll(PDO::FETCH_OBJ);
//var_dump($disability); exit;
        $dbCon = null;
     
        echo '{"profile": ' . json_encode($profile) . ',"history": ' . json_encode($history) . ',"disability": ' . json_encode($disability) . '}'; 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->run();
?>
