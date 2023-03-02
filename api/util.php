<?php

    function formatMessage($status = 200, $data = null) {
        $message = array();
        $message['status'] = $status;
        $message['data'] = $data;
        return $message;
    }

    function connectDB($host, $user, $password, $db) {
        global $dbhandle;
        $dbhandle = mysqli_connect($host, $user, $password, $db);
        if (!$dbhandle) {
            throw new Exception(mysqli_connect_error());
        }
    }

    function sqlSelect($sql) {
        global $dbhandle;
        $result = mysqli_query($dbhandle, $sql);
        if (!$result) die("Fehler: " . mysqli_error($dbhandle));
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }

    function sqlQuery($sql) {
        global $dbhandle;
        $result = mysqli_query($dbhandle, $sql);
        if (!$result) die(mysqli_error($dbhandle) . "<pre>" . $sql . "</pre>");
    }


    function redirect($id = "") {
        if (!empty($id)) $id = "?id=$id";
        header("Location: " . $_SERVER['PHP_SELF'] . $id);
        exit();
    }

    function CheckEmail($value, $empty = 'N') {
        $pattern_email = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';
        if ($empty == 'Y' && empty($value)) return true;
        if (preg_match($pattern_email, $value)) return true;
        else return false;
    }

    function CheckName($value, $empty = 'N') {
        $pattern_name = '/^[a-zA-ZÄÖÜäöü \-]{2,}$/';
        if ($empty == 'Y' && empty($value)) return true;
        if (preg_match($pattern_name, $value)) return true;
        else return false;
    }

    function CheckOrt($value, $empty = 'N') {
        $pattern_ort = '/^[a-zA-ZÄÖÜäöü \-\.]{2,}$/';
        if ($empty == 'Y' && empty($value)) return true;
        if (empty($value)) return false;
        if (preg_match($pattern_ort, $value)) return true;
        else return false;
    }

    function CheckPLZ($value, $empty = 'N') {
        $pattern_plz = '/^[0-9]{4,}$/';
        if ($empty == 'Y' && empty($value)) return true;
        if (empty($value)) return false;
        if (preg_match($pattern_plz, $value)) return true;
        else return false;
    }

?>