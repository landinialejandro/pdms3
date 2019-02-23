<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'electronicInvoice';

		/* data for selected record, or defaults if none is selected */
		var data = {
			idPaese_TR_PA: <?php echo json_encode($jdata['idPaese_TR_PA']); ?>,
			idCodice_TR_PA: <?php echo json_encode($jdata['idCodice_TR_PA']); ?>,
			codiceDestinatarioPA: <?php echo json_encode($jdata['codiceDestinatarioPA']); ?>,
			telefonoPA: <?php echo json_encode(array('id' => $rdata['telefonoPA'], 'value' => $rdata['telefonoPA'], 'text' => $jdata['telefonoPA'])); ?>,
			idFiscaleIVA_Ced_PA: <?php echo json_encode(array('id' => $rdata['idFiscaleIVA_Ced_PA'], 'value' => $rdata['idFiscaleIVA_Ced_PA'], 'text' => $jdata['idFiscaleIVA_Ced_PA'])); ?>,
			codiceFiscale_Ced_PA: <?php echo json_encode($jdata['codiceFiscale_Ced_PA']); ?>,
			denominazione_Ced_PA: <?php echo json_encode($jdata['denominazione_Ced_PA']); ?>,
			nome_Ced_PA: <?php echo json_encode($jdata['nome_Ced_PA']); ?>,
			cognome_Ced_PA: <?php echo json_encode($jdata['cognome_Ced_PA']); ?>,
			titolo_Ced_PA: <?php echo json_encode($jdata['titolo_Ced_PA']); ?>,
			codEORI_Ced_PA: <?php echo json_encode($jdata['codEORI_Ced_PA']); ?>,
			alboProfessionale_Ced_PA: <?php echo json_encode($jdata['alboProfessionale_Ced_PA']); ?>,
			provinciaAlbo_Ced_PA: <?php echo json_encode($jdata['provinciaAlbo_Ced_PA']); ?>,
			nrIscrizioneAlbo_Ced_PA: <?php echo json_encode($jdata['nrIscrizioneAlbo_Ced_PA']); ?>,
			dataIscAlbo_Ced_PA: <?php echo json_encode($jdata['dataIscAlbo_Ced_PA']); ?>,
			regimeFiscale_Ced_PA: <?php echo json_encode($jdata['regimeFiscale_Ced_PA']); ?>,
			indirizzo_Ced_PA: <?php echo json_encode(array('id' => $rdata['indirizzo_Ced_PA'], 'value' => $rdata['indirizzo_Ced_PA'], 'text' => $jdata['indirizzo_Ced_PA'])); ?>,
			numeroCivico_Ced_PA: <?php echo json_encode($jdata['numeroCivico_Ced_PA']); ?>,
			CAP_Ced_PA: <?php echo json_encode($jdata['CAP_Ced_PA']); ?>,
			comune_Ced_PA: <?php echo json_encode($jdata['comune_Ced_PA']); ?>,
			provincia_Ced_PA: <?php echo json_encode($jdata['provincia_Ced_PA']); ?>,
			nazione_Ced_PA: <?php echo json_encode($jdata['nazione_Ced_PA']); ?>,
			altroIndirizzo_Ced_PA: <?php echo json_encode($jdata['altroIndirizzo_Ced_PA']); ?>,
			altro_nr_Civico_Ced_PA: <?php echo json_encode($jdata['altro_nr_Civico_Ced_PA']); ?>,
			altroCAP_Ced_PA: <?php echo json_encode($jdata['altroCAP_Ced_PA']); ?>,
			altro_Com_Ced_PA: <?php echo json_encode($jdata['altro_Com_Ced_PA']); ?>,
			altro_PR_Ced_PA: <?php echo json_encode($jdata['altro_PR_Ced_PA']); ?>,
			altraNazione_Ced_PA: <?php echo json_encode($jdata['altraNazione_Ced_PA']); ?>,
			ufficio_Ced_PA: <?php echo json_encode(array('id' => $rdata['ufficio_Ced_PA'], 'value' => $rdata['ufficio_Ced_PA'], 'text' => $jdata['ufficio_Ced_PA'])); ?>,
			numeroREA_Ced__PA: <?php echo json_encode($jdata['numeroREA_Ced__PA']); ?>,
			capitaleSociale_Ced_PA: <?php echo json_encode($jdata['capitaleSociale_Ced_PA']); ?>,
			socioUnico_Ced_PA: <?php echo json_encode($jdata['socioUnico_Ced_PA']); ?>,
			statoLiquidazione_Ced_PA: <?php echo json_encode($jdata['statoLiquidazione_Ced_PA']); ?>,
			telefonoCompany_Ced_PA: <?php echo json_encode($jdata['telefonoCompany_Ced_PA']); ?>,
			faxCompany_Ced_PA: <?php echo json_encode(array('id' => $rdata['faxCompany_Ced_PA'], 'value' => $rdata['faxCompany_Ced_PA'], 'text' => $jdata['faxCompany_Ced_PA'])); ?>,
			eMailCompany_Ced_PA: <?php echo json_encode(array('id' => $rdata['eMailCompany_Ced_PA'], 'value' => $rdata['eMailCompany_Ced_PA'], 'text' => $jdata['eMailCompany_Ced_PA'])); ?>,
			idPaeseRap_Fisc_PA: <?php echo json_encode(array('id' => $rdata['idPaeseRap_Fisc_PA'], 'value' => $rdata['idPaeseRap_Fisc_PA'], 'text' => $jdata['idPaeseRap_Fisc_PA'])); ?>,
			idPaeseRap_CodPA: <?php echo json_encode($jdata['idPaeseRap_CodPA']); ?>,
			idCodFiscRap_Fisc_PA: <?php echo json_encode($jdata['idCodFiscRap_Fisc_PA']); ?>,
			idDenominazioneRap_FiscPA: <?php echo json_encode($jdata['idDenominazioneRap_FiscPA']); ?>,
			idNomeRap_Fisc_PA: <?php echo json_encode($jdata['idNomeRap_Fisc_PA']); ?>,
			idCognRap_Fisc_PA: <?php echo json_encode($jdata['idCognRap_Fisc_PA']); ?>,
			idTitoloRap_Fisc_PA: <?php echo json_encode($jdata['idTitoloRap_Fisc_PA']); ?>,
			idEORI_Rap_Fisc_PA: <?php echo json_encode($jdata['idEORI_Rap_Fisc_PA']); ?>,
			idPaeseCess_PA: <?php echo json_encode(array('id' => $rdata['idPaeseCess_PA'], 'value' => $rdata['idPaeseCess_PA'], 'text' => $jdata['idPaeseCess_PA'])); ?>,
			idCodiceCess_PA: <?php echo json_encode($jdata['idCodiceCess_PA']); ?>,
			denominazioneCess_PA: <?php echo json_encode($jdata['denominazioneCess_PA']); ?>,
			nomeCess_PA: <?php echo json_encode($jdata['nomeCess_PA']); ?>,
			cognomeCess_PA: <?php echo json_encode($jdata['cognomeCess_PA']); ?>,
			titoloCess_PA: <?php echo json_encode($jdata['titoloCess_PA']); ?>,
			codEORI_Cess_PA: <?php echo json_encode($jdata['codEORI_Cess_PA']); ?>,
			indirizzoCess_PA: <?php echo json_encode($jdata['indirizzoCess_PA']); ?>,
			nrCivicoCess_PA: <?php echo json_encode($jdata['nrCivicoCess_PA']); ?>,
			CAP_Cess_PA: <?php echo json_encode($jdata['CAP_Cess_PA']); ?>,
			comuneCess_PA: <?php echo json_encode($jdata['comuneCess_PA']); ?>,
			provCess_PA: <?php echo json_encode($jdata['provCess_PA']); ?>,
			nazione_Cess_PA: <?php echo json_encode($jdata['nazione_Cess_PA']); ?>,
			idPaese3intSogEm_PA: <?php echo json_encode($jdata['idPaese3intSogEm_PA']); ?>,
			idCod_3intSogEm_PA: <?php echo json_encode($jdata['idCod_3intSogEm_PA']); ?>,
			codFisc_3intSogEm_PA: <?php echo json_encode($jdata['codFisc_3intSogEm_PA']); ?>,
			denom_3intSogEm_PA: <?php echo json_encode($jdata['denom_3intSogEm_PA']); ?>,
			nome_3_intSogEm_PA: <?php echo json_encode($jdata['nome_3_intSogEm_PA']); ?>,
			cogn_3_intSogEm_PA: <?php echo json_encode($jdata['cogn_3_intSogEm_PA']); ?>,
			tit_3_IntSogEm_PA: <?php echo json_encode($jdata['tit_3_IntSogEm_PA']); ?>,
			codEORi_3_intSogEm_PA: <?php echo json_encode($jdata['codEORi_3_intSogEm_PA']); ?>,
			tipoDocumentoFEB_PA: <?php echo json_encode(array('id' => $rdata['tipoDocumentoFEB_PA'], 'value' => $rdata['tipoDocumentoFEB_PA'], 'text' => $jdata['tipoDocumentoFEB_PA'])); ?>,
			divisaFEB_PA: <?php echo json_encode($jdata['divisaFEB_PA']); ?>,
			dataFEB_PA: <?php echo json_encode($jdata['dataFEB_PA']); ?>,
			numeroFEB_PA: <?php echo json_encode($jdata['numeroFEB_PA']); ?>,
			tipoRiten_PA: <?php echo json_encode($jdata['tipoRiten_PA']); ?>,
			impRiten_PA: <?php echo json_encode($jdata['impRiten_PA']); ?>,
			aliqRiten_PA: <?php echo json_encode($jdata['aliqRiten_PA']); ?>,
			causPagRit_PA: <?php echo json_encode($jdata['causPagRit_PA']); ?>,
			numBolloRit_PA: <?php echo json_encode($jdata['numBolloRit_PA']); ?>,
			impBolloRit_PA: <?php echo json_encode($jdata['impBolloRit_PA']); ?>,
			tipoCassaPrev_PA: <?php echo json_encode($jdata['tipoCassaPrev_PA']); ?>,
			alCassaPr_PA: <?php echo json_encode($jdata['alCassaPr_PA']); ?>,
			impContCassaPr_PA: <?php echo json_encode($jdata['impContCassaPr_PA']); ?>,
			imponCassaPr_PA: <?php echo json_encode($jdata['imponCassaPr_PA']); ?>,
			aliIVA_CassaPr_PA: <?php echo json_encode($jdata['aliIVA_CassaPr_PA']); ?>,
			ritCassaPr_PA: <?php echo json_encode($jdata['ritCassaPr_PA']); ?>,
			naturaCassaPr_PA: <?php echo json_encode($jdata['naturaCassaPr_PA']); ?>,
			rifAmmCasPr_PA: <?php echo json_encode($jdata['rifAmmCasPr_PA']); ?>,
			tipoScMag_PA: <?php echo json_encode($jdata['tipoScMag_PA']); ?>,
			percScMag_PA: <?php echo json_encode($jdata['percScMag_PA']); ?>,
			impScMag_PA: <?php echo json_encode($jdata['impScMag_PA']); ?>,
			ImpTotDoc_PA: <?php echo json_encode($jdata['ImpTotDoc_PA']); ?>,
			arrotDoc_PA: <?php echo json_encode($jdata['arrotDoc_PA']); ?>,
			causale_Doc_PA: <?php echo json_encode($jdata['causale_Doc_PA']); ?>,
			art73_doc_PA: <?php echo json_encode($jdata['art73_doc_PA']); ?>,
			rifNumLineaDoc_PA: <?php echo json_encode(array('id' => $rdata['rifNumLineaDoc_PA'], 'value' => $rdata['rifNumLineaDoc_PA'], 'text' => $jdata['rifNumLineaDoc_PA'])); ?>,
			idDocNum_PA: <?php echo json_encode($jdata['idDocNum_PA']); ?>,
			dataOrder_PA: <?php echo json_encode($jdata['dataOrder_PA']); ?>,
			numItemDoc_PA: <?php echo json_encode($jdata['numItemDoc_PA']); ?>,
			codCommConvDoc_PA: <?php echo json_encode($jdata['codCommConvDoc_PA']); ?>,
			codCUP_PA: <?php echo json_encode($jdata['codCUP_PA']); ?>,
			codCIG_PA: <?php echo json_encode($jdata['codCIG_PA']); ?>,
			RIFERIMENTO_FASE_PA: <?php echo json_encode($jdata['RIFERIMENTO_FASE_PA']); ?>,
			NUMERO_DDT_PA: <?php echo json_encode($jdata['NUMERO_DDT_PA']); ?>,
			dataDDT_PA: <?php echo json_encode($jdata['dataDDT_PA']); ?>,
			rifNumLinea_PA: <?php echo json_encode($jdata['rifNumLinea_PA']); ?>,
			ID_PAESE_VET_PA: <?php echo json_encode($jdata['ID_PAESE_VET_PA']); ?>,
			idCodVet_PA: <?php echo json_encode($jdata['idCodVet_PA']); ?>,
			codFiscVet_PA: <?php echo json_encode($jdata['codFiscVet_PA']); ?>,
			DENOMINAZIONE_ANAGR_VETT_PA: <?php echo json_encode($jdata['DENOMINAZIONE_ANAGR_VETT_PA']); ?>,
			nomeVett_PA: <?php echo json_encode($jdata['nomeVett_PA']); ?>,
			cognVett_PA: <?php echo json_encode($jdata['cognVett_PA']); ?>,
			titVett_PA: <?php echo json_encode($jdata['titVett_PA']); ?>,
			codEORI_Vet_PA: <?php echo json_encode($jdata['codEORI_Vet_PA']); ?>,
			nrLicenzaGuidaVet_PA: <?php echo json_encode($jdata['nrLicenzaGuidaVet_PA']); ?>,
			mezzoTraspVet_PA: <?php echo json_encode($jdata['mezzoTraspVet_PA']); ?>,
			causaleTrsVet_PA: <?php echo json_encode($jdata['causaleTrsVet_PA']); ?>,
			nrColliTrasp_PA: <?php echo json_encode($jdata['nrColliTrasp_PA']); ?>,
			descrTrasp_PA: <?php echo json_encode($jdata['descrTrasp_PA']); ?>,
			unMisPeso_PA: <?php echo json_encode($jdata['unMisPeso_PA']); ?>,
			pesoLordoMerce_PA: <?php echo json_encode($jdata['pesoLordoMerce_PA']); ?>,
			pesoNettoMer_PA: <?php echo json_encode($jdata['pesoNettoMer_PA']); ?>,
			dataOraRitMer_PA: <?php echo json_encode($jdata['dataOraRitMer_PA']); ?>,
			dataInTrMer_PA: <?php echo json_encode($jdata['dataInTrMer_PA']); ?>,
			tipoResaTr_PA: <?php echo json_encode($jdata['tipoResaTr_PA']); ?>,
			INDIRIZZO_RESA_PA: <?php echo json_encode($jdata['INDIRIZZO_RESA_PA']); ?>,
			nrCivResa_PA: <?php echo json_encode($jdata['nrCivResa_PA']); ?>,
			capResa_PA: <?php echo json_encode($jdata['capResa_PA']); ?>,
			comuneResa_PA: <?php echo json_encode($jdata['comuneResa_PA']); ?>,
			prResa_PA: <?php echo json_encode($jdata['prResa_PA']); ?>,
			nazioneResa_PA: <?php echo json_encode($jdata['nazioneResa_PA']); ?>,
			dataOraCons_PA: <?php echo json_encode($jdata['dataOraCons_PA']); ?>,
			normaRif_PA: <?php echo json_encode($jdata['normaRif_PA']); ?>,
			NR_FATT_PRINC_PA: <?php echo json_encode($jdata['NR_FATT_PRINC_PA']); ?>,
			dataFattPrin_PA: <?php echo json_encode($jdata['dataFattPrin_PA']); ?>,
			descrizioneBene_PA: <?php echo json_encode($jdata['descrizioneBene_PA']); ?>,
			quantitaBene_PA: <?php echo json_encode($jdata['quantitaBene_PA']); ?>,
			uniMisBene_PA: <?php echo json_encode($jdata['uniMisBene_PA']); ?>,
			prezzoUn_PA: <?php echo json_encode($jdata['prezzoUn_PA']); ?>,
			TIPO_SCONTO_MAG_PA: <?php echo json_encode($jdata['TIPO_SCONTO_MAG_PA']); ?>,
			perScMagBene_PA: <?php echo json_encode($jdata['perScMagBene_PA']); ?>,
			impScMagBene_PA: <?php echo json_encode($jdata['impScMagBene_PA']); ?>,
			prezzoTotaleBene_PA: <?php echo json_encode($jdata['prezzoTotaleBene_PA']); ?>,
			aliqIVA_bene_PA: <?php echo json_encode($jdata['aliqIVA_bene_PA']); ?>,
			AL_IVA_RIEP_PA: <?php echo json_encode($jdata['AL_IVA_RIEP_PA']); ?>,
			naturaRiep_PA: <?php echo json_encode($jdata['naturaRiep_PA']); ?>,
			speseAcc_Riep_PA: <?php echo json_encode($jdata['speseAcc_Riep_PA']); ?>,
			arrotRiep_PA: <?php echo json_encode($jdata['arrotRiep_PA']); ?>,
			imponibileImpRiep_PA: <?php echo json_encode($jdata['imponibileImpRiep_PA']); ?>,
			impostaRiep_PA: <?php echo json_encode($jdata['impostaRiep_PA']); ?>,
			esigIVA_riep_PA: <?php echo json_encode($jdata['esigIVA_riep_PA']); ?>,
			DATA_DATI_VEIC_PA: <?php echo json_encode($jdata['DATA_DATI_VEIC_PA']); ?>,
			totalePercorso_PA: <?php echo json_encode($jdata['totalePercorso_PA']); ?>,
			BENEFIC_DATI_PAG_PA: <?php echo json_encode(array('id' => $rdata['BENEFIC_DATI_PAG_PA'], 'value' => $rdata['BENEFIC_DATI_PAG_PA'], 'text' => $jdata['BENEFIC_DATI_PAG_PA'])); ?>,
			modPagam_PA: <?php echo json_encode($jdata['modPagam_PA']); ?>,
			dataRifTermPag_PA: <?php echo json_encode($jdata['dataRifTermPag_PA']); ?>,
			giorniTermPag_PA: <?php echo json_encode($jdata['giorniTermPag_PA']); ?>,
			dataScadPag_PA: <?php echo json_encode($jdata['dataScadPag_PA']); ?>,
			imporPag_PA: <?php echo json_encode($jdata['imporPag_PA']); ?>,
			codUffPostale_PA: <?php echo json_encode($jdata['codUffPostale_PA']); ?>,
			cognomeQuietanzante_PA: <?php echo json_encode($jdata['cognomeQuietanzante_PA']); ?>,
			nomeQuietanzante_PA: <?php echo json_encode($jdata['nomeQuietanzante_PA']); ?>,
			CF_Quietanzante_PA: <?php echo json_encode($jdata['CF_Quietanzante_PA']); ?>,
			titQuietanzante_PA: <?php echo json_encode($jdata['titQuietanzante_PA']); ?>,
			IBAN_PA: <?php echo json_encode($jdata['IBAN_PA']); ?>,
			CAB_PA: <?php echo json_encode($jdata['CAB_PA']); ?>,
			scontoPagAntic_PA: <?php echo json_encode($jdata['scontoPagAntic_PA']); ?>,
			dataLimPagAntic_PA: <?php echo json_encode($jdata['dataLimPagAntic_PA']); ?>,
			penRitarPagam_PA: <?php echo json_encode($jdata['penRitarPagam_PA']); ?>,
			dataDecPenale_PA: <?php echo json_encode($jdata['dataDecPenale_PA']); ?>,
			codPagamento_PA: <?php echo json_encode($jdata['codPagamento_PA']); ?>,
			ALLEGATI_NOME_ALL_PA: <?php echo json_encode(array('id' => $rdata['ALLEGATI_NOME_ALL_PA'], 'value' => $rdata['ALLEGATI_NOME_ALL_PA'], 'text' => $jdata['ALLEGATI_NOME_ALL_PA'])); ?>,
			algoritmoComp_PA: <?php echo json_encode($jdata['algoritmoComp_PA']); ?>,
			formatoAttachement_PA: <?php echo json_encode($jdata['formatoAttachement_PA']); ?>,
			descrizioneAttach_PA: <?php echo json_encode($jdata['descrizioneAttach_PA']); ?>,
			attachment_PA: <?php echo json_encode($jdata['attachment_PA']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for telefonoPA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'telefonoPA' && d.id == data.telefonoPA.id)
				return { results: [ data.telefonoPA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idFiscaleIVA_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idFiscaleIVA_Ced_PA' && d.id == data.idFiscaleIVA_Ced_PA.id)
				return { results: [ data.idFiscaleIVA_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idFiscaleIVA_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idFiscaleIVA_Ced_PA' && d.id == data.idFiscaleIVA_Ced_PA.id){
				$j('#idPaese_TR_PA' + d[rnd]).html(data.idPaese_TR_PA);
				$j('#idCodice_TR_PA' + d[rnd]).html(data.idCodice_TR_PA);
				$j('#codiceDestinatarioPA' + d[rnd]).html(data.codiceDestinatarioPA);
				$j('#codiceFiscale_Ced_PA' + d[rnd]).html(data.codiceFiscale_Ced_PA);
				$j('#denominazione_Ced_PA' + d[rnd]).html(data.denominazione_Ced_PA);
				$j('#nome_Ced_PA' + d[rnd]).html(data.nome_Ced_PA);
				$j('#cognome_Ced_PA' + d[rnd]).html(data.cognome_Ced_PA);
				$j('#titolo_Ced_PA' + d[rnd]).html(data.titolo_Ced_PA);
				$j('#codEORI_Ced_PA' + d[rnd]).html(data.codEORI_Ced_PA);
				$j('#alboProfessionale_Ced_PA' + d[rnd]).html(data.alboProfessionale_Ced_PA);
				$j('#provinciaAlbo_Ced_PA' + d[rnd]).html(data.provinciaAlbo_Ced_PA);
				$j('#nrIscrizioneAlbo_Ced_PA' + d[rnd]).html(data.nrIscrizioneAlbo_Ced_PA);
				$j('#dataIscAlbo_Ced_PA' + d[rnd]).html(data.dataIscAlbo_Ced_PA);
				$j('#regimeFiscale_Ced_PA' + d[rnd]).html(data.regimeFiscale_Ced_PA);
				$j('#ID_PAESE_VET_PA' + d[rnd]).html(data.ID_PAESE_VET_PA);
				$j('#idCodVet_PA' + d[rnd]).html(data.idCodVet_PA);
				$j('#codFiscVet_PA' + d[rnd]).html(data.codFiscVet_PA);
				$j('#DENOMINAZIONE_ANAGR_VETT_PA' + d[rnd]).html(data.DENOMINAZIONE_ANAGR_VETT_PA);
				$j('#nomeVett_PA' + d[rnd]).html(data.nomeVett_PA);
				$j('#cognVett_PA' + d[rnd]).html(data.cognVett_PA);
				$j('#titVett_PA' + d[rnd]).html(data.titVett_PA);
				$j('#codEORI_Vet_PA' + d[rnd]).html(data.codEORI_Vet_PA);
				$j('#nrLicenzaGuidaVet_PA' + d[rnd]).html(data.nrLicenzaGuidaVet_PA);
				$j('#mezzoTraspVet_PA' + d[rnd]).html(data.mezzoTraspVet_PA);
				$j('#DATA_DATI_VEIC_PA' + d[rnd]).html(data.DATA_DATI_VEIC_PA);
				$j('#totalePercorso_PA' + d[rnd]).html(data.totalePercorso_PA);
				return true;
			}

			return false;
		});

		/* saved value for indirizzo_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'indirizzo_Ced_PA' && d.id == data.indirizzo_Ced_PA.id)
				return { results: [ data.indirizzo_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for indirizzo_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'indirizzo_Ced_PA' && d.id == data.indirizzo_Ced_PA.id){
				$j('#numeroCivico_Ced_PA' + d[rnd]).html(data.numeroCivico_Ced_PA);
				$j('#CAP_Ced_PA' + d[rnd]).html(data.CAP_Ced_PA);
				$j('#comune_Ced_PA' + d[rnd]).html(data.comune_Ced_PA);
				$j('#provincia_Ced_PA' + d[rnd]).html(data.provincia_Ced_PA);
				$j('#nazione_Ced_PA' + d[rnd]).html(data.nazione_Ced_PA);
				$j('#altroIndirizzo_Ced_PA' + d[rnd]).html(data.altroIndirizzo_Ced_PA);
				$j('#altro_nr_Civico_Ced_PA' + d[rnd]).html(data.altro_nr_Civico_Ced_PA);
				$j('#altroCAP_Ced_PA' + d[rnd]).html(data.altroCAP_Ced_PA);
				$j('#altro_Com_Ced_PA' + d[rnd]).html(data.altro_Com_Ced_PA);
				$j('#altro_PR_Ced_PA' + d[rnd]).html(data.altro_PR_Ced_PA);
				$j('#altraNazione_Ced_PA' + d[rnd]).html(data.altraNazione_Ced_PA);
				return true;
			}

			return false;
		});

		/* saved value for ufficio_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'ufficio_Ced_PA' && d.id == data.ufficio_Ced_PA.id)
				return { results: [ data.ufficio_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for ufficio_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'ufficio_Ced_PA' && d.id == data.ufficio_Ced_PA.id){
				$j('#numeroREA_Ced__PA' + d[rnd]).html(data.numeroREA_Ced__PA);
				$j('#capitaleSociale_Ced_PA' + d[rnd]).html(data.capitaleSociale_Ced_PA);
				$j('#socioUnico_Ced_PA' + d[rnd]).html(data.socioUnico_Ced_PA);
				$j('#statoLiquidazione_Ced_PA' + d[rnd]).html(data.statoLiquidazione_Ced_PA);
				return true;
			}

			return false;
		});

		/* saved value for faxCompany_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'faxCompany_Ced_PA' && d.id == data.faxCompany_Ced_PA.id)
				return { results: [ data.faxCompany_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for faxCompany_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'faxCompany_Ced_PA' && d.id == data.faxCompany_Ced_PA.id){
				$j('#telefonoCompany_Ced_PA' + d[rnd]).html(data.telefonoCompany_Ced_PA);
				return true;
			}

			return false;
		});

		/* saved value for eMailCompany_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'eMailCompany_Ced_PA' && d.id == data.eMailCompany_Ced_PA.id)
				return { results: [ data.eMailCompany_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idPaeseRap_Fisc_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idPaeseRap_Fisc_PA' && d.id == data.idPaeseRap_Fisc_PA.id)
				return { results: [ data.idPaeseRap_Fisc_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idPaeseRap_Fisc_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idPaeseRap_Fisc_PA' && d.id == data.idPaeseRap_Fisc_PA.id){
				$j('#idPaeseRap_CodPA' + d[rnd]).html(data.idPaeseRap_CodPA);
				$j('#idCodFiscRap_Fisc_PA' + d[rnd]).html(data.idCodFiscRap_Fisc_PA);
				$j('#idDenominazioneRap_FiscPA' + d[rnd]).html(data.idDenominazioneRap_FiscPA);
				$j('#idNomeRap_Fisc_PA' + d[rnd]).html(data.idNomeRap_Fisc_PA);
				$j('#idCognRap_Fisc_PA' + d[rnd]).html(data.idCognRap_Fisc_PA);
				$j('#idTitoloRap_Fisc_PA' + d[rnd]).html(data.idTitoloRap_Fisc_PA);
				$j('#idEORI_Rap_Fisc_PA' + d[rnd]).html(data.idEORI_Rap_Fisc_PA);
				$j('#idPaese3intSogEm_PA' + d[rnd]).html(data.idPaese3intSogEm_PA);
				$j('#idCod_3intSogEm_PA' + d[rnd]).html(data.idCod_3intSogEm_PA);
				$j('#codFisc_3intSogEm_PA' + d[rnd]).html(data.codFisc_3intSogEm_PA);
				$j('#denom_3intSogEm_PA' + d[rnd]).html(data.denom_3intSogEm_PA);
				$j('#nome_3_intSogEm_PA' + d[rnd]).html(data.nome_3_intSogEm_PA);
				$j('#cogn_3_intSogEm_PA' + d[rnd]).html(data.cogn_3_intSogEm_PA);
				$j('#tit_3_IntSogEm_PA' + d[rnd]).html(data.tit_3_IntSogEm_PA);
				$j('#codEORi_3_intSogEm_PA' + d[rnd]).html(data.codEORi_3_intSogEm_PA);
				$j('#codCommConvDoc_PA' + d[rnd]).html(data.codCommConvDoc_PA);
				$j('#codCUP_PA' + d[rnd]).html(data.codCUP_PA);
				$j('#codCIG_PA' + d[rnd]).html(data.codCIG_PA);
				$j('#RIFERIMENTO_FASE_PA' + d[rnd]).html(data.RIFERIMENTO_FASE_PA);
				$j('#normaRif_PA' + d[rnd]).html(data.normaRif_PA);
				$j('#NR_FATT_PRINC_PA' + d[rnd]).html(data.NR_FATT_PRINC_PA);
				$j('#dataFattPrin_PA' + d[rnd]).html(data.dataFattPrin_PA);
				return true;
			}

			return false;
		});

		/* saved value for idPaeseCess_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idPaeseCess_PA' && d.id == data.idPaeseCess_PA.id)
				return { results: [ data.idPaeseCess_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idPaeseCess_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idPaeseCess_PA' && d.id == data.idPaeseCess_PA.id){
				$j('#idCodiceCess_PA' + d[rnd]).html(data.idCodiceCess_PA);
				$j('#denominazioneCess_PA' + d[rnd]).html(data.denominazioneCess_PA);
				$j('#nomeCess_PA' + d[rnd]).html(data.nomeCess_PA);
				$j('#cognomeCess_PA' + d[rnd]).html(data.cognomeCess_PA);
				$j('#titoloCess_PA' + d[rnd]).html(data.titoloCess_PA);
				$j('#codEORI_Cess_PA' + d[rnd]).html(data.codEORI_Cess_PA);
				$j('#indirizzoCess_PA' + d[rnd]).html(data.indirizzoCess_PA);
				$j('#nrCivicoCess_PA' + d[rnd]).html(data.nrCivicoCess_PA);
				$j('#CAP_Cess_PA' + d[rnd]).html(data.CAP_Cess_PA);
				$j('#comuneCess_PA' + d[rnd]).html(data.comuneCess_PA);
				$j('#provCess_PA' + d[rnd]).html(data.provCess_PA);
				$j('#nazione_Cess_PA' + d[rnd]).html(data.nazione_Cess_PA);
				return true;
			}

			return false;
		});

		/* saved value for tipoDocumentoFEB_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'tipoDocumentoFEB_PA' && d.id == data.tipoDocumentoFEB_PA.id)
				return { results: [ data.tipoDocumentoFEB_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for tipoDocumentoFEB_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'tipoDocumentoFEB_PA' && d.id == data.tipoDocumentoFEB_PA.id){
				$j('#divisaFEB_PA' + d[rnd]).html(data.divisaFEB_PA);
				$j('#dataFEB_PA' + d[rnd]).html(data.dataFEB_PA);
				$j('#numeroFEB_PA' + d[rnd]).html(data.numeroFEB_PA);
				$j('#tipoRiten_PA' + d[rnd]).html(data.tipoRiten_PA);
				$j('#impRiten_PA' + d[rnd]).html(data.impRiten_PA);
				$j('#aliqRiten_PA' + d[rnd]).html(data.aliqRiten_PA);
				$j('#causPagRit_PA' + d[rnd]).html(data.causPagRit_PA);
				$j('#numBolloRit_PA' + d[rnd]).html(data.numBolloRit_PA);
				$j('#impBolloRit_PA' + d[rnd]).html(data.impBolloRit_PA);
				$j('#tipoCassaPrev_PA' + d[rnd]).html(data.tipoCassaPrev_PA);
				$j('#alCassaPr_PA' + d[rnd]).html(data.alCassaPr_PA);
				$j('#impContCassaPr_PA' + d[rnd]).html(data.impContCassaPr_PA);
				$j('#imponCassaPr_PA' + d[rnd]).html(data.imponCassaPr_PA);
				$j('#aliIVA_CassaPr_PA' + d[rnd]).html(data.aliIVA_CassaPr_PA);
				$j('#ritCassaPr_PA' + d[rnd]).html(data.ritCassaPr_PA);
				$j('#naturaCassaPr_PA' + d[rnd]).html(data.naturaCassaPr_PA);
				$j('#rifAmmCasPr_PA' + d[rnd]).html(data.rifAmmCasPr_PA);
				$j('#tipoScMag_PA' + d[rnd]).html(data.tipoScMag_PA);
				$j('#percScMag_PA' + d[rnd]).html(data.percScMag_PA);
				$j('#impScMag_PA' + d[rnd]).html(data.impScMag_PA);
				$j('#ImpTotDoc_PA' + d[rnd]).html(data.ImpTotDoc_PA);
				$j('#arrotDoc_PA' + d[rnd]).html(data.arrotDoc_PA);
				$j('#causale_Doc_PA' + d[rnd]).html(data.causale_Doc_PA);
				$j('#art73_doc_PA' + d[rnd]).html(data.art73_doc_PA);
				$j('#NUMERO_DDT_PA' + d[rnd]).html(data.NUMERO_DDT_PA);
				$j('#pesoLordoMerce_PA' + d[rnd]).html(data.pesoLordoMerce_PA);
				$j('#pesoNettoMer_PA' + d[rnd]).html(data.pesoNettoMer_PA);
				$j('#dataOraRitMer_PA' + d[rnd]).html(data.dataOraRitMer_PA);
				$j('#tipoResaTr_PA' + d[rnd]).html(data.tipoResaTr_PA);
				$j('#INDIRIZZO_RESA_PA' + d[rnd]).html(data.INDIRIZZO_RESA_PA);
				$j('#nrCivResa_PA' + d[rnd]).html(data.nrCivResa_PA);
				$j('#capResa_PA' + d[rnd]).html(data.capResa_PA);
				$j('#comuneResa_PA' + d[rnd]).html(data.comuneResa_PA);
				$j('#prResa_PA' + d[rnd]).html(data.prResa_PA);
				$j('#nazioneResa_PA' + d[rnd]).html(data.nazioneResa_PA);
				$j('#dataOraCons_PA' + d[rnd]).html(data.dataOraCons_PA);
				return true;
			}

			return false;
		});

		/* saved value for rifNumLineaDoc_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'rifNumLineaDoc_PA' && d.id == data.rifNumLineaDoc_PA.id)
				return { results: [ data.rifNumLineaDoc_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for rifNumLineaDoc_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'rifNumLineaDoc_PA' && d.id == data.rifNumLineaDoc_PA.id){
				$j('#idDocNum_PA' + d[rnd]).html(data.idDocNum_PA);
				$j('#dataOrder_PA' + d[rnd]).html(data.dataOrder_PA);
				$j('#numItemDoc_PA' + d[rnd]).html(data.numItemDoc_PA);
				$j('#dataDDT_PA' + d[rnd]).html(data.dataDDT_PA);
				$j('#rifNumLinea_PA' + d[rnd]).html(data.rifNumLinea_PA);
				$j('#causaleTrsVet_PA' + d[rnd]).html(data.causaleTrsVet_PA);
				$j('#nrColliTrasp_PA' + d[rnd]).html(data.nrColliTrasp_PA);
				$j('#descrTrasp_PA' + d[rnd]).html(data.descrTrasp_PA);
				$j('#unMisPeso_PA' + d[rnd]).html(data.unMisPeso_PA);
				$j('#dataInTrMer_PA' + d[rnd]).html(data.dataInTrMer_PA);
				$j('#descrizioneBene_PA' + d[rnd]).html(data.descrizioneBene_PA);
				$j('#quantitaBene_PA' + d[rnd]).html(data.quantitaBene_PA);
				$j('#uniMisBene_PA' + d[rnd]).html(data.uniMisBene_PA);
				$j('#prezzoUn_PA' + d[rnd]).html(data.prezzoUn_PA);
				$j('#TIPO_SCONTO_MAG_PA' + d[rnd]).html(data.TIPO_SCONTO_MAG_PA);
				$j('#perScMagBene_PA' + d[rnd]).html(data.perScMagBene_PA);
				$j('#impScMagBene_PA' + d[rnd]).html(data.impScMagBene_PA);
				$j('#prezzoTotaleBene_PA' + d[rnd]).html(data.prezzoTotaleBene_PA);
				$j('#aliqIVA_bene_PA' + d[rnd]).html(data.aliqIVA_bene_PA);
				$j('#AL_IVA_RIEP_PA' + d[rnd]).html(data.AL_IVA_RIEP_PA);
				$j('#naturaRiep_PA' + d[rnd]).html(data.naturaRiep_PA);
				$j('#speseAcc_Riep_PA' + d[rnd]).html(data.speseAcc_Riep_PA);
				$j('#arrotRiep_PA' + d[rnd]).html(data.arrotRiep_PA);
				$j('#imponibileImpRiep_PA' + d[rnd]).html(data.imponibileImpRiep_PA);
				$j('#impostaRiep_PA' + d[rnd]).html(data.impostaRiep_PA);
				$j('#esigIVA_riep_PA' + d[rnd]).html(data.esigIVA_riep_PA);
				return true;
			}

			return false;
		});

		/* saved value for BENEFIC_DATI_PAG_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'BENEFIC_DATI_PAG_PA' && d.id == data.BENEFIC_DATI_PAG_PA.id)
				return { results: [ data.BENEFIC_DATI_PAG_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for BENEFIC_DATI_PAG_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'BENEFIC_DATI_PAG_PA' && d.id == data.BENEFIC_DATI_PAG_PA.id){
				$j('#modPagam_PA' + d[rnd]).html(data.modPagam_PA);
				$j('#dataRifTermPag_PA' + d[rnd]).html(data.dataRifTermPag_PA);
				$j('#giorniTermPag_PA' + d[rnd]).html(data.giorniTermPag_PA);
				$j('#dataScadPag_PA' + d[rnd]).html(data.dataScadPag_PA);
				$j('#imporPag_PA' + d[rnd]).html(data.imporPag_PA);
				$j('#codUffPostale_PA' + d[rnd]).html(data.codUffPostale_PA);
				$j('#cognomeQuietanzante_PA' + d[rnd]).html(data.cognomeQuietanzante_PA);
				$j('#nomeQuietanzante_PA' + d[rnd]).html(data.nomeQuietanzante_PA);
				$j('#CF_Quietanzante_PA' + d[rnd]).html(data.CF_Quietanzante_PA);
				$j('#titQuietanzante_PA' + d[rnd]).html(data.titQuietanzante_PA);
				$j('#IBAN_PA' + d[rnd]).html(data.IBAN_PA);
				$j('#CAB_PA' + d[rnd]).html(data.CAB_PA);
				$j('#scontoPagAntic_PA' + d[rnd]).html(data.scontoPagAntic_PA);
				$j('#dataLimPagAntic_PA' + d[rnd]).html(data.dataLimPagAntic_PA);
				$j('#penRitarPagam_PA' + d[rnd]).html(data.penRitarPagam_PA);
				$j('#dataDecPenale_PA' + d[rnd]).html(data.dataDecPenale_PA);
				$j('#codPagamento_PA' + d[rnd]).html(data.codPagamento_PA);
				return true;
			}

			return false;
		});

		/* saved value for ALLEGATI_NOME_ALL_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'ALLEGATI_NOME_ALL_PA' && d.id == data.ALLEGATI_NOME_ALL_PA.id)
				return { results: [ data.ALLEGATI_NOME_ALL_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for ALLEGATI_NOME_ALL_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'ALLEGATI_NOME_ALL_PA' && d.id == data.ALLEGATI_NOME_ALL_PA.id){
				$j('#algoritmoComp_PA' + d[rnd]).html(data.algoritmoComp_PA);
				$j('#formatoAttachement_PA' + d[rnd]).html(data.formatoAttachement_PA);
				$j('#descrizioneAttach_PA' + d[rnd]).html(data.descrizioneAttach_PA);
				$j('#attachment_PA' + d[rnd]).html(data.attachment_PA);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

