<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/PEC.php");
	include("$currDir/PEC_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('PEC');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "PEC";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`PEC`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"if(CHAR_LENGTH(`PEC`.`PEC_PA`)>100, concat(left(`PEC`.`PEC_PA`,100),' ...'), `PEC`.`PEC_PA`)" => "PEC_PA",
		"`PEC`.`codiceUnivocoPA`" => "codiceUnivocoPA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Clienti */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* ID Fiscale Azienda Cedente */" => "company"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`PEC`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => 4,
		5 => '`CLIENTI_CESSIONARI_PA1`.`id`',
		6 => '`companies1`.`id`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`PEC`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`PEC`.`PEC_PA`" => "PEC_PA",
		"`PEC`.`codiceUnivocoPA`" => "codiceUnivocoPA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Clienti */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* ID Fiscale Azienda Cedente */" => "company"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`PEC`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "Kind",
		"`PEC`.`PEC_PA`" => "PEC",
		"`PEC`.`codiceUnivocoPA`" => "Codice Univoco PA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Clienti */" => "Clienti",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* ID Fiscale Azienda Cedente */" => "ID Fiscale Azienda Cedente"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`PEC`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`PEC`.`PEC_PA`" => "PEC",
		"`PEC`.`codiceUnivocoPA`" => "codiceUnivocoPA",
		"IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') /* Clienti */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* ID Fiscale Azienda Cedente */" => "company"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Kind', 'contact' => 'Clienti', 'company' => 'ID Fiscale Azienda Cedente');

	$x->QueryFrom = "`PEC` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`PEC`.`kind` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`PEC`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`PEC`.`company` ";
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
	$x->ScriptFileName = "PEC_view.php";
	$x->RedirectAfterInsert = "PEC_view.php?SelectedID=#ID#";
	$x->TableTitle = "Dati x Fattura Elettronica";
	$x->TableIcon = "resources/table_icons/email.png";
	$x->PrimaryKey = "`PEC`.`id`";

	$x->ColWidth   = array(  150, 150, 150);
	$x->ColCaption = array("Kind", "PEC", "Codice Univoco PA");
	$x->ColFieldName = array('kind', 'PEC_PA', 'codiceUnivocoPA');
	$x->ColNumber  = array(2, 3, 4);

	// template paths below are based on the app main directory
	$x->Template = 'templates/PEC_templateTV.html';
	$x->SelectedTemplate = 'templates/PEC_templateTVS.html';
	$x->TemplateDV = 'templates/PEC_templateDV.html';
	$x->TemplateDVP = 'templates/PEC_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `PEC`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='PEC' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `PEC`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='PEC' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`PEC`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: PEC_init
	$render=TRUE;
	if(function_exists('PEC_init')){
		$args=array();
		$render=PEC_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: PEC_header
	$headerCode='';
	if(function_exists('PEC_header')){
		$args=array();
		$headerCode=PEC_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: PEC_footer
	$footerCode='';
	if(function_exists('PEC_footer')){
		$args=array();
		$footerCode=PEC_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>