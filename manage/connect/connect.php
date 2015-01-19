<?php

$hostname = "localhost";
$username = "root";
$password = "root";
$dbname = "sion";

$conn = mysql_connect($hostname, $username, $password);

if (!$conn)
    die("ไม่สามาถติดต่อกับ MySQL ได้");
mysql_select_db($dbname, $conn) or die("ไม่สามารถเลือกฐานข้อมูลได้");
mysql_query("SET NAMES UTF8");

function generateID($OldId, $VarLength) {
    //P 099
    $ID_Var = substr($OldId, 0, $VarLength);
    $ID_num = substr($OldId, $VarLength);

    $NewNum = "";
    for ($i = 0; $i < strlen($ID_num); $i++) {
        if (substr($ID_num, $i, $VarLength) != "0") {
            $NewNum = $IDS = substr($ID_num, $i);
            break;
        }
    }

    $NewId = $ID_Var;
    if ($NewNum < 9) {
        $NewId .= "00" . ($NewNum + 1);
    } elseif ($NewNum < 99) {
        $NewId .= "0" . ($NewNum + 1);
    } elseif ($NewNum <= 999) {
        $NewId .= ($NewNum + 1);
    } elseif ($NewNum <= 9999) {
        $NewId .= ($NewNum + 1);
    } elseif ($NewNum <= 99999) {
        $NewId .= ($NewNum + 1);
    } elseif ($NewNum <= 999999) {
        $NewId .= ($NewNum + 1);
    } elseif ($NewNum <= 9999999) {
        $NewId .= ($NewNum + 1);
    }
    return $NewId;
}

function generateID2($OldId2, $VarLength) {
    //P 099
    $ID_Var = substr($OldId2, 0, $VarLength);
    $ID_num = substr($OldId2, $VarLength);

    $NewNum2 = "";
    for ($i = 0; $i < strlen($ID_num); $i++) {
        if (substr($ID_num, $i, $VarLength) != "0") {
            $NewNum2 = $IDS = substr($ID_num, $i);
            break;
        }
    }

    $NewId2 = $ID_Var;
    if ($NewNum2 < 9) {
        $NewId2 .= "00" . ($NewNum2 + 1);
    } elseif ($NewNum2 < 99) {
        $NewId2 .= "0" . ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    }
    return $NewId2;
}

function tranformDate($oldDate) {
    $splitdate = split("\/", $oldDate); //explode("\/", $oldDate);
    $date = $splitdate[0] . "-" . $splitdate[1] . "-" . $splitdate[2];
    return $date;
}

function alert($text){
    return "<script>alert('".$text."')</script>";
}
function location($href){
    return "<script>location='".$href."'</script>";
}

function reverseDate($oldDate) {
    $splitdate = split("\-", $oldDate);//explode("\-", $oldDate);
    $date = $splitdate[2] . "/" . $splitdate[1] . "/" . $splitdate[0];
    return $date;
}

function fetchArray($data) {
    $result = array();
    while ($row = mysql_fetch_assoc($data)) {
        $result[] = $row;
    }
    return $result;
}

function format_date($oldDate) {
    $splitdate = split("\/", $oldDate);
    $date = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
    return $date;
}

function generateIDbyFix($OldId, $VarLength, $str) {
    //P 099
    $ID_Var = substr($OldId, 0, $VarLength);
    $ID_num = substr($OldId, $VarLength);

    $NewNum2 = "";
    for ($i = 0; $i < strlen($ID_num); $i++) {
        if (substr($ID_num, $i, $VarLength) != "0") {
            $NewNum2 = $IDS = substr($ID_num, $i);
            break;
        }
    }
    //$NewId2 = (strpos($ID_Var,$str) != null) ? $ID_Var : $str.$ID_Var;
    $NewId2 = (strpos($ID_Var, $str) != null) ? $ID_Var : $str;
    if ($NewNum2 < 9) {
        $NewId2 .= "00" . ($NewNum2 + 1);
    } elseif ($NewNum2 < 99) {
        $NewId2 .= "0" . ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 9999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    } elseif ($NewNum2 <= 99999999999999999999) {
        $NewId2 .= ($NewNum2 + 1);
    }
    return $NewId2;
}

function generateIDbyFix4($OldId, $VarLength, $str) {
    //P 099
    $ID_Var = substr($OldId, 0, $VarLength);
    $ID_num = substr($OldId, $VarLength);

    $NewNum2 = "";
    for ($i = 0; $i < strlen($ID_num); $i++) {
        if (substr($ID_num, $i, $VarLength) != "0") {
            $NewNum2 = $IDS = substr($ID_num, $i);
            break;
        }
    }
    //$NewId2 = (strpos($ID_Var,$str) != null) ? $ID_Var : $str.$ID_Var;
    $NewId2 = (strpos($ID_Var, $str) != null) ? $ID_Var : $str;
    if ($NewNum2 < 9) {
        $NewId2 .= "0" . ($NewNum2 + 1);
    } elseif ($NewNum2 < 99) {
        $NewId2 .= ($NewNum2 + 1);
    } 
    return $NewId2;
}

?>
