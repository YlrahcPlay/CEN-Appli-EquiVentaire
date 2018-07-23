------------------------------------------------------------
-- Domaine: Générale
------------------------------------------------------------

-- Table: Categorie
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (1, 'Panneau', 1);
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (2, 'Sentier', 1);
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (3, 'Autre Aménagement de Valorisation', 1);
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (4, 'Clôture', 2);
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (5, 'Barrière', 2);
INSERT INTO bd_equipement.categorie (cate_id, cate_libe, cate_doma_id) VALUES (6, 'Autre Aménagement de Gestion', 2);


------------------------------------------------------------
-- Domaine: Communication
------------------------------------------------------------

-- Table: type_panneau
INSERT INTO bd_equipement.type_panneau (type_pann_id, type_pann_libe) VALUES (1, 'Accueil');
INSERT INTO bd_equipement.type_panneau (type_pann_id, type_pann_libe) VALUES (2, 'Pédagogique');
INSERT INTO bd_equipement.type_panneau (type_pann_id, type_pann_libe) VALUES (3, 'Site Préservé');
INSERT INTO bd_equipement.type_panneau (type_pann_id, type_pann_libe) VALUES (4, 'Financeur');
INSERT INTO bd_equipement.type_panneau (type_pann_id, type_pann_libe) VALUES (5, 'Autre');

-- Table: type_piece_jointe
INSERT INTO bd_equipement.type_piece_jointe (type_piec_join_id, type_piec_join_libe) VALUES (1, 'Contenu');
INSERT INTO bd_equipement.type_piece_jointe (type_piec_join_id, type_piec_join_libe) VALUES (2, 'Flash-Code');
INSERT INTO bd_equipement.type_piece_jointe (type_piec_join_id, type_piec_join_libe) VALUES (3, 'Site Internet');


-- Table: type_sentier
INSERT INTO bd_equipement.type_sentier (type_sent_id, type_sent_libe) VALUES (1, 'PR');
INSERT INTO bd_equipement.type_sentier (type_sent_id, type_sent_libe) VALUES (2, 'GR');
INSERT INTO bd_equipement.type_sentier (type_sent_id, type_sent_libe) VALUES (3, 'CEN');
INSERT INTO bd_equipement.type_sentier (type_sent_id, type_sent_libe) VALUES (4, 'Communal');
INSERT INTO bd_equipement.type_sentier (type_sent_id, type_sent_libe) VALUES (5, 'Départemental');

-- Table: type_cheminement
INSERT INTO bd_equipement.type_cheminement (type_chem_id, type_chem_libe) VALUES (1, 'Piétinement');
INSERT INTO bd_equipement.type_cheminement (type_chem_id, type_chem_libe) VALUES (2, 'Végétation Dense');
INSERT INTO bd_equipement.type_cheminement (type_chem_id, type_chem_libe) VALUES (3, 'Stabilisé');
INSERT INTO bd_equipement.type_cheminement (type_chem_id, type_chem_libe) VALUES (4, 'Platelage en bois');
INSERT INTO bd_equipement.type_cheminement (type_chem_id, type_chem_libe) VALUES (5, 'Mixte');

-- Table: difficulte
INSERT INTO bd_equipement.difficulte (diff_id, diff_libe) VALUES (1, '¤');
INSERT INTO bd_equipement.difficulte (diff_id, diff_libe) VALUES (2, '¤¤');
INSERT INTO bd_equipement.difficulte (diff_id, diff_libe) VALUES (3, '¤¤¤');


-- Table: type_support_communication
INSERT INTO bd_equipement.type_support_communication (type_supp_comm_id, type_supp_comm_libe) VALUES (1, 'Plaquette');
INSERT INTO bd_equipement.type_support_communication (type_supp_comm_id, type_supp_comm_libe) VALUES (2, 'Site Internet');
INSERT INTO bd_equipement.type_support_communication (type_supp_comm_id, type_supp_comm_libe) VALUES (3, 'Application');


-- Table: etat_communication/valorisation
INSERT INTO bd_equipement.etat_communication (etat_comm_id, etat_comm_libe) VALUES (1, 'Bon');
INSERT INTO bd_equipement.etat_communication (etat_comm_id, etat_comm_libe) VALUES (2, 'Moyen');
INSERT INTO bd_equipement.etat_communication (etat_comm_id, etat_comm_libe) VALUES (3, 'Mauvais');
INSERT INTO bd_equipement.etat_communication (etat_comm_id, etat_comm_libe) VALUES (4, 'En réparation');


