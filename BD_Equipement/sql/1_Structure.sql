------------------------------------------------------------
--        Script Postgre
------------------------------------------------------------
CREATE EXTENSION IF NOT EXISTS postgis ;

------------------------------------------------------------
-- Schéma: bd_equipement
------------------------------------------------------------

DROP SCHEMA IF EXISTS bd_equipement CASCADE ;
CREATE SCHEMA bd_equipement ;

------------------------------------------------------------
-- Domaine: Générale
------------------------------------------------------------

-- Table: categorie
CREATE TABLE bd_equipement.categorie(
	cate_id			SERIAL NOT NULL,
	cate_libe		VARCHAR (50),
	CONSTRAINT prk_constraint_categorie PRIMARY KEY (cate_id)
)WITHOUT OIDS;


------------------------------------------------------------
-- Domaine: communication
------------------------------------------------------------

-- Table: panneau
CREATE TABLE bd_equipement.panneau(
	pann_id					SERIAL NOT NULL,
	pann_date_enre			TIMESTAMP,
	pann_date_amgt			DATE,
	pann_prec				VARCHAR (50),
	pann_comm				TEXT,
	pann_geom				geometry(Geometry, 2154),
	pann_type_pann_id		INT,
	pann_etat_comm_id		INT,
	pann_site_cen_id		VARCHAR (12),
	CONSTRAINT prk_constraint_panneau PRIMARY KEY (pann_id)
)WITHOUT OIDS;

-- Table: type_panneau
CREATE TABLE bd_equipement.type_panneau(
	type_pann_id		SERIAL NOT NULL,
	type_pann_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_panneau PRIMARY KEY (type_pann_id)
)WITHOUT OIDS;

-- Table: photo
CREATE TABLE bd_equipement.photo(
	photo_id				SERIAL NOT NULL,
	photo_lien				VARCHAR (280),
	photo_date_enre			TIMESTAMP ,
	photo_pann_id			INT,
	CONSTRAINT prk_constraint_photo PRIMARY KEY (photo_id)
)WITHOUT OIDS;

-- Table: piece_jointe
CREATE TABLE bd_equipement.piece_jointe(
	piec_join_id				SERIAL NOT NULL,
	piec_join_lien				VARCHAR (280),
	piec_join_date_enre			TIMESTAMP ,
	piec_join_type_piec_join_id	INT,
	piec_join_pann_id			INT,
	CONSTRAINT prk_constraint_piece_jointe PRIMARY KEY (piec_join_id)
)WITHOUT OIDS;

-- Table: type_piece_jointe
CREATE TABLE bd_equipement.type_piece_jointe(
	type_piec_join_id		SERIAL NOT NULL,
	type_piec_join_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_piece_jointe PRIMARY KEY (type_piec_join_id)
)WITHOUT OIDS;


-- Table: sentier
CREATE TABLE bd_equipement.sentier(
	sent_id				SERIAL NOT NULL,
	sent_date_enre		TIMESTAMP,
	sent_date_amgt		DATE,
	sent_acces_pmr		BOOL,
	sent_comm			TEXT,
	sent_geom			geometry(Geometry, 2154),
	sent_type_sent_id	INT,
	sent_type_chem_id	INT,
	sent_diff_id		INT,
	sent_etat_comm_id	INT,
	sent_site_cen_id	VARCHAR (12),
	CONSTRAINT prk_constraint_sentier_pedagogique PRIMARY KEY (sent_id)
)WITHOUT OIDS;

-- Table: type_sentier
CREATE TABLE bd_equipement.type_sentier(
	type_sent_id		SERIAL NOT NULL,
	type_sent_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_sentier PRIMARY KEY (type_sent_id)
)WITHOUT OIDS;

-- Table: type_cheminement
CREATE TABLE bd_equipement.type_cheminement(
	type_chem_id		SERIAL NOT NULL,
	type_chem_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_cheminement PRIMARY KEY (type_chem_id)
)WITHOUT OIDS;

-- Table: difficulte
CREATE TABLE bd_equipement.difficulte(
	diff_id			SERIAL NOT NULL,
	diff_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_difficulte PRIMARY KEY (diff_id)
)WITHOUT OIDS;


-- Table: support_communication
CREATE TABLE bd_equipement.support_communication(
	supp_comm_id				SERIAL NOT NULL,
	supp_comm_lien				VARCHAR (280),
	supp_comm_date_enre				TIMESTAMP ,
	supp_comm_type_supp_comm_id	INT,
	supp_comm_equi_id			INT,
	CONSTRAINT prk_constraint_support_communication PRIMARY KEY (supp_comm_id)
)WITHOUT OIDS;

-- Table: type_support_communication
CREATE TABLE bd_equipement.type_support_communication(
	type_supp_comm_id		SERIAL NOT NULL,
	type_supp_comm_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_support_communication PRIMARY KEY (type_supp_comm_id)
)WITHOUT OIDS;


-- Table: etat_communication
CREATE TABLE bd_equipement.etat_communication(
	etat_comm_id		SERIAL NOT NULL,
	etat_comm_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_etat_communication PRIMARY KEY (etat_comm_id)
)WITHOUT OIDS;


