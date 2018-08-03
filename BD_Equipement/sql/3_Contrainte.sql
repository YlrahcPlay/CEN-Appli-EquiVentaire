/*
ALTER TABLE bd_equipement.panneau DROP CONSTRAINT FK_panneau_etat_comm_id;
ALTER TABLE bd_equipement.panneau DROP CONSTRAINT FK_panneau_type_pann_id;
ALTER TABLE bd_equipement.panneau DROP CONSTRAINT FK_panneau_site_cen_id;

ALTER TABLE bd_equipement.photo DROP CONSTRAINT FK_photo_pann_id;

ALTER TABLE bd_equipement.piece_jointe DROP CONSTRAINT FK_piece_jointe_type_piec_join_id;
ALTER TABLE bd_equipement.piece_jointe DROP CONSTRAINT FK_piece_jointe_pann_id;


ALTER TABLE bd_equipement.sentier DROP CONSTRAINT FK_sentier_type_sent_id;
ALTER TABLE bd_equipement.sentier DROP CONSTRAINT FK_sentier_type_chem_id;
ALTER TABLE bd_equipement.sentier DROP CONSTRAINT FK_sentier_diff_id;
ALTER TABLE bd_equipement.sentier DROP CONSTRAINT FK_sentier_etat_comm_id;
ALTER TABLE bd_equipement.sentier DROP CONSTRAINT FK_sentier_site_cen_id;

ALTER TABLE bd_equipement.support_communication DROP CONSTRAINT FK_support_communication_sent_id;
ALTER TABLE bd_equipement.support_communication DROP CONSTRAINT FK_support_communication_type_supp_comm_id;


ALTER TABLE bd_equipement.autre_amenagement_communication DROP CONSTRAINT FK_autre_amenagement_communication_type_autr_amen_comm_id;
ALTER TABLE bd_equipement.autre_amenagement_communication DROP CONSTRAINT FK_autre_amenagement_communication_etat_comm_id;
ALTER TABLE bd_equipement.autre_amenagement_communication DROP CONSTRAINT FK_autre_amenagement_communication_site_cen_id;


ALTER TABLE bd_equipement.cloture DROP CONSTRAINT FK_cloture_type_mobi_id;
ALTER TABLE bd_equipement.cloture DROP CONSTRAINT FK_cloture_type_fils_id;
ALTER TABLE bd_equipement.cloture DROP CONSTRAINT FK_cloture_type_pote_id;
ALTER TABLE bd_equipement.cloture DROP CONSTRAINT FK_cloture_etat_zoot_id;
ALTER TABLE bd_equipement.cloture DROP CONSTRAINT FK_cloture_site_cen_id;


ALTER TABLE bd_equipement.barriere DROP CONSTRAINT FK_barriere_type_mobi_id;
ALTER TABLE bd_equipement.barriere DROP CONSTRAINT FK_barriere_type_stru_id;
ALTER TABLE bd_equipement.barriere DROP CONSTRAINT FK_barriere_etat_zoot_id;
ALTER TABLE bd_equipement.barriere DROP CONSTRAINT FK_barriere_site_cen_id;


ALTER TABLE bd_equipement.autre_amenagement_zootechnie DROP CONSTRAINT FK_autre_amenagement_zootechnie_type_autr_amen_zoot_id;
ALTER TABLE bd_equipement.autre_amenagement_zootechnie DROP CONSTRAINT FK_autre_amenagement_zootechnie_site_cen_id;
*/




ALTER TABLE bd_equipement.panneau ADD CONSTRAINT FK_panneau_type_pann_id FOREIGN KEY (pann_type_pann_id) REFERENCES bd_equipement.type_panneau(type_pann_id);
ALTER TABLE bd_equipement.panneau ADD CONSTRAINT FK_panneau_etat_comm_id FOREIGN KEY (pann_etat_comm_id) REFERENCES bd_equipement.etat_communication(etat_comm_id);
ALTER TABLE bd_equipement.panneau ADD CONSTRAINT FK_panneau_site_cen_id FOREIGN KEY (pann_site_cen_id) REFERENCES md.site_cenhn("ID");

ALTER TABLE bd_equipement.photo ADD CONSTRAINT FK_photo_pann_id FOREIGN KEY (photo_pann_id) REFERENCES bd_equipement.panneau(pann_id) ON DELETE CASCADE;

ALTER TABLE bd_equipement.piece_jointe ADD CONSTRAINT FK_piece_jointe_type_piec_join_id FOREIGN KEY (piec_join_type_piec_join_id) REFERENCES bd_equipement.type_piece_jointe(type_piec_join_id);
ALTER TABLE bd_equipement.piece_jointe ADD CONSTRAINT FK_piece_jointe_pann_id FOREIGN KEY (piec_join_pann_id) REFERENCES bd_equipement.panneau(pann_id) ON DELETE CASCADE;


