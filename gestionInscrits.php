<?php
/**
 * Plugin Name:       gestionInscrits
 * description_camp:  instal to create and manage camps. also helps to generate an article from the information available
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            KIPDEV
 * Author URI:        denniskip.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       do not install bfore contacting the auther
 * Domain Path:       /languages
 */
function gestionInscrits($id_stagiaire)
{

//get info from the database

//sql to select
    $content_gestion_stagiaires = '
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">';
    $content_gestion_stagiaires = '
<h2 class="text-info text-left">Stagiaire</h2>
<table class="table-striped">
    <thead class="text-success">
    <tr>
        <th>Id_stagiaire</th>
        <th>Nom stagiaire</th>
        <th>Date de naissance</th>
        <th>Date d\'inscription</th>
        <th>ID Camp inscrit</th>
        <th>Voir stagiaire <i class="bi bi-eye"></i></th>
    </tr>
    </thead>
    <tbody>
    ';

    $sql = "SELECT * FROM mm_stagiaire ORDER by date_inscription asc";

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);
        $r_results = $conn->query($sql);
        if ($r_results) {
            while ($row = $r_results->fetch(\PDO::FETCH_ASSOC)) {
                $content_gestion_stagiaires .= '
           <tr>
            <td>' . $row['id_stagiaire'] . '</td>
            <td>' . $row['nom_stagiaire'] . '</td>
            <td> ' . $row['date_naissance'] . '</td>
            <td>' . $row['date_inscription'] . '</td>
            <td>' . $row['id_camp'] . '</td>
            <td>
            <a href="https://www.magalimendy.fr/gestion-des-inscrits/?id_stagiaire=' . $row['id_stagiaire'] .'"><i class="bi bi-eye"></i></a>
            </td>
            </tr>
            ';

            }
            $content_gestion_stagiaires .= '</tr> </tbody> </table>';

        } else {

            $content_gestion_stagiaires .= '<p> aucun des stagiaires n\'a été retrouvé </p>';
            $content_gestion_stagiaires .= ' </tr> </tbody> </table>';
        }
    } catch (PDOException $e) {
        echo "prolem while selecting stagiaires from the DB '.$e.'";
        $content_gestion_stagiaires .= '<p> probléme avec connection a la BDD </p>';
        $content_gestion_stagiaires .= '</tr> </tbody> </table>';
    }
    $conn = null;

    return $content_gestion_stagiaires;
}
add_shortcode('kipdev_affiche_stagiaires', 'gestionInscrits');

