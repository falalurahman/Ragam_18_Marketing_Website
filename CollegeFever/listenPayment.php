<?php
    include "connectDatabase.php";
    header("Content-Type: application/json; charset=UTF-8");
    $res = json_decode(file_get_contents('php://input'));
    	$attendingevents = $res->attendingEvents[0];
        $programName = $attendingevents->subProgramName;
        $amountPaid = $attendingevents->fare;
        $participantMail = $attendingevents->attendees[0]->email;
        $mainregistration = 0;
        $hospitalityregistration = 0;
        $workshopregistration = 0;
        $workshopid = "";
        $proshowregistration = 0;
        $proshowid = "";
        $tshrt = 0;
	$merchandiseid = "";
	//echo $programName;
        switch ($programName){
            case "Main Event Registration" :
            	$mainregistration = 1;
 		break;
            case "Hospitality Registration": 
            	$hospitalityregistration = 1;	
            	break;
            case "Logophilia Vocabulary Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID01";
                break;
            case "Photography Workshop":
            	$workshopregistraion = 1;
                $workshopid = "WID02";
                break;
            case "Hip Hop International Dance Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID03";
                break;
            case "Social Entrepreneurship Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID04";
                break;
            case "Ethical Hacking Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID05";
                break;;
            case "Robotics And IoT Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID06";
                break;
            case "Film Workshop": 
            	$workshopregistraion = 1;
                $workshopid = "WID07";
                break;
            case "Proshow Day 1": 
            	$proshowregistration = 1;
                $proshowid = "PID01";
                break;
       	   case "Proshow Day 2": 
            	$proshowregistration = 1;
                $proshowid = "PID02";
                break;
           case "Proshow Day 3": 
            	$proshowregistration = 1;
                $proshowid = "PID03";
                break;
           case "Nites Combo": 
            	$proshowregistraion = 1;
                $proshowid = "PID04";
                break;
           case "Compete.Sleep.Rave.Repeat Combo":
           	$mainregistration = 1;
           	$hospitalityregistration = 1;
           	$tshirt = 1;
           	$merchandiseid = "MID01";
           	$proshowregistration = 1;
           	$proshowid = "PID04";
           	break;
           case "Vest and Nest Combo":
           	$mainregistration = 1;
           	$hospitalityregistration = 1;
           	$tshirt = 1;
           	$merchandiseid = "MID01";
           	break;
           	
        }
        $stmt = $connection->prepare("UPDATE `Participants` SET `AmountPaid` = `AmountPaid` + ? WHERE `Email` LIKE ?");
            $stmt->bind_param("is",$amountPaid,$participantMail);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();

        if($mainregistration == 1){
            $stmt = $connection->prepare("UPDATE `Participants` SET `MainRegistration` = 1 WHERE `Email` LIKE ?");
            $stmt->bind_param("s",$participantMai);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();
        }
        if($hospitalityregistration == 1){
            $stmt = $connection->prepare("UPDATE `Participants` SET `HospitalityRegistration` = 1 WHERE `Email` LIKE ?");
            $stmt->bind_param("s",$participantMail);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();
        }
        if($workshopregistration == 1){
            $stmt = $connection->prepare("SELECT `RagamID` FROM `Participants` WHERE `Email` LIKE ?");
            $stmt->bind_param("s" , $participantMail);
            $stmt->execute();
            $stmt->bind_result($ragamID);

            $stmt->fetch();
            $stmt->close();
            $stmt = $connection->prepare("INSERT INTO `WorkshopRegistration`(`WorkshopID`, `ParticipantID`, `Participating`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$workshopid,$ragamID);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();
        }
        if($proshowregistration == 1){
            $stmt = $connection->prepare("SELECT `RagamID` FROM `Participants` WHERE `Email` LIKE ?");
            $stmt->bind_param("s" , $participantMail);
            $stmt->execute();
            $stmt->bind_result($ragamID);

            $stmt->fetch();
            $stmt->close();
            $stmt = $connection->prepare("INSERT INTO `ProshowRegistration`(`ProshowID`, `ParticipantID`, `ProshowGiven`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$proshowid,$ragamID);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();
        }
        if($tshirt == 1){
            $stmt = $connection->prepare("SELECT `RagamID` FROM `Participants` WHERE `Email` LIKE ?");
            $stmt->bind_param("s" , $participantMail);
            $stmt->execute();
            $stmt->bind_result($ragamID);

            $stmt->fetch();
            $stmt->close();
            $stmt = $connection->prepare("INSERT INTO `MerchandiseRegistration`(`MerchandiseID`, `ParticipantID`, `MerchandiseGiven`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$merchandiseid,$ragamID);
            $stmt->execute();

            if($stmt->affected_rows == 1){
                //echo "SUCCESS";
            }
            else{
                //echo "FAILURE";
            }
            $stmt->close();
    	}

    $connection->close();
   ?>