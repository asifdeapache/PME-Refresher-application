<?php
        include_once 'connection.php';
		
            try {
                $database = new Connection();
                $db = $database->openConnection();
                
                //calculate EMP next refresher date
                //$prevREFdateFormatted = strtotime(date_format(date_create_from_format("d/m/Y",$_POST["updEmpREFPrev"]), "Y-m-d"));
                


                $sql = "UPDATE pmerefmaster SET EMP_TI_UNIT = \"".$_POST["updEmpTIUnit"]."\", EMP_NAME = \""
                        .$_POST["updEmpName"]."\", EMP_DOB = STR_TO_DATE(\"".$_POST["updEmpDoB"]."\",\"%Y-%m-%d\"), EMP_DESIG = \""
                        .$_POST["updEmpDesig"]."\", EMP_STN = \"".strtoupper($_POST["updEmpSTN"])."\", EMP_PME_PREV = STR_TO_DATE(\""
                        .$_POST["updEmpPMEPrev"]."\",\"%Y-%m-%d\"), EMP_REF_PREV = STR_TO_DATE(\""
                        .$_POST["updEmpREFPrev"]."\",\"%Y-%m-%d\") WHERE EMP_ID=".$_POST["updEmpID"];

                $statement = $db->prepare($sql);
                $statement->execute();
                
                $sql = "SELECT * FROM pmerefmaster WHERE EMP_ID=".$_POST["updEmpID"];              

                $today = new Datetime(date('m/d/y'));

                foreach ($db->query($sql) as $row) {

                    $empID = $row['EMP_ID'];

                    $age = $today->diff(new DateTime($row['EMP_DOB']));
                    $lastPMEDate = new DateTime($row['EMP_PME_PREV']); 
                    $ageOnPME = $lastPMEDate->diff(new DateTime($row['EMP_DOB']));

                    $dobTimeStamped = strtotime($row['EMP_DOB']);
                    $pmePrevTimeStamped = strtotime($row['EMP_PME_PREV']);
                    
                    $refPrevTimeStamped = strtotime($row['EMP_REF_PREV']);
                    $refNextTimeStamped = strtotime("+3 years", strtotime($row['EMP_REF_PREV']));

                    //PME logic addition goes here
                    if ( $ageOnPME->y < 41 ) {
                        $pmeNextTimeStamped = strtotime("+4 years", strtotime($row['EMP_PME_PREV']));
                    }
                    else if ( $ageOnPME->y >= 41 && $ageOnPME->y < 43 ) {
                        $pmeNextTimeStamped = strtotime("+45 years", strtotime($row['EMP_DOB']));
                    }
                    else if ( $ageOnPME->y >= 43 && $ageOnPME->y <= 52 ) {
                        $pmeNextTimeStamped = strtotime("+2 years", strtotime($row['EMP_PME_PREV']));
                    }
                    else if ( $ageOnPME->y == 53 ) {
                        $pmeNextTimeStamped = strtotime("+55 years", strtotime($row['EMP_DOB']));
                    }
                    else if ( $ageOnPME->y >= 54) {
                        $pmeNextTimeStamped = strtotime("+1 years", strtotime($row['EMP_PME_PREV']));
                    }

                    $sql = "UPDATE pmerefmaster SET EMP_REF_NEXT = STR_TO_DATE(\"".date("d/m/Y", $refNextTimeStamped)."\",\"%d/%m/%Y\"), EMP_PME_NEXT = STR_TO_DATE(\""
                            .date("d/m/Y", $pmeNextTimeStamped)."\",\"%d/%m/%Y\") WHERE EMP_ID=".$_POST["updEmpID"];
                            
                    $statement = $db->prepare($sql);
                    $statement->execute();

                    echo    "<td id=\"listEmpRow".$empID."\">".$_POST["updListRowID"]."</td>".
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
                            "</td>";
                }
            }
            catch (PDOException $e)
            {
                echo "There is some problem in connection: " . $e->getMessage();
            }
?>