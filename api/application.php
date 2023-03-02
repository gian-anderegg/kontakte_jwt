<?php
    include_once("config.php");


    function controller($method, $ressource, $id, $dataFromClient, $pdo) {
        if ($ressource == 'kontakt') {
            switch ($method) {
                case 'GET':
                    if (empty($id)) {
                        return getKontakte($pdo);
                    } else {
                        return getKontakteById($id, $pdo);
                    }
                case 'POST':
                    return insertKontakt($dataFromClient);
                case 'PUT':
                    return updateKontakt($dataFromClient);
                case 'DELETE':
                    return deleteKontakt($id);
                case 'OPTIONS':
                    return formatMessage(405);
                default:
                    return formatMessage(405);
            }
        } else {
            return formatMessage(404, "Controller successful accessed");
        }
    }

    function checkInput($kontakt) {
        $status = true;
        $inputfields = array('name' => true, 'vorname' => true, 'email' => true);

        if (!CheckName($kontakt->name)) {
            $inputfields['name'] = false;
            $status = false;
        }

        if (!CheckName($kontakt->vorname)) {
            $inputfields['vorname'] = false;
            $status = false;
        }

        if (!CheckEmail($kontakt->email)) {
            $inputfields['email'] = false;
            $status = false;
        }

        if ($status) return formatMessage();
        else return formatMessage(420, $inputfields);
    }

    function insertKontakt($kontakt) {
        $status = checkInput($kontakt);
        if ($status['status'] == 200) {
            db_insert_kontakt($kontakt);
        }
        return formatMessage(200, "Kontakt wurde gespeichert");
    }

    function getKontakte($pdo) {
        $data = db_get_all_kontakte($pdo);
        return formatMessage(200, $data);
    }

    function getKontakteById($id, $pdo) {
        $data = db_get_kontakte_by_id($id, $pdo);
        return formatMessage(200, $data);
    }

    function deleteKontakt($id) {
        db_delete_kontakte_by_id($id);
        return formatMessage(200, "Kontakt wurde gelöscht");
    }

    function updateKontakt($kontakt) {
        db_update_kontakte_by_id($kontakt);
        return formatMessage(200, "Kontakt wurde angepasst");
    }

?>