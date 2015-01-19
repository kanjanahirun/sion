<?php
$password = $_POST[password];
$confirmpassword = $_POST[confirmpassword];
if ($password == "" & $confirmpassword == "") {
    echo "กรุณากรอกรหัสผ่านทั้ง 2 ช่อง";
} else if ($password != $confirmpassword) {
    echo "<script type='text/javascript'>alert('รหัสผ่านไม่ตรงกัน')</script>";
} else {
    echo "<script type='text/javascript'>alert('รหัสผ่านตรงกัน')</script>";
}
if ($username == "") {                    //ถ้ายังไม่ได้กรอกข้อมูลที่ชื่อผู้ใช้ให้ทำงานดังต่อไปนี้
    echo "<script type='text/javascript'>alert('คุณยังไม่ได้กรอกชื่อผู้ใช้ครับ')</script>";
} else if ($password == "") {        //ถ้ายังไม่ได้กรอกรหัสผ่านให้ทำงานดังต่อไปนี้
    echo "<script type='text/javascript'>alert('คุณยังไม่ได้กรอกรหัสผ่านครับ')</script>";
}
?>

