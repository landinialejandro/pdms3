<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/sogg_Terzi_Rapp_PA.php");
	include("$currDir/sogg_Terzi_Rapp_PA_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('sogg_Terzi_Rapp_PA');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "sogg_Terzi_Rapp_PA";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`sogg_Terzi_Rapp_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') /* Id Paese PA */" => "idPaese_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_RF_PA`" => "idCodice_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codiceFiscale_RF_PA`" => "codiceFiscale_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_RF_PA`" => "denominazione_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_RF_PA`" => "nome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_RF_PA`" => "cognome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_RF_PA`" => "titolo_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI__RF_PA`" => "codEORI__RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idPaeseIVA_3_Int_PA`" => "idPaeseIVA_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_3_Int_PA`" => "idCodice_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codFiscale_3_Int_PA`" => "codFiscale_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_3_Int_PA`" => "denominazione_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_3_Int_PA`" => "nome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_3_Int_PA`" => "cognome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_3_Int_PA`" => "titolo_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI_3_Int_PA`" => "codEORI_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`sogg_Emittente_PA`" => "sogg_Emittente_PA",
		"`sogg_Terzi_Rapp_PA`.`rif_num_linea_PA`" => "rif_num_linea_PA",
		"`sogg_Terzi_Rapp_PA`.`idDoc_PA`" => "idDoc_PA",
		"if(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,date_format(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,'%Y-%m-%d'),'')" => "data_orAcq_PA",
		"`sogg_Terzi_Rapp_PA`.`numItem_PA`" => "numItem_PA",
		"`sogg_Terzi_Rapp_PA`.`codCom_Con_PA`" => "codCom_Con_PA",
		"`sogg_Terzi_Rapp_PA`.`codCUP_PA`" => "codCUP_PA",
		"`sogg_Terzi_Rapp_PA`.`codGIG_PA`" => "codGIG_PA",
		"`sogg_Terzi_Rapp_PA`.`datiCont_PA`" => "datiCont_PA",
		"`sogg_Terzi_Rapp_PA`.`datiConv_PA`" => "datiConv_PA",
		"`sogg_Terzi_Rapp_PA`.`datiRic_PA`" => "datiRic_PA",
		"`sogg_Terzi_Rapp_PA`.`datiFatCol_PA`" => "datiFatCol_PA",
		"`sogg_Terzi_Rapp_PA`.`datiSal_PA`" => "datiSal_PA",
		"`sogg_Terzi_Rapp_PA`.`riferFase_PA`" => "riferFase_PA",
		"`sogg_Terzi_Rapp_PA`.`normaRifer_PA`" => "normaRifer_PA",
		"`sogg_Terzi_Rapp_PA`.`nrFatturaPrinc_PA`" => "nrFatturaPrinc_PA",
		"DATE_FORMAT(`sogg_Terzi_Rapp_PA`.`dataFattPrinc_PA`, '%Y-%m-%d %H:%i')" => "dataFattPrinc_PA"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`sogg_Terzi_Rapp_PA`.`id`',
		2 => '`countries1`.`code`',
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => 12,
		13 => 13,
		14 => 14,
		15 => 15,
		16 => 16,
		17 => 17,
		18 => 18,
		19 => '`sogg_Terzi_Rapp_PA`.`rif_num_linea_PA`',
		20 => 20,
		21 => '`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`',
		22 => 22,
		23 => 23,
		24 => 24,
		25 => 25,
		26 => 26,
		27 => 27,
		28 => 28,
		29 => 29,
		30 => 30,
		31 => '`sogg_Terzi_Rapp_PA`.`riferFase_PA`',
		32 => 32,
		33 => 33,
		34 => 34
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`sogg_Terzi_Rapp_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') /* Id Paese PA */" => "idPaese_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_RF_PA`" => "idCodice_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codiceFiscale_RF_PA`" => "codiceFiscale_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_RF_PA`" => "denominazione_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_RF_PA`" => "nome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_RF_PA`" => "cognome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_RF_PA`" => "titolo_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI__RF_PA`" => "codEORI__RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idPaeseIVA_3_Int_PA`" => "idPaeseIVA_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_3_Int_PA`" => "idCodice_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codFiscale_3_Int_PA`" => "codFiscale_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_3_Int_PA`" => "denominazione_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_3_Int_PA`" => "nome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_3_Int_PA`" => "cognome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_3_Int_PA`" => "titolo_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI_3_Int_PA`" => "codEORI_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`sogg_Emittente_PA`" => "sogg_Emittente_PA",
		"`sogg_Terzi_Rapp_PA`.`rif_num_linea_PA`" => "rif_num_linea_PA",
		"`sogg_Terzi_Rapp_PA`.`idDoc_PA`" => "idDoc_PA",
		"if(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,date_format(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,'%Y-%m-%d'),'')" => "data_orAcq_PA",
		"`sogg_Terzi_Rapp_PA`.`numItem_PA`" => "numItem_PA",
		"`sogg_Terzi_Rapp_PA`.`codCom_Con_PA`" => "codCom_Con_PA",
		"`sogg_Terzi_Rapp_PA`.`codCUP_PA`" => "codCUP_PA",
		"`sogg_Terzi_Rapp_PA`.`codGIG_PA`" => "codGIG_PA",
		"`sogg_Terzi_Rapp_PA`.`datiCont_PA`" => "datiCont_PA",
		"`sogg_Terzi_Rapp_PA`.`datiConv_PA`" => "datiConv_PA",
		"`sogg_Terzi_Rapp_PA`.`datiRic_PA`" => "datiRic_PA",
		"`sogg_Terzi_Rapp_PA`.`datiFatCol_PA`" => "datiFatCol_PA",
		"`sogg_Terzi_Rapp_PA`.`datiSal_PA`" => "datiSal_PA",
		"`sogg_Terzi_Rapp_PA`.`riferFase_PA`" => "riferFase_PA",
		"`sogg_Terzi_Rapp_PA`.`normaRifer_PA`" => "normaRifer_PA",
		"`sogg_Terzi_Rapp_PA`.`nrFatturaPrinc_PA`" => "nrFatturaPrinc_PA",
		"DATE_FORMAT(`sogg_Terzi_Rapp_PA`.`dataFattPrinc_PA`, '%Y-%m-%d %H:%i')" => "dataFattPrinc_PA"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`sogg_Terzi_Rapp_PA`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') /* Id Paese PA */" => "Id Paese PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_RF_PA`" => "Id Partita IVA PA",
		"`sogg_Terzi_Rapp_PA`.`codiceFiscale_RF_PA`" => "Codice Fiscale PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_RF_PA`" => "Denominazione PA",
		"`sogg_Terzi_Rapp_PA`.`nome_RF_PA`" => "Nome Rap. Fiscale PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_RF_PA`" => "Cognome Rap. Fiscale PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_RF_PA`" => "Titolo Rap. Fisc. PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI__RF_PA`" => "CodEORI  Rap. Fisc. PA",
		"`sogg_Terzi_Rapp_PA`.`idPaeseIVA_3_Int_PA`" => "IdFiscaleIVA 3 Intermediario",
		"`sogg_Terzi_Rapp_PA`.`idCodice_3_Int_PA`" => "IdCodice 3 Int PA",
		"`sogg_Terzi_Rapp_PA`.`codFiscale_3_Int_PA`" => "CodFiscale 3 Int. PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_3_Int_PA`" => "Denominazione 3 Int. PA",
		"`sogg_Terzi_Rapp_PA`.`nome_3_Int_PA`" => "Nome 3 Int. PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_3_Int_PA`" => "Cognome 3 Int PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_3_Int_PA`" => "Titolo 3 Int. PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI_3_Int_PA`" => "CodEORI 3 Int. PA",
		"`sogg_Terzi_Rapp_PA`.`sogg_Emittente_PA`" => "Sogg Emittente PA",
		"`sogg_Terzi_Rapp_PA`.`rif_num_linea_PA`" => "Rif num linea PA",
		"`sogg_Terzi_Rapp_PA`.`idDoc_PA`" => "IdDoc PA",
		"`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`" => "Data ordine Acq. PA",
		"`sogg_Terzi_Rapp_PA`.`numItem_PA`" => "NumItem PA",
		"`sogg_Terzi_Rapp_PA`.`codCom_Con_PA`" => "Cod Com Con PA",
		"`sogg_Terzi_Rapp_PA`.`codCUP_PA`" => "CodCUP PA",
		"`sogg_Terzi_Rapp_PA`.`codGIG_PA`" => "Cod GIG PA",
		"`sogg_Terzi_Rapp_PA`.`datiCont_PA`" => "DatiCont PA",
		"`sogg_Terzi_Rapp_PA`.`datiConv_PA`" => "DatiConv PA",
		"`sogg_Terzi_Rapp_PA`.`datiRic_PA`" => "DatiRic PA",
		"`sogg_Terzi_Rapp_PA`.`datiFatCol_PA`" => "DatiFatCol PA",
		"`sogg_Terzi_Rapp_PA`.`datiSal_PA`" => "DatiSal PA",
		"`sogg_Terzi_Rapp_PA`.`riferFase_PA`" => "RiferFase PA",
		"`sogg_Terzi_Rapp_PA`.`normaRifer_PA`" => "NormaRifer PA",
		"`sogg_Terzi_Rapp_PA`.`nrFatturaPrinc_PA`" => "Nr. FatturaPrinc PA",
		"`sogg_Terzi_Rapp_PA`.`dataFattPrinc_PA`" => "DataFattPrinc PA"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`sogg_Terzi_Rapp_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') /* Id Paese PA */" => "idPaese_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_RF_PA`" => "idCodice_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codiceFiscale_RF_PA`" => "codiceFiscale_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_RF_PA`" => "denominazione_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_RF_PA`" => "nome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_RF_PA`" => "cognome_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_RF_PA`" => "titolo_RF_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI__RF_PA`" => "codEORI__RF_PA",
		"`sogg_Terzi_Rapp_PA`.`idPaeseIVA_3_Int_PA`" => "idPaeseIVA_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`idCodice_3_Int_PA`" => "idCodice_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codFiscale_3_Int_PA`" => "codFiscale_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`denominazione_3_Int_PA`" => "denominazione_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`nome_3_Int_PA`" => "nome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`cognome_3_Int_PA`" => "cognome_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`titolo_3_Int_PA`" => "titolo_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`codEORI_3_Int_PA`" => "codEORI_3_Int_PA",
		"`sogg_Terzi_Rapp_PA`.`sogg_Emittente_PA`" => "sogg_Emittente_PA",
		"`sogg_Terzi_Rapp_PA`.`rif_num_linea_PA`" => "rif_num_linea_PA",
		"`sogg_Terzi_Rapp_PA`.`idDoc_PA`" => "idDoc_PA",
		"if(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,date_format(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,'%Y-%m-%d'),'')" => "data_orAcq_PA",
		"`sogg_Terzi_Rapp_PA`.`numItem_PA`" => "numItem_PA",
		"`sogg_Terzi_Rapp_PA`.`codCom_Con_PA`" => "codCom_Con_PA",
		"`sogg_Terzi_Rapp_PA`.`codCUP_PA`" => "codCUP_PA",
		"`sogg_Terzi_Rapp_PA`.`codGIG_PA`" => "codGIG_PA",
		"`sogg_Terzi_Rapp_PA`.`datiCont_PA`" => "datiCont_PA",
		"`sogg_Terzi_Rapp_PA`.`datiConv_PA`" => "datiConv_PA",
		"`sogg_Terzi_Rapp_PA`.`datiRic_PA`" => "datiRic_PA",
		"`sogg_Terzi_Rapp_PA`.`datiFatCol_PA`" => "datiFatCol_PA",
		"`sogg_Terzi_Rapp_PA`.`datiSal_PA`" => "datiSal_PA",
		"`sogg_Terzi_Rapp_PA`.`riferFase_PA`" => "riferFase_PA",
		"`sogg_Terzi_Rapp_PA`.`normaRifer_PA`" => "normaRifer_PA",
		"`sogg_Terzi_Rapp_PA`.`nrFatturaPrinc_PA`" => "nrFatturaPrinc_PA",
		"DATE_FORMAT(`sogg_Terzi_Rapp_PA`.`dataFattPrinc_PA`, '%Y-%m-%d %H:%i')" => "dataFattPrinc_PA"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'idPaese_RF_PA' => 'Id Paese PA');

	$x->QueryFrom = "`sogg_Terzi_Rapp_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`sogg_Terzi_Rapp_PA`.`idPaese_RF_PA` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "sogg_Terzi_Rapp_PA_view.php";
	$x->RedirectAfterInsert = "sogg_Terzi_Rapp_PA_view.php?SelectedID=#ID#";
	$x->TableTitle = "Sezioni facoltative PA";
	$x->TableIcon = "resources/table_icons/document_mark_as_final.png";
	$x->PrimaryKey = "`sogg_Terzi_Rapp_PA`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Id Paese PA", "Id Partita IVA PA", "Codice Fiscale PA", "Denominazione PA", "Nome Rap. Fiscale PA", "Cognome Rap. Fiscale PA", "Titolo Rap. Fisc. PA", "CodEORI  Rap. Fisc. PA", "IdFiscaleIVA 3 Intermediario", "IdCodice 3 Int PA", "CodFiscale 3 Int. PA", "Denominazione 3 Int. PA", "Nome 3 Int. PA", "Cognome 3 Int PA", "Titolo 3 Int. PA", "CodEORI 3 Int. PA", "Sogg Emittente PA", "Rif num linea PA", "IdDoc PA", "Data ordine Acq. PA", "NumItem PA", "Cod Com Con PA", "CodCUP PA", "Cod GIG PA", "DatiCont PA", "DatiConv PA", "DatiRic PA", "DatiFatCol PA", "DatiSal PA", "RiferFase PA", "NormaRifer PA", "Nr. FatturaPrinc PA", "DataFattPrinc PA");
	$x->ColFieldName = array('idPaese_RF_PA', 'idCodice_RF_PA', 'codiceFiscale_RF_PA', 'denominazione_RF_PA', 'nome_RF_PA', 'cognome_RF_PA', 'titolo_RF_PA', 'codEORI__RF_PA', 'idPaeseIVA_3_Int_PA', 'idCodice_3_Int_PA', 'codFiscale_3_Int_PA', 'denominazione_3_Int_PA', 'nome_3_Int_PA', 'cognome_3_Int_PA', 'titolo_3_Int_PA', 'codEORI_3_Int_PA', 'sogg_Emittente_PA', 'rif_num_linea_PA', 'idDoc_PA', 'data_orAcq_PA', 'numItem_PA', 'codCom_Con_PA', 'codCUP_PA', 'codGIG_PA', 'datiCont_PA', 'datiConv_PA', 'datiRic_PA', 'datiFatCol_PA', 'datiSal_PA', 'riferFase_PA', 'normaRifer_PA', 'nrFatturaPrinc_PA', 'dataFattPrinc_PA');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34);

	// template paths below are based on the app main directory
	$x->Template = 'templates/sogg_Terzi_Rapp_PA_templateTV.html';
	$x->SelectedTemplate = 'templates/sogg_Terzi_Rapp_PA_templateTVS.html';
	$x->TemplateDV = 'templates/sogg_Terzi_Rapp_PA_templateDV.html';
	$x->TemplateDVP = 'templates/sogg_Terzi_Rapp_PA_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `sogg_Terzi_Rapp_PA`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='sogg_Terzi_Rapp_PA' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `sogg_Terzi_Rapp_PA`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='sogg_Terzi_Rapp_PA' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`sogg_Terzi_Rapp_PA`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: sogg_Terzi_Rapp_PA_init
	$render=TRUE;
	if(function_exists('sogg_Terzi_Rapp_PA_init')){
		$args=array();
		$render=sogg_Terzi_Rapp_PA_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: sogg_Terzi_Rapp_PA_header
	$headerCode='';
	if(function_exists('sogg_Terzi_Rapp_PA_header')){
		$args=array();
		$headerCode=sogg_Terzi_Rapp_PA_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: sogg_Terzi_Rapp_PA_footer
	$footerCode='';
	if(function_exists('sogg_Terzi_Rapp_PA_footer')){
		$args=array();
		$footerCode=sogg_Terzi_Rapp_PA_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>