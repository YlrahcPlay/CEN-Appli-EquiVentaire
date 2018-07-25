------------------------------------------------------------
-- Fonction d'enrgistrement
------------------------------------------------------------

-- Verification de la géométrie
CREATE OR REPLACE FUNCTION bd_equipement.verification(objet VARCHAR, this_geom GEOMETRY) RETURNS INT AS $$
DECLARE
	error		INTEGER;
	in_site		BOOLEAN;
	in_out_site	BOOLEAN;
	distance	INTEGER;

BEGIN

	SELECT DISTINCT ST_CoveredBy(this_geom, ST_Buffer(geom, 100)) INTO in_site
		FROM md.site_cenhn
		WHERE ST_CoveredBy(this_geom, ST_Buffer(geom, 100)) ;

	IF (in_site = TRUE) THEN
		error := 0;

	ELSE
		error := -11;

		IF (objet = 'sentier' OR objet = 'cloture') THEN
			SELECT ST_Intersects(this_geom, ST_Buffer(geom, 100)) INTO in_out_site
				FROM md.site_cenhn
				WHERE ST_Intersects(this_geom, ST_Buffer(geom, 100)) AND categorie = 1;

			IF (in_out_site = TRUE) THEN
				error := -12;
			END IF;
		END IF;
	END IF;

	RETURN error;
END;
$$ LANGUAGE plpgsql;

-- Panneau Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.panneau(modif BOOLEAN, this_geom GEOMETRY, id INT, type INT, precis VARCHAR, date_amgt DATE, etat INT, commentaire TEXT) RETURNS VOID AS $$
DECLARE
	nb_fichier 	INTEGER;

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.panneau
		SET pann_type_pann_id = type
		  , pann_prec = precis
		  , pann_date_amgt = date_amgt
		  , pann_etat_comm_id = etat
		  , pann_comm = commentaire
		WHERE pann_id = id ;

	ELSE
		INSERT INTO bd_equipement.panneau(pann_type_pann_id, pann_prec, pann_date_amgt, pann_etat_comm_id, pann_comm, pann_geom)
		VALUES(type, precis, date_amgt, etat, commentaire, this_geom);

	END IF;
END;
$$ LANGUAGE plpgsql;
-- Panneau Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_panneau() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT pann_id AS id, pann_geom AS geom
		FROM bd_equipement.panneau
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.panneau
	SET pann_site_cen_id = equip_site."ID"
	  , pann_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE pann_id = rec.id
	;
	
	RETURN NULL;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_panneau AFTER INSERT ON bd_equipement.panneau
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_panneau();


-- Sentier Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.sentier(modif BOOLEAN, this_geom GEOMETRY, id INT, type_sentier INT, type_cheminement INT, date_amgt DATE, etat INT, pmr BOOLEAN, difficulte INT, commentaire TEXT) RETURNS VOID AS $$
DECLARE
	nb_fichier	INTEGER;

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.sentier
        SET sent_type_sent_id = type_sentier
          , sent_type_chem_id = type_cheminement
          , sent_date_amgt = date_amgt
          , sent_etat_comm_id = etat
          , sent_acces_pmr = pmr
          , sent_diff_id = difficulte
          , sent_comm = commentaire
        WHERE sent_id = id;

	ELSE
		INSERT INTO bd_equipement.sentier(sent_type_sent_id, sent_type_chem_id, sent_date_amgt, sent_etat_comm_id, sent_acces_pmr, sent_diff_id, sent_comm, sent_geom)
		VALUES(type_sentier, type_cheminement, date_amgt, etat, pmr, difficulte, commentaire, this_geom);

	END IF;
END;
$$ LANGUAGE plpgsql;
-- Sentier Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_sentier() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT sent_id AS id, sent_geom AS geom
		FROM bd_equipement.sentier
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.sentier
	SET sent_site_cen_id = equip_site."ID"
	  , sent_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE sent_id = rec.id
	;

	RETURN NULL;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_sentier AFTER INSERT ON bd_equipement.sentier
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_sentier();


-- Autre Aménagement de Valorisation Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.autre_amenagement_communication(modif BOOLEAN, this_geom GEOMETRY, id INT, type INT, date_amgt DATE, etat INT, commentaire TEXT) RETURNS VOID AS $$

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.autre_amenagement_communication
        SET autr_amen_comm_type_autr_amen_comm_id = type
		  , autr_amen_comm_date_amgt = date_amgt
		  , autr_amen_comm_etat_comm_id = etat
		  , autr_amen_comm_comm = commentaire
        WHERE autr_amen_comm_id = id;

	ELSE
		INSERT INTO bd_equipement.autre_amenagement_communication(autr_amen_comm_type_autr_amen_comm_id, autr_amen_comm_date_amgt, autr_amen_comm_etat_comm_id, autr_amen_comm_comm, autr_amen_comm_geom)
		VALUES(type, date_amgt, etat, commentaire, this_geom);

	END IF;
