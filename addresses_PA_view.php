<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/addresses_PA.php");
	include("$currDir/addresses_PA_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('addresses_PA');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "addresses_PA";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`addresses_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"if(CHAR_LENGTH(`addresses_PA`.`indirizzo_Ced_PA`)>100, concat(left(`addresses_PA`.`indirizzo_Ced_PA`,100),' ...'), `addresses_PA`.`indirizzo_Ced_PA`)" => "indirizzo_Ced_PA",
		"`addresses_PA`.`numeroCivico_Ced_PA`" => "numeroCivico_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') /* Codice postale Ced. PA */" => "CAP_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') /* Comune Cedente PA */" => "comune_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') /* Provincia Ced. PA */" => "provincia_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Nazione Ced. PA */" => "nazione_Ced_PA",
		"`addresses_PA`.`IBAN_PA`" => "IBAN_PA",
		"`addresses_PA`.`ABI_PA`" => "ABI_PA",
		"`addresses_PA`.`CAB_PA`" => "CAB_PA",
		"`addresses_PA`.`BIC_PA`" => "BIC_PA",
		"`addresses_PA`.`altroIndirizzo_Ced_PA`" => "altroIndirizzo_Ced_PA",
		"`addresses_PA`.`altro_nr_Civico_Ced_PA`" => "altro_nr_Civico_Ced_PA",
		"`addresses_PA`.`altroCAP_Ced_PA`" => "altroCAP_Ced_PA",
		"`addresses_PA`.`altra_PR_Ced_PA`" => "altra_PR_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Altra Nazione Ced. PA */" => "altraNazione_Ced_PA",
		"`addresses_PA`.`indirizzo_Ces_PA`" => "indirizzo_Ces_PA",
		"`addresses_PA`.`numeroCivico_Ces_PA`" => "numeroCivico_Ces_PA",
		"`addresses_PA`.`CAP_Ces_PA`" => "CAP_Ces_PA",
		"`addresses_PA`.`comune_Ces_PA`" => "comune_Ces_PA",
		"`addresses_PA`.`prov_Ces_PA`" => "prov_Ces_PA",
		"`addresses_PA`.`nazione_Ces_PA`" => "nazione_Ces_PA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"`addresses_PA`.`map`" => "map",
		"concat('<i class=\"glyphicon glyphicon-', if(`addresses_PA`.`default`, 'check', 'unchecked'), '\"></i>')" => "default",
		"concat('<i class=\"glyphicon glyphicon-', if(`addresses_PA`.`ship`, 'check', 'unchecked'), '\"></i>')" => "ship",
		"CONCAT('&euro;', FORMAT(`addresses_PA`.`scontoPagAnt_PA`, 2))" => "scontoPagAnt_PA",
		"if(`addresses_PA`.`dataPagAntic_PA`,date_format(`addresses_PA`.`dataPagAntic_PA`,'%Y-%m-%d'),'')" => "dataPagAntic_PA",
		"`addresses_PA`.`penalRitardPag_PA`" => "penalRitardPag_PA",
		"if(`addresses_PA`.`dataDecorPag_PA`,date_format(`addresses_PA`.`dataDecorPag_PA`,'%Y-%m-%d'),'')" => "dataDecorPag_PA",
		"`addresses_PA`.`codPagam_PA`" => "codPagam_PA"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`addresses_PA`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => 4,
		5 => '`town1`.`shipCode`',
		6 => '`town1`.`town`',
		7 => '`town1`.`district`',
		8 => '`countries1`.`country`',
		9 => 9,
		10 => '`addresses_PA`.`ABI_PA`',
		11 => '`addresses_PA`.`CAB_PA`',
		12 => 12,
		13 => 13,
		14 => 14,
		15 => 15,
		16 => 16,
		17 => '`countries1`.`country`',
		18 => 18,
		19 => 19,
		20 => 20,
		21 => 21,
		22 => 22,
		23 => 23,
		24 => '`CLIENTI_CESSIONARI_PA1`.`id`',
		25 => '`companies1`.`id`',
		26 => 26,
		27 => '`addresses_PA`.`default`',
		28 => '`addresses_PA`.`ship`',
		29 => '`addresses_PA`.`scontoPagAnt_PA`',
		30 => '`addresses_PA`.`dataPagAntic_PA`',
		31 => '`addresses_PA`.`penalRitardPag_PA`',
		32 => '`addresses_PA`.`dataDecorPag_PA`',
		33 => 33
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`addresses_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`addresses_PA`.`indirizzo_Ced_PA`" => "indirizzo_Ced_PA",
		"`addresses_PA`.`numeroCivico_Ced_PA`" => "numeroCivico_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') /* Codice postale Ced. PA */" => "CAP_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') /* Comune Cedente PA */" => "comune_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') /* Provincia Ced. PA */" => "provincia_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Nazione Ced. PA */" => "nazione_Ced_PA",
		"`addresses_PA`.`IBAN_PA`" => "IBAN_PA",
		"`addresses_PA`.`ABI_PA`" => "ABI_PA",
		"`addresses_PA`.`CAB_PA`" => "CAB_PA",
		"`addresses_PA`.`BIC_PA`" => "BIC_PA",
		"`addresses_PA`.`altroIndirizzo_Ced_PA`" => "altroIndirizzo_Ced_PA",
		"`addresses_PA`.`altro_nr_Civico_Ced_PA`" => "altro_nr_Civico_Ced_PA",
		"`addresses_PA`.`altroCAP_Ced_PA`" => "altroCAP_Ced_PA",
		"`addresses_PA`.`altra_PR_Ced_PA`" => "altra_PR_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Altra Nazione Ced. PA */" => "altraNazione_Ced_PA",
		"`addresses_PA`.`indirizzo_Ces_PA`" => "indirizzo_Ces_PA",
		"`addresses_PA`.`numeroCivico_Ces_PA`" => "numeroCivico_Ces_PA",
		"`addresses_PA`.`CAP_Ces_PA`" => "CAP_Ces_PA",
		"`addresses_PA`.`comune_Ces_PA`" => "comune_Ces_PA",
		"`addresses_PA`.`prov_Ces_PA`" => "prov_Ces_PA",
		"`addresses_PA`.`nazione_Ces_PA`" => "nazione_Ces_PA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"`addresses_PA`.`map`" => "map",
		"`addresses_PA`.`default`" => "default",
		"`addresses_PA`.`ship`" => "ship",
		"CONCAT('&euro;', FORMAT(`addresses_PA`.`scontoPagAnt_PA`, 2))" => "scontoPagAnt_PA",
		"if(`addresses_PA`.`dataPagAntic_PA`,date_format(`addresses_PA`.`dataPagAntic_PA`,'%Y-%m-%d'),'')" => "dataPagAntic_PA",
		"`addresses_PA`.`penalRitardPag_PA`" => "penalRitardPag_PA",
		"if(`addresses_PA`.`dataDecorPag_PA`,date_format(`addresses_PA`.`dataDecorPag_PA`,'%Y-%m-%d'),'')" => "dataDecorPag_PA",
		"`addresses_PA`.`codPagam_PA`" => "codPagam_PA"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`addresses_PA`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "Kind",
		"`addresses_PA`.`indirizzo_Ced_PA`" => "Indirizzo Cedente PA",
		"`addresses_PA`.`numeroCivico_Ced_PA`" => "Numero Civico Ced. PA",
		"IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') /* Codice postale Ced. PA */" => "Codice postale Ced. PA",
		"IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') /* Comune Cedente PA */" => "Comune Cedente PA",
		"IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') /* Provincia Ced. PA */" => "Provincia Ced. PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Nazione Ced. PA */" => "Nazione Ced. PA",
		"`addresses_PA`.`IBAN_PA`" => "IBAN PA",
		"`addresses_PA`.`ABI_PA`" => "ABI PA",
		"`addresses_PA`.`CAB_PA`" => "CAB PA",
		"`addresses_PA`.`BIC_PA`" => "BIC PA",
		"`addresses_PA`.`altroIndirizzo_Ced_PA`" => "Altro Indirizzo Ced. PA",
		"`addresses_PA`.`altro_nr_Civico_Ced_PA`" => "Altro nr Civico Ced. PA",
		"`addresses_PA`.`altroCAP_Ced_PA`" => "Altro CAP Ced. PA",
		"`addresses_PA`.`altra_PR_Ced_PA`" => "Altra PR Ced. PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Altra Nazione Ced. PA */" => "Altra Nazione Ced. PA",
		"`addresses_PA`.`indirizzo_Ces_PA`" => "Indirizzo Cessionario PA",
		"`addresses_PA`.`numeroCivico_Ces_PA`" => "Nr. Civico Cessionario PA",
		"`addresses_PA`.`CAP_Ces_PA`" => "CAP Cessionario PA",
		"`addresses_PA`.`comune_Ces_PA`" => "Comune Cessionario PA",
		"`addresses_PA`.`prov_Ces_PA`" => "Prov. Cessionario PA",
		"`addresses_PA`.`nazione_Ces_PA`" => "Nazione Ces. PA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Contact */" => "Contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "Company",
		"`addresses_PA`.`map`" => "Map",
		"`addresses_PA`.`default`" => "Default",
		"`addresses_PA`.`ship`" => "Ship",
		"`addresses_PA`.`scontoPagAnt_PA`" => "ScontoPagAnt PA",
		"`addresses_PA`.`dataPagAntic_PA`" => "DataPagAntic PA",
		"`addresses_PA`.`penalRitardPag_PA`" => "PenalRitardPag PA",
		"`addresses_PA`.`dataDecorPag_PA`" => "DataDecorPag PA",
		"`addresses_PA`.`codPagam_PA`" => "CodPagam PA"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`addresses_PA`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`addresses_PA`.`indirizzo_Ced_PA`" => "Indirizzo Cedente PA",
		"`addresses_PA`.`numeroCivico_Ced_PA`" => "numeroCivico_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') /* Codice postale Ced. PA */" => "CAP_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') /* Comune Cedente PA */" => "comune_Ced_PA",
		"IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') /* Provincia Ced. PA */" => "provincia_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Nazione Ced. PA */" => "nazione_Ced_PA",
		"`addresses_PA`.`IBAN_PA`" => "IBAN_PA",
		"`addresses_PA`.`ABI_PA`" => "ABI_PA",
		"`addresses_PA`.`CAB_PA`" => "CAB_PA",
		"`addresses_PA`.`BIC_PA`" => "BIC_PA",
		"`addresses_PA`.`altroIndirizzo_Ced_PA`" => "altroIndirizzo_Ced_PA",
		"`addresses_PA`.`altro_nr_Civico_Ced_PA`" => "altro_nr_Civico_Ced_PA",
		"`addresses_PA`.`altroCAP_Ced_PA`" => "altroCAP_Ced_PA",
		"`addresses_PA`.`altra_PR_Ced_PA`" => "altra_PR_Ced_PA",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Altra Nazione Ced. PA */" => "altraNazione_Ced_PA",
		"`addresses_PA`.`indirizzo_Ces_PA`" => "indirizzo_Ces_PA",
		"`addresses_PA`.`numeroCivico_Ces_PA`" => "numeroCivico_Ces_PA",
		"`addresses_PA`.`CAP_Ces_PA`" => "CAP_Ces_PA",
		"`addresses_PA`.`comune_Ces_PA`" => "comune_Ces_PA",
		"`addresses_PA`.`prov_Ces_PA`" => "prov_Ces_PA",
		"`addresses_PA`.`nazione_Ces_PA`" => "nazione_Ces_PA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"`addresses_PA`.`map`" => "map",
		"concat('<i class=\"glyphicon glyphicon-', if(`addresses_PA`.`default`, 'check', 'unchecked'), '\"></i>')" => "default",
		"concat('<i class=\"glyphicon glyphicon-', if(`addresses_PA`.`ship`, 'check', 'unchecked'), '\"></i>')" => "ship",
		"CONCAT('&euro;', FORMAT(`addresses_PA`.`scontoPagAnt_PA`, 2))" => "scontoPagAnt_PA",
		"if(`addresses_PA`.`dataPagAntic_PA`,date_format(`addresses_PA`.`dataPagAntic_PA`,'%Y-%m-%d'),'')" => "dataPagAntic_PA",
		"`addresses_PA`.`penalRitardPag_PA`" => "penalRitardPag_PA",
		"if(`addresses_PA`.`dataDecorPag_PA`,date_format(`addresses_PA`.`dataDecorPag_PA`,'%Y-%m-%d'),'')" => "dataDecorPag_PA",
		"`addresses_PA`.`codPagam_PA`" => "codPagam_PA"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Kind', 'provincia_Ced_PA' => 'Provincia Ced. PA', 'nazione_Ced_PA' => 'Nazione Ced. PA', 'contact' => 'Contact', 'company' => 'Company');

	$x->QueryFrom = "`addresses_PA` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`addresses_PA`.`kind` LEFT JOIN `town` as town1 ON `town1`.`id`=`addresses_PA`.`provincia_Ced_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`addresses_PA`.`nazione_Ced_PA` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`addresses_PA`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`addresses_PA`.`company` ";
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
	$x->ScriptFileName = "addresses_PA_view.php";
	$x->RedirectAfterInsert = "addresses_PA_view.php?SelectedID=#ID#";
	$x->TableTitle = "Altro Indirizzo inf. Bancarie";
	$x->TableIcon = "resources/table_icons/mail_box.png";
	$x->PrimaryKey = "`addresses_PA`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Kind", "IBAN PA", "ABI PA", "CAB PA", "BIC PA", "Altro Indirizzo Ced. PA", "Altro nr Civico Ced. PA", "Altro CAP Ced. PA", "Altra PR Ced. PA", "Altra Nazione Ced. PA", "Default", "Ship");
	$x->ColFieldName = array('kind', 'IBAN_PA', 'ABI_PA', 'CAB_PA', 'BIC_PA', 'altroIndirizzo_Ced_PA', 'altro_nr_Civico_Ced_PA', 'altroCAP_Ced_PA', 'altra_PR_Ced_PA', 'altraNazione_Ced_PA', 'default', 'ship');
	$x->ColNumber  = array(2, 9, 10, 11, 12, 13, 14, 15, 16, 17, 27, 28);

	// template paths below are based on the app main directory
	$x->Template = 'templates/addresses_PA_templateTV.html';
	$x->SelectedTemplate = 'templates/addresses_PA_templateTVS.html';
	$x->TemplateDV = 'templates/addresses_PA_templateDV.html';
	$x->TemplateDVP = 'templates/addresses_PA_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `addresses_PA`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='addresses_PA' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `addresses_PA`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='addresses_PA' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`addresses_PA`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: addresses_PA_init
	$render=TRUE;
	if(function_exists('addresses_PA_init')){
		$args=array();
		$render=addresses_PA_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: addresses_PA_header
	$headerCode='';
	if(function_exists('addresses_PA_header')){
		$args=array();
		$headerCode=addresses_PA_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: addresses_PA_footer
	$footerCode='';
	if(function_exists('addresses_PA_footer')){
		$args=array();
		$footerCode=addresses_PA_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>