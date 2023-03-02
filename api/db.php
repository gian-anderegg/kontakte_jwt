<?php
    function db_insert_kontakt($kontakt, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO kontakte (name, vorname, strasse, plz, ort, email, tpriv, tgesch) 
                           VALUES (:name, :vorname, :strasse, :plz, :ort, :email, :tpriv, :tgesch)");

        $stmt->bindParam(':name', $kontakt->name);
        $stmt->bindParam(':vorname', $kontakt->vorname);
        $stmt->bindParam(':strasse', $kontakt->strasse);
        $stmt->bindParam(':plz', $kontakt->plz);
        $stmt->bindParam(':ort', $kontakt->ort);
        $stmt->bindParam(':email', $kontakt->email);
        $stmt->bindParam(':tpriv', $kontakt->tpriv);
        $stmt->bindParam(':tgesch', $kontakt->tgesch);

        $stmt->execute();

    }

    function db_get_all_kontakte($pdo) {
        $sql = $pdo->prepare("SELECT * FROM kontakte");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function db_get_kontakte_by_id($id, $pdo) {
        $sql = $pdo->prepare("select * from kontakte where kid = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    function db_delete_kontakte_by_id($id, $pdo) {
        $sql = $pdo->prepare("delete from kontakte where kid = $id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    function db_update_kontakte_by_id($kontakt, $pdo) {
        $sql = "UPDATE kontakte SET name = :name,
                                vorname = :vorname,
                                strasse = :strasse,
                                plz = :plz,
                                ort = :ort,
                                email = :email,
                                tpriv = :tpriv,
                                tgesch = :tgesch
            WHERE kid = :kid";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $kontakt->name);
        $stmt->bindParam(':vorname', $kontakt->vorname);
        $stmt->bindParam(':strasse', $kontakt->strasse);
        $stmt->bindParam(':plz', $kontakt->plz);
        $stmt->bindParam(':ort', $kontakt->ort);
        $stmt->bindParam(':email', $kontakt->email);
        $stmt->bindParam(':tpriv', $kontakt->tpriv);
        $stmt->bindParam(':tgesch', $kontakt->tgesch);
        $stmt->bindParam(':kid', $kontakt->kid);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>