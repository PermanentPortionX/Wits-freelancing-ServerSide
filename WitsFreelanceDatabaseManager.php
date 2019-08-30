<?php
header('Access-Control-Allow-Origin: *');
require_once("Constants.php");
require_once("ServerInfo.php");

class WitsFreelanceDatabaseManager {
    private $pdo;

    function __construct() {
        $dsn = "mysql:host=".ServerInfo::SERVER_PROXY.";dbname=".ServerInfo::DATABASE.";charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this -> pdo = new PDO($dsn, ServerInfo::USER_NAME, ServerInfo::USER_PASS, $options);
        }
        catch (PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function __destruct(){
        $this -> pdo = null;
    }

    function execute($stmt, $args, $provideFeedback){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);
            $execStmt -> execute($args);
            if ($provideFeedback) echo ($execStmt) ? Constants::SUCCESS : Constants::FAILED;
            if ($execStmt) return $this -> pdo -> lastInsertId();
        }
        catch (PDOException $e){
            echo $e -> getMessage();
        }
        return -1;
    }

    function fetch($stmt, $args){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);
            echo json_encode(($execStmt -> execute($args)) ? $execStmt -> fetchAll(): Constants::DEFAULT_JSON_ARRAY);
        }
        catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /*function fetchAllActvities($stmt, $args, $userId){
	try{
	    $execStmt = $this -> pdo -> prepare($stmt, $args);
	    if($execStmt -> execute($args)){
		$output = array();
		while($row = $execStmt -> fetch(PDO::FETCH_ASSOC)){
			$activity_id = $row["activity_id"];
			$numLikesStmt = "SELECT COUNT(*) AS num_likes FROM STUD_LIKE_DISLIKE WHERE activity_id = :AI AND stud_like_dislike = 0";
			$numDislikesStmt = "SELECT COUNT(*) AS num_dislikes FROM STUD_LIKE_DISLIKE WHERE activity_id = :AI AND stud_like_dislike = 1";
			$numCommentsStmt = "SELECT COUNT(*) AS num_comments FROM STUD_COMMENT WHERE activity_id = :AI";
			$likeStatusStmt = "SELECT * FROM STUD_LIKE_DISLIKE WHERE activity_id = :AI AND student_id = :UI AND stud_like_dislike = 0";
			$dislikeStatusStmt = "SELECT * FROM STUD_LIKE_DISLIKE WHERE activity_id = :AI AND student_id = :UI AND stud_like_dislike = 1";

			$args = array(":AI" => $activity_id);
			$sttsArgs = array(":AI" => $activity_id, ":UI" => $userId);

			$execLikeStmt = $this -> pdo -> prepare($numLikesStmt);
			$execDisLikeStmt = $this -> pdo -> prepare($numDislikesStmt);
			$execCommentsStmt = $this -> pdo -> prepare($numCommentsStmt);

			if($execLikeStmt -> execute($args)) $row["num_likes"] = $execLikeStmt -> fetch(PDO::FETCH_ASSOC)["num_likes"];
			if($execDisLikeStmt -> execute($args)) $row["num_dislikes"] = $execDisLikeStmt -> fetch(PDO::FETCH_ASSOC)["num_dislikes"];
			if($execCommentsStmt -> execute($args)) $row["num_comments"] = $execCommentsStmt -> fetch(PDO::FETCH_ASSOC)["num_comments"];
			
			$row["like_status"] = -1;
			if($this -> exists($likeStatusStmt, $sttsArgs)) $row["like_status"] = 0;
			if($this -> exists($dislikeStatusStmt, $sttsArgs)) $row["like_status"] = 1; 

			$output[] = $row;
		}
		usort($output, function($a, $b){return $a["num_likes"] < $b["num_likes"];});
		echo json_encode($output);
	    }
	    else echo Constants::DEFAULT_JSON;
	}
        catch(PDOException $e){
		echo Constants::DEFAULT_JSON;
	}
    }

    function executeFetchPollStatement($stmt, $args){
	try{
	    $execStmt = $this -> pdo -> prepare($stmt);
	    
            if($execStmt -> execute($args)){
		$results = array();
		while($row = $execStmt -> fetch(PDO::FETCH_ASSOC)){
		  $poll_id = $row["poll_id"];
		  $choices = $row["poll_choices"];
		  $choice = explode("~", $choices);
   		  
		  $countVotesStmt = "SELECT COUNT(*) AS votes FROM ".Constants::POLL_VOTE_TABLE." WHERE ".Constants::POLL_ID." = :PI";
		  $countVoteArgs = array(":PI" => $poll_id);
		  $execCountVote = $this -> pdo -> prepare($countVotesStmt);

		  if($execCountVote -> execute($countVoteArgs)){
			$row["num_votes"] = $execCountVote -> fetch(PDO::FETCH_ASSOC)["votes"];
		  }

		  $choicesWithResults = "";
		  foreach($choice as $c){
   		  $choiceCountStmt = "SELECT COUNT(*) AS ".$c." FROM ".Constants::POLL_VOTE_TABLE." WHERE ".Constants::POLL_ID." = :PI AND ".Constants::POLL_SEL_CHOICE." LIKE :SC";
		    $choicesArgs = array(":PI" => $poll_id, ":SC" => "%".$c."%");
		    $execChoiceCountStmt = $this -> pdo -> prepare($choiceCountStmt);
		    if($execChoiceCountStmt -> execute($choicesArgs)){
			$count = $execChoiceCountStmt -> fetch(PDO::FETCH_ASSOC)[$c];
			$choicesWithResults .= $c.": ".$count."~";
		    }
		  }
		  $row["poll_choices"] = substr($choicesWithResults, 0, -1);
		  $results[] = $row;
		}

		usort($results, function($a, $b){return $a["num_votes"] < $b["num_votes"];});
		echo json_encode($results);
	    }
	}
	catch(PDOException $e){
		echo $e -> getMessage();
		echo Constants::DEFAULT_JSON;
	}
    }

    function executeStatement($stmt, $args, $provideFeedBack){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);

            if($execStmt -> execute($args)){
                if ($provideFeedBack) return true;
                else echo Constants::SUCCESS;
            }
            else {
                if ($provideFeedBack) return false;
                else echo Constants::FAILED;
            }
        }
        catch(PDOException $e){
            echo $e -> getMessage();
        }
    }*/

    function exists($stmt, $args){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);
            if($execStmt -> execute($args)) return $execStmt -> rowCount() > 0;
            else return false;
        }
        catch(PDOException $e){
            echo $e -> getMessage();
            return false;
        }

    }
}