ALTER TABLE bd_equipement.sentier ADD CONSTRAINT FK_sentier_type_sent_id FOREIGN KEY (sent_type_sent_id) REFERENCES bd_equipement.type_sentier(type_sent_id);
ALTER TABLE bd_equipement.sentier ADD CONSTRAINT FK_sentier_type_chem_id FOREIGN KEY (sent_type_chem_id) REFERENCES bd_equipement.type_cheminement(type_chem_id);
ALTER TABLE bd_equipement.sentier ADD CONSTRAINT FK_sentier_diff_id FOREIGN KEY (sent_diff_id) REFERENCES bd_equipement.difficulte(diff_id);
ALTER TABLE bd_equipement.sentier ADD CONSTRAINT FK_sentier_etat_comm_id FOREIGN KEY (sent_etat_comm_id) REFERENCES bd_equipement.etat_communication(etat_comm_id);
ALTER TABLE bd_equipement.sentier ADD CONSTRAINT FK_sentier_site_cen_id FOREIGN KEY (sent_site_cen_id) REFERENCES md.site_cenhn("ID");

ALTER TABLE bd_equipement.support_communication ADD CONSTRAINT FK_support_communication_sent_id FOREIGN KEY (supp_comm_equi_id) REFERENCES bd_equipement.sentier(sent_id) ON DELETE CASCADE;
ALTER TABLE bd_equipement.support_communication ADD CONSTRAINT FK_support_communication_type_supp_comm_id FOREIGN KEY (supp_comm_type_supp_comm_id) REFERENCES bd_equipement.type_support_communication(type_supp_comm_id);


ALTER TABLE bd_equipement.autre_amenagement_communication ADD CONSTRAINT FK_autre_amenagement_communication_type_autr_amen_comm_id FOREIGN KEY (autr_amen_comm_type_autr_amen_comm_id) REFERENCES bd_equipement.type_autre_amenagement_communication(type_autr_amen_comm_id);
ALTER TABLE bd_equipement.autre_amenagement_communication ADD CONSTRAINT FK_autre_amenagement_communication_etat_comm_id FOREIGN KEY (autr_amen_comm_etat_comm_id) REFERENCES bd_equipement.etat_communication(etat_comm_id);
ALTER TABLE bd_equipement.autre_amenagement_communication ADD CONSTRAINT FK_autre_amenagement_communication_site_cen_id FOREIGN KEY (autr_amen_comm_site_cen_id) REFERENCES md.site_cenhn("ID");


ALTER TABLE bd_equipement.cloture ADD CONSTRAINT FK_cloture_type_mobi_id FOREIGN KEY (clot_type_mobi_id) REFERENCES bd_equipement.type_mobilite(type_mobi_id);
ALTER TABLE bd_equipement.cloture ADD CONSTRAINT FK_cloture_type_fils_id FOREIGN KEY (clot_type_fils_id) REFERENCES bd_equipement.type_fils(type_fils_id);
ALTER TABLE bd_equipement.cloture ADD CONSTRAINT FK_cloture_type_pote_id FOREIGN KEY (clot_type_pote_id) REFERENCES bd_equipement.type_poteau(type_pote_id);
ALTER TABLE bd_equipement.cloture ADD CONSTRAINT FK_cloture_etat_zoot_id FOREIGN KEY (clot_etat_zoot_id) REFERENCES bd_equipement.etat_zootechnie(etat_zoot_id);
ALTER TABLE bd_equipement.cloture ADD CONSTRAINT FK_cloture_site_cen_id FOREIGN KEY (clot_site_cen_id) REFERENCES md.site_cenhn("ID");


ALTER TABLE bd_equipement.barriere ADD CONSTRAINT FK_barriere_type_mobi_id FOREIGN KEY (barr_type_mobi_id) REFERENCES bd_equipement.type_mobilite(type_mobi_id);
ALTER TABLE bd_equipement.barriere ADD CONSTRAINT FK_barriere_type_stru_id FOREIGN KEY (barr_type_stru_id) REFERENCES bd_equipement.type_structure(type_stru_id);
ALTER TABLE bd_equipement.barriere ADD CONSTRAINT FK_barriere_etat_zoot_id FOREIGN KEY (barr_etat_zoot_id) REFERENCES bd_equipement.etat_zootechnie(etat_zoot_id);
ALTER TABLE bd_equipement.barriere ADD CONSTRAINT FK_barriere_site_cen_id FOREIGN KEY (barr_site_cen_id) REFERENCES md.site_cenhn("ID");


ALTER TABLE bd_equipement.autre_amenagement_zootechnie ADD CONSTRAINT FK_autre_amenagement_zootechnie_type_autr_amen_zoot_id FOREIGN KEY (autr_amen_zoot_type_autr_amen_zoot_id) REFERENCES bd_equipement.type_autre_amenagement_zootechnie(type_autr_amen_zoot_id);
ALTER TABLE bd_equipement.autre_amenagement_zootechnie ADD CONSTRAINT FK_autre_amenagement_zootechnie_site_cen_id FOREIGN KEY (autr_amen_zoot_site_cen_id) REFERENCES md.site_cenhn("ID");
