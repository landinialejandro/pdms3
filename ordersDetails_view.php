<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/ordersDetails.php");
	include("$currDir/ordersDetails_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('ordersDetails');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "ordersDetails";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%Y-%m-%d'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%Y-%m-%d'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%Y-%m-%d'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice Articolo PA */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`quantity_PA`" => "quantity_PA",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM PA */" => "UMRifPeso_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoUn_PA`, 2))" => "prezzoUn_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`aliquotaIVA_PA`, 2))" => "aliquotaIVA_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoTot_PA`, 2))" => "prezzoTot_PA",
		"`ordersDetails`.`tipoScMAg_PA`" => "tipoScMAg_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percScontoLinea_PA`, 2))" => "percScontoLinea_PA",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') /* Tipo transazione */" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"concat('<i class=\"glyphicon glyphicon-', if(`ordersDetails`.`return`, 'check', 'unchecked'), '\"></i>')" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode",
		"`ordersDetails`.`causTrasp_PA`" => "causTrasp_PA",
		"`ordersDetails`.`nrLinea_PA`" => "nrLinea_PA",
		"`ordersDetails`.`tipoCessionePrest_PA`" => "tipoCessionePrest_PA",
		"`ordersDetails`.`codTipo_PA`" => "codTipo_PA",
		"`ordersDetails`.`codValore_PA`" => "codValore_PA",
		"IF(    CHAR_LENGTH(`products1`.`productName`), CONCAT_WS('',   `products1`.`productName`), '') /* DescrizioneArt PA */" => "descrizioneArt_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percentualeScontoMag_PA`, 2))" => "percentualeScontoMag_PA",
		"`ordersDetails`.`importoScontoMag_PA`" => "importoScontoMag_PA",
		"`ordersDetails`.`imponibileImp_PA`" => "imponibileImp_PA",
		"`ordersDetails`.`impostaRiep_PA`" => "impostaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"`ordersDetails`.`esigibilitaIVA_PA`" => "esigibilitaIVA_PA",
		"`ordersDetails`.`ritenuta_PA`" => "ritenuta_PA",
		"`ordersDetails`.`natura_PA`" => "natura_PA",
		"`ordersDetails`.`rifAmmin_PA`" => "rifAmmin_PA",
		"`ordersDetails`.`tipoDato_PA`" => "tipoDato_PA",
		"`ordersDetails`.`riferTesto_PA`" => "riferTesto_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`rifNumero_PA`, 2))" => "rifNumero_PA",
		"if(`ordersDetails`.`rifData_PA`,date_format(`ordersDetails`.`rifData_PA`,'%Y-%m-%d'),'')" => "rifData_PA",
		"`ordersDetails`.`aliquotaIVAriep_PA`" => "aliquotaIVAriep_PA",
		"`ordersDetails`.`naturaRiep_PA`" => "naturaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`speseAccess_PA`, 2))" => "speseAccess_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`arrotondamentoRiep_PA`, 2))" => "arrotondamentoRiep_PA",
		"`ordersDetails`.`rifNormativoRiep_PA`" => "rifNormativoRiep_PA"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`ordersDetails`.`id`',
		2 => '`orders1`.`id`',
		3 => '`ordersDetails`.`manufactureDate`',
		4 => '`ordersDetails`.`sellDate`',
		5 => '`ordersDetails`.`expiryDate`',
		6 => '`ordersDetails`.`daysToExpiry`',
		7 => '`products1`.`codebar`',
		8 => '`products1`.`productCode`',
		9 => 9,
		10 => '`ordersDetails`.`packages`',
		11 => '`ordersDetails`.`noSell`',
		12 => '`ordersDetails`.`quantity_PA`',
		13 => '`ordersDetails`.`QuantityReal`',
		14 => '`products1`.`UM`',
		15 => '`ordersDetails`.`prezzoUn_PA`',
		16 => '`ordersDetails`.`aliquotaIVA_PA`',
		17 => '`ordersDetails`.`prezzoTot_PA`',
		18 => 18,
		19 => '`ordersDetails`.`percScontoLinea_PA`',
		20 => '`kinds1`.`code`',
		21 => 21,
		22 => '`ordersDetails`.`skBatches`',
		23 => '`ordersDetails`.`averagePrice`',
		24 => '`ordersDetails`.`averageWeight`',
		25 => '`ordersDetails`.`commission`',
		26 => 26,
		27 => 27,
		28 => 28,
		29 => '`ordersDetails`.`nrLinea_PA`',
		30 => 30,
		31 => 31,
		32 => 32,
		33 => '`products1`.`productName`',
		34 => '`ordersDetails`.`percentualeScontoMag_PA`',
		35 => '`ordersDetails`.`importoScontoMag_PA`',
		36 => '`ordersDetails`.`imponibileImp_PA`',
		37 => '`ordersDetails`.`impostaRiep_PA`',
		38 => '`ordersDetails`.`LineTotal`',
		39 => 39,
		40 => 40,
		41 => 41,
		42 => 42,
		43 => 43,
		44 => 44,
		45 => '`ordersDetails`.`rifNumero_PA`',
		46 => '`ordersDetails`.`rifData_PA`',
		47 => '`ordersDetails`.`aliquotaIVAriep_PA`',
		48 => 48,
		49 => '`ordersDetails`.`speseAccess_PA`',
		50 => '`ordersDetails`.`arrotondamentoRiep_PA`',
		51 => 51
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%Y-%m-%d'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%Y-%m-%d'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%Y-%m-%d'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice Articolo PA */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`quantity_PA`" => "quantity_PA",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM PA */" => "UMRifPeso_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoUn_PA`, 2))" => "prezzoUn_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`aliquotaIVA_PA`, 2))" => "aliquotaIVA_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoTot_PA`, 2))" => "prezzoTot_PA",
		"`ordersDetails`.`tipoScMAg_PA`" => "tipoScMAg_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percScontoLinea_PA`, 2))" => "percScontoLinea_PA",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') /* Tipo transazione */" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"`ordersDetails`.`return`" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode",
		"`ordersDetails`.`causTrasp_PA`" => "causTrasp_PA",
		"`ordersDetails`.`nrLinea_PA`" => "nrLinea_PA",
		"`ordersDetails`.`tipoCessionePrest_PA`" => "tipoCessionePrest_PA",
		"`ordersDetails`.`codTipo_PA`" => "codTipo_PA",
		"`ordersDetails`.`codValore_PA`" => "codValore_PA",
		"IF(    CHAR_LENGTH(`products1`.`productName`), CONCAT_WS('',   `products1`.`productName`), '') /* DescrizioneArt PA */" => "descrizioneArt_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percentualeScontoMag_PA`, 2))" => "percentualeScontoMag_PA",
		"`ordersDetails`.`importoScontoMag_PA`" => "importoScontoMag_PA",
		"`ordersDetails`.`imponibileImp_PA`" => "imponibileImp_PA",
		"`ordersDetails`.`impostaRiep_PA`" => "impostaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"`ordersDetails`.`esigibilitaIVA_PA`" => "esigibilitaIVA_PA",
		"`ordersDetails`.`ritenuta_PA`" => "ritenuta_PA",
		"`ordersDetails`.`natura_PA`" => "natura_PA",
		"`ordersDetails`.`rifAmmin_PA`" => "rifAmmin_PA",
		"`ordersDetails`.`tipoDato_PA`" => "tipoDato_PA",
		"`ordersDetails`.`riferTesto_PA`" => "riferTesto_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`rifNumero_PA`, 2))" => "rifNumero_PA",
		"if(`ordersDetails`.`rifData_PA`,date_format(`ordersDetails`.`rifData_PA`,'%Y-%m-%d'),'')" => "rifData_PA",
		"`ordersDetails`.`aliquotaIVAriep_PA`" => "aliquotaIVAriep_PA",
		"`ordersDetails`.`naturaRiep_PA`" => "naturaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`speseAccess_PA`, 2))" => "speseAccess_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`arrotondamentoRiep_PA`, 2))" => "arrotondamentoRiep_PA",
		"`ordersDetails`.`rifNormativoRiep_PA`" => "rifNormativoRiep_PA"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "Id Azienda",
		"`ordersDetails`.`manufactureDate`" => "Data produzione PA",
		"`ordersDetails`.`sellDate`" => "Data vendita PA",
		"`ordersDetails`.`expiryDate`" => "Data di scadenza",
		"`ordersDetails`.`daysToExpiry`" => "Giorni alla scadenza",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "Codebar",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice Articolo PA */" => "Codice Articolo PA",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "Lotto",
		"`ordersDetails`.`packages`" => "Colli",
		"`ordersDetails`.`noSell`" => "Es. Colli",
		"`ordersDetails`.`quantity_PA`" => "Quantita PA",
		"`ordersDetails`.`QuantityReal`" => "Peso riscontrato",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM PA */" => "UM PA",
		"`ordersDetails`.`prezzoUn_PA`" => "Prezzo unitario PA",
		"`ordersDetails`.`aliquotaIVA_PA`" => "Aliquota IVA PA",
		"`ordersDetails`.`prezzoTot_PA`" => "Prezzo Totale PA",
		"`ordersDetails`.`tipoScMAg_PA`" => "TipoScMAg PA",
		"`ordersDetails`.`percScontoLinea_PA`" => "Sconto singolo Art. PA",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "Reparto",
		"IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') /* Tipo transazione */" => "Tipo transazione",
		"`ordersDetails`.`skBatches`" => "Giacenza",
		"`ordersDetails`.`averagePrice`" => "Prezzo medio giorno",
		"`ordersDetails`.`averageWeight`" => "Peso medio giorno",
		"`ordersDetails`.`commission`" => "Provvigione",
		"`ordersDetails`.`return`" => "Includi commissione",
		"`ordersDetails`.`supplierCode`" => "SupplierCode",
		"`ordersDetails`.`causTrasp_PA`" => "CausTrasp PA",
		"`ordersDetails`.`nrLinea_PA`" => "NrLinea PA",
		"`ordersDetails`.`tipoCessionePrest_PA`" => "TipoCessionePrest PA",
		"`ordersDetails`.`codTipo_PA`" => "CodTipo PA",
		"`ordersDetails`.`codValore_PA`" => "CodValore PA",
		"IF(    CHAR_LENGTH(`products1`.`productName`), CONCAT_WS('',   `products1`.`productName`), '') /* DescrizioneArt PA */" => "DescrizioneArt PA",
		"`ordersDetails`.`percentualeScontoMag_PA`" => "Percentuale Sconto PA",
		"`ordersDetails`.`importoScontoMag_PA`" => "ImportoScontoMag PA",
		"`ordersDetails`.`imponibileImp_PA`" => "ImponibileImp PA",
		"`ordersDetails`.`impostaRiep_PA`" => "ImpostaRiep PA",
		"`ordersDetails`.`LineTotal`" => "Totale riga",
		"`ordersDetails`.`esigibilitaIVA_PA`" => "EsigibilitaIVA PA",
		"`ordersDetails`.`ritenuta_PA`" => "Ritenuta PA",
		"`ordersDetails`.`natura_PA`" => "Natura PA",
		"`ordersDetails`.`rifAmmin_PA`" => "RifAmmin PA",
		"`ordersDetails`.`tipoDato_PA`" => "TipoDato PA",
		"`ordersDetails`.`riferTesto_PA`" => "RiferTesto PA",
		"`ordersDetails`.`rifNumero_PA`" => "RifNumero PA",
		"`ordersDetails`.`rifData_PA`" => "RifData PA",
		"`ordersDetails`.`aliquotaIVAriep_PA`" => "Aliquota IVA riep PA",
		"`ordersDetails`.`naturaRiep_PA`" => "NaturaRiep PA",
		"`ordersDetails`.`speseAccess_PA`" => "Spese Access PA",
		"`ordersDetails`.`arrotondamentoRiep_PA`" => "ArrotondamentoRiep PA",
		"`ordersDetails`.`rifNormativoRiep_PA`" => "RifNormativoRiep PA"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%Y-%m-%d'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%Y-%m-%d'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%Y-%m-%d'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice Articolo PA */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`quantity_PA`" => "quantity_PA",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM PA */" => "UMRifPeso_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoUn_PA`, 2))" => "prezzoUn_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`aliquotaIVA_PA`, 2))" => "aliquotaIVA_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoTot_PA`, 2))" => "prezzoTot_PA",
		"`ordersDetails`.`tipoScMAg_PA`" => "tipoScMAg_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percScontoLinea_PA`, 2))" => "percScontoLinea_PA",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') /* Tipo transazione */" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"concat('<i class=\"glyphicon glyphicon-', if(`ordersDetails`.`return`, 'check', 'unchecked'), '\"></i>')" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode",
		"`ordersDetails`.`causTrasp_PA`" => "causTrasp_PA",
		"`ordersDetails`.`nrLinea_PA`" => "nrLinea_PA",
		"`ordersDetails`.`tipoCessionePrest_PA`" => "tipoCessionePrest_PA",
		"`ordersDetails`.`codTipo_PA`" => "codTipo_PA",
		"`ordersDetails`.`codValore_PA`" => "codValore_PA",
		"IF(    CHAR_LENGTH(`products1`.`productName`), CONCAT_WS('',   `products1`.`productName`), '') /* DescrizioneArt PA */" => "descrizioneArt_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`percentualeScontoMag_PA`, 2))" => "percentualeScontoMag_PA",
		"`ordersDetails`.`importoScontoMag_PA`" => "importoScontoMag_PA",
		"`ordersDetails`.`imponibileImp_PA`" => "imponibileImp_PA",
		"`ordersDetails`.`impostaRiep_PA`" => "impostaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"`ordersDetails`.`esigibilitaIVA_PA`" => "esigibilitaIVA_PA",
		"`ordersDetails`.`ritenuta_PA`" => "ritenuta_PA",
		"`ordersDetails`.`natura_PA`" => "natura_PA",
		"`ordersDetails`.`rifAmmin_PA`" => "rifAmmin_PA",
		"`ordersDetails`.`tipoDato_PA`" => "tipoDato_PA",
		"`ordersDetails`.`riferTesto_PA`" => "riferTesto_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`rifNumero_PA`, 2))" => "rifNumero_PA",
		"if(`ordersDetails`.`rifData_PA`,date_format(`ordersDetails`.`rifData_PA`,'%Y-%m-%d'),'')" => "rifData_PA",
		"`ordersDetails`.`aliquotaIVAriep_PA`" => "aliquotaIVAriep_PA",
		"`ordersDetails`.`naturaRiep_PA`" => "naturaRiep_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`speseAccess_PA`, 2))" => "speseAccess_PA",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`arrotondamentoRiep_PA`, 2))" => "arrotondamentoRiep_PA",
		"`ordersDetails`.`rifNormativoRiep_PA`" => "rifNormativoRiep_PA"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'order' => 'Id Azienda', 'productCode' => 'Codice Articolo PA', 'section' => 'Reparto');

	$x->QueryFrom = "`ordersDetails` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`ordersDetails`.`order` LEFT JOIN `products` as products1 ON `products1`.`id`=`ordersDetails`.`productCode` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`ordersDetails`.`section` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders1`.`kind` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 0;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 0;
	$x->RecordsPerPage = 50;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "ordersDetails_view.php";
	$x->RedirectAfterInsert = "ordersDetails_view.php?SelectedID=#ID#";
	$x->TableTitle = "Dettaglio Ordini vendita PA";
	$x->TableIcon = "resources/table_icons/calendar_view_month.png";
	$x->PrimaryKey = "`ordersDetails`.`id`";
	$x->DefaultSortField = '1';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 75, 150, 150, 75, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Data produzione PA", "Data vendita PA", "Codice Articolo PA", "Colli", "Es. Colli", "Quantita PA", "Peso riscontrato", "UM PA", "Prezzo unitario PA", "Aliquota IVA PA", "Prezzo Totale PA", "TipoScMAg PA", "Sconto singolo Art. PA", "Tipo transazione", "Prezzo medio giorno", "Peso medio giorno", "Provvigione", "Includi commissione", "SupplierCode", "CausTrasp PA", "NrLinea PA", "DescrizioneArt PA", "Percentuale Sconto PA", "ImportoScontoMag PA", "ImponibileImp PA", "ImpostaRiep PA", "Totale riga", "EsigibilitaIVA PA");
	$x->ColFieldName = array('manufactureDate', 'sellDate', 'productCode', 'packages', 'noSell', 'quantity_PA', 'QuantityReal', 'UMRifPeso_PA', 'prezzoUn_PA', 'aliquotaIVA_PA', 'prezzoTot_PA', 'tipoScMAg_PA', 'percScontoLinea_PA', 'transaction_type', 'averagePrice', 'averageWeight', 'commission', 'return', 'supplierCode', 'causTrasp_PA', 'nrLinea_PA', 'descrizioneArt_PA', 'percentualeScontoMag_PA', 'importoScontoMag_PA', 'imponibileImp_PA', 'impostaRiep_PA', 'LineTotal', 'esigibilitaIVA_PA');
	$x->ColNumber  = array(3, 4, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 23, 24, 25, 26, 27, 28, 29, 33, 34, 35, 36, 37, 38, 39);

	// template paths below are based on the app main directory
	$x->Template = 'templates/ordersDetails_templateTV.html';
	$x->SelectedTemplate = 'templates/ordersDetails_templateTVS.html';
	$x->TemplateDV = 'templates/ordersDetails_templateDV.html';
	$x->TemplateDVP = 'templates/ordersDetails_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `ordersDetails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='ordersDetails' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `ordersDetails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='ordersDetails' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`ordersDetails`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: ordersDetails_init
	$render=TRUE;
	if(function_exists('ordersDetails_init')){
		$args=array();
		$render=ordersDetails_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// column sums
	if(strpos($x->HTML, '<!-- tv data below -->')){
		// if printing multi-selection TV, calculate the sum only for the selected records
		if(isset($_REQUEST['Print_x']) && is_array($_REQUEST['record_selector'])){
			$QueryWhere = '';
			foreach($_REQUEST['record_selector'] as $id){   // get selected records
				if($id != '') $QueryWhere .= "'" . makeSafe($id) . "',";
			}
			if($QueryWhere != ''){
				$QueryWhere = 'where `ordersDetails`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select sum(`ordersDetails`.`noSell`), sum(`ordersDetails`.`quantity_PA`), sum(`ordersDetails`.`QuantityReal`), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`prezzoTot_PA`), 2)), sum(`ordersDetails`.`importoScontoMag_PA`), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`LineTotal`), 2)) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="ordersDetails-manufactureDate"></td>';
			$sumRow .= '<td class="ordersDetails-sellDate"></td>';
			$sumRow .= '<td class="ordersDetails-productCode"></td>';
			$sumRow .= '<td class="ordersDetails-packages"></td>';
			$sumRow .= "<td class=\"ordersDetails-noSell text-right\">{$row[0]}</td>";
			$sumRow .= "<td class=\"ordersDetails-quantity_PA text-right\">{$row[1]}</td>";
			$sumRow .= "<td class=\"ordersDetails-QuantityReal text-right\">{$row[2]}</td>";
			$sumRow .= '<td class="ordersDetails-UMRifPeso_PA"></td>';
			$sumRow .= '<td class="ordersDetails-prezzoUn_PA"></td>';
			$sumRow .= '<td class="ordersDetails-aliquotaIVA_PA"></td>';
			$sumRow .= "<td class=\"ordersDetails-prezzoTot_PA text-right\">{$row[3]}</td>";
			$sumRow .= '<td class="ordersDetails-tipoScMAg_PA"></td>';
			$sumRow .= '<td class="ordersDetails-percScontoLinea_PA"></td>';
			$sumRow .= '<td class="ordersDetails-transaction_type"></td>';
			$sumRow .= '<td class="ordersDetails-averagePrice"></td>';
			$sumRow .= '<td class="ordersDetails-averageWeight"></td>';
			$sumRow .= '<td class="ordersDetails-commission"></td>';
			$sumRow .= '<td class="ordersDetails-return"></td>';
			$sumRow .= '<td class="ordersDetails-supplierCode"></td>';
			$sumRow .= '<td class="ordersDetails-causTrasp_PA"></td>';
			$sumRow .= '<td class="ordersDetails-nrLinea_PA"></td>';
			$sumRow .= '<td class="ordersDetails-descrizioneArt_PA"></td>';
			$sumRow .= '<td class="ordersDetails-percentualeScontoMag_PA"></td>';
			$sumRow .= "<td class=\"ordersDetails-importoScontoMag_PA text-right\">{$row[4]}</td>";
			$sumRow .= '<td class="ordersDetails-imponibileImp_PA"></td>';
			$sumRow .= '<td class="ordersDetails-impostaRiep_PA"></td>';
			$sumRow .= "<td class=\"ordersDetails-LineTotal text-right\">{$row[5]}</td>";
			$sumRow .= '<td class="ordersDetails-esigibilitaIVA_PA"></td>';
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: ordersDetails_header
	$headerCode='';
	if(function_exists('ordersDetails_header')){
		$args=array();
		$headerCode=ordersDetails_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: ordersDetails_footer
	$footerCode='';
	if(function_exists('ordersDetails_footer')){
		$args=array();
		$footerCode=ordersDetails_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>