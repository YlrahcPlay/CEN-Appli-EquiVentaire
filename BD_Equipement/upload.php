<?php
	include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
	header('Content-type: text/html; charset=utf8'); // Ici c'est de l'utf8

	// Fonction pour l'upload de fichier image ou pdf
	function uploadFile($objet, $destination) { // Argument : Type & lieu d'enregistrement
		$File = $_FILES[$objet];
		var_dump($File);

		if ($File['error'] == 0) {
			if ($File['size'] < 2100000) { // Si taille du fichier inférieur à 2Mo
				$FileExtension = strtolower(pathinfo($File['name'],PATHINFO_EXTENSION)); // nom de l'extension

				$FileNewName = time(); // Récup du temps

				if (in_array($FileExtension, array('jpg', 'jpeg', 'png'))) { // Si l'extension du fichier correspond
					$File['name'] = $FileNewName .".jpg"; // Création du nouveau nom

					//Création d'une copie de l'image à redimensionner
					if ($FileExtension == 'jpg' || $FileExtension == 'jpeg') {
						$ImageChoisie = imagecreatefromjpeg($File['tmp_name']);
					}
					elseif ($FileExtension == 'png') {
						$ImageChoisie = imagecreatefrompng($File['tmp_name']);
					};

					// Récupération des dimensions de l'image de départ
					$TailleImageChoisie = getimagesize($File['tmp_name']);
					// Définition d'une nouvelle taille
					$NouvelleLargeur = 800; //Largeur choisie à 800 px mais modifiable
					$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );

					// Redimensionnage de notre image
					$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
					imagecopyresampled($NouvelleImage, $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

					// Création de miniature pour les photos
					if ($objet == 'photo') {
						$MiniLargeur = 200;
						$MiniHauteur = ( ($TailleImageChoisie[1] * (($MiniLargeur)/$TailleImageChoisie[0])) );

						$Miniature = imagecreatetruecolor($MiniLargeur , $MiniHauteur) or die ("Erreur");
						imagecopyresampled($Miniature, $ImageChoisie, 0, 0, 0, 0, $MiniLargeur , $MiniHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

						imagejpeg($Miniature, $destination."miniature/mini_".$File['name'], 100);
					};

					// Suppression du fichier image que l'on veux plus
					imagedestroy($ImageChoisie);

					// Création de la nouvelle image à l'emplacement voulu.
					imagejpeg($NouvelleImage , $destination.$File['name'], 100);
					$FileLink = $destination.$File['name']; // Création du lien
				}
				elseif ($objet != 'photo' && $FileExtension == 'pdf') {
					$File['name'] = $FileNewName .".pdf"; // Création du nouveau nom

					move_uploaded_file($File['tmp_name'], $destination.$File['name']); //  Déplacement du fichier
					// var_dump($File['error']);
					$FileLink = $destination.$File['name']; // Création du lien
				}
				else { // Message d'erreur si les extensions de format ne sont pas respecté
					if ($objet != 'photo') {
						echo ("<br/><span style=\"background: #F00; color: #FFF;\">Seul les .jpg, .jpeg, .png et .pdf sont accepté.</span>");
					}
					else {
						echo ("<br/><span style=\"background: #F00; color: #FFF;\">Seul les .jpg, .jpeg et .png sont accepté.</span>");
					}
				};
			}
			else { // Message d'erreur si la taille du fichier n'est pas respecté
				$tailleMo = round($File['size']/(1024*1024),2);
				echo("<br/><span style=\"background: #F00; color: #FFF;\">La taille étant limité à 2Mo, le fichier spécifié est trop gros : ".$tailleMo." Mo</span>");
			};
		}
		elseif ($File['error'] == 1) {
			echo("<br/><span style=\"background: #F00; color: #FFF;\">La taille étant limité à 2Mo, le fichier spécifié est trop gros.</span>");
		}
		else {
			echo("<br/><span style=\"background: #F00; color: #FFF;\">Le chargement a échoué, <br/>contacter le responsable informatique pour le résoudre.</span>");
		};

		// Si un lien a été créé, création de la requette sql
		if (isset($FileLink)) {
			if ($objet == 'photo') {
				$categorie = 1; // Il s'agit d'un panneau
				$type = 1; // Il s'agit d'une photo
				$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_cate_id, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES(E'".$FileLink."', ".$categorie.", ".$type.", to_timestamp('".$FileNewName."'))";
			}
			elseif ($objet == 'contenu' || $objet == 'flashCode') {
				$categorie = $_GET['categorie']; // Il s'agit d'un panneau

				if ($objet == 'contenu') {
					$type = 2;
				}
				elseif ($objet == 'flashCode') {
					$type = 3;
				};

				$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_cate_id, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES(E'".$FileLink."', ".$categorie.", ".$type.", to_timestamp('".$FileNewName."'))";
			}
			elseif ($objet == 'plaquette') {
				$categorie = 2; // Il s'agit d'un sentier
				$type = 4;
				$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_cate_id, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES(E'".$FileLink."', ".$categorie.", ".$type.", to_timestamp('".$FileNewName."'))";
			};

			return array("sql" => $sql, "FileNewName" => $FileNewName); // Retour de la requête et de l'id
		};
	};






	// Répartition des actions lors de l'appel d' upload.php
	// Si c'est une photo
	if (isset($_FILES['photo'])) {
		$objet = "photo";
		$res = uploadFile($objet, 'doc/photo/'); // Appel de la fonction
		$sql = $res['sql'];
		$FileNewName = $res['FileNewName'];
	}
	elseif (isset($_FILES['contenu'])) {
		$objet = "contenu";
		$res = uploadFile($objet, 'doc/contenu/');
		$sql = $res['sql'];
		$FileNewName = $res['FileNewName'];
	}
	elseif (isset($_FILES['flashCode'])) {
		$objet = "flashCode";
		$res = uploadFile($objet, 'doc/flashCode/');
		$sql = $res['sql'];
		$FileNewName = $res['FileNewName'];
	}
	elseif (isset($_FILES['plaquette'])) {
		$objet = "plaquette";
		$res = uploadFile($objet, 'doc/plaquette/');
		$sql = $res['sql'];
		$FileNewName = $res['FileNewName'];
	}
	// Si c'est un site internet ou une application, Création de la requête sql
	elseif (isset($_POST['SiteInternet']) || isset($_POST['application'])) {
		if ($_POST['SiteInternet'] != '' || $_POST['application'] != '') {
			$categorie = $_GET['categorie'];

			if (isset($_POST['SiteInternet'])) {
				$objet = "SiteInternet";
				$type = 5;
				$FileLink = $_POST['SiteInternet'];

			}
			elseif (isset($_POST['application'])) {
				$objet = "Application";
				$type = 6;
				$FileLink = addslashes($_POST['application']);
			};

			$FileNewName = time();

			$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_cate_id, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES(E'".$FileLink."', ".$categorie.", ".$type.", to_timestamp('".$FileNewName."'))";
		}
		else {
			echo("<br/>Insérez un lien");
		}
	}
	else {
		echo("<br/>Inserez un fichier");
	};

	// Si une requête sql existe
	if (isset($sql)) {
		$req = pg_query($dbConnect, $sql); // Execution de la requête
		echo("<br/>" .ucfirst($objet) ." enregistré.");

		// Ajout à la table de liaison
		$tableLiaison = $_GET['tableLiaison'];
		$sql = "INSERT INTO bd_equipement.".$tableLiaison."(liai_fich_id, liai_obje) VALUES(to_timestamp('".$FileNewName."'), '".$objet."')";
		$req = pg_query($dbConnect, $sql); // Exécution de la requête
	};

	pg_close(); // Fermeture de l'accès à la base de donnée
?>