END;
$$ LANGUAGE plpgsql;
-- Autre Aménagement de Valorisation Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_autre_amenagement_communication() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT autr_amen_comm_id AS id, autre_amen_comm_geom AS geom
		FROM bd_equipement.autre_amenagement_communication
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.autre_amenagement_communication
	SET autr_amen_comm_site_cen_id = equip_site."ID"
	  , autr_amen_comm_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE autr_amen_comm_site_cen_id = rec.id
	;

	RETURN NULL;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_autre_amenagement_communication AFTER INSERT ON bd_equipement.autre_amenagement_communication
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_autre_amenagement_communication();


-- Clôture Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.cloture(modif BOOLEAN, this_geom GEOMETRY, id INT, type_mobilite INT, type_fils INT, type_poteau INT, date_amgt DATE, partiel BOOLEAN, etat INT, commentaire TEXT) RETURNS VOID AS $$

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.cloture
        SET clot_type_mobi_id = type_mobilite
          , clot_type_fils_id = type_fils
          , clot_type_pote_id = type_poteau
          , clot_date_amgt = date_amgt
          , clot_partiel = partiel
          , clot_etat_zoot_id = etat
		  , clot_comm = commentaire
        WHERE clot_id = id;

	ELSE
		INSERT INTO bd_equipement.cloture(clot_type_mobi_id , clot_type_fils_id , clot_type_pote_id , clot_date_amgt , clot_partiel , clot_etat_zoot_id, clot_comm, clot_geom)
		VALUES(type_mobilite, type_fils, type_poteau, date_amgt, partiel, etat, commentaire, this_geom);

	END IF;
END;
$$ LANGUAGE plpgsql;
-- Clôture Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_cloture() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT clot_id AS id, clot_geom AS geom
		FROM bd_equipement.cloture
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.cloture
	SET clot_site_cen_id = equip_site."ID"
	  , clot_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE clot_id = rec.id
	;

	RETURN NULL;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_cloture AFTER INSERT ON bd_equipement.cloture
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_cloture();


-- Barrière Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.barriere(modif BOOLEAN, this_geom GEOMETRY, id INT, type_mobilite INT, type_structure INT, dimension INT, date_amgt DATE, cadenasPerm BOOLEAN, etat INT, commentaire TEXT) RETURNS INT AS $$
DECLARE
	distance	INTEGER;

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.barriere
        SET barr_type_mobi_id = type_mobilite
		  , barr_type_stru_id = type_structure
          , barr_dime = dimension
		  , barr_date_amgt = date_amgt
          , barr_cade_perm = cadenasPerm
          , barr_etat_zoot_id = etat
		  , barr_comm = commentaire
        WHERE barr_id = id;

	ELSE
		IF (type_mobilite = 1) THEN
			SELECT ST_Distance(this_geom, clot_geom) AS dist INTO distance
				FROM bd_equipement.cloture
				ORDER BY dist
				LIMIT 1;

			IF (distance > 20) THEN
				RETURN -20;
			END IF;
		END IF;

		INSERT INTO bd_equipement.barriere(barr_type_mobi_id, barr_type_stru_id, barr_dime, barr_date_amgt, barr_cade_perm, barr_etat_zoot_id, barr_comm, barr_geom)
		VALUES(type_mobilite, type_structure, dimension, date_amgt, cadenasPerm, etat, commentaire, this_geom);

	END IF;

	RETURN 0;
END;
$$ LANGUAGE plpgsql;
-- Barrière Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_barriere() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT barr_id AS id, barr_geom AS geom
		FROM bd_equipement.barriere
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.barriere
	SET barr_site_cen_id = equip_site."ID"
	  , barr_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE barr_id = rec.id
	;

	RETURN NULL;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_barriere AFTER INSERT ON bd_equipement.barriere
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_barriere();


-- Autre Aménagement de Gestion Fonction Rec
CREATE OR REPLACE FUNCTION bd_equipement.autre_amenagement_zootechnie(modif BOOLEAN, this_geom GEOMETRY, id INT, type INT, date_amgt DATE, etat INT, commentaire TEXT) RETURNS INT AS $$
DECLARE
	distance	INTEGER;

