<?php
	$currDir = dirname(__FILE__);
	require("{$currDir}/incCommon.php");
	$GLOBALS['page_title'] = $Translation['view or rebuild fields'];
	include("{$currDir}/incHeader.php");

	/*
		$schema: [ tablename => [ fieldname => [ appgini => '...', 'db' => '...'], ... ], ... ]
	*/

	/* application schema as created in AppGini */
	$schema = array(   
		'orders' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'progressivNumber' => array('appgini' => 'CHAR(10) null '),
			'consigneeID' => array('appgini' => 'CHAR(10) null '),
			'company' => array('appgini' => 'INT unsigned not null '),
			'typeDoc' => array('appgini' => 'VARCHAR(40) not null '),
			'multiOrder_nr_PA' => array('appgini' => 'INT not null '),
			'formatoTrasmissione_PA' => array('appgini' => 'CHAR(5) null default \'SDI10\' '),
			'tipo_Documento_PA' => array('appgini' => 'CHAR(4) not null default \'TD01\' '),
			'divisa_PA' => array('appgini' => 'CHAR(3) not null default \'EUR\' '),
			'importo_Sc_Mg_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'importoTot_Doc_PA' => array('appgini' => 'DECIMAL(10,2) not null '),
			'arrotondamento_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'causale_PA' => array('appgini' => 'VARCHAR(200) not null default \'VENDITA\' '),
			'art73_PA' => array('appgini' => 'CHAR(2) null '),
			'data_Ord_PA' => array('appgini' => 'DATE not null '),
			'dataOraRit_PA' => array('appgini' => 'DATE null '),
			'dataInizTrasp_PA' => array('appgini' => 'DATE null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'supplier' => array('appgini' => 'INT unsigned null '),
			'employee' => array('appgini' => 'INT unsigned null '),
			'shipVia' => array('appgini' => 'INT unsigned null '),
			'Freight' => array('appgini' => 'DECIMAL(10,2) null '),
			'pallets' => array('appgini' => 'INT null '),
			'mezzoTraspVet_PA' => array('appgini' => 'VARCHAR(80) null '),
			'causaleTraspVet_PA' => array('appgini' => 'VARCHAR(100) null '),
			'nrColliVett_PA' => array('appgini' => 'SMALLINT(4) null '),
			'descTraspVet_PA' => array('appgini' => 'VARCHAR(100) null '),
			'cashCredit' => array('appgini' => 'VARCHAR(255) null default \'1\' '),
			'trust' => array('appgini' => 'INT unsigned null '),
			'overdraft' => array('appgini' => 'INT null '),
			'commisionFee' => array('appgini' => 'DECIMAL(10,2) null '),
			'commisionRate' => array('appgini' => 'DECIMAL(10,2) null '),
			'related' => array('appgini' => 'INT null '),
			'document' => array('appgini' => 'VARCHAR(255) null '),
			'tipo_rit_PA' => array('appgini' => 'CHAR(4) null '),
			'imp_rit_PA' => array('appgini' => 'CHAR(15) null '),
			'aliq_rit_PA' => array('appgini' => 'SMALLINT(6) null '),
			'causale_pag_rit_PA' => array('appgini' => 'CHAR(1) null '),
			'nr_bollo_rit_PA' => array('appgini' => 'CHAR(14) null '),
			'importo_Bollo_rit_PA' => array('appgini' => 'VARCHAR(255) null '),
			'tipo_cassa_Prev_PA' => array('appgini' => 'CHAR(4) null '),
			'al_cassa_Prev_PA' => array('appgini' => 'SMALLINT(6) null '),
			'importo_cont_cassa_prev_PA' => array('appgini' => 'INT(15) null '),
			'imponibile_cassa_Prev_PA' => array('appgini' => 'SMALLINT(15) null '),
			'aliq_IVA_cassa_prev_PA' => array('appgini' => 'SMALLINT(6) null '),
			'ritenuta_cassa_prev_PA' => array('appgini' => 'CHAR(2) null '),
			'natura_cassa_prev_PA' => array('appgini' => 'CHAR(2) null '),
			'rif_amm_prev_PA' => array('appgini' => 'CHAR(20) null '),
			'tipoResa_PA' => array('appgini' => 'CHAR(3) null default \'EXW\' '),
			'indirizzoResa_PA' => array('appgini' => 'VARCHAR(60) null '),
			'nrCivicoResa_PA' => array('appgini' => 'CHAR(8) null '),
			'CAP_Resa_PA' => array('appgini' => 'INT unsigned null '),
			'comuneResa_PA' => array('appgini' => 'INT unsigned null '),
			'provResa_PA' => array('appgini' => 'INT unsigned null '),
			'nazioneResa_PA' => array('appgini' => 'INT unsigned null '),
			'dataOraCons_PA' => array('appgini' => 'DATE null ')
		),
		'ordersDetails' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'order' => array('appgini' => 'INT unsigned null '),
			'manufactureDate' => array('appgini' => 'DATE null '),
			'sellDate' => array('appgini' => 'DATE null '),
			'expiryDate' => array('appgini' => 'DATE null '),
			'daysToExpiry' => array('appgini' => 'INT null '),
			'codebar' => array('appgini' => 'INT null '),
			'productCode' => array('appgini' => 'INT not null '),
			'batch' => array('appgini' => 'INT null '),
			'packages' => array('appgini' => 'DECIMAL(10,2) null '),
			'noSell' => array('appgini' => 'INT null '),
			'quantity_PA' => array('appgini' => 'DECIMAL(10,2) null default \'1\' '),
			'QuantityReal' => array('appgini' => 'DECIMAL(10,2) not null '),
			'UMRifPeso_PA' => array('appgini' => 'INT not null '),
			'prezzoUn_PA' => array('appgini' => 'DECIMAL(21,2) not null '),
			'aliquotaIVA_PA' => array('appgini' => 'DECIMAL(6,2) not null '),
			'prezzoTot_PA' => array('appgini' => 'DECIMAL(21,2) unsigned not null '),
			'tipoScMAg_PA' => array('appgini' => 'CHAR(2) null '),
			'percScontoLinea_PA' => array('appgini' => 'DECIMAL(10,2) null '),
			'section' => array('appgini' => 'VARCHAR(40) null default \'Magazzino Metaponto\' '),
			'transaction_type' => array('appgini' => 'INT unsigned null '),
			'skBatches' => array('appgini' => 'INT unsigned null '),
			'averagePrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'averageWeight' => array('appgini' => 'DECIMAL(10,2) null '),
			'commission' => array('appgini' => 'DECIMAL(10,2) null default \'15.00\' '),
			'return' => array('appgini' => 'VARCHAR(255) null default \'1\' '),
			'supplierCode' => array('appgini' => 'VARCHAR(100) null '),
			'causTrasp_PA' => array('appgini' => 'VARCHAR(100) null '),
			'nrLinea_PA' => array('appgini' => 'SMALLINT(4) null '),
			'tipoCessionePrest_PA' => array('appgini' => 'VARCHAR(255) null '),
			'codTipo_PA' => array('appgini' => 'CHAR(35) null '),
			'codValore_PA' => array('appgini' => 'CHAR(35) null '),
			'descrizioneArt_PA' => array('appgini' => 'INT not null '),
			'percentualeScontoMag_PA' => array('appgini' => 'DECIMAL(6,2) null '),
			'importoScontoMag_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'imponibileImp_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'impostaRiep_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'LineTotal' => array('appgini' => 'DECIMAL(10,2) null '),
			'esigibilitaIVA_PA' => array('appgini' => 'CHAR(1) null default \'D\' '),
			'ritenuta_PA' => array('appgini' => 'CHAR(2) null '),
			'natura_PA' => array('appgini' => 'CHAR(2) null '),
			'rifAmmin_PA' => array('appgini' => 'CHAR(20) null '),
			'tipoDato_PA' => array('appgini' => 'CHAR(10) null '),
			'riferTesto_PA' => array('appgini' => 'CHAR(60) null '),
			'rifNumero_PA' => array('appgini' => 'DECIMAL(21,2) null '),
			'rifData_PA' => array('appgini' => 'DATE null '),
			'aliquotaIVAriep_PA' => array('appgini' => 'DECIMAL(6,2) null '),
			'naturaRiep_PA' => array('appgini' => 'CHAR(2) null '),
			'speseAccess_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'arrotondamentoRiep_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'rifNormativoRiep_PA' => array('appgini' => 'VARCHAR(100) null ')
		),
		'_resumeOrders' => array(   
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'typedoc' => array('appgini' => 'VARCHAR(40) null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'TOT' => array('appgini' => 'VARCHAR(40) null '),
			'MONTH' => array('appgini' => 'VARCHAR(40) null '),
			'YEAR' => array('appgini' => 'VARCHAR(40) null '),
			'DOCs' => array('appgini' => 'VARCHAR(40) null '),
			'related' => array('appgini' => 'INT unsigned null '),
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment ')
		),
		'products' => array(   
			'id' => array('appgini' => 'INT not null primary key auto_increment '),
			'codebar' => array('appgini' => 'VARCHAR(16) null '),
			'productCode' => array('appgini' => 'VARCHAR(255) null '),
			'productName' => array('appgini' => 'VARCHAR(255) null '),
			'tax' => array('appgini' => 'VARCHAR(40) null '),
			'increment' => array('appgini' => 'DECIMAL(10,2) null '),
			'CategoryID' => array('appgini' => 'VARCHAR(40) null '),
			'UM' => array('appgini' => 'VARCHAR(40) null '),
			'tare' => array('appgini' => 'DECIMAL(10,2) null '),
			'QuantityPerUnit' => array('appgini' => 'VARCHAR(50) null '),
			'UnitPrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'sellPrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'UnitsInStock' => array('appgini' => 'DECIMAL(10,2) null '),
			'UnitsOnOrder' => array('appgini' => 'DECIMAL(10,2) null default \'0\' '),
			'ReorderLevel' => array('appgini' => 'DECIMAL(10,2) null default \'0\' '),
			'balance' => array('appgini' => 'DECIMAL(10,2) null '),
			'Discontinued' => array('appgini' => 'INT null default \'0\' '),
			'manufactured_date' => array('appgini' => 'DATE null '),
			'expiry_date' => array('appgini' => 'DATE null '),
			'note' => array('appgini' => 'TEXT null '),
			'update_date' => array('appgini' => 'DATETIME null ')
		),
		'firstCashNote' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'order' => array('appgini' => 'INT unsigned null '),
			'operationDate' => array('appgini' => 'DATE null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'documentNumber' => array('appgini' => 'INT null '),
			'causal' => array('appgini' => 'VARCHAR(255) null '),
			'importoPag_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'outputs' => array('appgini' => 'DECIMAL(10,2) null '),
			'balance' => array('appgini' => 'DECIMAL(10,2) null '),
			'idBank' => array('appgini' => 'INT unsigned null '),
			'istitutoFinanziario_PA' => array('appgini' => 'INT unsigned null '),
			'note' => array('appgini' => 'VARCHAR(255) null '),
			'paymentDeadLine' => array('appgini' => 'DATE null '),
			'payed' => array('appgini' => 'VARCHAR(255) null default \'0\' '),
			'datiPag_PA' => array('appgini' => 'VARCHAR(255) null '),
			'modPagam_PA' => array('appgini' => 'CHAR(4) null default \'MP02\' '),
			'dataRifTerPag_PA' => array('appgini' => 'DATE null '),
			'giorniTermPag_PA' => array('appgini' => 'SMALLINT(3) null '),
			'dataScadPag_PA' => array('appgini' => 'DATE null '),
			'codUffPost_PA' => array('appgini' => 'CHAR(20) null '),
			'cognomeQuietanzante_PA' => array('appgini' => 'VARCHAR(60) null '),
			'nomeQuietanzante_PA' => array('appgini' => 'VARCHAR(60) null '),
			'codFiscQuietanzante_PA' => array('appgini' => 'CHAR(16) null '),
			'titoloQuietanzante_PA' => array('appgini' => 'CHAR(10) null ')
		),
		'vatRegister' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'idCompany' => array('appgini' => 'INT unsigned null '),
			'companyName' => array('appgini' => 'INT unsigned null '),
			'tax' => array('appgini' => 'VARCHAR(40) null default \'4%\' '),
			'month' => array('appgini' => 'VARCHAR(40) null '),
			'year' => array('appgini' => 'VARCHAR(40) null default \'2018\' '),
			'amount' => array('appgini' => 'DECIMAL(10,2) null '),
			'ufficio_Ced_PA' => array('appgini' => 'CHAR(2) null '),
			'numeroREA_Ced_PA' => array('appgini' => 'CHAR(20) null '),
			'capitaleSociale_Ced_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'socioUnico_Ced_PA' => array('appgini' => 'CHAR(2) null default \'SM\' '),
			'statoLiquidazione_Ced_PA' => array('appgini' => 'CHAR(2) null default \'LN\' ')
		),
		'companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'companyCode' => array('appgini' => 'VARCHAR(255) null '),
			'companyName' => array('appgini' => 'VARCHAR(255) null '),
			'notes' => array('appgini' => 'TEXT null '),
			'codiceDestinatarioUff_PA' => array('appgini' => 'INT unsigned null '),
			'idPaese_Ced_PA' => array('appgini' => 'INT unsigned not null '),
			'idCodice_Ced_PA' => array('appgini' => 'CHAR(28) not null '),
			'codiceFiscale_Ced_PA' => array('appgini' => 'CHAR(28) not null '),
			'denominazione_Ced_PA' => array('appgini' => 'VARCHAR(80) not null '),
			'titolo_Ced_PA' => array('appgini' => 'CHAR(10) null '),
			'nome_Ced_PA' => array('appgini' => 'VARCHAR(60) null '),
			'cognome_Ced_PA' => array('appgini' => 'VARCHAR(60) null '),
			'codEORICed__PA' => array('appgini' => 'CHAR(17) null '),
			'alboProfessionale_Ced_PA' => array('appgini' => 'VARCHAR(60) null '),
			'provinciaAlbo_Ced_PA' => array('appgini' => 'CHAR(2) null '),
			'numeroIscrizione_Ced_AlboPA' => array('appgini' => 'VARCHAR(60) null '),
			'dataIscrAlbo_Ced_PA' => array('appgini' => 'DATE null '),
			'regimeFiscalePA' => array('appgini' => 'CHAR(4) not null default \'RF01\' '),
			'idPaeseVett_PA' => array('appgini' => 'CHAR(3) not null default \'IT\' '),
			'idFiscaleVet_PA' => array('appgini' => 'CHAR(28) not null '),
			'codFiscVet_PA' => array('appgini' => 'CHAR(16) not null '),
			'denominazioneVet_PA' => array('appgini' => 'VARCHAR(80) not null '),
			'titoloVet_PA' => array('appgini' => 'CHAR(10) null '),
			'nomeVet_PA' => array('appgini' => 'VARCHAR(60) null '),
			'cognomeVett_PA' => array('appgini' => 'VARCHAR(60) null '),
			'codEORIVet_PA' => array('appgini' => 'CHAR(17) null '),
			'nrLicGuidaVet_PA' => array('appgini' => 'CHAR(20) null '),
			'data_DatiVeic_PA' => array('appgini' => 'DATE null '),
			'totalPercVeic_PA' => array('appgini' => 'CHAR(15) null '),
			'mezzoTrVet_PA' => array('appgini' => 'VARCHAR(255) null ')
		),
		'CLIENTI_CESSIONARI_PA' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'idPaese_Ces_PA' => array('appgini' => 'INT unsigned not null '),
			'idCodice_Ces_PA' => array('appgini' => 'CHAR(28) not null '),
			'codiceFiscale_Ces_PA' => array('appgini' => 'CHAR(16) not null '),
			'Denominazione_Ces_PA' => array('appgini' => 'VARCHAR(80) null '),
			'tit_Ces_PA' => array('appgini' => 'CHAR(10) null '),
			'nome_Ces_PA' => array('appgini' => 'VARCHAR(60) null '),
			'cogn_Ces_PA' => array('appgini' => 'VARCHAR(60) null '),
			'Cod_Ces_EORI_PA' => array('appgini' => 'VARCHAR(40) null '),
			'indirizzo_Ces_PA' => array('appgini' => 'VARCHAR(60) not null '),
			'numeroCiv_CesPA' => array('appgini' => 'CHAR(8) null '),
			'CAP_Ces_PA' => array('appgini' => 'CHAR(5) not null '),
			'comune_Ces_PA' => array('appgini' => 'VARCHAR(60) not null '),
			'pr_Ces_PA' => array('appgini' => 'INT unsigned not null '),
			'nazione_Ces_PA' => array('appgini' => 'VARCHAR(255) not null default \'IT\' '),
			'notes' => array('appgini' => 'TEXT null '),
			'birthDate' => array('appgini' => 'DATE null '),
			'autorizzSanitaria_SAM' => array('appgini' => 'VARCHAR(255) null '),
			'AutSanEmessa_SAM' => array('appgini' => 'VARCHAR(255) null '),
			'NrPresSan_SAM' => array('appgini' => 'VARCHAR(255) null '),
			'NrAutSan_SAM' => array('appgini' => 'VARCHAR(40) null '),
			'dataAutSan_SAM' => array('appgini' => 'DATE null ')
		),
		'creditDocument' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'incomingTypeDoc' => array('appgini' => 'VARCHAR(255) null '),
			'customerID' => array('appgini' => 'VARCHAR(255) null '),
			'nrDoc' => array('appgini' => 'VARCHAR(255) null '),
			'dateIncomingNote' => array('appgini' => 'DATE null '),
			'customerFirm' => array('appgini' => 'VARCHAR(255) null '),
			'customerAddress' => array('appgini' => 'VARCHAR(255) null '),
			'customerPostCode' => array('appgini' => 'VARCHAR(255) null '),
			'customerTown' => array('appgini' => 'VARCHAR(255) null ')
		),
		'electronicInvoice' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'idPaese_TR_PA' => array('appgini' => 'INT unsigned null '),
			'idCodice_TR_PA' => array('appgini' => 'INT unsigned null '),
			'progressivoInvioPA' => array('appgini' => 'CHAR(28) null '),
			'formatoTrasmissionePA' => array('appgini' => 'CHAR(5) null default \'SDI10\' '),
			'codiceDestinatarioPA' => array('appgini' => 'INT unsigned null '),
			'telefonoPA' => array('appgini' => 'INT unsigned null '),
			'emailPA' => array('appgini' => 'VARCHAR(255) null '),
			'idFiscaleIVA_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'codiceFiscale_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'denominazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'nome_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'cognome_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'titolo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'codEORI_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'alboProfessionale_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'provinciaAlbo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'nrIscrizioneAlbo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'dataIscAlbo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'regimeFiscale_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'indirizzo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'numeroCivico_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'CAP_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'comune_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'provincia_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'nazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altroIndirizzo_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altro_nr_Civico_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altroCAP_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altro_Com_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altro_PR_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'altraNazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'ufficio_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'numeroREA_Ced__PA' => array('appgini' => 'INT unsigned null '),
			'capitaleSociale_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'socioUnico_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'statoLiquidazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'telefonoCompany_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'faxCompany_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'eMailCompany_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'rif_Amm_Ced_PA' => array('appgini' => 'CHAR(20) null '),
			'idPaeseRap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idPaeseRap_CodPA' => array('appgini' => 'INT unsigned null '),
			'idCodFiscRap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idDenominazioneRap_FiscPA' => array('appgini' => 'INT unsigned null '),
			'idNomeRap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idCognRap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idTitoloRap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idEORI_Rap_Fisc_PA' => array('appgini' => 'INT unsigned null '),
			'idPaeseCess_PA' => array('appgini' => 'INT unsigned null '),
			'idCodiceCess_PA' => array('appgini' => 'INT unsigned null '),
			'idCodiceFiscCess_PA' => array('appgini' => 'CHAR(16) null '),
			'denominazioneCess_PA' => array('appgini' => 'INT unsigned null '),
			'nomeCess_PA' => array('appgini' => 'INT unsigned null '),
			'cognomeCess_PA' => array('appgini' => 'INT unsigned null '),
			'titoloCess_PA' => array('appgini' => 'INT unsigned null '),
			'codEORI_Cess_PA' => array('appgini' => 'INT unsigned null '),
			'indirizzoCess_PA' => array('appgini' => 'INT unsigned null '),
			'nrCivicoCess_PA' => array('appgini' => 'INT unsigned null '),
			'CAP_Cess_PA' => array('appgini' => 'INT unsigned null '),
			'comuneCess_PA' => array('appgini' => 'INT unsigned null '),
			'provCess_PA' => array('appgini' => 'INT unsigned null '),
			'nazione_Cess_PA' => array('appgini' => 'INT unsigned null '),
			'idPaese3intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'idCod_3intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'codFisc_3intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'denom_3intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'nome_3_intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'cogn_3_intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'tit_3_IntSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'codEORi_3_intSogEm_PA' => array('appgini' => 'INT unsigned null '),
			'SoggettoEmittente_PA' => array('appgini' => 'VARCHAR(255) null '),
			'tipoDocumentoFEB_PA' => array('appgini' => 'INT unsigned null '),
			'divisaFEB_PA' => array('appgini' => 'INT unsigned null '),
			'dataFEB_PA' => array('appgini' => 'INT unsigned null '),
			'numeroFEB_PA' => array('appgini' => 'INT unsigned null '),
			'tipoRiten_PA' => array('appgini' => 'INT unsigned null '),
			'impRiten_PA' => array('appgini' => 'INT unsigned null '),
			'aliqRiten_PA' => array('appgini' => 'INT unsigned null '),
			'causPagRit_PA' => array('appgini' => 'INT unsigned null '),
			'numBolloRit_PA' => array('appgini' => 'INT unsigned null '),
			'impBolloRit_PA' => array('appgini' => 'INT unsigned null '),
			'tipoCassaPrev_PA' => array('appgini' => 'INT unsigned null '),
			'alCassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'impContCassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'imponCassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'aliIVA_CassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'ritCassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'naturaCassaPr_PA' => array('appgini' => 'INT unsigned null '),
			'rifAmmCasPr_PA' => array('appgini' => 'INT unsigned null '),
			'tipoScMag_PA' => array('appgini' => 'INT unsigned null '),
			'percScMag_PA' => array('appgini' => 'INT unsigned null '),
			'impScMag_PA' => array('appgini' => 'INT unsigned null '),
			'ImpTotDoc_PA' => array('appgini' => 'INT unsigned null '),
			'arrotDoc_PA' => array('appgini' => 'INT unsigned null '),
			'causale_Doc_PA' => array('appgini' => 'INT unsigned null '),
			'art73_doc_PA' => array('appgini' => 'INT unsigned null '),
			'rifNumLineaDoc_PA' => array('appgini' => 'INT unsigned null '),
			'idDocNum_PA' => array('appgini' => 'INT unsigned null '),
			'dataOrder_PA' => array('appgini' => 'INT unsigned null '),
			'numItemDoc_PA' => array('appgini' => 'INT unsigned null '),
			'codCommConvDoc_PA' => array('appgini' => 'INT unsigned null '),
			'codCUP_PA' => array('appgini' => 'INT unsigned null '),
			'codCIG_PA' => array('appgini' => 'INT unsigned null '),
			'RIFERIMENTO_FASE_PA' => array('appgini' => 'INT unsigned null '),
			'NUMERO_DDT_PA' => array('appgini' => 'INT unsigned null '),
			'dataDDT_PA' => array('appgini' => 'INT unsigned null '),
			'rifNumLinea_PA' => array('appgini' => 'INT unsigned null '),
			'ID_PAESE_VET_PA' => array('appgini' => 'INT unsigned null '),
			'idCodVet_PA' => array('appgini' => 'INT unsigned null '),
			'codFiscVet_PA' => array('appgini' => 'INT unsigned null '),
			'DENOMINAZIONE_ANAGR_VETT_PA' => array('appgini' => 'INT unsigned null '),
			'nomeVett_PA' => array('appgini' => 'INT unsigned null '),
			'cognVett_PA' => array('appgini' => 'INT unsigned null '),
			'titVett_PA' => array('appgini' => 'INT unsigned null '),
			'codEORI_Vet_PA' => array('appgini' => 'INT unsigned null '),
			'nrLicenzaGuidaVet_PA' => array('appgini' => 'INT unsigned null '),
			'mezzoTraspVet_PA' => array('appgini' => 'INT unsigned null '),
			'causaleTrsVet_PA' => array('appgini' => 'INT unsigned null '),
			'nrColliTrasp_PA' => array('appgini' => 'INT unsigned null '),
			'descrTrasp_PA' => array('appgini' => 'INT unsigned null '),
			'unMisPeso_PA' => array('appgini' => 'INT unsigned null '),
			'pesoLordoMerce_PA' => array('appgini' => 'INT unsigned null '),
			'pesoNettoMer_PA' => array('appgini' => 'INT unsigned null '),
			'dataOraRitMer_PA' => array('appgini' => 'INT unsigned null '),
			'dataInTrMer_PA' => array('appgini' => 'INT unsigned null '),
			'tipoResaTr_PA' => array('appgini' => 'INT unsigned null '),
			'INDIRIZZO_RESA_PA' => array('appgini' => 'INT unsigned null '),
			'nrCivResa_PA' => array('appgini' => 'INT unsigned null '),
			'capResa_PA' => array('appgini' => 'INT unsigned null '),
			'comuneResa_PA' => array('appgini' => 'INT unsigned null '),
			'prResa_PA' => array('appgini' => 'INT unsigned null '),
			'nazioneResa_PA' => array('appgini' => 'INT unsigned null '),
			'dataOraCons_PA' => array('appgini' => 'INT unsigned null '),
			'normaRif_PA' => array('appgini' => 'INT unsigned null '),
			'NR_FATT_PRINC_PA' => array('appgini' => 'INT unsigned null '),
			'dataFattPrin_PA' => array('appgini' => 'INT unsigned null '),
			'NUMERO_LINEA_BENI_SERV_PA' => array('appgini' => 'VARCHAR(255) null '),
			'tipoCessPrest_PA' => array('appgini' => 'CHAR(2) null '),
			'CODICE_TIPO_PA' => array('appgini' => 'CHAR(35) null '),
			'codiceVal_PA' => array('appgini' => 'CHAR(35) null '),
			'descrizioneBene_PA' => array('appgini' => 'INT unsigned null '),
			'quantitaBene_PA' => array('appgini' => 'INT unsigned null '),
			'uniMisBene_PA' => array('appgini' => 'INT unsigned null '),
			'dataInPeriodo_PA' => array('appgini' => 'DATE null '),
			'dataFinePeriodo_PA' => array('appgini' => 'DATE null '),
			'prezzoUn_PA' => array('appgini' => 'INT unsigned null '),
			'TIPO_SCONTO_MAG_PA' => array('appgini' => 'INT unsigned null '),
			'perScMagBene_PA' => array('appgini' => 'INT unsigned null '),
			'impScMagBene_PA' => array('appgini' => 'INT unsigned null '),
			'prezzoTotaleBene_PA' => array('appgini' => 'INT unsigned null '),
			'aliqIVA_bene_PA' => array('appgini' => 'INT unsigned null '),
			'ritenuta_bene_PA' => array('appgini' => 'CHAR(2) null '),
			'naturaRitBene' => array('appgini' => 'VARCHAR(255) null '),
			'rifAmm_PA' => array('appgini' => 'CHAR(20) null '),
			'TIPO_DATO_ALTRI_DATI_PA' => array('appgini' => 'VARCHAR(255) null '),
			'rifTesto_altri_dati_PA' => array('appgini' => 'VARCHAR(60) null '),
			'rifNum_Altri_dati_PA' => array('appgini' => 'DECIMAL(21,2) null '),
			'rifData_altri_dati_PA' => array('appgini' => 'DATE null '),
			'AL_IVA_RIEP_PA' => array('appgini' => 'INT unsigned null '),
			'naturaRiep_PA' => array('appgini' => 'INT unsigned null '),
			'speseAcc_Riep_PA' => array('appgini' => 'INT unsigned null '),
			'arrotRiep_PA' => array('appgini' => 'INT unsigned null '),
			'imponibileImpRiep_PA' => array('appgini' => 'INT unsigned null '),
			'impostaRiep_PA' => array('appgini' => 'INT unsigned null '),
			'esigIVA_riep_PA' => array('appgini' => 'INT unsigned null '),
			'rifNormRiep_PA' => array('appgini' => 'VARCHAR(255) null '),
			'DATA_DATI_VEIC_PA' => array('appgini' => 'INT unsigned null '),
			'totalePercorso_PA' => array('appgini' => 'INT unsigned null '),
			'BENEFIC_DATI_PAG_PA' => array('appgini' => 'INT unsigned null '),
			'modPagam_PA' => array('appgini' => 'INT unsigned null '),
			'dataRifTermPag_PA' => array('appgini' => 'INT unsigned null '),
			'giorniTermPag_PA' => array('appgini' => 'INT unsigned null '),
			'dataScadPag_PA' => array('appgini' => 'INT unsigned null '),
			'imporPag_PA' => array('appgini' => 'INT unsigned null '),
			'codUffPostale_PA' => array('appgini' => 'INT unsigned null '),
			'cognomeQuietanzante_PA' => array('appgini' => 'INT unsigned null '),
			'nomeQuietanzante_PA' => array('appgini' => 'INT unsigned null '),
			'CF_Quietanzante_PA' => array('appgini' => 'INT unsigned null '),
			'titQuietanzante_PA' => array('appgini' => 'INT unsigned null '),
			'IBAN_PA' => array('appgini' => 'INT unsigned null '),
			'ABI_PA' => array('appgini' => 'VARCHAR(255) null '),
			'CAB_PA' => array('appgini' => 'INT unsigned null '),
			'BIC_PA' => array('appgini' => 'VARCHAR(255) null '),
			'scontoPagAntic_PA' => array('appgini' => 'INT unsigned null '),
			'dataLimPagAntic_PA' => array('appgini' => 'INT unsigned null '),
			'penRitarPagam_PA' => array('appgini' => 'INT unsigned null '),
			'dataDecPenale_PA' => array('appgini' => 'INT unsigned null '),
			'codPagamento_PA' => array('appgini' => 'INT unsigned null '),
			'ALLEGATI_NOME_ALL_PA' => array('appgini' => 'INT unsigned null '),
			'algoritmoComp_PA' => array('appgini' => 'INT unsigned null '),
			'formatoAttachement_PA' => array('appgini' => 'INT unsigned null '),
			'descrizioneAttach_PA' => array('appgini' => 'INT unsigned null '),
			'attachment_PA' => array('appgini' => 'INT unsigned null ')
		),
		'countries' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'VARCHAR(255) null '),
			'code' => array('appgini' => 'VARCHAR(100) null '),
			'ISOcode' => array('appgini' => 'VARCHAR(40) null ')
		),
		'town' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'INT unsigned null '),
			'idIstat' => array('appgini' => 'VARCHAR(255) null '),
			'town' => array('appgini' => 'VARCHAR(255) null '),
			'district' => array('appgini' => 'VARCHAR(255) null '),
			'region' => array('appgini' => 'VARCHAR(255) null '),
			'prefix' => array('appgini' => 'VARCHAR(255) null '),
			'shipCode' => array('appgini' => 'VARCHAR(255) null '),
			'fiscCode' => array('appgini' => 'VARCHAR(255) null '),
			'inhabitants' => array('appgini' => 'VARCHAR(255) null '),
			'link' => array('appgini' => 'VARCHAR(255) null ')
		),
		'GPSTrackingSystem' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'carTracked' => array('appgini' => 'VARCHAR(40) null ')
		),
		'kinds' => array(   
			'entity' => array('appgini' => 'BLOB not null '),
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'name' => array('appgini' => 'VARCHAR(255) not null '),
			'value' => array('appgini' => 'TEXT null '),
			'descriptions' => array('appgini' => 'TEXT null ')
		),
		'Logs' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'ip' => array('appgini' => 'VARCHAR(16) null '),
			'ts' => array('appgini' => 'BIGINT null '),
			'details' => array('appgini' => 'TEXT null ')
		),
		'attributes' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'attribute' => array('appgini' => 'VARCHAR(40) null '),
			'value' => array('appgini' => 'TEXT null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'companies' => array('appgini' => 'INT unsigned null '),
			'products' => array('appgini' => 'INT null ')
		),
		'addresses_PA' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'indirizzo_Ced_PA' => array('appgini' => 'VARCHAR(60) null '),
			'numeroCivico_Ced_PA' => array('appgini' => 'CHAR(8) null '),
			'CAP_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'comune_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'provincia_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'nazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'IBAN_PA' => array('appgini' => 'CHAR(34) null '),
			'ABI_PA' => array('appgini' => 'SMALLINT(5) null '),
			'CAB_PA' => array('appgini' => 'SMALLINT(5) null '),
			'BIC_PA' => array('appgini' => 'CHAR(11) null '),
			'altroIndirizzo_Ced_PA' => array('appgini' => 'VARCHAR(60) null '),
			'altro_nr_Civico_Ced_PA' => array('appgini' => 'CHAR(8) null '),
			'altroCAP_Ced_PA' => array('appgini' => 'CHAR(5) null '),
			'altra_PR_Ced_PA' => array('appgini' => 'CHAR(2) null '),
			'altraNazione_Ced_PA' => array('appgini' => 'INT unsigned null '),
			'indirizzo_Ces_PA' => array('appgini' => 'VARCHAR(60) null '),
			'numeroCivico_Ces_PA' => array('appgini' => 'CHAR(8) null '),
			'CAP_Ces_PA' => array('appgini' => 'CHAR(5) null '),
			'comune_Ces_PA' => array('appgini' => 'VARCHAR(60) null '),
			'prov_Ces_PA' => array('appgini' => 'CHAR(2) null '),
			'nazione_Ces_PA' => array('appgini' => 'CHAR(2) null default \'IT\' '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'map' => array('appgini' => 'VARCHAR(40) null '),
			'default' => array('appgini' => 'INT null default \'0\' '),
			'ship' => array('appgini' => 'INT null default \'0\' '),
			'scontoPagAnt_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'dataPagAntic_PA' => array('appgini' => 'DATE null '),
			'penalRitardPag_PA' => array('appgini' => 'DECIMAL(15,2) null '),
			'dataDecorPag_PA' => array('appgini' => 'DATE null '),
			'codPagam_PA' => array('appgini' => 'CHAR(15) null ')
		),
		'phones' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'phoneNumber' => array('appgini' => 'VARCHAR(255) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null ')
		),
		'PEC' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'PEC_PA' => array('appgini' => 'VARCHAR(255) null '),
			'codiceUnivocoPA' => array('appgini' => 'CHAR(7) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null ')
		),
		'contacts_companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'default' => array('appgini' => 'VARCHAR(40) null default \'0\' '),
			'telefonoCompanyPA' => array('appgini' => 'CHAR(12) null '),
			'faxCompanyPA' => array('appgini' => 'CHAR(12) null '),
			'eMailCompanyPA' => array('appgini' => 'VARCHAR(255) null '),
			'riferimentoAmministrazionePA' => array('appgini' => 'CHAR(20) null ')
		),
		'allegati_PA' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'momeAlleg_PA' => array('appgini' => 'VARCHAR(60) null '),
			'file' => array('appgini' => 'VARCHAR(255) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'algoritmoComp_PA' => array('appgini' => 'CHAR(10) null '),
			'thumbUse' => array('appgini' => 'INT null default \'0\' '),
			'formatoAlleg_PA' => array('appgini' => 'CHAR(10) null default \'PDF\' '),
			'descrizAlleg_PA' => array('appgini' => 'VARCHAR(100) null default \'Allegato Ft. in PDF\' ')
		),
		'sogg_Terzi_Rapp_PA' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'idPaese_RF_PA' => array('appgini' => 'INT unsigned null '),
			'idCodice_RF_PA' => array('appgini' => 'CHAR(28) null '),
			'codiceFiscale_RF_PA' => array('appgini' => 'CHAR(16) null '),
			'denominazione_RF_PA' => array('appgini' => 'VARCHAR(80) null '),
			'nome_RF_PA' => array('appgini' => 'VARCHAR(60) null '),
			'cognome_RF_PA' => array('appgini' => 'VARCHAR(60) null '),
			'titolo_RF_PA' => array('appgini' => 'CHAR(10) null '),
			'codEORI__RF_PA' => array('appgini' => 'CHAR(17) null '),
			'idPaeseIVA_3_Int_PA' => array('appgini' => 'CHAR(2) null '),
			'idCodice_3_Int_PA' => array('appgini' => 'CHAR(28) null '),
			'codFiscale_3_Int_PA' => array('appgini' => 'CHAR(16) null '),
			'denominazione_3_Int_PA' => array('appgini' => 'VARCHAR(80) null '),
			'nome_3_Int_PA' => array('appgini' => 'VARCHAR(60) null '),
			'cognome_3_Int_PA' => array('appgini' => 'VARCHAR(60) null '),
			'titolo_3_Int_PA' => array('appgini' => 'CHAR(10) null '),
			'codEORI_3_Int_PA' => array('appgini' => 'CHAR(17) null '),
			'sogg_Emittente_PA' => array('appgini' => 'VARCHAR(255) null '),
			'rif_num_linea_PA' => array('appgini' => 'SMALLINT(4) null '),
			'idDoc_PA' => array('appgini' => 'CHAR(20) null '),
			'data_orAcq_PA' => array('appgini' => 'DATE null '),
			'numItem_PA' => array('appgini' => 'CHAR(20) null '),
			'codCom_Con_PA' => array('appgini' => 'VARCHAR(100) null '),
			'codCUP_PA' => array('appgini' => 'CHAR(15) null '),
			'codGIG_PA' => array('appgini' => 'CHAR(15) null '),
			'datiCont_PA' => array('appgini' => 'VARCHAR(255) null '),
			'datiConv_PA' => array('appgini' => 'VARCHAR(255) null '),
			'datiRic_PA' => array('appgini' => 'VARCHAR(255) null '),
			'datiFatCol_PA' => array('appgini' => 'VARCHAR(255) null '),
			'datiSal_PA' => array('appgini' => 'VARCHAR(255) null '),
			'riferFase_PA' => array('appgini' => 'SMALLINT(3) null '),
			'normaRifer_PA' => array('appgini' => 'VARCHAR(100) null '),
			'nrFatturaPrinc_PA' => array('appgini' => 'CHAR(20) null '),
			'dataFattPrinc_PA' => array('appgini' => 'VARCHAR(255) null ')
		)
	);

	$table_captions = getTableList();

	/* function for preparing field definition for comparison */
	function prepare_def($def) {
		$def = strtolower($def);

		/* ignore 'null' */
		$def = preg_replace('/\s+not\s+null\s*/', '%%NOT_NULL%%', $def);
		$def = preg_replace('/\s+null\s*/', ' ', $def);
		$def = str_replace('%%NOT_NULL%%', ' not null ', $def);

		/* ignore length for int data types */
		$def = preg_replace('/int\s*\([0-9]+\)/', 'int', $def);

		/* make sure there is always a space before mysql words */
		$def = preg_replace('/(\S)(unsigned|not null|binary|zerofill|auto_increment|default)/', '$1 $2', $def);

		/* treat 0.000.. same as 0 */
		$def = preg_replace('/([0-9])*\.0+/', '$1', $def);

		/* treat unsigned zerofill same as zerofill */
		$def = str_ireplace('unsigned zerofill', 'zerofill', $def);

		/* ignore zero-padding for date data types */
		$def = preg_replace("/date\s*default\s*'([0-9]{4})-0?([1-9])-0?([1-9])'/", "date default '$1-$2-$3'", $def);

		return trim($def);
	}

	/**
	 *  @brief creates/fixes given field according to given schema
	 *  @return integer: 0 = error, 1 = field updated, 2 = field created
	 */
	function fix_field($fix_table, $fix_field, $schema, &$qry) {
		if(!isset($schema[$fix_table][$fix_field])) return 0;

		$def = $schema[$fix_table][$fix_field];
		$field_added = $field_updated = false;
		$eo['silentErrors'] = true;

		// field exists?
		$res = sql("show columns from `{$fix_table}` like '{$fix_field}'", $eo);
		if($row = db_fetch_assoc($res)){
			// modify field
			$qry = "alter table `{$fix_table}` modify `{$fix_field}` {$def['appgini']}";
			sql($qry, $eo);

			// remove unique from db if necessary
			if($row['Key'] == 'UNI' && !stripos($def['appgini'], ' unique')){
				// retrieve unique index name
				$res_unique = sql("show index from `{$fix_table}` where Column_name='{$fix_field}' and Non_unique=0", $eo);
				if($row_unique = db_fetch_assoc($res_unique)){
					$qry_unique = "drop index `{$row_unique['Key_name']}` on `{$fix_table}`";
					sql($qry_unique, $eo);
					$qry .= ";\n{$qry_unique}";
				}
			}

			return 1;
		}

		// create field
		$qry = "alter table `{$fix_table}` add column `{$fix_field}` {$schema[$fix_table][$fix_field]['appgini']}";
		sql($qry, $eo);
		return 2;
	}

	/* process requested fixes */
	$fix_table = (isset($_GET['t']) ? $_GET['t'] : false);
	$fix_field = (isset($_GET['f']) ? $_GET['f'] : false);
	$fix_all = (isset($_GET['all']) ? true : false);

	if($fix_field && $fix_table) $fix_status = fix_field($fix_table, $fix_field, $schema, $qry);

	/* retrieve actual db schema */
	foreach($table_captions as $tn => $tc){
		$eo['silentErrors'] = true;
		$res = sql("show columns from `{$tn}`", $eo);
		if($res){
			while($row = db_fetch_assoc($res)){
				if(!isset($schema[$tn][$row['Field']]['appgini'])) continue;
				$field_description = strtoupper(str_replace(' ', '', $row['Type']));
				$field_description = str_ireplace('unsigned', ' unsigned', $field_description);
				$field_description = str_ireplace('zerofill', ' zerofill', $field_description);
				$field_description = str_ireplace('binary', ' binary', $field_description);
				$field_description .= ($row['Null'] == 'NO' ? ' not null' : '');
				$field_description .= ($row['Key'] == 'PRI' ? ' primary key' : '');
				$field_description .= ($row['Key'] == 'UNI' ? ' unique' : '');
				$field_description .= ($row['Default'] != '' ? " default '" . makeSafe($row['Default']) . "'" : '');
				$field_description .= ($row['Extra'] == 'auto_increment' ? ' auto_increment' : '');

				$schema[$tn][$row['Field']]['db'] = '';
				if(isset($schema[$tn][$row['Field']])){
					$schema[$tn][$row['Field']]['db'] = $field_description;
				}
			}
		}
	}

	/* handle fix_all request */
	if($fix_all){
		foreach($schema as $tn => $fields){
			foreach($fields as $fn => $fd){
				if(prepare_def($fd['appgini']) == prepare_def($fd['db'])) continue;
				fix_field($tn, $fn, $schema, $qry);
			}
		}

		redirect('admin/pageRebuildFields.php');
		exit;
	}
