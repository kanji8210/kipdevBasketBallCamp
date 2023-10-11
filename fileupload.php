<?php
if (isset($_FILES["imageCamp"]) && $_FILES["imageCamp"]["error"] === 0) {

    $imageCamp               = $_FILES["imageCamp"];

    //Si le fichier n'est pas trop volumineux(1Mo accepté)
    if ($imageCamp["size"] <= (1024 * 1024)) {

        $extensionAutorisees = [
            "jpg"     => "image/jpeg",
            "jpeg"     => "image/jpeg",
            "png"     => "image/png"
        ];

        //strtolower pour être sûr que l'extension est en minuscules
        $extension = strtolower(pathinfo($imageCamp["name"], PATHINFO_EXTENSION));

        //Si l'extension/MIME ok
        if (array_key_exists($extension, $extensionAutorisees) && in_array($imageCamp["type"], $extensionAutorisees)) {
            // var_dump(file_exists($imageCamp["tmp_name"]));
            // var_dump(getcwd());
            // var_dump(file_exists('./wp-content/uploads/propositions'));

            //déplacer le fichier du dossier temporaire vers le dossier uploads/propositions
            move_uploaded_file($imageCamp["tmp_name"], './wp-content/uploads/camps/images/' . basename($imageCamp["name"]));

            $cheminImage = 'https://magalimendy.fr//wp-content/uploads/camps/images/' . $imageCamp["name"] . '';
        }
    }
} else if ($_FILES["imageCamp"]["error"] != 0) {
    $cheminImage = $_POST["cheminImage"];
}
