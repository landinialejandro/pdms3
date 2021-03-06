<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/_resumeOrders.php");
	include("$currDir/_resumeOrders_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('_resumeOrders');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "_resumeOrders";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Typedoc */" => "typedoc",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Customer */" => "customer",
		"`_resumeOrders`.`TOT`" => "TOT",
		"`_resumeOrders`.`MONTH`" => "MONTH",
		"`_resumeOrders`.`YEAR`" => "YEAR",
		"`_resumeOrders`.`DOCs`" => "DOCs",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Related */" => "related",
		"`_resumeOrders`.`id`" => "id"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`kinds1`.`name`',
		2 => 2,
		3 => 3,
		4 => '`companies2`.`companyName`',
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => '`orders1`.`id`',
		10 => '`_resumeOrders`.`id`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Typedoc */" => "typedoc",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Customer */" => "customer",
		"`_resumeOrders`.`TOT`" => "TOT",
		"`_resumeOrders`.`MONTH`" => "MONTH",
		"`_resumeOrders`.`YEAR`" => "YEAR",
		"`_resumeOrders`.`DOCs`" => "DOCs",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Related */" => "related",
		"`_resumeOrders`.`id`" => "id"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "Kind",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* Company */" => "Company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Typedoc */" => "Typedoc",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Customer */" => "Customer",
		"`_resumeOrders`.`TOT`" => "TOT",
		"`_resumeOrders`.`MONTH`" => "MONTH",
		"`_resumeOrders`.`YEAR`" => "YEAR",
		"`_resumeOrders`.`DOCs`" => "DOCs",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Related */" => "Related",
		"`_resumeOrders`.`id`" => "ID"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Typedoc */" => "typedoc",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Customer */" => "customer",
		"`_resumeOrders`.`TOT`" => "TOT",
		"`_resumeOrders`.`MONTH`" => "MONTH",
		"`_resumeOrders`.`YEAR`" => "YEAR",
		"`_resumeOrders`.`DOCs`" => "DOCs",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Related */" => "related",
		"`_resumeOrders`.`id`" => "id"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Kind', 'company' => 'Company', 'typedoc' => 'Typedoc', 'customer' => 'Customer', 'related' => 'Related');

	$x->QueryFrom = "`_resumeOrders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`_resumeOrders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`_resumeOrders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`_resumeOrders`.`typedoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`_resumeOrders`.`customer` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`_resumeOrders`.`related` ";
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
	$x->ScriptFileName = "_resumeOrders_view.php";
	$x->RedirectAfterInsert = "_resumeOrders_view.php?SelectedID=#ID#";
	$x->TableTitle = "Resume Orders";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`_resumeOrders`.`id`";
	$x->DefaultSortField = '1';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Kind", "Company", "Typedoc", "Customer", "TOT", "MONTH", "YEAR", "DOCs", "Related");
	$x->ColFieldName = array('kind', 'company', 'typedoc', 'customer', 'TOT', 'MONTH', 'YEAR', 'DOCs', 'related');
	$x->ColNumber  = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

	// template paths below are based on the app main directory
	$x->Template = 'templates/_resumeOrders_templateTV.html';
	$x->SelectedTemplate = 'templates/_resumeOrders_templateTVS.html';
	$x->TemplateDV = 'templates/_resumeOrders_templateDV.html';
	$x->TemplateDVP = 'templates/_resumeOrders_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `_resumeOrders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='_resumeOrders' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `_resumeOrders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='_resumeOrders' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`_resumeOrders`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: _resumeOrders_init
	$render=TRUE;
	if(function_exists('_resumeOrders_init')){
		$args=array();
		$render=_resumeOrders_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: _resumeOrders_header
	$headerCode='';
	if(function_exists('_resumeOrders_header')){
		$args=array();
		$headerCode=_resumeOrders_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: _resumeOrders_footer
	$footerCode='';
	if(function_exists('_resumeOrders_footer')){
		$args=array();
		$footerCode=_resumeOrders_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>