function kipdevAfficheSagiaire($id_stagiaire)
{
    $content_stagiaire = '       <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
 rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">';

   

        $id_stagiaire = $_GET['id_stagiaire'];
        $sql = 'SELECT * FROM mm_stagiaires WHERE id_stagiaire = :id_stagiaire';

        try {
            $sql = 'SELECT * FROM mm_stagiaire WHERE id_stagiaire=:id_stagiaire';
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stm = $conn->prepare($sql);
            $stm->bindValue(':id_stagiaire', $id_stagiaire);
            $stm->execute(['id_stagiaire' => $id_stagiaire]);
            $stagiaire = $stm->fetch(PDO::FETCH_ASSOC);

            $id_stagiaire = $stagiaire['id_stagiaire'];
            $date_inscription = $stagiaire['date_inscription'];
            $id_camp = $stagiaire['id_camp'];
            $id_responsable_legal = $stagiaire['id_responsable_legal'];
            $nom_stagiaire = $stagiaire['nom_stagiaire'];
            $prenom_stagiaire = $stagiaire['prenom_stagiaire'];
            $adresse_stagiaire = $stagiaire['adresse_stagiaire'];
            $date_naisance = $stagiaire['date_naissance'];
            $sex_stagiaire = $stagiaire['sex_stagiaire'];
            $taille_haut = $stagiaire['tailles_haut'];
            $taille_bas = $stagiaire['tailles_bas'];
            $lien_cert_ed_licence_ffbb = $stagiaire['lien_cert_med_licence_ffbb'];
            $lien_consentement_photo = $stagiaire['lien_consentement_photo'];
            $lien_securite_social = $stagiaire['lien_securite_social'];
            $lien_mutuelle = $stagiaire['lien_mutuelle'];
            $lien_fiche_sanitaire = $stagiaire['lien_fiche_sanitaire'];
            $demande = $stagiaire['demande'];
            $modalite= $stagiaire['modalite'];
            $lien_phot_passport = $stagiaire['lien_phot_passport'];

            //calculate age
            $today = date("Y-m-d");
            $diff = date_diff(date_create($date_naisance), date_create($today));
            $age_stagiaire = $diff->format('%y');
            

            $content_stagiaire .= '
    <div class="container">
    <div class="row" >
        <div class="col-4">
            <img src="' . $lien_phot_passport . '" alt="photo profil">
            <p>Nom ' . $nom_stagiaire . '  Prenom  ' . $prenom_stagiaire . '</p>
            <p>Age: ' . $age_stagiaire . '</p>
            <p> Sex stagiaire : ' . $sex_stagiaire . '</p>';

                $content_stagiaire .= '<h4> personnes à contacter en cas d\'urgence </h4>';
                $sqlResplegal= 
                "SELECT * FROM mm_responsable_legal
                 WHERE id_responsable_legal= :id_responsable_legal";
                try {
                    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                    $stm = $conn->prepare($sqlResplegal);
                    $stm->execute(['id_responsable_legal' => $id_responsable_legal]);
                    $RespLegal = $stm->fetch(PDO::FETCH_ASSOC);
                    $nomResp1 = $RespLegal['nom_person_a_contacter1'];
                    $prenomResp1 = $RespLegal['prenom_responsable1'];
                    $telResp1 = $RespLegal['tel_responsable1'];
                    $nomResp2 = $RespLegal['nom_responsable2'];
                    $emailResp2 = $RespLegal['email_responsable2'];
                    $telResp2=$RespLegal['tel_responsable2'];

                    $content_stagiaire .= '
                    <p>NOM Prenom  : ' . $nomResp1 .' '. $prenomResp1. ' </p>
                    <br>
                    <p>Numero tel.  : ' . $telResp1. ' </p>
                    <br>
                    <h5> personne2</h5>
                    
                    <p>NOM Prenom  : ' . $nomResp2 .' </p>
                    <br>
                    <p> Email : '. $emailResp2 . '</p>
                    <br>
                    <p>Numero tel.  : ' . $telResp2. ' </p>
                    <br>
                    <div>
                    <h4>Demand de stagiaire</h4>
                        ' . $demande . '
                    </div>
                    

                    ';
                } catch (PDOException $e) {
                    echo "Error while selecting resnsable legal ".$e;
                }
                $conn = null;

            $content_stagiaire .= '</div>
        <div class="col-8">
            <p>id stagiaire : ' . $id_stagiaire . '</p>
            <br>
            <p>date inscription : ' . $date_inscription . '</p>
            <br>
            <p>adresse stagiaire : ' . $adresse_stagiaire . '</p>
            <br>
            <p>date naisance : ' . $date_naisance . '</p>
            <br>
            <p>Taille vêtment : haut-' . $taille_haut . ',  bas- '.$taille_bas.'</p>
            <br>
           <p> modalité d\'accueil : '.$modalite.'</p>

            <h4>Documents</h4>
            <div class="row">
                <div class="col">
                <h5>PDF Cert Medical/License ffbb</h5>
                <iframe src="' . $lien_cert_ed_licence_ffbb . '">
                </iframe>
                </div>
                <div class="col">
                <h5>PDF Consement publication photo</h5>
                <iframe src="' . $lien_consentement_photo . '">
                </iframe>
                </div>
                <div class="col">
                <h5>PDF <br> Securité social</h5>
                <iframe src="' . $lien_securite_social . '">
                </iframe>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                <h5>PDF Mutuelle</h5>
                <iframe src="' . $lien_mutuelle . '">
                </iframe>
                </div>
                <div class="col">
                <h5>PDF Fiche sanitaire</h5>
                <iframe src="' . $lien_fiche_sanitaire . '">
                </iframe>
                </div>
            </div>
            <br>
        </div>
    </div>
   
    </div>  ';
            
        } catch (PDOException $e) {
            echo "there was an error fetching subscriber information '.$e.'";
        }
        $conn = null;

        return $content_stagiaire;
    
}

add_shortcode('kipdev_affiche_stagiaire_par_id', 'kipdevAfficheSagiaire');
