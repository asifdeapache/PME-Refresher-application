<!DOCTYPE html>

<!-- initial PHP code to check logged in user in session -->
<?php
        include_once 'php/connection.php';
		session_start();
		if (isset ($_SESSION["loggedUser"]) && isset(($_SESSION["loggedPassword"]))) {
            /*User already logged into System*/
            try {
                $database = new Connection();
                $db = $database->openConnection();
                                
                $sql = "SELECT * FROM pmerefmaster ";

                $whereSQL = "";
                $whereFlag = false;
                if (isset($_POST["filterSearchMonth"]) && ($_POST["filterSearchMonth"] != "None")) {
                    //year also can be None, check in JS, both checkbox cannot be deselected if None
                    
                    $numericMonth = 01;
                    switch($_POST["filterSearchMonth"]) {
                        case "January":
                            $numericMonth = 1;
                            break;
                        case "February":
                            $numericMonth = 2;
                            break;
                        case "March":
                            $numericMonth = 3;
                            break;
                        case "April":
                            $numericMonth = 4;
                            break;
                        case "May":
                            $numericMonth = 5;
                            break;
                        case "June":
                            $numericMonth = 6;
                            break;
                        case "July":
                            $numericMonth = 7;
                            break;
                        case "August":
                            $numericMonth = 8;
                            break;
                        case "September":
                            $numericMonth = 9;
                            break;
                        case "October":
                            $numericMonth = 10;
                            break;
                        case "November":
                            $numericMonth = 11;
                            break;    
                        case "December":
                            $numericMonth = 12;
                            break;         
                    }
                    
                    if (isset($_POST["checkREF"]) && isset($_POST["checkPME"]) ) {
                        $whereSQL = $whereSQL." ( MONTH(EMP_PME_NEXT)=".$numericMonth." OR MONTH(EMP_REF_NEXT)=".$numericMonth
                        ." ) ";    
                        $whereFlag = true;
                    }
                    elseif(isset($_POST["checkREF"])) {
                        $whereSQL = $whereSQL." MONTH(EMP_REF_NEXT)=".$numericMonth;
                        $whereFlag = true;
                    }
                    elseif(isset($_POST["checkPME"])) {
                        $whereSQL = $whereSQL." MONTH(EMP_PME_NEXT)=".$numericMonth;
                        $whereFlag = true;
                    }
                }

                //check fileter by Year function
                if (isset($_POST["filterSearchYear"]) && ($_POST["filterSearchYear"] != "None")) {
                    //year also can be None, check in JS, both checkbox cannot be deselected if None
                                        
                    if (isset($_POST["checkREF"]) && isset($_POST["checkPME"]) ) {
                        if ($whereFlag) {
                            $whereSQL = $whereSQL." AND ( YEAR(EMP_PME_NEXT)=".$_POST["filterSearchYear"]." OR YEAR(EMP_REF_NEXT)=".$_POST["filterSearchYear"]." )";
                        }
                        else {
                            $whereSQL = $whereSQL." ( YEAR(EMP_PME_NEXT)=".$_POST["filterSearchYear"]." OR YEAR(EMP_REF_NEXT)=".$_POST["filterSearchYear"]." )";
                            $whereFlag = true;
                        }   
                    }
                    elseif(isset($_POST["checkREF"])) {
                        if ($whereFlag) {
                            $whereSQL = $whereSQL." AND YEAR(EMP_REF_NEXT)=".$_POST["filterSearchYear"];
                        }
                        else {
                            $whereSQL = $whereSQL." YEAR(EMP_REF_NEXT)=".$_POST["filterSearchYear"];
                            $whereFlag = true;
                        }
                    }
                    elseif(isset($_POST["checkPME"])) {
                        if ($whereFlag) {
                            $whereSQL = $whereSQL." AND YEAR(EMP_PME_NEXT)=".$_POST["filterSearchYear"];
                        }
                        else {
                            $whereSQL = $whereSQL." YEAR(EMP_PME_NEXT)=".$_POST["filterSearchYear"];
                            $whereFlag = true;
                        }
                    }
                }

                //check for TI Unit
                $unitTIChosen = false;
                $unitTISQL = "";
                
             
                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                    if (isset($_POST["checkREFTIBTI"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-BT-I'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-BT-I'";
                            $unitTIChosen = true;       
                        }                    
                    }
                    
                    if (isset($_POST["checkREFTIBTII"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-BT-II'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-BT-II'";
                            $unitTIChosen = true;       
                        }                    
                    }
                    
                    if (isset($_POST["checkREFTISPRI"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-SPR-I'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-SPR-I'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if (isset($_POST["checkREFTISPRII"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-SPR-II'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-SPR-II'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if (isset($_POST["checkREFTISDAH"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-SDAH'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-SDAH'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if (isset($_POST["checkREFTIRHA"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-RHA'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-RHA'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if (isset($_POST["checkREFTIKNJ"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-KNJ'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-KNJ'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if (isset($_POST["checkREFTIGEDE"])) {
                        if ($unitTIChosen == true) {
                            $unitTISQL=$unitTISQL.",'TI-M-GEDE'";    
                        }
                        else {
                            $unitTISQL=$unitTISQL."'TI-M-GEDE'";
                            $unitTIChosen = true;       
                        }                    
                    }

                    if ($unitTIChosen == true) {
                        if ($whereFlag == true) {
                            $unitTISQL = " AND EMP_TI_UNIT IN(".$unitTISQL;
                        }
                        else {
                            $unitTISQL = " EMP_TI_UNIT IN(".$unitTISQL;
                            $whereFlag = true;
                        }
                        $unitTISQL=$unitTISQL.")";
                    }
                }
                elseif ($_SESSION["sessionAdmin"] == "TI-USER") {
                    if ($whereFlag) 
                        $unitTISQL = " AND EMP_TI_UNIT = \"".$_SESSION["loggedUser"]."\"";
                    else {
                        $unitTISQL = " EMP_TI_UNIT = \"".$_SESSION["loggedUser"]."\"";
                        $whereFlag = true;
                    }
                }
                else {
                    if ($whereFlag) 
                        $unitTISQL = " AND EMP_STN = \"".$_SESSION["sessionAdmin"]."\"";
                    else {
                        $unitTISQL = " EMP_STN = \"".$_SESSION["sessionAdmin"]."\"";
                        $whereFlag = true;
                    }                    
                }          

                // code for Name and Station code filter
                
                $filterByNameStnSQL = "";
                

                if((isset($_POST["filterName"]) && $_POST["filterName"] != "") && 
                    (isset($_POST["filterStnName"]) && $_POST["filterStnName"] != "")) {
                    if ($whereFlag == true) {
                        $filterByNameStnSQL = " AND ( UPPER(EMP_NAME) LIKE'%";
                    }
                    else {
                        $filterByNameStnSQL = " ( UPPER(EMP_NAME) LIKE'%";
                        $whereFlag = true;
                    }
                    $filterByNameStnSQL = $filterByNameStnSQL.strtoupper($_POST["filterName"]).
                            "%' AND UPPER(EMP_STN) LIKE'%".strtoupper($_POST["filterStnName"])."%' )";
                }
                elseif(isset($_POST["filterName"]) && $_POST["filterName"] != "") {
                    if ($whereFlag == true) {
                        $filterByNameStnSQL = " AND ( UPPER(EMP_NAME) LIKE'%";
                    }
                    else {
                        $filterByNameStnSQL = " ( UPPER(EMP_NAME) LIKE'%";
                        $whereFlag = true;
                    }
                    $filterByNameStnSQL = $filterByNameStnSQL.strtoupper($_POST["filterName"])."%' )";
                }
                elseif(isset($_POST["filterStnName"]) && $_POST["filterStnName"] != "") {
                    if ($whereFlag == true) {
                        $filterByNameStnSQL = " AND ( UPPER(EMP_STN) LIKE'%";
                    }
                    else {
                        $filterByNameStnSQL = " ( UPPER(EMP_STN) LIKE'%";
                        $whereFlag = true;
                    }
                    $filterByNameStnSQL = $filterByNameStnSQL.strtoupper($_POST["filterStnName"])."%' )";
                }

                if ($whereFlag) {
                    $sql = $sql."WHERE ".$whereSQL.$unitTISQL.$filterByNameStnSQL;
                    $sqlCountByDesignation = "SELECT COUNT(*) AS COUNT_DESIG,EMP_DESIG FROM pmerefmaster WHERE ".$whereSQL.$unitTISQL.$filterByNameStnSQL." GROUP BY EMP_DESIG";
                }
                else {
                    // another SQL to count
                    $sqlCountByDesignation = "SELECT COUNT(*) AS COUNT_DESIG,EMP_DESIG FROM pmerefmaster ".$whereSQL.$unitTISQL.$filterByNameStnSQL." GROUP BY EMP_DESIG";
                }

                $totalStaffCount = 0;
                $smCount = 0;
                $pointsmanCount = 0;
                $cabinMasterCount = 0;
                $porterCount = 0;
                $shuntmanCount = 0;
                $gatemanCount = 0;
                $cabinmanCount = 0;
                $ssCount = 0;
                $stgMasterCount = 0;

                foreach ($db->query($sqlCountByDesignation) as $rowCountByDesig) {

                         switch($rowCountByDesig["EMP_DESIG"]) {
                            case "SM":
                                $smCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Pointsman":
                                $pointsmanCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Cabin Master":
                                $cabinMasterCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Porter":
                                $porterCount = $rowCountByDesig["COUNT_DESIG"];                            
                                break;
                            case "Shuntman":
                                $shuntmanCount = $rowCountByDesig["COUNT_DESIG"];        
                                break;
                            case "Gateman":
                                $gatemanCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "Cabinman":
                                $cabinmanCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "Stg. Master":
                                $stgMasterCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "SS":
                                $ssCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                        }
                        $totalStaffCount = $totalStaffCount + $rowCountByDesig["COUNT_DESIG"];
                    }                                
            }
            catch (PDOException $e)
            {
                echo "There is some problem in connection: " . $e->getMessage();
            }
            
		}
        else {
            $_SESSION["loggedUser"] = $_POST["user"];
            $_SESSION["loggedPassword"] = $_POST["pass"];
            $_SESSION["sessionContinueFlag"] = $_POST["check"];

            try {
                $database = new Connection();
                $db = $database->openConnection();
                /*$sql = "SELECT * FROM pmerefusers WHERE USER_NAME = '" + $_SESSION["loggedUser"] + "' AND USER_PWD = '" + $_SESSION["loggedPassword"] + "'";*/
                $sql = "SELECT USER_ADMIN FROM pmerefusers WHERE user_name = \"" . $_SESSION["loggedUser"] . "\" AND user_pwd = \"". $_SESSION["loggedPassword"] . "\"";
                
                $userAdmin = $db->query($sql)->fetchColumn();
                 
                $sqlAddendum = "";
                 
                if ($userAdmin != null ) {
                    if ($userAdmin == "GLOBAL"){
                        
                    }
                    elseif ($userAdmin == "TI-USER") 
                        $sqlAddendum = " WHERE EMP_TI_UNIT = \"".$_SESSION["loggedUser"]."\"";
                    else
                        $sqlAddendum = " WHERE EMP_STN = \"".$userAdmin."\"";

                    $_SESSION["sessionAdmin"] = $userAdmin;
                }
                else {
                    $_SESSION["errorMessage"] = "Username and/or password is incorrect";
                    header("Location: index.php");
                }
            
                $sql = "SELECT * FROM pmerefmaster ".$sqlAddendum;
                
                $sqlCountByDesignation = "SELECT COUNT(*) AS COUNT_DESIG,EMP_DESIG FROM pmerefmaster ".$sqlAddendum." GROUP BY EMP_DESIG";
                
                $totalStaffCount = 0;
                $smCount = 0;
                $pointsmanCount = 0;
                $cabinMasterCount = 0;
                $porterCount = 0;
                $shuntmanCount = 0;
                $gatemanCount = 0;  
                $cabinmanCount = 0;
                $ssCount = 0;
                $stgMasterCount = 0;

                foreach ($db->query($sqlCountByDesignation) as $rowCountByDesig) {

                        switch($rowCountByDesig["EMP_DESIG"]) {
                            case "SM":
                                $smCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Pointsman":
                                $pointsmanCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Cabin Master":
                                $cabinMasterCount = $rowCountByDesig["COUNT_DESIG"];
                                break;
                            case "Porter":
                                $porterCount = $rowCountByDesig["COUNT_DESIG"];                            
                                break;
                            case "Shuntman":
                                $shuntmanCount = $rowCountByDesig["COUNT_DESIG"];        
                                break;
                            case "Gateman":
                                $gatemanCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "Cabinman":
                                $cabinmanCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "Stg. Master":
                                $stgMasterCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                            case "SS":
                                $ssCount = $rowCountByDesig["COUNT_DESIG"]; 
                                break;
                        }
                        $totalStaffCount = $totalStaffCount + $rowCountByDesig["COUNT_DESIG"];
                }       
                
            }
            catch (PDOException $e)
            {
                echo "There is some problem in connection: " . $e->getMessage();
            }
		}

?>

<html lang="en">
<head>
	<title>PME & Refresher Tracking Application, Eastern Railway, Sealdah Division</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-width, initial-scale=1.0">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/Login.css">
<!--========================================= Asif Hossain ========================================-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda">
<!--===============================================================================================-->

<!-- jQuery scripts & funtions follows-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    
    //Begin : code section to Create Filter by Month dropdown and select current month if not selected
    const monthNames = [ "January", "February", "March", 
         "April", "May", "June", "July", "August", 
         "September", "October", "November", "December"];

    const currentDate = new Date();
    var counterMonth = 0;
    var monthName = "";
    var optionHtml = "<option class=\"input-option\" >None</option>";
    var currMonthNum = currentDate.getMonth();
    var postMonth = "<?php echo isset($_POST['filterSearchMonth'])?$_POST['filterSearchMonth']:''; ?>";
    for (monthName in monthNames) {
        if (postMonth == monthNames[monthName] )
            optionHtml = optionHtml + 
            "<option class=\"input-option\" selected>" + monthNames[monthName] + "</option>";
        else if ( postMonth == "" && (counterMonth == currMonthNum) )
            optionHtml = optionHtml + 
            "<option class=\"input-option\" selected>" + monthNames[monthName] + "</option>";
        else
            optionHtml = optionHtml + 
            "<option class=\"input-option\" >" + monthNames[monthName] + "</option>";

        counterMonth++;
    }
    
    $("#idFilterMonth").html(optionHtml);

    //End : code section to Create Filter by Month dropdown and select current month if not selected

    //Begin : code section to Create Filter by year dropdown and select current yesr if not selected
    var optionHtml = "<option class=\"input-option\" >None</option>";
    var currYear = currentDate.getFullYear();
    var maxYearLimit = currYear + 20;
    var minYearLimit = currYear - 20;
    var postYear = "<?php echo isset($_POST['filterSearchYear'])?$_POST['filterSearchYear']:''; ?>";
    var yearCounter;
    for (yearCounter = maxYearLimit; yearCounter > minYearLimit;  yearCounter--) {
        if (postYear == yearCounter )
            optionHtml = optionHtml + 
            "<option class=\"input-option\" selected>" + yearCounter + "</option>";
        else if ( postYear == "" && (yearCounter == currYear) )
            optionHtml = optionHtml + 
            "<option class=\"input-option\" selected>" + yearCounter + "</option>";
        else
            optionHtml = optionHtml + 
            "<option class=\"input-option\" >" + yearCounter + "</option>";

    }
    $("#idFilterYear").html(optionHtml);
    //End : code section to Create Filter by year dropdown and select current yesr if not selected  

    //Begin : code section to update database goes here

    function updateDatabaseFunc(e) {
    
        var btnID = e.target.id.substr(6);
        var sessionAdmin = "<?php echo $_SESSION["sessionAdmin"]; ?>";
        if ($("#btnupd" + btnID).val() == "Edit") {

            //if TI user then TI UNIT is fixed TODO
            var selectTIUnit = "";
            if (sessionAdmin == "GLOBAL")
                selectTIUnit = $("#list-emp-ti-unit" + btnID).text();

            var selectTIUnitHtml = "<select name=\"updEmpTIUnit" + btnID + "\" id=\"updEmpTIUnit" + btnID + "\" class=\"dynamicUpdateFields\" >" +
                                    "<option " + ((selectTIUnit == "TI-M-BT-I") ? "selected":"") + ">TI-M-BT-I</option>" +
                                    "<option " + ((selectTIUnit == "TI-M-BT-II")?"selected":"") + ">TI-M-BT-II</option>" +
                                    "<option " + ((selectTIUnit == "TI-M-SPR-I")?"selected":"") + ">TI-M-SPR-I</option>" +
                                    "<option " + ((selectTIUnit == "TI-M-SPR-II")?"selected":"") + ">TI-M-SPR-II</option>" +
                                    "<option " + ((selectTIUnit == "TI-M-SDAH")?"selected":"") + ">TI-M-SDAH </option>" +
                                    "<option " + ((selectTIUnit == "TI-M-RHA")?"selected":"") + ">TI-M-RHA </option>" +
                                    "<option " + ((selectTIUnit == "TI-M-KNJ")?"selected":"") + ">TI-M-KNJ </option>" +
                                    "<option " + ((selectTIUnit == "TI-M-GEDE")?"selected":"") + ">TI-M-GEDE </option>" +
                                "</select>";

            var selectDesig = "<select name=\"updEmpDesig" + btnID + "\" id=\"updEmpDesig" + btnID + "\" class=\"dynamicUpdateFields\" >" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "SS") ? "selected" : "") + ">SS</option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "SM")?"selected":"") + ">SM</option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Porter")?"selected":"") + ">Porter</option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Cabin Master")?"selected":"") + ">Cabin Master</option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Shuntman")?"selected":"") + ">Shuntman </option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Gateman")?"selected":"") + ">Gateman </option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Cabinman")?"selected":"") + ">Cabinman </option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Stg. Master")?"selected":"") + ">Stg. Master </option>" +
                                    "<option " + (($("#list-emp-desig" + btnID).text() == "Pointsman")?"selected":"") + ">Pointsman </option>" +
                                "</select>";

            
            
            $("#list-emp-name" + btnID).html("<input type=\"text\" class=\"dynamicUpdateFields\" id=\"updEmpName" + btnID + "\" value=\"" +
            $("#list-emp-name" + btnID).text() +"\" required>");

            if (sessionAdmin == "GLOBAL")
                $("#list-emp-ti-unit" + btnID).html(selectTIUnitHtml);

            $("#list-emp-stn" + btnID).html("<input type=\"text\" class=\"dynamicUpdateFields\" style=\"text-transform:uppercase;\" id=\"updEmpSTN" + btnID + "\" value=\"" +
            $("#list-emp-stn" + btnID).text() +"\">");

            $("#list-emp-desig" + btnID).html(selectDesig);

            var dateSplits = $("#list-emp-dob" + btnID).text().split("/");
            var dateYYYYMMDD = dateSplits[2] + "-" + dateSplits[1] + "-" + dateSplits[0];

            $("#list-emp-dob" + btnID).html("<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpDoB" + btnID + "\" value=\"" +
            dateYYYYMMDD +"\" required>");

            dateSplits = $("#list-emp-pme-prv" + btnID).text().split("/");
            dateYYYYMMDD = dateSplits[2] + "-" + dateSplits[1] + "-" + dateSplits[0];

            $("#list-emp-pme-prv" + btnID).html("<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpPMEPrev" + btnID + "\" value=\"" +
            dateYYYYMMDD +"\" required>");

            dateSplits = $("#list-emp-ref-prv" + btnID).text().split("/");
            dateYYYYMMDD = dateSplits[2] + "-" + dateSplits[1] + "-" + dateSplits[0];

            $("#list-emp-ref-prv" + btnID).html("<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpREFPrev" + btnID + "\" value=\"" +
            dateYYYYMMDD +"\">");
            

            $("#updEmpName" + btnID).focus();

            $("#btnupd" + btnID).val("Update");
        } 
        else {
            //code to update into database goes here
            //filed validation needs to be done here
            var validValues = true;
            //validate fields before sending to DB
            if ($("#updEmpName" + btnID).val().trim() == "") {
                alert("Please enter a valid name");
                validValues = false;
                return false;
            }
            if ($("#updEmpSTN" + btnID).val().trim() == "") {
                alert("Please enter valid station code");
                validValues = false;
                return false;
            }
            if ($("#updEmpDoB" + btnID).val().trim() == "") {
                alert("Please enter valid date of birth");
                validValues = false;
                return false;
            }
            if ($("#updEmpPMEPrev" + btnID).val().trim() == "") {
                alert("Please enter valid previous PME date");
                validValues = false;
                return false;
            }
            if ($("#updEmpREFPrev" + btnID).val().trim() == "") {
                alert("Please enter valid previous Refresher date");
                validValues = false;
                return false;
            }
            
            if (sessionAdmin == "TI-USER")
                tiUnit = "<?php echo $_SESSION["loggedUser"]; ?>";
            else
                tiUnit = $("#updEmpTIUnit" + btnID).val();

            var http = new XMLHttpRequest();
            var url = "php/update.php";
            var params = "updEmpID=" + btnID + "&updEmpName=" + $("#updEmpName" + btnID).val() + "&updEmpTIUnit=" + tiUnit +
                        "&updEmpSTN=" + $("#updEmpSTN" + btnID).val() + "&updEmpDesig=" + $("#updEmpDesig" + btnID).val() +
                        "&updEmpDoB=" + $("#updEmpDoB" + btnID).val() + "&updEmpPMEPrev=" + $("#updEmpPMEPrev" + btnID).val() +
                        "&updEmpREFPrev=" + $("#updEmpREFPrev" + btnID).val() + "&updListRowID=" + $("#listEmpRow" + btnID).text() ;

            http.open('POST', url, true);        

            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    //sets row data to updated values in situ
                    
                    $("#listEmp" + btnID).html(http.responseText);
                    $("#btnupd" + btnID).on("click",updateDatabaseFunc);
                    $("#btndel" + btnID).on("click",deleteDatabaseFunc);
                }
            };

            http.send(params);
        }

    }

    function deleteDatabaseFunc(e) {
    
        var btnID = e.target.id.substr(6);
        if ($("#btndel" + btnID).val() == "Delete") {

            $("#listEmp" + btnID).css({"background-color":"rgb(249, 250, 195)","text-decoration":"line-through","color":"red"});
            $("#btndel" + btnID).val("Confirm");
            alert("Highlighted record will be deleted. Please click ok and then click on confirm.");            

        } 
        else {
            //code to delete into database goes here
            var http = new XMLHttpRequest();
            var url = "php/delete.php";
            var params = "updEmpID=" + btnID;

            http.open('POST', url, true);        

            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    //sets row data to deleted values in situ
                    $("#listEmp" + btnID).hide();
                }
            };

            http.send(params);
        }

    }

    //End: code section to update database goes here

    //this section of code prints list table
    function printTable() {
        
        var isOperations = $("#listEmployeeBody").html().search("type=\"text\"");
        if (isOperations > 0 )
            alert("Please complete all actions before printing.");
        else {
            var prntDataTableHeader = $("#listEmployeeHead").html();
            var prntDataTableData = $("#listEmployeeBody").html();
            var prntDataTableEnd = "</table>";
            var mywindow = window.open('', 'printer', 'height=400,width=600');
            var cssStyle = '<style>table {border-collapse: collapse; width: 100%; white-space: nowrap; }' + 
                                    '.list-emp-sticky-action { display: none;}' +
                                    'th {background-image: linear-gradient(0deg, rgb(147, 201, 255), rgb(98, 165, 252)); border: 1px;}' +
                                    'td, th {border: 1px solid #000; padding: 8px;}' +
                                    'body {text-align: center; font-size: 16px;}' +
                            '</style>';
            mywindow.document.write('<html><head><title>PME-Refresher list(PDF)</title>');
            mywindow.document.write(cssStyle);
            mywindow.document.write('<scr' + 'ipt src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></scr' + 'ipt>');
            mywindow.document.write('<scr' + 'ipt>');
            mywindow.document.write('$(document).ready(function(){');
            mywindow.document.write('$(".list-emp-sticky-action").hide();');
            mywindow.document.write('});');
            mywindow.document.write('</scr' + 'ipt></head><body>');
            mywindow.document.write('<h2> PME and Refresher record of employees </h2>');
            mywindow.document.write('<table>');
            mywindow.document.write(prntDataTableHeader);
            mywindow.document.write(prntDataTableData);
            mywindow.document.write(prntDataTableEnd);
            mywindow.document.write('</' + 'body></' + 'html>');
            mywindow.document.close();
            mywindow.print();
        }
    }


    //Begin: insert new record into database 
    function insertDatabaseFunc(e) {
        
        if ($("#addNewRecord").text() == "Add New" || e.target.id.substr(0,10) == "btnupd-new") {
            if ($("#addNewRecord").text() == "Add New" ) {
                var btnIDStr = $("#totalStaff").text();
                var btnID    = parseInt(btnIDStr) + 1;
            }
            else {
                var btnIDStr = $(".dummy-class-id").last().text();
                var btnID    = parseInt(btnIDStr) + 1;
            }
            
            var selectTIUnit = "<select name=\"updEmpTIUnit" + btnID + "\" id=\"updEmpTIUnit" + btnID + "\" class=\"dynamicUpdateFields\" >" +
                                    "<option selected>TI-M-BT-I</option>" +
                                    "<option >TI-M-BT-II</option>" +
                                    "<option >TI-M-SPR-I</option>" +
                                    "<option >TI-M-SPR-II</option>" +
                                    "<option >TI-M-SDAH </option>" +
                                    "<option >TI-M-RHA </option>" +
                                    "<option >TI-M-KNJ </option>" +
                                    "<option >TI-M-GEDE </option>" +
                                "</select>";
            var selectDesig = "<select name=\"updEmpDesig" + btnID + "\" id=\"updEmpDesig" + btnID + "\" class=\"dynamicUpdateFields\" >" +
                                    "<option selected>SS</option>" +
                                    "<option >SM</option>" +
                                    "<option >Porter</option>" +
                                    "<option >Cabin Master</option>" +
                                    "<option >Shuntman </option>" +
                                    "<option >Gateman </option>" +
                                    "<option >Cabinman </option>" +
                                    "<option >Stg. Master </option>" +
                                    "<option >Pointsman </option>" +
                                "</select>";

            //if TI user then TI UNIT is fixed TODO
            var sessionAdmin = "<?php echo $_SESSION["sessionAdmin"]; ?>";
            if (sessionAdmin == "TI-USER")
                selectTIUnit = "<?php echo $_SESSION["loggedUser"]; ?>";

            var blankRow = "<tr id=\"listEmpNew" +  btnID + "\" class=\"dummy-class-tr\" >" + 
                        "<td id=\"listEmpRowNew\" class=\"dummy-class-id\" >" + btnID + ".</td>" + 
                        "<td id=\"list-emp-name-new\">" + "<input type=\"text\" class=\"dynamicUpdateFields\" " +
                         " id=\"updEmpName" + btnID + "\" value=\"\" required/>" + "</td>" + 
                        "<td id=\"list-emp-ti-unit-new\">" + selectTIUnit + "</td>" + 
                        "<td id=\"list-emp-stn-new\">" + "<input type=\"text\" class=\"dynamicUpdateFields\" style=\"text-transform:uppercase;\"" + 
                        "id=\"updEmpSTN" + btnID + "\" value=\"\" required/>" + "</td>" + 
                        "<td id=\"list-emp-desig-new\">" + selectDesig + "</td>" + 
                        "<td id=\"list-emp-dob-new\">" + "<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpDoB" + btnID + "\" value=\"\" required/>" + "</td>" + 
                        "<td>" + "Cal" + "</td>" + 
                        "<td>" + "Cal" + "</td>" + 
                        "<td id=\"list-emp-pme-prv-new\">" + "<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpPMEPrev" + btnID + "\" required/>" + "</td>" + 
                        "<td id=\"list-emp-pme-nxt-new\">" + "Calculated" + "</td>" + 
                        "<td id=\"list-emp-ref-prv-new\">" + "<input type=\"date\" class=\"dynamicUpdateFields\" id=\"updEmpREFPrev" + btnID + "\" required />" + "</td>" + 
                        "<td id=\"list-emp-ref-nxt-new\">" + "Calculated" + "</td>" + 
                        "<td class=\"list-emp-sticky-action\">" + 
                            "<table id=\"listEmpActionTab\">" + 
                                "<tr>" + 
                                    "<td>" + 
                                        "<input type=\"button\" id=\"btnupd-new"+ btnID + "\" class=\"scroll-add\" value=\"+More\" />" + 
                                    "</td>" + 
                                    "<td>" + 
                                        "<input type=\"button\" id=\"btndel-new"+ btnID + "\" class=\"scroll-add-del\" value=\"Delete\" />" + 
                                    "</td>" + 
                                "</tr>" + 
                            "</table>" + 
                        "</td>" + 
                    "</tr>";

            $("#btnupd-new" + (btnID-1)).hide();
            $("#btndel-new" + (btnID-1)).hide();

            $("#listEmployeeBody").append(blankRow);

            $("#updEmpName" + btnID).focus();

            $(".scroll-update").on("click", updateDatabaseFunc); 

            $(".scroll-delete").on("click", deleteDatabaseFunc);

            $(".scroll-add").on("click", insertDatabaseFunc); 

            $(".scroll-add-del").on("click", insertDatabaseFunc); 

            $("#addNewRecord").text("Confirm Add");

        }
        else if (e.target.id.substr(0,10) == "btndel-new") {
            
            var btnIDStr = $(".dummy-class-id").last().text();
            var btnID    = parseInt(btnIDStr);

            $('#listEmpNew' +  btnID).remove();
            if ($("#btnupd-new" + (btnID-1)).length && $("#btndel-new" + (btnID-1)).length) {
                $("#btnupd-new" + (btnID-1)).show();
                $("#btndel-new" + (btnID-1)).show();
            }
            else
                $("#addNewRecord").text("Add New");
        }
        else if ($("#addNewRecord").text() == "Confirm Add") {
            //for each new entries insert into database and add rows to Master Display List            
            $(".dummy-class-tr").each(function(){
                var btnID = parseInt($(this).attr('id').substr(10));
                var sessionAdmin = "<?php echo $_SESSION["sessionAdmin"]; ?>";
                //code to insert into database goes here
                var validValues = true;
                //validate fields before sending to DB
                if ($("#updEmpName" + btnID).val().trim() == "") {
                    alert("Please enter a valid name");
                    validValues = false;
                    return false;
                }
                if ($("#updEmpSTN" + btnID).val().trim() == "") {
                    alert("Please enter valid station code");
                    validValues = false;
                    return false;
                }
                if ($("#updEmpDoB" + btnID).val().trim() == "") {
                    alert("Please enter valid date of birth");
                    validValues = false;
                    return false;
                }
                if ($("#updEmpPMEPrev" + btnID).val().trim() == "") {
                    alert("Please enter valid previous PME date");
                    validValues = false;
                    return false;
                }
                if ($("#updEmpREFPrev" + btnID).val().trim() == "") {
                    alert("Please enter valid previous Refresher date");
                    validValues = false;
                    return false;
                }

                if (sessionAdmin == "TI-USER")
                    tiUnit = "<?php echo $_SESSION["loggedUser"]; ?>";
                else
                    tiUnit = $("#updEmpTIUnit" + btnID).val();
            
                if (validValues) {
                    var http = new XMLHttpRequest();
                    var url = "php/insert.php";
                    var params = "updListRowID=" + btnID + "&updEmpName=" + $("#updEmpName" + btnID).val() + "&updEmpTIUnit=" + tiUnit +
                                "&updEmpSTN=" + $("#updEmpSTN" + btnID).val() + "&updEmpDesig=" + $("#updEmpDesig" + btnID).val() +
                                "&updEmpDoB=" + $("#updEmpDoB" + btnID).val() + "&updEmpPMEPrev=" + $("#updEmpPMEPrev" + btnID).val() +
                                "&updEmpREFPrev=" + $("#updEmpREFPrev" + btnID).val();

                    http.open('POST', url, true);

                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.onreadystatechange = function() {//Call a function when the state changes.
                        if(http.readyState == 4 && http.status == 200) {
                            //sets row data to updated values in situ
                            $("#listEmpNew" + btnID).html(http.responseText);
                            //$("#btnupd" + btnID).on("click",updateDatabaseFunc);
                            //$("#btndel" + btnID).on("click",deleteDatabaseFunc);
                            $(".scroll-update").on("click",updateDatabaseFunc);
                            $(".scroll-delete").on("click",deleteDatabaseFunc);
                            $("#addNewRecord").text("Add New");
                        }
                    };

                    http.send(params);
                }
                
            });
        }
     
    }

    // validation of checkPME & cheeckREF 
    $("#idFilterMonth").on("change", validatePMEREFCheck);
    $("#idFilterYear").on("change", validatePMEREFCheck);

    function validatePMEREFCheck() {
        if ($("#idFilterMonth").val() == "None" && $("#idFilterYear").val() == "None") {
            $('#checkPME').attr("disabled",true);
            $('#checkREF').attr("disabled", true);
        }
        else {
            $('#checkPME').attr("disabled",false);
            $('#checkREF').attr("disabled",false);
        }
    }

    $(".scroll-update").on("click", updateDatabaseFunc); 

    $(".scroll-delete").on("click", deleteDatabaseFunc); 

    $("#printButton").on("click", printTable);

    $("#addNewRecord").on("click", insertDatabaseFunc);
    
});

</script>

<style>

input[type="date"]::-webkit-datetime-edit, input[type="date"]::-webkit-inner-spin-button, input[type="date"]::-webkit-clear-button {
  color: #fff;
  position: relative;
}

input[type="date"]::-webkit-datetime-edit-year-field{
  position: absolute !important;
  border-left:1px solid #8c8c8c;
  color:#000;
  left: 50px;
}

input[type="date"]::-webkit-datetime-edit-month-field{
  position: absolute !important;
  border-left:1px solid #8c8c8c;
  color:#000;
  left: 25px;
}


input[type="date"]::-webkit-datetime-edit-day-field{
  position: absolute !important;
  color:#000;
  left: 4px;
}


    /* Use a media query to add a break point at 600px: */
@media screen and (max-width:600px) {
  .body-wrapper {
    width:100%; /* The width is 100%, when the viewport is 800px or smaller */
  }
}
</style>

</head>
<body>


<div class="body-wrapper">

    <div class="list-header">
            
        <div class="login-header-label">
            PME & Refresher Tracking App, Eastern Railway, Sealdah
        </div>
        
        <div class="logged-user-info">
            <p class="logedInTag">Logged in as : <?php echo $_SESSION["loggedUser"] ?> on <span id="datetime"> </span> <|> <a href="index.php"> LOGOUT </a></p>
        </div>
        
        <script>        
            var d = new Date();          
            document.getElementById("datetime").innerHTML = d.toLocaleString([], { hour12: true});
        </script>

    </div>

    <form name="filterForm" action="ListEmployees.php" method="post">

    <div class="head-responsive-wrap">
    <!--div class="list-emp-filter"-->
        <div class="responsive-head-left">
            <!--div class="column" style="background-image: linear-gradient(0deg, rgb(3, 180, 142), rgb(1, 66, 55));"-->
            <div class="staff-pos-head">
            <p class="filter-header">Staff Position</p>
            <p class="filter-body">Shows number of staff in the list.</p>
            </div>
            <!--div class="filter-col-header2"-->
            <div class="staff-pos-detail" >
                <table class="staff-pos-table">
                    <!--col width="150px" />
                    <col width="50px" />
                    <col width="150px" />
                    <col width="50px" /-->
            
                    <tr>
                        <td class="staff-pos-tab-lbl">Total Staff</td>
                        <td id="totalStaff" class="staff-pos-tab-data"><?php echo $totalStaffCount; ?></td>
                        <td class="staff-pos-tab-lbl">SS</td>
                        <td id="totalSS" class="staff-pos-tab-data"><?php echo $ssCount; ?></td>
                    </tr>
                    
                    <tr>
                        <td class="staff-pos-tab-lbl">SM</td>
                        <td id="totalSM" class="staff-pos-tab-data"><?php echo $smCount; ?></td>
                        <td class="staff-pos-tab-lbl">Porter</td>
                        <td id="totalPorter" class="staff-pos-tab-data"><?php echo $porterCount; ?></td>
                    </tr>

                    <tr>
                        <td class="staff-pos-tab-lbl">Cabin Master</td>
                        <td id="totalCabinMaster" class="staff-pos-tab-data"><?php echo $cabinMasterCount; ?></td>
                        <td class="staff-pos-tab-lbl">Shuntman</td>
                        <td id="totalShuntman" class="staff-pos-tab-data"><?php echo $shuntmanCount; ?></td>
                    </tr>

                    <tr>
                        <td class="staff-pos-tab-lbl">Gateman</td>
                        <td id="totalGateman" class="staff-pos-tab-data"><?php echo $gatemanCount; ?></td>
                        <td class="staff-pos-tab-lbl">Cabinman</td>
                        <td id="totalCabinman" class="staff-pos-tab-data"><?php echo $cabinmanCount; ?></td>
                    </tr>

                    <tr>
                        <td class="staff-pos-tab-lbl">Stg. Master</td>
                        <td id="totalStgmaster" class="staff-pos-tab-data"><?php echo $stgMasterCount; ?></td>
                        <td class="staff-pos-tab-lbl">Pointsman</td>
                        <td id="totalPointsman" class="staff-pos-tab-data"><?php echo $pointsmanCount; ?></td>
                    </tr>

                </table>
            </div>
        </div> <!-- responsive-head-left -->
        <div class="responsive-head-right">
            <div class="responsive-fliter">
                <p class="filter-header">Filter Criteria</p>
                <p class="filter-body">Allows user to filter search criteria.</p>
            </div>
            <div class="responsive-filter-detail">
                <table class="res-filter-table">
                    <!--col width="170px" />
                    <col width="130px" /-->
                    <tr>
                        <td class="filter-table1" >
                            <?php
                                if(isset($_POST["checkREF"]) || isset($_POST["user"])) {
                                        echo "<input name=\"checkREF\" id=\"checkREF\" type=\"checkbox\" class=\"check\" checked>";
                                }
                                else {
                                    echo "<input name=\"checkREF\" id=\"checkREF\" type=\"checkbox\" class=\"check\" >";
                                }
                            ?>
                            
                            <label for="checkREF" class="filter2-checkbox">Check for Refresher</label>
                        </td>
                        <td class="filter-table1">
                            <?php
                                if(isset($_POST["checkPME"]) || isset($_POST["user"])) {
                                        echo "<input name=\"checkPME\" id=\"checkPME\" type=\"checkbox\" class=\"check\" checked>";
                                }
                                else {
                                    echo "<input name=\"checkPME\" id=\"checkPME\" type=\"checkbox\" class=\"check\" >";
                                }
                            ?>
                            <label for="check" class="filter2-checkbox"> Check for PME</label>
                        </td>	
                    </tr>

                    <tr>
                        <td class="filter-pos-tab-lbl">Filter by Month : </td>
                        <td class="staff-pos-tab-lbl">
                            <select name="filterSearchMonth" id="idFilterMonth" class="input-dropdown" >
                                <option class="input-option" selected>January</option>
                                <option class="input-option">February</option>
                                <option class="input-option">March</option>
                                <option class="input-option">April</option>
                                <option class="input-option">May</option>
                                <option class="input-option">June</option>
                                <option class="input-option">July</option>
                                <option class="input-option">August</option>
                                <option class="input-option">September</option>
                                <option class="input-option">October</option>
                                <option class="input-option">November</option>
                                <option class="input-option">December</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="filter-pos-tab-lbl">Filter by Year : </td>
                        <td class="staff-pos-tab-lbl">
                            <select name="filterSearchYear" id="idFilterYear" class="input-dropdown" >
                                <option class="input-option">2045</option>
                                <option class="input-option">2044</option>
                                <option class="input-option">2043</option>
                                <option class="input-option">2042</option>
                                <option class="input-option">2041</option>
                                <option class="input-option">2040</option>
                                <option class="input-option">2039</option>
                                <option class="input-option">2038</option>
                                <option class="input-option">2037</option>
                                <option class="input-option">2036</option>
                                <option class="input-option">2035</option>
                                <option class="input-option">2034</option>
                                <option class="input-option">2033</option>
                                <option class="input-option">2032</option>
                                <option class="input-option">2031</option>
                                <option class="input-option">2030</option>
                                <option class="input-option">2029</option>
                                <option class="input-option">2028</option>
                                <option class="input-option">2027</option>
                                <option class="input-option">2026</option>
                                <option class="input-option">2025</option>
                                <option class="input-option">2024</option>
                                <option class="input-option">2023</option>
                                <option class="input-option">2022</option>
                                <option class="input-option">2021</option>
                                <option class="input-option" selected>2020</option>
                                <option class="input-option">2019</option>
                                <option class="input-option">2018</option>
                                <option class="input-option">2017</option>
                                <option class="input-option">2016</option>
                            </select>
                        </td>
                    </tr>

                </table>
            </div> <!-- responsive-filter-detail -->
        </div>  <!-- responsive-head-right -->
    </div> <!-- head-responsive-wrap -->
    
    
    <div class="choice-ti-unit" >
            <div class="ti-unit-label">
                <p class="staff-pos-tab-lbl" >Choose TI Unit(s) : </p>
            </div>
            <div class="ti-units">
                <table class="ti-unit-table">
                    <tr>
                        <td class="staff-pos-tab-lbl" > 
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTIBTI";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-BT-I") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?>
                        
                            <label for="checkREFTIBTI" class="filter2-checkbox">TI (M) / BT - I</label> 
                        </td>
                        <td class="staff-pos-tab-lbl">
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTIBTII";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-BT-II") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTIBTII" class="filter2-checkbox">TI (M) / BT - II</label>	
                        </td>
                        <td class="staff-pos-tab-lbl">
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTISPRI";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-SPR-I") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTISPRI" class="filter2-checkbox">TI (M) / SPR - I</label>	
                        </td>
                        <td class="staff-pos-tab-lbl">
                        <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTISPRII";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-SPR-II") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTISPRII" class="filter2-checkbox">TI (M) / SPR - II</label>	
                        </td>
                        
                    </tr>
                    <tr>
                         <td class="staff-pos-tab-lbl">
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTISDAH";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-SDAH") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTISDAH" class="filter2-checkbox">TI (M) / SDAH</label>	
                        </td>
                        <td class="staff-pos-tab-lbl">
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTIRHA";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-RHA") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTIRHA" class="filter2-checkbox">TI (M) / RHA</label>	
                        </td>
                        <td class="staff-pos-tab-lbl" > 
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTIKNJ";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-KNJ") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            <label for="checkREFTIKNJ" class="filter2-checkbox">TI (M) / KNJ</label> 
                        </td>
                        <td class="staff-pos-tab-lbl">
                            <?php  //restrict data to logged user
                                $checkedTiUnit = "checkREFTIGEDE";
                                if ($_SESSION["sessionAdmin"] == "GLOBAL") {
                                    if(isset($_POST[$checkedTiUnit]) || isset($_POST["user"])) {
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked>";
                                    }
                                    else
                                        echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" >";
                                }
                                else if ($_SESSION["loggedUser"] == "TI-M-GEDE") {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" checked disabled>";
                                }
                                else {
                                    echo "<input name=\"".$checkedTiUnit."\" id=\"".$checkedTiUnit."\" type=\"checkbox\" class=\"check\" disabled>";
                                }
                            ?> 
                            
                            <label for="checkREFTIGEDE" class="filter2-checkbox">TI (M) / GEDE</label>	
                        </td>
                      
                        </td>
                    </tr>
                </table>
            </div>
    </div>

    <div class="filter-by-name-stn">
        <table class="filter-name-stn-tab">
            <!--col width="100px" />
            <col width="100px" />
            <col width="100px" />
            <col width="100px" />
            <col width="105px" /-->
            <tr >
                <td class="staff-pos-tab-lbl" > 
                    By Staff Name : 
                </td>
                <td>
                    <input name="filterName" id="filterName" type="text" class="input-filter-box" value="<?php echo isset($_POST['filterName'])?$_POST['filterName']:''; ?>">
                </td>
                <td class="staff-pos-tab-lbl" >
                    By Station code : 
                </td>
                <td>
                    <input name="filterStnName" id="filterStnName" type="text" class="input-filter-box" value="<?php echo isset($_POST['filterStnName'])?$_POST['filterStnName']:''; ?>">
                </td>
                <td class="filter-table1" style="padding-left: 5px;" >
                    <button type="submit" class="button-refresh"><span>Refresh</span></button>
                </td>
            </tr>
        </table>
    </div>
    
    </form>

<!-- End of List Emp Filter form-->
<form>
<div id="printerFreindly" class="list-emp-data">
	<table id="listEmployee" class="master-list-tab">
        <!--col width="20px" />
		<col width="140px" />
		<col width="60px" />
		<col width="30px" />
        <col width="55px" />
        <col width="75px" />
		<col width="25px" />
		<col width="50px" />
        <col width="75px" />
        <col width="75px" />
        <col width="75px" />
        <col width="75px" /-->
		<thead id="listEmployeeHead">
		<tr>
			<th>SL</th>
            <th>EMPLOYEE NAME</th>
            <th>TI UNIT</th>
			<th>STN</th>
			<th>DESIG.</th>
            <th>DOB</th>
            <th>AGE</th>
            <th>AGE ON<br/> LAST PME</th>
			<th>PME DONE</th>
			<th style="background-image: linear-gradient(0deg, rgb(255, 105, 67), rgb(139, 10, 5));">PME DUE</th>
			<th>REF DONE</th>
			<th style="background-image: linear-gradient(0deg, rgb(255, 105, 67), rgb(139, 10, 5));">REF DUE</th>
			<th class="list-emp-sticky-action">Action</th>
		</tr>
        </thead>
        <tbody id="listEmployeeBody">
        
        <!-- ListEmployee Sample rows-->
        
        <?php

        $listEmpCounter = 1;
        $today = new Datetime(date('m/d/y'));
        foreach ($db->query($sql) as $row) {
        
        $empID = $row['EMP_ID'];
        $dobTimeStamped = strtotime($row['EMP_DOB']);

        $age = $today->diff(new DateTime($row['EMP_DOB']));
        $lastPMEDate = new DateTime($row['EMP_PME_PREV']); 
        $ageOnPME = $lastPMEDate->diff(new DateTime($row['EMP_DOB']));

        $pmePrevTimeStamped = strtotime($row['EMP_PME_PREV']);
        $pmeNextTimeStamped = strtotime($row['EMP_PME_NEXT']);
        $refPrevTimeStamped = strtotime($row['EMP_REF_PREV']);
        $refNextTimeStamped = strtotime($row['EMP_REF_NEXT']);

        echo "<tr id=\"listEmp".$empID."\">".
                "<td id=\"listEmpRow".$empID."\">".$listEmpCounter.".</td>".
                "<td id=\"list-emp-name".$empID."\">".$row['EMP_NAME']."</td>".
                "<td id=\"list-emp-ti-unit".$empID."\">".$row['EMP_TI_UNIT']."</td>".
		        "<td id=\"list-emp-stn".$empID."\">".$row['EMP_STN']."</td>".
		        "<td id=\"list-emp-desig".$empID."\">".$row['EMP_DESIG']."</td>".
                "<td id=\"list-emp-dob".$empID."\">".date("d/m/Y", $dobTimeStamped)."</td>".
                "<td>".$age->y."</td>".
                "<td>".$ageOnPME->y."</td>".
		        "<td id=\"list-emp-pme-prv".$empID."\">".date("d/m/Y", $pmePrevTimeStamped)."</td>".
		        "<td id=\"list-emp-pme-nxt".$empID."\">".date("d/m/Y", $pmeNextTimeStamped)."</td>".
		        "<td id=\"list-emp-ref-prv".$empID."\">".date("d/m/Y", $refPrevTimeStamped)."</td>".
		        "<td id=\"list-emp-ref-nxt".$empID."\">".date("d/m/Y", $refNextTimeStamped)."</td>".
		        "<td class=\"list-emp-sticky-action\">".
                    "<table id=\"listEmpActionTab\">".
                        "<tr>".
                            "<td>".
                                "<input type=\"button\" id=\"btnupd".$empID."\" class=\"scroll-update\" value=\"Edit\" />".
                            "</td>".
                            "<td>".
                                "<input type=\"button\" id=\"btndel".$empID."\" class=\"scroll-delete\" value=\"Delete\" />".
                            "</td>".
                        "</tr>".
                    "</table>".
			    "</td>".
            "</tr>";

            $listEmpCounter = $listEmpCounter + 1;
        }
        ?>
        
        </tbody>
		<!-- ListEmployee Sample rows-->
	</table>
</div>

<div class="list-page-scroll">
		<button id="printButton" class="scroll-button"> Print List </button> <span> | </span> <button id="addNewRecord" class="scroll-button" >Add New</button> 
</div>

</form>
<div class="list-footer">
   
    <i>Copyright © 2020 - Asif Hossain </i> 
   
</div>

</div> <!-- body-wrapper -->

</body>
</html>