-- Table: autre_amenagement_communication/valorisation
CREATE TABLE bd_equipement.autre_amenagement_communication(
	autr_amen_comm_id						SERIAL NOT NULL,
	autr_amen_comm_date_enre				TIMESTAMP,
	autr_amen_comm_date_amgt				DATE,
	autr_amen_comm_comm						TEXT,
	autr_amen_comm_geom						geometry(Geometry, 2154),
	autr_amen_comm_type_autr_amen_comm_id	INT,
	autr_amen_comm_etat_comm_id						INT,
	autr_amen_comm_site_cen_id				VARCHAR (12),
	CONSTRAINT prk_constraint_autre_amenagement_communication PRIMARY KEY (autr_amen_comm_id)
)WITHOUT OIDS;

-- Table: type_autre_amenagement_communication
CREATE TABLE bd_equipement.type_autre_amenagement_communication(
	type_autr_amen_comm_id		SERIAL NOT NULL,
	type_autr_amen_comm_libe	VARCHAR (50),
	CONSTRAINT prk_constraint_type_autre_amenagement_communication PRIMARY KEY (type_autr_amen_comm_id)
)WITHOUT OIDS;


------------------------------------------------------------
-- Domaine: zootechnie
------------------------------------------------------------

-- Table: cloture
CREATE TABLE bd_equipement.cloture(
	clot_id					SERIAL NOT NULL,
	clot_date_enre			TIMESTAMP,
	clot_date_amgt			DATE,
	clot_partiel			BOOL,
	clot_comm				TEXT,
	clot_geom				geometry(Geometry, 2154),
	clot_type_mobi_id		INT,
	clot_type_fils_id		INT,
	clot_type_pote_id		INT,
	clot_etat_zoot_id		INT,
	clot_site_cen_id		VARCHAR (12),
	CONSTRAINT prk_constraint_cloture PRIMARY KEY (clot_id)
)WITHOUT OIDS;

-- Table: type_fils
CREATE TABLE bd_equipement.type_fils(
	type_fils_id		SERIAL NOT NULL,
	type_fils_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_fils PRIMARY KEY (type_fils_id)
)WITHOUT OIDS;

-- Table: type_poteau
CREATE TABLE bd_equipement.type_poteau(
	type_pote_id		SERIAL NOT NULL,
	type_pote_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_poteau PRIMARY KEY (type_pote_id)
)WITHOUT OIDS;


-- Table: barriere
CREATE TABLE bd_equipement.barriere(
	barr_id					SERIAL NOT NULL,
	barr_date_enre			TIMESTAMP,
	barr_date_amgt			DATE,
	barr_dime				INT,
	barr_cade_perm			BOOL,
	barr_comm				TEXT,
	barr_geom				geometry(Geometry, 2154),
	barr_type_mobi_id		INT,
	barr_type_stru_id		INT,
	barr_etat_zoot_id		INT,
	barr_site_cen_id		VARCHAR (12),
	CONSTRAINT prk_constraint_barriere PRIMARY KEY (barr_id)
)WITHOUT OIDS;

-- Table: type_structure
CREATE TABLE bd_equipement.type_structure(
	type_stru_id		SERIAL NOT NULL,
	type_stru_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_structure PRIMARY KEY (type_stru_id)
)WITHOUT OIDS;


-- Table: etat_zootechnie
CREATE TABLE bd_equipement.etat_zootechnie(
	etat_zoot_id		SERIAL NOT NULL,
	etat_zoot_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_etat_zootechnie PRIMARY KEY (etat_zoot_id)
)WITHOUT OIDS;


-- Table: type_mobilite
CREATE TABLE bd_equipement.type_mobilite(
	type_mobi_id		SERIAL NOT NULL,
	type_mobi_libe		VARCHAR (25),
	CONSTRAINT prk_constraint_type_cloture PRIMARY KEY (type_mobi_id)
)WITHOUT OIDS;


-- Table: autre_amenagement_zootechnie/gestion
CREATE TABLE bd_equipement.autre_amenagement_zootechnie(
	autr_amen_zoot_id						SERIAL NOT NULL,
	autr_amen_zoot_date_enre				TIMESTAMP,
	autr_amen_zoot_date_amgt				DATE,
	autr_amen_zoot_comm						TEXT,
	autr_amen_zoot_geom						geometry(Geometry, 2154),
	autr_amen_zoot_type_autr_amen_zoot_id	INT,
	autr_amen_zoot_etat_zoot_id						INT,
	autr_amen_zoot_site_cen_id				VARCHAR (12),
	CONSTRAINT prk_constraint_autre_amenagement_zootechnie PRIMARY KEY (autr_amen_zoot_id)
)WITHOUT OIDS;

-- Table: type_autre_amenagement_zootechnie
CREATE TABLE bd_equipement.type_autre_amenagement_zootechnie(
	type_autr_amen_zoot_id		SERIAL NOT NULL,
	type_autr_amen_zoot_libe	VARCHAR (25),
	CONSTRAINT prk_constraint_type_autre_amenagement_zootechnie PRIMARY KEY (type_autr_amen_zoot_id)
)WITHOUT OIDS;

/*
------------------------------------------------------------
-- Schéma: md
------------------------------------------------------------

DROP SCHEMA IF EXISTS md CASCADE ;
CREATE SCHEMA md ;

------------------------------------------------------------
-- Domaine: Générale
------------------------------------------------------------

-- Table: site_cenhn
CREATE TABLE md.site_cenhn (
  "ID"				CHARACTER VARYING NOT NULL,
  geom				geometry(MultiPolygon,2154),
  "Nom_Site"	CHARACTER VARYING(254),
  commune			CHARACTER VARYING,
  CONSTRAINT site_cenhn_pkey PRIMARY KEY ("ID")
);
*/
