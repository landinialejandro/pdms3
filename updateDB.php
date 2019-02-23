<?php
	// check this file's MD5 to make sure it wasn't called before
	$prevMD5=@implode('', @file(dirname(__FILE__).'/setup.md5'));
	$thisMD5=md5(@implode('', @file("./updateDB.php")));
	if($thisMD5==$prevMD5){
		$setupAlreadyRun=true;
	}else{
		// set up tables
		if(!isset($silent)){
			$silent=true;
		}

		// set up tables
		setupTable('orders', "create table if not exists `orders` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `progressivNumber` CHAR(10) null , `consigneeID` CHAR(10) null , `company` INT unsigned not null , `typeDoc` VARCHAR(40) not null , `multiOrder_nr_PA` INT not null , `formatoTrasmissione_PA` CHAR(5) null default 'SDI10' , `tipo_Documento_PA` CHAR(4) not null default 'TD01' , `divisa_PA` CHAR(3) not null default 'EUR' , `importo_Sc_Mg_PA` DECIMAL(15,2) null , `importoTot_Doc_PA` DECIMAL(10,2) not null , `arrotondamento_PA` DECIMAL(15,2) null , `causale_PA` VARCHAR(200) not null default 'VENDITA' , `art73_PA` CHAR(2) null , `data_Ord_PA` DATE not null , `dataOraRit_PA` DATE null , `dataInizTrasp_PA` DATE null , `customer` INT unsigned null , `supplier` INT unsigned null , `employee` INT unsigned null , `shipVia` INT unsigned null , `Freight` DECIMAL(10,2) null , `pallets` INT null , `mezzoTraspVet_PA` VARCHAR(80) null , `causaleTraspVet_PA` VARCHAR(100) null , `nrColliVett_PA` SMALLINT(4) null , `descTraspVet_PA` VARCHAR(100) null , `cashCredit` VARCHAR(255) null default '1' , `trust` INT unsigned null , `overdraft` INT null , `commisionFee` DECIMAL(10,2) null , `commisionRate` DECIMAL(10,2) null , `related` INT null , `document` VARCHAR(255) null , `tipo_rit_PA` CHAR(4) null , `imp_rit_PA` CHAR(15) null , `aliq_rit_PA` SMALLINT(6) null , `causale_pag_rit_PA` CHAR(1) null , `nr_bollo_rit_PA` CHAR(14) null , `importo_Bollo_rit_PA` VARCHAR(255) null , `tipo_cassa_Prev_PA` CHAR(4) null , `al_cassa_Prev_PA` SMALLINT(6) null , `importo_cont_cassa_prev_PA` INT(15) null , `imponibile_cassa_Prev_PA` SMALLINT(15) null , `aliq_IVA_cassa_prev_PA` SMALLINT(6) null , `ritenuta_cassa_prev_PA` CHAR(2) null , `natura_cassa_prev_PA` CHAR(2) null , `rif_amm_prev_PA` CHAR(20) null , `tipoResa_PA` CHAR(3) null default 'EXW' , `indirizzoResa_PA` VARCHAR(60) null , `nrCivicoResa_PA` CHAR(8) null , `CAP_Resa_PA` INT unsigned null , `comuneResa_PA` INT unsigned null , `provResa_PA` INT unsigned null , `nazioneResa_PA` INT unsigned null , `dataOraCons_PA` DATE null ) CHARSET utf8", $silent);
		setupIndexes('orders', array('kind','company','typeDoc','customer','supplier','employee','shipVia','CAP_Resa_PA','nazioneResa_PA'));
		setupTable('ordersDetails', "create table if not exists `ordersDetails` (   `id` INT unsigned not null auto_increment , primary key (`id`), `order` INT unsigned null , `manufactureDate` DATE null , `sellDate` DATE null , `expiryDate` DATE null , `daysToExpiry` INT null , `codebar` INT null , `productCode` INT not null , `batch` INT null , `packages` DECIMAL(10,2) null , `noSell` INT null , `quantity_PA` DECIMAL(10,2) null default '1' , `QuantityReal` DECIMAL(10,2) not null , `UMRifPeso_PA` INT not null , `prezzoUn_PA` DECIMAL(21,2) not null , `aliquotaIVA_PA` DECIMAL(6,2) not null , `prezzoTot_PA` DECIMAL(21,2) unsigned not null , `tipoScMAg_PA` CHAR(2) null , `percScontoLinea_PA` DECIMAL(10,2) null , `section` VARCHAR(40) null default 'Magazzino Metaponto' , `transaction_type` INT unsigned null , `skBatches` INT unsigned null , `averagePrice` DECIMAL(10,2) null , `averageWeight` DECIMAL(10,2) null , `commission` DECIMAL(10,2) null default '15.00' , `return` VARCHAR(255) null default '1' , `supplierCode` VARCHAR(100) null , `causTrasp_PA` VARCHAR(100) null , `nrLinea_PA` SMALLINT(4) null , `tipoCessionePrest_PA` VARCHAR(255) null , `codTipo_PA` CHAR(35) null , `codValore_PA` CHAR(35) null , `descrizioneArt_PA` INT not null , `percentualeScontoMag_PA` DECIMAL(6,2) null , `importoScontoMag_PA` DECIMAL(15,2) null , `imponibileImp_PA` DECIMAL(15,2) null , `impostaRiep_PA` DECIMAL(15,2) null , `LineTotal` DECIMAL(10,2) null , `esigibilitaIVA_PA` CHAR(1) null default 'D' , `ritenuta_PA` CHAR(2) null , `natura_PA` CHAR(2) null , `rifAmmin_PA` CHAR(20) null , `tipoDato_PA` CHAR(10) null , `riferTesto_PA` CHAR(60) null , `rifNumero_PA` DECIMAL(21,2) null , `rifData_PA` DATE null , `aliquotaIVAriep_PA` DECIMAL(6,2) null , `naturaRiep_PA` CHAR(2) null , `speseAccess_PA` DECIMAL(15,2) null , `arrotondamentoRiep_PA` DECIMAL(15,2) null , `rifNormativoRiep_PA` VARCHAR(100) null ) CHARSET utf8", $silent);
		setupIndexes('ordersDetails', array('order','productCode','section'));
		setupTable('_resumeOrders', "create table if not exists `_resumeOrders` (   `kind` VARCHAR(40) null , `company` INT unsigned null , `typedoc` VARCHAR(40) null , `customer` INT unsigned null , `TOT` VARCHAR(40) null , `MONTH` VARCHAR(40) null , `YEAR` VARCHAR(40) null , `DOCs` VARCHAR(40) null , `related` INT unsigned null , `id` INT unsigned not null auto_increment , primary key (`id`)) CHARSET utf8", $silent);
		setupIndexes('_resumeOrders', array('kind','company','typedoc','customer','related'));
		setupTable('products', "create table if not exists `products` (   `id` INT not null auto_increment , primary key (`id`), `codebar` VARCHAR(16) null , `productCode` VARCHAR(255) null , `productName` VARCHAR(255) null , `tax` VARCHAR(40) null , `increment` DECIMAL(10,2) null , `CategoryID` VARCHAR(40) null , `UM` VARCHAR(40) null , `tare` DECIMAL(10,2) null , `QuantityPerUnit` VARCHAR(50) null , `UnitPrice` DECIMAL(10,2) null , `sellPrice` DECIMAL(10,2) null , `UnitsInStock` DECIMAL(10,2) null , `UnitsOnOrder` DECIMAL(10,2) null default '0' , `ReorderLevel` DECIMAL(10,2) null default '0' , `balance` DECIMAL(10,2) null , `Discontinued` INT null default '0' , `manufactured_date` DATE null , `expiry_date` DATE null , `note` TEXT null , `update_date` DATETIME null ) CHARSET utf8", $silent);
		setupIndexes('products', array('tax','CategoryID'));
		setupTable('firstCashNote', "create table if not exists `firstCashNote` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `order` INT unsigned null , `operationDate` DATE null , `company` INT unsigned null , `customer` INT unsigned null , `documentNumber` INT null , `causal` VARCHAR(255) null , `importoPag_PA` DECIMAL(15,2) null , `outputs` DECIMAL(10,2) null , `balance` DECIMAL(10,2) null , `idBank` INT unsigned null , `istitutoFinanziario_PA` INT unsigned null , `note` VARCHAR(255) null , `paymentDeadLine` DATE null , `payed` VARCHAR(255) null default '0' , `datiPag_PA` VARCHAR(255) null , `modPagam_PA` CHAR(4) null default 'MP02' , `dataRifTerPag_PA` DATE null , `giorniTermPag_PA` SMALLINT(3) null , `dataScadPag_PA` DATE null , `codUffPost_PA` CHAR(20) null , `cognomeQuietanzante_PA` VARCHAR(60) null , `nomeQuietanzante_PA` VARCHAR(60) null , `codFiscQuietanzante_PA` CHAR(16) null , `titoloQuietanzante_PA` CHAR(10) null ) CHARSET utf8", $silent);
		setupIndexes('firstCashNote', array('kind','order','customer','idBank'));
		setupTable('vatRegister', "create table if not exists `vatRegister` (   `id` INT unsigned not null auto_increment , primary key (`id`), `idCompany` INT unsigned null , `companyName` INT unsigned null , `tax` VARCHAR(40) null default '4%' , `month` VARCHAR(40) null , `year` VARCHAR(40) null default '2018' , `amount` DECIMAL(10,2) null , `ufficio_Ced_PA` CHAR(2) null , `numeroREA_Ced_PA` CHAR(20) null , `capitaleSociale_Ced_PA` DECIMAL(15,2) null , `socioUnico_Ced_PA` CHAR(2) null default 'SM' , `statoLiquidazione_Ced_PA` CHAR(2) null default 'LN' ) CHARSET utf8", $silent);
		setupIndexes('vatRegister', array('idCompany'));
		setupTable('companies', "create table if not exists `companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `companyCode` VARCHAR(255) null , `companyName` VARCHAR(255) null , `notes` TEXT null , `codiceDestinatarioUff_PA` INT unsigned null , `idPaese_Ced_PA` INT unsigned not null , `idCodice_Ced_PA` CHAR(28) not null , `codiceFiscale_Ced_PA` CHAR(28) not null , `denominazione_Ced_PA` VARCHAR(80) not null , `titolo_Ced_PA` CHAR(10) null , `nome_Ced_PA` VARCHAR(60) null , `cognome_Ced_PA` VARCHAR(60) null , `codEORICed__PA` CHAR(17) null , `alboProfessionale_Ced_PA` VARCHAR(60) null , `provinciaAlbo_Ced_PA` CHAR(2) null , `numeroIscrizione_Ced_AlboPA` VARCHAR(60) null , `dataIscrAlbo_Ced_PA` DATE null , `regimeFiscalePA` CHAR(4) not null default 'RF01' , `idPaeseVett_PA` CHAR(3) not null default 'IT' , `idFiscaleVet_PA` CHAR(28) not null , `codFiscVet_PA` CHAR(16) not null , `denominazioneVet_PA` VARCHAR(80) not null , `titoloVet_PA` CHAR(10) null , `nomeVet_PA` VARCHAR(60) null , `cognomeVett_PA` VARCHAR(60) null , `codEORIVet_PA` CHAR(17) null , `nrLicGuidaVet_PA` CHAR(20) null , `data_DatiVeic_PA` DATE null , `totalPercVeic_PA` CHAR(15) null , `mezzoTrVet_PA` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupIndexes('companies', array('kind','idPaese_Ced_PA'));
		setupTable('CLIENTI_CESSIONARI_PA', "create table if not exists `CLIENTI_CESSIONARI_PA` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `idPaese_Ces_PA` INT unsigned not null , `idCodice_Ces_PA` CHAR(28) not null , `codiceFiscale_Ces_PA` CHAR(16) not null , `Denominazione_Ces_PA` VARCHAR(80) null , `tit_Ces_PA` CHAR(10) null , `nome_Ces_PA` VARCHAR(60) null , `cogn_Ces_PA` VARCHAR(60) null , `Cod_Ces_EORI_PA` VARCHAR(40) null , `indirizzo_Ces_PA` VARCHAR(60) not null , `numeroCiv_CesPA` CHAR(8) null , `CAP_Ces_PA` CHAR(5) not null , `comune_Ces_PA` VARCHAR(60) not null , `pr_Ces_PA` INT unsigned not null , `nazione_Ces_PA` VARCHAR(255) not null default 'IT' , `notes` TEXT null , `birthDate` DATE null , `autorizzSanitaria_SAM` VARCHAR(255) null , `AutSanEmessa_SAM` VARCHAR(255) null , `NrPresSan_SAM` VARCHAR(255) null , `NrAutSan_SAM` VARCHAR(40) null , `dataAutSan_SAM` DATE null ) CHARSET utf8", $silent);
		setupIndexes('CLIENTI_CESSIONARI_PA', array('kind','idPaese_Ces_PA','pr_Ces_PA'));
		setupTable('creditDocument', "create table if not exists `creditDocument` (   `id` INT unsigned not null auto_increment , primary key (`id`), `incomingTypeDoc` VARCHAR(255) null , `customerID` VARCHAR(255) null , `nrDoc` VARCHAR(255) null , `dateIncomingNote` DATE null , `customerFirm` VARCHAR(255) null , `customerAddress` VARCHAR(255) null , `customerPostCode` VARCHAR(255) null , `customerTown` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupTable('electronicInvoice', "create table if not exists `electronicInvoice` (   `id` INT unsigned not null auto_increment , primary key (`id`), `idPaese_TR_PA` INT unsigned null , `idCodice_TR_PA` INT unsigned null , `progressivoInvioPA` CHAR(28) null , `formatoTrasmissionePA` CHAR(5) null default 'SDI10' , `codiceDestinatarioPA` INT unsigned null , `telefonoPA` INT unsigned null , `emailPA` VARCHAR(255) null , `idFiscaleIVA_Ced_PA` INT unsigned null , `codiceFiscale_Ced_PA` INT unsigned null , `denominazione_Ced_PA` INT unsigned null , `nome_Ced_PA` INT unsigned null , `cognome_Ced_PA` INT unsigned null , `titolo_Ced_PA` INT unsigned null , `codEORI_Ced_PA` INT unsigned null , `alboProfessionale_Ced_PA` INT unsigned null , `provinciaAlbo_Ced_PA` INT unsigned null , `nrIscrizioneAlbo_Ced_PA` INT unsigned null , `dataIscAlbo_Ced_PA` INT unsigned null , `regimeFiscale_Ced_PA` INT unsigned null , `indirizzo_Ced_PA` INT unsigned null , `numeroCivico_Ced_PA` INT unsigned null , `CAP_Ced_PA` INT unsigned null , `comune_Ced_PA` INT unsigned null , `provincia_Ced_PA` INT unsigned null , `nazione_Ced_PA` INT unsigned null , `altroIndirizzo_Ced_PA` INT unsigned null , `altro_nr_Civico_Ced_PA` INT unsigned null , `altroCAP_Ced_PA` INT unsigned null , `altro_Com_Ced_PA` INT unsigned null , `altro_PR_Ced_PA` INT unsigned null , `altraNazione_Ced_PA` INT unsigned null , `ufficio_Ced_PA` INT unsigned null , `numeroREA_Ced__PA` INT unsigned null , `capitaleSociale_Ced_PA` INT unsigned null , `socioUnico_Ced_PA` INT unsigned null , `statoLiquidazione_Ced_PA` INT unsigned null , `telefonoCompany_Ced_PA` INT unsigned null , `faxCompany_Ced_PA` INT unsigned null , `eMailCompany_Ced_PA` INT unsigned null , `rif_Amm_Ced_PA` CHAR(20) null , `idPaeseRap_Fisc_PA` INT unsigned null , `idPaeseRap_CodPA` INT unsigned null , `idCodFiscRap_Fisc_PA` INT unsigned null , `idDenominazioneRap_FiscPA` INT unsigned null , `idNomeRap_Fisc_PA` INT unsigned null , `idCognRap_Fisc_PA` INT unsigned null , `idTitoloRap_Fisc_PA` INT unsigned null , `idEORI_Rap_Fisc_PA` INT unsigned null , `idPaeseCess_PA` INT unsigned null , `idCodiceCess_PA` INT unsigned null , `idCodiceFiscCess_PA` CHAR(16) null , `denominazioneCess_PA` INT unsigned null , `nomeCess_PA` INT unsigned null , `cognomeCess_PA` INT unsigned null , `titoloCess_PA` INT unsigned null , `codEORI_Cess_PA` INT unsigned null , `indirizzoCess_PA` INT unsigned null , `nrCivicoCess_PA` INT unsigned null , `CAP_Cess_PA` INT unsigned null , `comuneCess_PA` INT unsigned null , `provCess_PA` INT unsigned null , `nazione_Cess_PA` INT unsigned null , `idPaese3intSogEm_PA` INT unsigned null , `idCod_3intSogEm_PA` INT unsigned null , `codFisc_3intSogEm_PA` INT unsigned null , `denom_3intSogEm_PA` INT unsigned null , `nome_3_intSogEm_PA` INT unsigned null , `cogn_3_intSogEm_PA` INT unsigned null , `tit_3_IntSogEm_PA` INT unsigned null , `codEORi_3_intSogEm_PA` INT unsigned null , `SoggettoEmittente_PA` VARCHAR(255) null , `tipoDocumentoFEB_PA` INT unsigned null , `divisaFEB_PA` INT unsigned null , `dataFEB_PA` INT unsigned null , `numeroFEB_PA` INT unsigned null , `tipoRiten_PA` INT unsigned null , `impRiten_PA` INT unsigned null , `aliqRiten_PA` INT unsigned null , `causPagRit_PA` INT unsigned null , `numBolloRit_PA` INT unsigned null , `impBolloRit_PA` INT unsigned null , `tipoCassaPrev_PA` INT unsigned null , `alCassaPr_PA` INT unsigned null , `impContCassaPr_PA` INT unsigned null , `imponCassaPr_PA` INT unsigned null , `aliIVA_CassaPr_PA` INT unsigned null , `ritCassaPr_PA` INT unsigned null , `naturaCassaPr_PA` INT unsigned null , `rifAmmCasPr_PA` INT unsigned null , `tipoScMag_PA` INT unsigned null , `percScMag_PA` INT unsigned null , `impScMag_PA` INT unsigned null , `ImpTotDoc_PA` INT unsigned null , `arrotDoc_PA` INT unsigned null , `causale_Doc_PA` INT unsigned null , `art73_doc_PA` INT unsigned null , `rifNumLineaDoc_PA` INT unsigned null , `idDocNum_PA` INT unsigned null , `dataOrder_PA` INT unsigned null , `numItemDoc_PA` INT unsigned null , `codCommConvDoc_PA` INT unsigned null , `codCUP_PA` INT unsigned null , `codCIG_PA` INT unsigned null , `RIFERIMENTO_FASE_PA` INT unsigned null , `NUMERO_DDT_PA` INT unsigned null , `dataDDT_PA` INT unsigned null , `rifNumLinea_PA` INT unsigned null , `ID_PAESE_VET_PA` INT unsigned null , `idCodVet_PA` INT unsigned null , `codFiscVet_PA` INT unsigned null , `DENOMINAZIONE_ANAGR_VETT_PA` INT unsigned null , `nomeVett_PA` INT unsigned null , `cognVett_PA` INT unsigned null , `titVett_PA` INT unsigned null , `codEORI_Vet_PA` INT unsigned null , `nrLicenzaGuidaVet_PA` INT unsigned null , `mezzoTraspVet_PA` INT unsigned null , `causaleTrsVet_PA` INT unsigned null , `nrColliTrasp_PA` INT unsigned null , `descrTrasp_PA` INT unsigned null , `unMisPeso_PA` INT unsigned null , `pesoLordoMerce_PA` INT unsigned null , `pesoNettoMer_PA` INT unsigned null , `dataOraRitMer_PA` INT unsigned null , `dataInTrMer_PA` INT unsigned null , `tipoResaTr_PA` INT unsigned null , `INDIRIZZO_RESA_PA` INT unsigned null , `nrCivResa_PA` INT unsigned null , `capResa_PA` INT unsigned null , `comuneResa_PA` INT unsigned null , `prResa_PA` INT unsigned null , `nazioneResa_PA` INT unsigned null , `dataOraCons_PA` INT unsigned null , `normaRif_PA` INT unsigned null , `NR_FATT_PRINC_PA` INT unsigned null , `dataFattPrin_PA` INT unsigned null , `NUMERO_LINEA_BENI_SERV_PA` VARCHAR(255) null , `tipoCessPrest_PA` CHAR(2) null , `CODICE_TIPO_PA` CHAR(35) null , `codiceVal_PA` CHAR(35) null , `descrizioneBene_PA` INT unsigned null , `quantitaBene_PA` INT unsigned null , `uniMisBene_PA` INT unsigned null , `dataInPeriodo_PA` DATE null , `dataFinePeriodo_PA` DATE null , `prezzoUn_PA` INT unsigned null , `TIPO_SCONTO_MAG_PA` INT unsigned null , `perScMagBene_PA` INT unsigned null , `impScMagBene_PA` INT unsigned null , `prezzoTotaleBene_PA` INT unsigned null , `aliqIVA_bene_PA` INT unsigned null , `ritenuta_bene_PA` CHAR(2) null , `naturaRitBene` VARCHAR(255) null , `rifAmm_PA` CHAR(20) null , `TIPO_DATO_ALTRI_DATI_PA` VARCHAR(255) null , `rifTesto_altri_dati_PA` VARCHAR(60) null , `rifNum_Altri_dati_PA` DECIMAL(21,2) null , `rifData_altri_dati_PA` DATE null , `AL_IVA_RIEP_PA` INT unsigned null , `naturaRiep_PA` INT unsigned null , `speseAcc_Riep_PA` INT unsigned null , `arrotRiep_PA` INT unsigned null , `imponibileImpRiep_PA` INT unsigned null , `impostaRiep_PA` INT unsigned null , `esigIVA_riep_PA` INT unsigned null , `rifNormRiep_PA` VARCHAR(255) null , `DATA_DATI_VEIC_PA` INT unsigned null , `totalePercorso_PA` INT unsigned null , `BENEFIC_DATI_PAG_PA` INT unsigned null , `modPagam_PA` INT unsigned null , `dataRifTermPag_PA` INT unsigned null , `giorniTermPag_PA` INT unsigned null , `dataScadPag_PA` INT unsigned null , `imporPag_PA` INT unsigned null , `codUffPostale_PA` INT unsigned null , `cognomeQuietanzante_PA` INT unsigned null , `nomeQuietanzante_PA` INT unsigned null , `CF_Quietanzante_PA` INT unsigned null , `titQuietanzante_PA` INT unsigned null , `IBAN_PA` INT unsigned null , `ABI_PA` VARCHAR(255) null , `CAB_PA` INT unsigned null , `BIC_PA` VARCHAR(255) null , `scontoPagAntic_PA` INT unsigned null , `dataLimPagAntic_PA` INT unsigned null , `penRitarPagam_PA` INT unsigned null , `dataDecPenale_PA` INT unsigned null , `codPagamento_PA` INT unsigned null , `ALLEGATI_NOME_ALL_PA` INT unsigned null , `algoritmoComp_PA` INT unsigned null , `formatoAttachement_PA` INT unsigned null , `descrizioneAttach_PA` INT unsigned null , `attachment_PA` INT unsigned null ) CHARSET utf8", $silent);
		setupIndexes('electronicInvoice', array('telefonoPA','idFiscaleIVA_Ced_PA','indirizzo_Ced_PA','ufficio_Ced_PA','faxCompany_Ced_PA','eMailCompany_Ced_PA','idPaeseRap_Fisc_PA','idPaeseCess_PA','tipoDocumentoFEB_PA','rifNumLineaDoc_PA','BENEFIC_DATI_PAG_PA','ALLEGATI_NOME_ALL_PA'));
		setupTable('countries', "create table if not exists `countries` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` VARCHAR(255) null , `code` VARCHAR(100) null , `ISOcode` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupTable('town', "create table if not exists `town` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` INT unsigned null , `idIstat` VARCHAR(255) null , `town` VARCHAR(255) null , `district` VARCHAR(255) null , `region` VARCHAR(255) null , `prefix` VARCHAR(255) null , `shipCode` VARCHAR(255) null , `fiscCode` VARCHAR(255) null , `inhabitants` VARCHAR(255) null , `link` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupIndexes('town', array('country'));
		setupTable('GPSTrackingSystem', "create table if not exists `GPSTrackingSystem` (   `id` INT unsigned not null auto_increment , primary key (`id`), `carTracked` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupTable('kinds', "create table if not exists `kinds` (   `entity` BLOB not null , `code` VARCHAR(40) not null , primary key (`code`), `name` VARCHAR(255) not null , `value` TEXT null , `descriptions` TEXT null ) CHARSET utf8", $silent);
		setupTable('Logs', "create table if not exists `Logs` (   `id` INT unsigned not null auto_increment , primary key (`id`), `ip` VARCHAR(16) null , `ts` BIGINT null , `details` TEXT null ) CHARSET utf8", $silent);
		setupTable('attributes', "create table if not exists `attributes` (   `id` INT unsigned not null auto_increment , primary key (`id`), `attribute` VARCHAR(40) null , `value` TEXT null , `contact` INT unsigned null , `companies` INT unsigned null , `products` INT null ) CHARSET utf8", $silent);
		setupIndexes('attributes', array('attribute','contact','companies','products'));
		setupTable('addresses_PA', "create table if not exists `addresses_PA` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `indirizzo_Ced_PA` VARCHAR(60) null , `numeroCivico_Ced_PA` CHAR(8) null , `CAP_Ced_PA` INT unsigned null , `comune_Ced_PA` INT unsigned null , `provincia_Ced_PA` INT unsigned null , `nazione_Ced_PA` INT unsigned null , `IBAN_PA` CHAR(34) null , `ABI_PA` SMALLINT(5) null , `CAB_PA` SMALLINT(5) null , `BIC_PA` CHAR(11) null , `altroIndirizzo_Ced_PA` VARCHAR(60) null , `altro_nr_Civico_Ced_PA` CHAR(8) null , `altroCAP_Ced_PA` CHAR(5) null , `altra_PR_Ced_PA` CHAR(2) null , `altraNazione_Ced_PA` INT unsigned null , `indirizzo_Ces_PA` VARCHAR(60) null , `numeroCivico_Ces_PA` CHAR(8) null , `CAP_Ces_PA` CHAR(5) null , `comune_Ces_PA` VARCHAR(60) null , `prov_Ces_PA` CHAR(2) null , `nazione_Ces_PA` CHAR(2) null default 'IT' , `contact` INT unsigned null , `company` INT unsigned null , `map` VARCHAR(40) null , `default` INT null default '0' , `ship` INT null default '0' , `scontoPagAnt_PA` DECIMAL(15,2) null , `dataPagAntic_PA` DATE null , `penalRitardPag_PA` DECIMAL(15,2) null , `dataDecorPag_PA` DATE null , `codPagam_PA` CHAR(15) null ) CHARSET utf8", $silent);
		setupIndexes('addresses_PA', array('kind','provincia_Ced_PA','nazione_Ced_PA','contact','company'));
		setupTable('phones', "create table if not exists `phones` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `phoneNumber` VARCHAR(255) null , `contact` INT unsigned null , `company` INT unsigned null ) CHARSET utf8", $silent);
		setupIndexes('phones', array('kind','contact','company'));
		setupTable('PEC', "create table if not exists `PEC` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `PEC_PA` VARCHAR(255) null , `codiceUnivocoPA` CHAR(7) null , `contact` INT unsigned null , `company` INT unsigned null ) CHARSET utf8", $silent);
		setupIndexes('PEC', array('kind','contact','company'));
		setupTable('contacts_companies', "create table if not exists `contacts_companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `contact` INT unsigned null , `company` INT unsigned null , `default` VARCHAR(40) null default '0' , `telefonoCompanyPA` CHAR(12) null , `faxCompanyPA` CHAR(12) null , `eMailCompanyPA` VARCHAR(255) null , `riferimentoAmministrazionePA` CHAR(20) null ) CHARSET utf8", $silent);
		setupIndexes('contacts_companies', array('contact','company'));
		setupTable('allegati_PA', "create table if not exists `allegati_PA` (   `id` INT unsigned not null auto_increment , primary key (`id`), `momeAlleg_PA` VARCHAR(60) null , `file` VARCHAR(255) null , `contact` INT unsigned null , `company` INT unsigned null , `algoritmoComp_PA` CHAR(10) null , `thumbUse` INT null default '0' , `formatoAlleg_PA` CHAR(10) null default 'PDF' , `descrizAlleg_PA` VARCHAR(100) null default 'Allegato Ft. in PDF' ) CHARSET utf8", $silent);
		setupIndexes('allegati_PA', array('contact','company'));
		setupTable('sogg_Terzi_Rapp_PA', "create table if not exists `sogg_Terzi_Rapp_PA` (   `id` INT unsigned not null auto_increment , primary key (`id`), `idPaese_RF_PA` INT unsigned null , `idCodice_RF_PA` CHAR(28) null , `codiceFiscale_RF_PA` CHAR(16) null , `denominazione_RF_PA` VARCHAR(80) null , `nome_RF_PA` VARCHAR(60) null , `cognome_RF_PA` VARCHAR(60) null , `titolo_RF_PA` CHAR(10) null , `codEORI__RF_PA` CHAR(17) null , `idPaeseIVA_3_Int_PA` CHAR(2) null , `idCodice_3_Int_PA` CHAR(28) null , `codFiscale_3_Int_PA` CHAR(16) null , `denominazione_3_Int_PA` VARCHAR(80) null , `nome_3_Int_PA` VARCHAR(60) null , `cognome_3_Int_PA` VARCHAR(60) null , `titolo_3_Int_PA` CHAR(10) null , `codEORI_3_Int_PA` CHAR(17) null , `sogg_Emittente_PA` VARCHAR(255) null , `rif_num_linea_PA` SMALLINT(4) null , `idDoc_PA` CHAR(20) null , `data_orAcq_PA` DATE null , `numItem_PA` CHAR(20) null , `codCom_Con_PA` VARCHAR(100) null , `codCUP_PA` CHAR(15) null , `codGIG_PA` CHAR(15) null , `datiCont_PA` VARCHAR(255) null , `datiConv_PA` VARCHAR(255) null , `datiRic_PA` VARCHAR(255) null , `datiFatCol_PA` VARCHAR(255) null , `datiSal_PA` VARCHAR(255) null , `riferFase_PA` SMALLINT(3) null , `normaRifer_PA` VARCHAR(100) null , `nrFatturaPrinc_PA` CHAR(20) null , `dataFattPrinc_PA` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupIndexes('sogg_Terzi_Rapp_PA', array('idPaese_RF_PA'));


		// save MD5
		if($fp=@fopen(dirname(__FILE__).'/setup.md5', 'w')){
			fwrite($fp, $thisMD5);
			fclose($fp);
		}
	}


	function setupIndexes($tableName, $arrFields){
		if(!is_array($arrFields)){
			return false;
		}

		foreach($arrFields as $fieldName){
			if(!$res=@db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")){
				continue;
			}
			if(!$row=@db_fetch_assoc($res)){
				continue;
			}
			if($row['Key']==''){
				@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
			}
		}
	}


	function setupTable($tableName, $createSQL='', $silent=true, $arrAlter=''){
		global $Translation;
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)){
			$matches=array();
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/", $arrAlter[0], $matches)){
				$oldTableName=$matches[1];
			}
		}

		if($res=@db_query("select count(1) from `$tableName`")){ // table already exists
			if($row = @db_fetch_array($res)){
				echo str_replace("<TableName>", $tableName, str_replace("<NumRecords>", $row[0],$Translation["table exists"]));
				if(is_array($arrAlter)){
					echo '<br>';
					foreach($arrAlter as $alter){
						if($alter!=''){
							echo "$alter ... ";
							if(!@db_query($alter)){
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							}else{
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				}else{
					echo $Translation["table uptodate"];
				}
			}else{
				echo str_replace("<TableName>", $tableName, $Translation["couldnt count"]);
			}
		}else{ // given tableName doesn't exist

			if($oldTableName!=''){ // if we have a table rename query
				if($ro=@db_query("select count(1) from `$oldTableName`")){ // if old table exists, rename it.
					$renameQuery=array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)){
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					}else{
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				}else{ // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			}else{ // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)){
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';
				}else{
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}
		}

		echo "</div>";

		$out=ob_get_contents();
		ob_end_clean();
		if(!$silent){
			echo $out;
		}
	}
?>