-- Table: type_autre_amenagement_communication
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (1, 'Observatoire');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (2, 'Marche');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (3, 'Panorama & Plateforme d''observation');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (4, 'Table d''orientation');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (5, 'Fléchage & Guidage');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (6, 'Eco-Compteur');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (7, 'Aire de décollage de parapente');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (8, 'Parking');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (9, 'Entrée de site');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (10, 'Passerelle');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (11, 'Table de pique-nique');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (12, 'Ludique');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (13, 'Banc');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (14, 'Borne à vélo');
INSERT INTO bd_equipement.type_autre_amenagement_communication (type_autr_amen_comm_id, type_autr_amen_comm_libe) VALUES (15, 'Escalier');


------------------------------------------------------------
-- Domaine: Zootechnie
------------------------------------------------------------

-- Table: type_fils
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (1, 'Barbelés');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (2, 'Fils Lisse');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (3, 'Ursus');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (4, 'Cyclone');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (5, 'Maille Torsadé');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (6, 'Maille Soudé');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (7, 'Eléctrique');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (8, 'Fils Torsadé');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (9, 'Grillage');
INSERT INTO bd_equipement.type_fils (type_fils_id, type_fils_libe) VALUES (10, 'Lisse en Bois (Ranch)');

-- Table: type_poteau
INSERT INTO bd_equipement.type_poteau (type_pote_id, type_pote_libe) VALUES (1, 'Bois');
INSERT INTO bd_equipement.type_poteau (type_pote_id, type_pote_libe) VALUES (2, 'Métal');
INSERT INTO bd_equipement.type_poteau (type_pote_id, type_pote_libe) VALUES (4, 'Mixte');
INSERT INTO bd_equipement.type_poteau (type_pote_id, type_pote_libe) VALUES (5, 'Béton');
INSERT INTO bd_equipement.type_poteau (type_pote_id, type_pote_libe) VALUES (6, 'Plastique');


-- Table: type_structure
INSERT INTO bd_equipement.type_structure (type_stru_id, type_stru_libe) VALUES (1, 'Tubulaire');
INSERT INTO bd_equipement.type_structure (type_stru_id, type_stru_libe) VALUES (2, 'Grillage avec Levier / Herbagère');
INSERT INTO bd_equipement.type_structure (type_stru_id, type_stru_libe) VALUES (3, 'Bois');
INSERT INTO bd_equipement.type_structure (type_stru_id, type_stru_libe) VALUES (4, 'Porte Grillagée');
INSERT INTO bd_equipement.type_structure (type_stru_id, type_stru_libe) VALUES (5, 'Portail métalique');


-- Table: etat_zootechnie/gestion
INSERT INTO bd_equipement.etat_zootechnie (etat_zoot_id, etat_zoot_libe) VALUES (1, 'Bon');
INSERT INTO bd_equipement.etat_zootechnie (etat_zoot_id, etat_zoot_libe) VALUES (2, 'Ponctuellement Dégradé');
INSERT INTO bd_equipement.etat_zootechnie (etat_zoot_id, etat_zoot_libe) VALUES (3, 'Partiellement Dégradé');
INSERT INTO bd_equipement.etat_zootechnie (etat_zoot_id, etat_zoot_libe) VALUES (4, 'Dégradé');
INSERT INTO bd_equipement.etat_zootechnie (etat_zoot_id, etat_zoot_libe) VALUES (5, 'Détruit');


-- Table: type_mobilite
INSERT INTO bd_equipement.type_mobilite (type_mobi_id, type_mobi_libe) VALUES (1, 'Fixe');
INSERT INTO bd_equipement.type_mobilite (type_mobi_id, type_mobi_libe) VALUES (2, 'Semi-Mobile');
INSERT INTO bd_equipement.type_mobilite (type_mobi_id, type_mobi_libe) VALUES (3, 'Mobile');


-- Table: type_autre_amenagement_zootechnie
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (1, 'Parc de contention');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (2, 'Parc de chargement');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (3, 'Abreuvoir');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (4, 'Point d''eau');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (5, 'Râtelier à fourrage');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (6, 'Passage d''homme');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (7, 'Batiment de Stockage');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (8, 'Batiment Abris');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (9, 'Abreuvoir - Rivière');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (10, 'Piézomètre');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (11, 'Grille à Chauve-Souris');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (12, 'Seuil');
INSERT INTO bd_equipement.type_autre_amenagement_zootechnie (type_autr_amen_zoot_id, type_autr_amen_zoot_libe) VALUES (13, 'Cale de mise à l''eau');