BEGIN

	IF (modif = TRUE) THEN
		UPDATE bd_equipement.autre_amenagement_zootechnie
        SET autr_amen_zoot_type_autr_amen_zoot_id = type
		  , autr_amen_zoot_date_amgt = date_amgt
		  , autr_amen_zoot_etat_zoot_id = etat
		  , autr_amen_zoot_comm = commentaire
        WHERE autr_amen_zoot_id = id;

	ELSE
		IF (type = 6) THEN
			SELECT ST_Distance(this_geom, clot_geom) AS dist INTO distance
				FROM bd_equipement.cloture
				ORDER BY dist
				LIMIT 1 ;

			IF (distance > 20) THEN
				RETURN -20;
			END IF;
		END IF;

		INSERT INTO bd_equipement.autre_amenagement_zootechnie(autr_amen_zoot_type_autr_amen_zoot_id, autr_amen_zoot_date_amgt, autr_amen_zoot_etat_zoot_id, autr_amen_zoot_comm, autr_amen_zoot_geom)
		VALUES(type, date_amgt, etat, commentaire, this_geom);

	END IF;

	RETURN 0;

END;
$$ LANGUAGE plpgsql;
-- Autre Aménagement de Gestion Trigger Site
CREATE OR REPLACE FUNCTION bd_equipement.site_autre_amenagement_zootechnie() RETURNS TRIGGER AS $$

BEGIN

	WITH enregistrement AS (
		SELECT autr_amen_zoot_id AS id, autre_amen_zoot_geom AS geom
		FROM bd_equipement.autre_amenagement_zootechnie
		ORDER BY id DESC
		LIMIT 1
	),
	site AS (
		SELECT "ID", geom, ST_Buffer(ST_Simplify(geom, 0.1), 100) AS buffer_geom
		FROM md.site_cenhn
		WHERE categorie = 1
	),
	equip_site AS (
		SELECT "ID", ST_Distance(rec.geom, site.geom) AS dist
		FROM enregistrement AS rec, site
		WHERE ST_Intersects(rec.geom, site.buffer_geom)
		ORDER BY dist
		LIMIT 1
	)
	UPDATE bd_equipement.autre_amenagement_zootechnie
	SET autr_amen_zoot_site_cen_id = equip_site."ID"
	  , autr_amen_zoot_date_enre = now()
	FROM enregistrement AS rec, equip_site
	WHERE autr_amen_zoot_site_cen_id = rec.id
	;

	RETURN NULL;


END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER site_autre_amenagement_zootechnie AFTER INSERT ON bd_equipement.autre_amenagement_zootechnie
FOR EACH ROW EXECUTE PROCEDURE bd_equipement.site_autre_amenagement_zootechnie();





-- Suppression
CREATE OR REPLACE FUNCTION bd_equipement.suppression(objet VARCHAR, id_objet INT) RETURNS INT AS $$
DECLARE
	nbVingtBarrClot INTEGER;
	nbVingtPaHoClot INTEGER;
	error 			INTEGER;

BEGIN
	error := 0;

	IF (objet = 'panneau') THEN
		DELETE FROM bd_equipement.panneau WHERE pann_id = id_objet;

	ELSIF (objet = 'sentier') THEN
		DELETE FROM bd_equipement.sentier WHERE sent_id = id_objet;

	ELSIF (objet = 'autreamgtcomm') THEN
		DELETE FROM bd_equipement.autre_amenagement_communication WHERE autr_amen_comm_id = id_objet;

	ELSIF (objet = 'cloture') THEN
		SELECT COUNT(*) INTO nbVingtBarrClot FROM bd_equipement.barriere, bd_equipement.cloture WHERE ST_Distance(barr_geom, clot_geom) < 20 AND clot_id = id_objet;
		SELECT COUNT(*) INTO nbVingtPaHoClot FROM bd_equipement.autre_amenagement_zootechnie, bd_equipement.cloture WHERE autr_amen_zoot_type_autr_amen_zoot_id = 6 AND ST_Distance(autr_amen_zoot_geom, clot_geom) < 20 AND clot_id = id_objet;

		IF (nbVingtBarrClot = 0 AND nbVingtPaHoClot = 0) THEN
			DELETE FROM bd_equipement.cloture WHERE clot_id = id_objet;
		ELSE
			error = -1;
		END IF;

	ELSIF (objet = 'barriere') THEN
		DELETE FROM bd_equipement.barriere WHERE barr_id = id_objet;

	ELSIF (objet = 'autreamgtzoot') THEN
		DELETE FROM bd_equipement.autre_amenagement_zootechnie WHERE autr_amen_zoot_id = id_objet;

	END IF;

	RETURN error;

END;
$$ LANGUAGE plpgsql;