?>

<?php if($fix_status == 1 || $fix_status == 2){ ?>
	<div class="alert alert-info alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="glyphicon glyphicon-info-sign"></i>
		<?php 
			$originalValues = array('<ACTION>', '<FIELD>', '<TABLE>', '<QUERY>');
			$action = ($fix_status == 2 ? 'create' : 'update');
			$replaceValues = array($action, $fix_field, $fix_table, $qry);
			echo str_replace($originalValues, $replaceValues, $Translation['create or update table']);
		?>
	</div>
<?php } ?>

<div class="page-header"><h1>
	<?php echo $Translation['view or rebuild fields'] ; ?>
	<button type="button" class="btn btn-default" id="show_deviations_only"><i class="glyphicon glyphicon-eye-close"></i> <?php echo $Translation['show deviations only'] ; ?></button>
	<button type="button" class="btn btn-default hidden" id="show_all_fields"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $Translation['show all fields'] ; ?></button>
</h1></div>

<p class="lead"><?php echo $Translation['compare tables page'] ; ?></p>

<div class="alert summary"></div>
<table class="table table-responsive table-hover table-striped">
	<thead><tr>
		<th></th>
		<th><?php echo $Translation['field'] ; ?></th>
		<th><?php echo $Translation['AppGini definition'] ; ?></th>
		<th><?php echo $Translation['database definition'] ; ?></th>
		<th id="fix_all"></th>
	</tr></thead>

	<tbody>
	<?php foreach($schema as $tn => $fields){ ?>
		<tr class="text-info"><td colspan="5"><h4 data-placement="left" data-toggle="tooltip" title="<?php echo str_replace ( "<TABLENAME>" , $tn , $Translation['table name title']) ; ?>"><i class="glyphicon glyphicon-th-list"></i> <?php echo $table_captions[$tn]; ?></h4></td></tr>
		<?php foreach($fields as $fn => $fd){ ?>
			<?php $diff = ((prepare_def($fd['appgini']) == prepare_def($fd['db'])) ? false : true); ?>
			<?php $no_db = ($fd['db'] ? false : true); ?>
			<tr class="<?php echo ($diff ? 'warning' : 'field_ok'); ?>">
				<td><i class="glyphicon glyphicon-<?php echo ($diff ? 'remove text-danger' : 'ok text-success'); ?>"></i></td>
				<td><?php echo $fn; ?></td>
				<td class="<?php echo ($diff ? 'bold text-success' : ''); ?>"><?php echo $fd['appgini']; ?></td>
				<td class="<?php echo ($diff ? 'bold text-danger' : ''); ?>"><?php echo thisOr($fd['db'], $Translation['does not exist']); ?></td>
				<td>
					<?php if($diff && $no_db){ ?>
						<a href="pageRebuildFields.php?t=<?php echo $tn; ?>&f=<?php echo $fn; ?>" class="btn btn-success btn-xs btn_create" data-toggle="tooltip" data-placement="top" title="<?php echo $Translation['create field'] ; ?>"><i class="glyphicon glyphicon-plus"></i> <?php echo $Translation['create it'] ; ?></a>
					<?php }elseif($diff){ ?>
						<a href="pageRebuildFields.php?t=<?php echo $tn; ?>&f=<?php echo $fn; ?>" class="btn btn-warning btn-xs btn_update" data-toggle="tooltip" title="<?php echo $Translation['fix field'] ; ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['fix it'] ; ?></a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	<?php } ?>
	</tbody>
</table>
<div class="alert summary"></div>

<style>
	.bold{ font-weight: bold; }
	[data-toggle="tooltip"]{ display: block !important; }
</style>

<script>
	$j(function(){
		$j('[data-toggle="tooltip"]').tooltip();

		$j('#show_deviations_only').click(function(){
			$j(this).addClass('hidden');
			$j('#show_all_fields').removeClass('hidden');
			$j('.field_ok').hide();
		});

		$j('#show_all_fields').click(function(){
			$j(this).addClass('hidden');
			$j('#show_deviations_only').removeClass('hidden');
			$j('.field_ok').show();
		});

		$j('.btn_update, #fix_all').click(function(){
			return confirm("<?php echo $Translation['field update warning'] ; ?>");
		});

		var count_updates = $j('.btn_update').length;
		var count_creates = $j('.btn_create').length;
		if(!count_creates && !count_updates){
			$j('.summary').addClass('alert-success').html("<?php echo $Translation['no deviations found'] ; ?>");
		}else{
			var fieldsCount = "<?php echo $Translation['error fields']; ?>";
			fieldsCount = fieldsCount.replace(/<CREATENUM>/, count_creates ).replace(/<UPDATENUM>/, count_updates);


			$j('.summary')
				.addClass('alert-warning')
				.html(
					fieldsCount + 
					'<br><br>' + 
					'<a href="pageBackupRestore.php" class="alert-link">' +
						'<b><?php echo addslashes($Translation['backup before fix']); ?></b>' +
					'</a>'
				);

			$j('<a href="pageRebuildFields.php?all=1" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-cog"></i> <?php echo addslashes($Translation['fix all']); ?></a>').appendTo('#fix_all');
		}
	});
</script>

<?php
	include("{$currDir}/incFooter.php");
?>
