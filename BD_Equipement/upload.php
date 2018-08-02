<?php
	include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
	header('Content-type: text/html; charset=utf8'); // Ici c'est de l'utf8

	// Fonction pour l'upload de fichier image ou pdf
	function uploadFile($objet, $destination) { // Argument : Type & lieu d'enregistrement
		$File = $_FILES[$objet];
		var_dump($File);

		if ($File['size'] < 2000000) { // Si taille du fichier inférieur à 2Mo
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
				var_dump($File['error']);
				$FileLink = $destination.$File['name']; // Création du lien
			}
			else { // Message d'erreur si les extensions de format ne sont pas respecté
				if ($objet != 'photo') {
					echo ("<br/><span style=\"background/ #F00; color: #FFF;\">Seul les .jpg, .jpeg, .png et .pdf sont accepté.</span>");
				}
				else {
					echo ("<br/><span style=\"background/ #F00; color: #FFF;\">Seul les .jpg, .jpeg et .png sont accepté.</span>");
				}
			};
		}
		else { // Message d'erreur si la taille du fichier n'est pas respecté
			$tailleMo = $_FILES[$objet]['size']/1000*1000;
			echo("<br/><span style=\"background/ #F00; color: #FFF;\">La taille étant limité à 2Mo, le fichier spécifié est trop gros : ".$tailleMo." Mo</span>");
		};

		// Si un lien a été créé, création de la requette sql
		if (isset($FileLink)) {
			if ($objet == 'photo') {
				$sql = "INSERT INTO bd_equipement.photo(photo_lien, photo_date_enre) VALUES('".$FileLink."', to_timestamp('".$FileNewName."'))";
			}
			elseif ($objet == 'contenu' || $objet == 'flashCode') {
				if ($objet == 'contenu') {
					$type = 1;
				}
				elseif ($objet == 'flashCode') {
					$type = 2;
				};

				$sql = "INSERT INTO bd_equipement.piece_jointe(piec_join_lien, piec_join_type_piec_join_id, piec_join_date_enre) VALUES('".$FileLink."', ".$type.", to_timestamp('".$FileNewName."'))";
			}
			elseif ($objet == 'plaquette') {
				$type = 1;
				$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES('".$FileLink."', ".$type.", to_timestamp('".$FileNewName."'))";
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
	// Si c'est une pièce jointe
	elseif (isset($_FILES['contenu']) || isset($_FILES['flashCode']) || isset($_POST['PJSiteInternet'])) {
		if (isset($_FILES['contenu'])) {
			$objet = "contenu";
			$res = uploadFile($objet, 'doc/pieceJointe/contenu/');
			$sql = $res['sql'];
			$FileNewName = $res['FileNewName'];
		}
		elseif (isset($_FILES['flashCode'])) {
			$objet = "flashCode";
			$res = uploadFile($objet, 'doc/pieceJointe/flashCode/');
			$sql = $res['sql'];
			$FileNewName = $res['FileNewName'];
		}
		// Si c'est un site internet, Création de la requête sql
		elseif (isset($_POST['PJSiteInternet'])) {
			if ($_POST['PJSiteInternet'] == '') {
				echo "<br/>Insérez un lien internet";
			}
			else {
				$objet = "PJSiteInternet";
				$type = 3;
				$FileNewName = time();
				$FileLink = $_POST['PJSiteInternet'];

				$sql = "INSERT INTO bd_equipement.piece_jointe(piec_join_lien, piec_join_type_piec_join_id, piec_join_date_enre) VALUES('".$FileLink."', ".$type.", to_timestamp('".$FileNewName."'))";
			};
		};
	}
	// Si c'est un support de communication
	elseif (isset($_FILES['plaquette']) || isset($_POST['SCSiteInternet']) || isset($_POST['application'])) {
		if (isset($_FILES['plaquette'])) {
			$objet = "plaquette";
			$res = uploadFile($objet, 'doc/supportComm/');
			$sql = $res['sql'];
			$FileNewName = $res['FileNewName'];
		}
		elseif ((isset($_POST['SCSiteInternet']) AND $_POST['SCSiteInternet'] != '') || (isset($_POST['application']) AND $_POST['application'] != '')) {
			if (isset($_POST['SCSiteInternet'])) {
				$objet = "SCSiteInternet";
				$type = 2;
				$FileLink = $_POST['SCSiteInternet'];
			}
			elseif (isset($_POST['application'])) {
				$objet = "application";
				$type = 3;
				$FileLink = addslashes($_POST['application']);
			}

			$FileNewName = time();

			$sql = "INSERT INTO bd_equipement.support_communication(supp_comm_lien, supp_comm_type_supp_comm_id, supp_comm_date_enre) VALUES(E'".$FileLink."', ".$type.", to_timestamp('".$FileNewName."'))";
		}
		else {
			echo("<br/>Insérez un lien");
		};
	}
	else {
		echo("<br/>Inserez un fichier");
	};

	// Si une requête sql exisite
	if (isset($sql)) {
		$req = pg_query($dbConnect, $sql); // Execution de la requête
		echo("<br/>" .ucfirst($objet) ." enregistré.");

		// Si c'est une pièce jointe
		if ($objet == 'contenu' || $objet == 'flashCode' || $objet == 'PJSiteInternet') {
			$objet = "piece_jointe";
		}
		// Si c'est un support de communcation
		elseif ($objet == 'plaquette' || $objet == 'SCSiteInternet' || $objet == 'application') {
			$objet = "support_communication";
		};

		// Ajout à la table de liaison
		$tableLiaison = $_GET['tableLiaison'];
		$sql = "INSERT INTO bd_equipement.".$tableLiaison."(liai_fich_id, liai_obje) VALUES(to_timestamp('".$FileNewName."'), '".$objet."')";
		$req = pg_query($dbConnect, $sql); // Exécution de la requête
	};

	pg_close(); // Fermeture de l'accès à la base de donnée
?>
