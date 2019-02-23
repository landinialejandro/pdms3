<?php

	#########################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		getTableList() -- returns an associative array (tableName => tableData, tableData is array(tableCaption, tableDescription, tableIcon)) of tables accessible by current user
		get_table_groups() -- returns an associative array (table_group => tables_array)
		logInMember() -- checks POST login. If not valid, redirects to index.php, else returns TRUE
		getTablePermissions($tn) -- returns an array of permissions allowed for logged member to given table (allowAccess, allowInsert, allowView, allowEdit, allowDelete) -- allowAccess is set to true if any access level is allowed
		get_sql_fields($tn) -- returns the SELECT part of the table view query
		get_sql_from($tn[, true, [, false]]) -- returns the FROM part of the table view query, with full joins (unless third paramaeter is set to true), optionally skipping permissions if true passed as 2nd param.
		get_joined_record($table, $id[, true]) -- returns assoc array of record values for given PK value of given table, with full joins, optionally skipping permissions if true passed as 3rd param.
		get_defaults($table) -- returns assoc array of table fields as array keys and default values (or empty), excluding automatic values as array values
		htmlUserBar() -- returns html code for displaying user login status to be used on top of pages.
		showNotifications($msg, $class) -- returns html code for displaying a notification. If no parameters provided, processes the GET request for possible notifications.
		parseMySQLDate(a, b) -- returns a if valid mysql date, or b if valid mysql date, or today if b is true, or empty if b is false.
		parseCode(code) -- calculates and returns special values to be inserted in automatic fields.
		addFilter(i, filterAnd, filterField, filterOperator, filterValue) -- enforce a filter over data
		clearFilters() -- clear all filters
		loadView($view, $data) -- passes $data to templates/{$view}.php and returns the output
		loadTable($table, $data) -- loads table template, passing $data to it
		filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo) -- applies cascading drop-downs for a lookup field, returns js code to be inserted into the page
		br2nl($text) -- replaces all variations of HTML <br> tags with a new line character
		htmlspecialchars_decode($text) -- inverse of htmlspecialchars()
		entitiesToUTF8($text) -- convert unicode entities (e.g. &#1234;) to actual UTF8 characters, requires multibyte string PHP extension
		func_get_args_byref() -- returns an array of arguments passed to a function, by reference
		permissions_sql($table, $level) -- returns an array containing the FROM and WHERE additions for applying permissions to an SQL query
		error_message($msg[, $back_url]) -- returns html code for a styled error message .. pass explicit false in second param to suppress back button
		toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format)
		reIndex(&$arr) -- returns a copy of the given array, with keys replaced by 1-based numeric indices, and values replaced by original keys
		get_embed($provider, $url[, $width, $height, $retrieve]) -- returns embed code for a given url (supported providers: youtube, googlemap)
		check_record_permission($table, $id, $perm = 'view') -- returns true if current user has the specified permission $perm ('view', 'edit' or 'delete') for the given recors, false otherwise
		NavMenus($options) -- returns the HTML code for the top navigation menus. $options is not implemented currently.
		StyleSheet() -- returns the HTML code for included style sheet files to be placed in the <head> section.
		getUploadDir($dir) -- if dir is empty, returns upload dir configured in defaultLang.php, else returns $dir.
		PrepareUploadedFile($FieldName, $MaxSize, $FileTypes='jpg|jpeg|gif|png', $NoRename=false, $dir="") -- validates and moves uploaded file for given $FieldName into the given $dir (or the default one if empty)
		get_home_links($homeLinks, $default_classes, $tgroup) -- process $homeLinks array and return custom links for homepage. Applies $default_classes to links if links have classes defined, and filters links by $tgroup (using '*' matches all table_group values)
		quick_search_html($search_term, $label, $separate_dv = true) -- returns HTML code for the quick search box.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/

	#########################################################

	function getTableList($skip_authentication = false){
		$arrAccessTables = array();
		$arrTables = array(
			/* 'table_name' => ['table caption', 'homepage description', 'icon', 'table group name'] */   
			'orders' => array('Ordini', '2.1.8 <DatiDDT>blocco da valorizzare nei casi di fattura "differita" per indicare il documento con cui &#232; stato consegnato il bene (i campi del blocco<br>possono essere ripetuti se la fattura fa riferimento a pi&#249; consegne e quindi a pi&#249; documenti di trasporto)', 'resources/table_icons/cart_remove.png', 'Documenti'),
			'ordersDetails' => array('Dettaglio Ordini vendita PA', '2.2 <DatiBeniServizi>blocco sempre obbligatorio contenente natura, qualit&#224; e quantit&#224; dei beni / servizi formanti oggetto dell\'operazione;<br>2.2.1 <DettaglioLinee>blocco sempre obbligatorio contenente le linee di dettaglio del documento (i campi del blocco si ripetono per ogni riga di dettaglio) ;<br>', 'resources/table_icons/calendar_view_month.png', 'hiddens'),
			'_resumeOrders' => array('Resume Orders', 'In questa tabella inseriremo le fatture passive, cio&#232; quelle ricevute in formato xml alla Agenzie delle Entrate <br>trasformate in pdf ed inseriremo un archivio in pdf delle fatture emesse, e le ricevute di scarto delle fatture emesse.<br>', 'table.gif', 'Documenti'),
			'products' => array('Articoli Magazzino', 'Oltre all\'accesso ai dettagli dei prodotti, &#232; anche possibile accedere alla cronologia degli ordini di ogni<br> singolo prodotto da qui.', 'resources/table_icons/installer_box.png', 'Catalogo'),
			'firstCashNote' => array('Prima Nota', '', 'resources/table_icons/data_sort.png', 'Prima Nota'),
			'vatRegister' => array('IscrizioneREA/IVA', '1.2.4 <IscrizioneREA>blocco da valorizzare nei casi di societ&#224; iscritte nel registro delle imprese ai sensi dell\'art. 2250 del codice civile', 'resources/table_icons/book_spelling.png', 'Prima Nota'),
			'companies' => array('Cedente Prestatore', '1.2 <CedentePrestatore>blocco sempre obbligatorio contenente dati relativi al cedente / prestatore ;<br>1.2.1<DatiAnagrafici>blocco sempre obbligatorio contenente i dati anagrafici, professionali e fiscali del cedente / prestatore ;<br>1.2.1.1 <IdFiscaleIVA>numero di identificazione fiscale ai fini IVA; i primi due caratteri rappresentano il paese ( IT, DE, ES &#8230;..) ed i restanti (fino ad un<br>massimo di 28) il codice vero e proprio che, per i residenti in Italia, corrisponde al numero di partita IVA.<br>', 'resources/table_icons/factory.png', 'Anagrafiche'),
			'CLIENTI_CESSIONARI_PA' => array('Cessionario Committente PA', '1.4 <CessionarioCommittente>blocco sempre obbligatorio contenente dati relativi al cessionario / committente <br>1.4.1 <DatiAnagrafici>blocco contenente i dati fiscali e anagrafici del cessionario/committente;<br>1.4.1.1 numero di identificazione fiscale ai fini IVA; i primi due caratteri rappresentano il paese ( IT, DE, ES &#8230;..) ed i restanti (fino ad un<br>massimo di 28) il codice vero e proprio che, per i residenti in Italia, corrisponde al numero di partita IVA. L&#8217;indicazione di questo<br>campo &#232; obbligatoria nei casi in cui il cessionario/committente &#232; titolare di partita IVA (agisce nell&#8217;esercizio di impresa, arte o<br>professione).<br>', 'resources/table_icons/client_account_template.png', 'Anagrafiche'),
			'creditDocument' => array('Nota Credito', '', 'resources/table_icons/card_credit.png', 'Anagrafiche'),
			'electronicInvoice' => array('Fattura Elettronica PA', '1 <FatturaElettronicaHeader> il blocco ha molteplicit&#224; pari a 1, sia nel caso di fattura singola che nel caso di lotto di fatture;<br><br>1.1 <DatiTrasmissione>blocco sempre obbligatorio contenente informazioni che identificano univocamente il soggetto che trasmette, il documento<br>trasmesso, il formato in cui &#232; stato trasmesso il documento, il soggetto destinatario;<br><br>1.1.1 <IdTrasmittente>&#232; l&#8217;identificativo univoco del soggetto trasmittente; per i soggetti residenti in Italia, siano essi persone fisiche o giuridiche,<br>corrisponde al codice fiscale preceduto da IT; per i soggetti non residenti corrisponde al numero identificativo IVA (dove i primi due<br>caratteri rappresentano il paese secondo lo standard ISO 3166-1 alpha-2 code, ed i restanti, fino ad un massimo di 28, il codice<br>vero e proprio)<br>', 'resources/table_icons/document_editing.png', 'Anagrafiche'),
			'countries' => array('Countries', '', 'resources/table_icons/globe_model.png', 'Anagrafiche'),
			'town' => array('Comuni italiani', 'Elenco dei comuni italiani con i relativi codici.', 'resources/table_icons/italy.png', 'Anagrafiche'),
			'GPSTrackingSystem' => array('GPS Tracking System', 'Questa tabella, non disponibile al momento, serve per chi ha necessit&#224; di controllare i propri mezzi con un sistema di tracciamento GPS.<br>Si puo richiedere questa opzione a parte.', 'resources/table_icons/compass.png', 'Altro'),
			'kinds' => array('Entities Kinds', 'Config kind\'s name for Addreses, Phones, Companies, Mails, Orders, Products, Contacts...etc.', 'resources/table_icons/application_view_tile.png', 'Altro'),
			'Logs' => array('Logs', 'Questa tabella serve a tener traccia dei tentativi di accesso che possono risultare dannosi, tracciando l\'IP di provenienza.', 'resources/table_icons/centroid.png', 'Altro'),
			'attributes' => array('Attributi', '', 'resources/table_icons/application_form_add.png', 'hiddens'),
			'addresses_PA' => array('Altro Indirizzo inf. Bancarie', '1.2.2 <Sede>blocco sempre obbligatorio contenente i dati della sede del cedente / prestatore;<br>1.4.2 <Sede>blocco contenente i dati fiscali e anagrafici del cessionario/committente', 'resources/table_icons/mail_box.png', 'hiddens'),
			'phones' => array('Phones', '', 'resources/table_icons/phone.png', 'hiddens'),
			'PEC' => array('Dati x Fattura Elettronica', 'Contiene i codici univoci e/o pec di Clienti, Fornitori, Multiaziende', 'resources/table_icons/email.png', 'hiddens'),
			'contacts_companies' => array('Contacts companies', 'relate contacts with companies', 'resources/table_icons/brick_link.png', 'hiddens'),
			'allegati_PA' => array('Allegati PA', '2.5 <Allegati>dati relativi ad eventuali allegati;<br>', 'resources/table_icons/attach.png', 'hiddens'),
			'sogg_Terzi_Rapp_PA' => array('Sezioni facoltative PA', '1.3 <RappresentanteFiscale> blocco da valorizzare nei casi in cui il cedente / prestatore si <br>avvalga <br>di un rappresentante fiscale in Italia <br>;<br>1.3.1 <DatiAnagrafici> blocco contenente i dati fiscali e anagrafici del rappresentante fiscale del cedente / prestatore<br><br>1.3.1.1 <IdFiscaleIVA> numero di identificazione fiscale ai fini IVA; i primi due caratteri rappresentano <br>il paese ( IT, DE, ES &#8230;..) ed i restanti (fino ad un<br>massimo di 28) il codice vero e proprio che, <br>per i residenti in Italia, corrisponde al numero di partita IVA. <br>1.5 <TerzoIntermediarioOSoggettoEmittente> dati relativi al soggetto terzo che emette fattura per conto del cedente / prestatore<br>1.5.1 <DatiAnagrafici>blocco contenente i dati fiscali e anagrafici del terzo intermediario<br>1.5.1.1 <IdFiscaleIVA>numero di identificazione fiscale ai fini IVA; i primi due caratteri rappresentano il paese ( IT, DE, ES &#8230;..) ed i restanti (fino ad un<br>massimo di 28) il codice vero e proprio che, per i residenti in Italia, corrisponde al numero di partita IVA. <br>Questa Tabella, rappresenta tutte le sezioni facoltative della Fattura elettronica che solitamente vengono <br>lasciate in bianco.', 'resources/table_icons/document_mark_as_final.png', 'Anagrafiche')
		);
		if($skip_authentication || getLoggedAdmin()) return $arrTables;

		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				$arrPerm = getTablePermissions($tn);
				if($arrPerm[0]){
					$arrAccessTables[$tn] = $tc;
				}
			}
		}

		return $arrAccessTables;
	}

	#########################################################

	function get_table_groups($skip_authentication = false){
		$tables = getTableList($skip_authentication);
		$all_groups = array('Documenti', 'Catalogo', 'Prima Nota', 'Anagrafiche', 'Altro', 'hiddens');

		$groups = array();
		foreach($all_groups as $grp){
			foreach($tables as $tn => $td){
				if($td[3] && $td[3] == $grp) $groups[$grp][] = $tn;
				if(!$td[3]) $groups[0][] = $tn;
			}
		}

		return $groups;
	}

	#########################################################

	function getTablePermissions($tn){
		static $table_permissions = array();
		if(isset($table_permissions[$tn])) return $table_permissions[$tn];

		$groupID = getLoggedGroupID();
		$memberID = makeSafe(getLoggedMemberID());
		$res_group = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_grouppermissions where groupID='{$groupID}'", $eo);
		$res_user = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_userpermissions where lcase(memberID)='{$memberID}'", $eo);

		while($row = db_fetch_assoc($res_group)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// user-specific permissions, if specified, overwrite his group permissions
		while($row = db_fetch_assoc($res_user)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// if user has any type of access, set 'access' flag
		foreach($table_permissions as $t => $p){
			$table_permissions[$t]['access'] = $table_permissions[$t][0] = false;

			if($p['insert'] || $p['view'] || $p['edit'] || $p['delete']){
				$table_permissions[$t]['access'] = $table_permissions[$t][0] = true;
			}
		}

		return $table_permissions[$tn];
	}

	#########################################################

	function get_sql_fields($table_name){
		$sql_fields = array(   
			'orders' => "`orders`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `orders`.`progressivNumber` as 'progressivNumber', `orders`.`consigneeID` as 'consigneeID', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typeDoc', `orders`.`multiOrder_nr_PA` as 'multiOrder_nr_PA', `orders`.`formatoTrasmissione_PA` as 'formatoTrasmissione_PA', `orders`.`tipo_Documento_PA` as 'tipo_Documento_PA', `orders`.`divisa_PA` as 'divisa_PA', CONCAT('&euro;', FORMAT(`orders`.`importo_Sc_Mg_PA`, 2)) as 'importo_Sc_Mg_PA', CONCAT('&euro;', FORMAT(`orders`.`importoTot_Doc_PA`, 2)) as 'importoTot_Doc_PA', CONCAT('&euro;', FORMAT(`orders`.`arrotondamento_PA`, 2)) as 'arrotondamento_PA', `orders`.`causale_PA` as 'causale_PA', `orders`.`art73_PA` as 'art73_PA', if(`orders`.`data_Ord_PA`,date_format(`orders`.`data_Ord_PA`,'%Y-%m-%d'),'') as 'data_Ord_PA', if(`orders`.`dataOraRit_PA`,date_format(`orders`.`dataOraRit_PA`,'%Y-%m-%d'),'') as 'dataOraRit_PA', if(`orders`.`dataInizTrasp_PA`,date_format(`orders`.`dataInizTrasp_PA`,'%Y-%m-%d'),'') as 'dataInizTrasp_PA', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') as 'supplier', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), '') as 'employee', IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') as 'shipVia', `orders`.`Freight` as 'Freight', `orders`.`pallets` as 'pallets', `orders`.`mezzoTraspVet_PA` as 'mezzoTraspVet_PA', `orders`.`causaleTraspVet_PA` as 'causaleTraspVet_PA', `orders`.`nrColliVett_PA` as 'nrColliVett_PA', `orders`.`descTraspVet_PA` as 'descTraspVet_PA', `orders`.`cashCredit` as 'cashCredit', `orders`.`trust` as 'trust', `orders`.`overdraft` as 'overdraft', `orders`.`commisionFee` as 'commisionFee', `orders`.`commisionRate` as 'commisionRate', `orders`.`related` as 'related', `orders`.`document` as 'document', `orders`.`tipo_rit_PA` as 'tipo_rit_PA', `orders`.`imp_rit_PA` as 'imp_rit_PA', FORMAT(`orders`.`aliq_rit_PA`, 2) as 'aliq_rit_PA', `orders`.`causale_pag_rit_PA` as 'causale_pag_rit_PA', `orders`.`nr_bollo_rit_PA` as 'nr_bollo_rit_PA', FORMAT(`orders`.`importo_Bollo_rit_PA`, 2) as 'importo_Bollo_rit_PA', `orders`.`tipo_cassa_Prev_PA` as 'tipo_cassa_Prev_PA', FORMAT(`orders`.`al_cassa_Prev_PA`, 2) as 'al_cassa_Prev_PA', FORMAT(`orders`.`importo_cont_cassa_prev_PA`, 2) as 'importo_cont_cassa_prev_PA', FORMAT(`orders`.`imponibile_cassa_Prev_PA`, 2) as 'imponibile_cassa_Prev_PA', FORMAT(`orders`.`aliq_IVA_cassa_prev_PA`, 2) as 'aliq_IVA_cassa_prev_PA', `orders`.`ritenuta_cassa_prev_PA` as 'ritenuta_cassa_prev_PA', `orders`.`natura_cassa_prev_PA` as 'natura_cassa_prev_PA', `orders`.`rif_amm_prev_PA` as 'rif_amm_prev_PA', `orders`.`tipoResa_PA` as 'tipoResa_PA', `orders`.`indirizzoResa_PA` as 'indirizzoResa_PA', `orders`.`nrCivicoResa_PA` as 'nrCivicoResa_PA', IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') as 'CAP_Resa_PA', IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') as 'comuneResa_PA', IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') as 'provResa_PA', IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') as 'nazioneResa_PA', if(`orders`.`dataOraCons_PA`,date_format(`orders`.`dataOraCons_PA`,'%Y-%m-%d'),'') as 'dataOraCons_PA'",
			'ordersDetails' => "`ordersDetails`.`id` as 'id', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'order', if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%Y-%m-%d'),'') as 'manufactureDate', if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%Y-%m-%d'),'') as 'sellDate', if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%Y-%m-%d'),'') as 'expiryDate', `ordersDetails`.`daysToExpiry` as 'daysToExpiry', IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') as 'codebar', IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') as 'productCode', IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') as 'batch', `ordersDetails`.`packages` as 'packages', `ordersDetails`.`noSell` as 'noSell', `ordersDetails`.`quantity_PA` as 'quantity_PA', `ordersDetails`.`QuantityReal` as 'QuantityReal', IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') as 'UMRifPeso_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoUn_PA`, 2)) as 'prezzoUn_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`aliquotaIVA_PA`, 2)) as 'aliquotaIVA_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`prezzoTot_PA`, 2)) as 'prezzoTot_PA', `ordersDetails`.`tipoScMAg_PA` as 'tipoScMAg_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`percScontoLinea_PA`, 2)) as 'percScontoLinea_PA', IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') as 'section', IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') as 'transaction_type', `ordersDetails`.`skBatches` as 'skBatches', `ordersDetails`.`averagePrice` as 'averagePrice', `ordersDetails`.`averageWeight` as 'averageWeight', `ordersDetails`.`commission` as 'commission', `ordersDetails`.`return` as 'return', `ordersDetails`.`supplierCode` as 'supplierCode', `ordersDetails`.`causTrasp_PA` as 'causTrasp_PA', `ordersDetails`.`nrLinea_PA` as 'nrLinea_PA', `ordersDetails`.`tipoCessionePrest_PA` as 'tipoCessionePrest_PA', `ordersDetails`.`codTipo_PA` as 'codTipo_PA', `ordersDetails`.`codValore_PA` as 'codValore_PA', IF(    CHAR_LENGTH(`products1`.`productName`), CONCAT_WS('',   `products1`.`productName`), '') as 'descrizioneArt_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`percentualeScontoMag_PA`, 2)) as 'percentualeScontoMag_PA', `ordersDetails`.`importoScontoMag_PA` as 'importoScontoMag_PA', `ordersDetails`.`imponibileImp_PA` as 'imponibileImp_PA', `ordersDetails`.`impostaRiep_PA` as 'impostaRiep_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2)) as 'LineTotal', `ordersDetails`.`esigibilitaIVA_PA` as 'esigibilitaIVA_PA', `ordersDetails`.`ritenuta_PA` as 'ritenuta_PA', `ordersDetails`.`natura_PA` as 'natura_PA', `ordersDetails`.`rifAmmin_PA` as 'rifAmmin_PA', `ordersDetails`.`tipoDato_PA` as 'tipoDato_PA', `ordersDetails`.`riferTesto_PA` as 'riferTesto_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`rifNumero_PA`, 2)) as 'rifNumero_PA', if(`ordersDetails`.`rifData_PA`,date_format(`ordersDetails`.`rifData_PA`,'%Y-%m-%d'),'') as 'rifData_PA', `ordersDetails`.`aliquotaIVAriep_PA` as 'aliquotaIVAriep_PA', `ordersDetails`.`naturaRiep_PA` as 'naturaRiep_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`speseAccess_PA`, 2)) as 'speseAccess_PA', CONCAT('&euro;', FORMAT(`ordersDetails`.`arrotondamentoRiep_PA`, 2)) as 'arrotondamentoRiep_PA', `ordersDetails`.`rifNormativoRiep_PA` as 'rifNormativoRiep_PA'",
			'_resumeOrders' => "IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typedoc', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', `_resumeOrders`.`TOT` as 'TOT', `_resumeOrders`.`MONTH` as 'MONTH', `_resumeOrders`.`YEAR` as 'YEAR', `_resumeOrders`.`DOCs` as 'DOCs', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'related', `_resumeOrders`.`id` as 'id'",
			'products' => "`products`.`id` as 'id', `products`.`codebar` as 'codebar', `products`.`productCode` as 'productCode', `products`.`productName` as 'productName', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'tax', `products`.`increment` as 'increment', IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') as 'CategoryID', `products`.`UM` as 'UM', `products`.`tare` as 'tare', `products`.`QuantityPerUnit` as 'QuantityPerUnit', CONCAT('&euro;', FORMAT(`products`.`UnitPrice`, 2)) as 'UnitPrice', CONCAT('&euro;', FORMAT(`products`.`sellPrice`, 2)) as 'sellPrice', `products`.`UnitsInStock` as 'UnitsInStock', `products`.`UnitsOnOrder` as 'UnitsOnOrder', `products`.`ReorderLevel` as 'ReorderLevel', `products`.`balance` as 'balance', `products`.`Discontinued` as 'Discontinued', if(`products`.`manufactured_date`,date_format(`products`.`manufactured_date`,'%Y-%m-%d'),'') as 'manufactured_date', if(`products`.`expiry_date`,date_format(`products`.`expiry_date`,'%Y-%m-%d'),'') as 'expiry_date', `products`.`note` as 'note', if(`products`.`update_date`,date_format(`products`.`update_date`,'%Y-%m-%d %h:%i %p'),'') as 'update_date'",
			'firstCashNote' => "`firstCashNote`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', IF(    CHAR_LENGTH(`orders1`.`multiOrder_nr_PA`) || CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `orders1`.`multiOrder_nr_PA`, ' - ', `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'order', if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%Y-%m-%d'),'') as 'operationDate', IF(    CHAR_LENGTH(`companies2`.`companyCode`) || CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyCode`, ' - ', `companies2`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), '') as 'customer', `firstCashNote`.`documentNumber` as 'documentNumber', `firstCashNote`.`causal` as 'causal', `firstCashNote`.`importoPag_PA` as 'importoPag_PA', `firstCashNote`.`outputs` as 'outputs', `firstCashNote`.`balance` as 'balance', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'idBank', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), '') as 'istitutoFinanziario_PA', `firstCashNote`.`note` as 'note', if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%Y-%m-%d'),'') as 'paymentDeadLine', `firstCashNote`.`payed` as 'payed', `firstCashNote`.`datiPag_PA` as 'datiPag_PA', `firstCashNote`.`modPagam_PA` as 'modPagam_PA', if(`firstCashNote`.`dataRifTerPag_PA`,date_format(`firstCashNote`.`dataRifTerPag_PA`,'%Y-%m-%d'),'') as 'dataRifTerPag_PA', `firstCashNote`.`giorniTermPag_PA` as 'giorniTermPag_PA', if(`firstCashNote`.`dataScadPag_PA`,date_format(`firstCashNote`.`dataScadPag_PA`,'%Y-%m-%d'),'') as 'dataScadPag_PA', `firstCashNote`.`codUffPost_PA` as 'codUffPost_PA', `firstCashNote`.`cognomeQuietanzante_PA` as 'cognomeQuietanzante_PA', `firstCashNote`.`nomeQuietanzante_PA` as 'nomeQuietanzante_PA', `firstCashNote`.`codFiscQuietanzante_PA` as 'codFiscQuietanzante_PA', `firstCashNote`.`titoloQuietanzante_PA` as 'titoloQuietanzante_PA'",
			'vatRegister' => "`vatRegister`.`id` as 'id', IF(    CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyCode`), '') as 'idCompany', IF(    CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyName`), '') as 'companyName', `vatRegister`.`tax` as 'tax', `vatRegister`.`month` as 'month', `vatRegister`.`year` as 'year', `vatRegister`.`amount` as 'amount', `vatRegister`.`ufficio_Ced_PA` as 'ufficio_Ced_PA', `vatRegister`.`numeroREA_Ced_PA` as 'numeroREA_Ced_PA', `vatRegister`.`capitaleSociale_Ced_PA` as 'capitaleSociale_Ced_PA', `vatRegister`.`socioUnico_Ced_PA` as 'socioUnico_Ced_PA', `vatRegister`.`statoLiquidazione_Ced_PA` as 'statoLiquidazione_Ced_PA'",
			'companies' => "`companies`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `companies`.`companyCode` as 'companyCode', `companies`.`companyName` as 'companyName', `companies`.`notes` as 'notes', `companies`.`codiceDestinatarioUff_PA` as 'codiceDestinatarioUff_PA', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'idPaese_Ced_PA', `companies`.`idCodice_Ced_PA` as 'idCodice_Ced_PA', `companies`.`codiceFiscale_Ced_PA` as 'codiceFiscale_Ced_PA', `companies`.`denominazione_Ced_PA` as 'denominazione_Ced_PA', `companies`.`titolo_Ced_PA` as 'titolo_Ced_PA', `companies`.`nome_Ced_PA` as 'nome_Ced_PA', `companies`.`cognome_Ced_PA` as 'cognome_Ced_PA', `companies`.`codEORICed__PA` as 'codEORICed__PA', `companies`.`alboProfessionale_Ced_PA` as 'alboProfessionale_Ced_PA', `companies`.`provinciaAlbo_Ced_PA` as 'provinciaAlbo_Ced_PA', `companies`.`numeroIscrizione_Ced_AlboPA` as 'numeroIscrizione_Ced_AlboPA', if(`companies`.`dataIscrAlbo_Ced_PA`,date_format(`companies`.`dataIscrAlbo_Ced_PA`,'%Y-%m-%d'),'') as 'dataIscrAlbo_Ced_PA', `companies`.`regimeFiscalePA` as 'regimeFiscalePA', `companies`.`idPaeseVett_PA` as 'idPaeseVett_PA', `companies`.`idFiscaleVet_PA` as 'idFiscaleVet_PA', `companies`.`codFiscVet_PA` as 'codFiscVet_PA', `companies`.`denominazioneVet_PA` as 'denominazioneVet_PA', `companies`.`titoloVet_PA` as 'titoloVet_PA', `companies`.`nomeVet_PA` as 'nomeVet_PA', `companies`.`cognomeVett_PA` as 'cognomeVett_PA', `companies`.`codEORIVet_PA` as 'codEORIVet_PA', `companies`.`nrLicGuidaVet_PA` as 'nrLicGuidaVet_PA', if(`companies`.`data_DatiVeic_PA`,date_format(`companies`.`data_DatiVeic_PA`,'%Y-%m-%d'),'') as 'data_DatiVeic_PA', `companies`.`totalPercVeic_PA` as 'totalPercVeic_PA', `companies`.`mezzoTrVet_PA` as 'mezzoTrVet_PA'",
			'CLIENTI_CESSIONARI_PA' => "`CLIENTI_CESSIONARI_PA`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') as 'idPaese_Ces_PA', `CLIENTI_CESSIONARI_PA`.`idCodice_Ces_PA` as 'idCodice_Ces_PA', `CLIENTI_CESSIONARI_PA`.`codiceFiscale_Ces_PA` as 'codiceFiscale_Ces_PA', `CLIENTI_CESSIONARI_PA`.`Denominazione_Ces_PA` as 'Denominazione_Ces_PA', `CLIENTI_CESSIONARI_PA`.`tit_Ces_PA` as 'tit_Ces_PA', `CLIENTI_CESSIONARI_PA`.`nome_Ces_PA` as 'nome_Ces_PA', `CLIENTI_CESSIONARI_PA`.`cogn_Ces_PA` as 'cogn_Ces_PA', `CLIENTI_CESSIONARI_PA`.`Cod_Ces_EORI_PA` as 'Cod_Ces_EORI_PA', `CLIENTI_CESSIONARI_PA`.`indirizzo_Ces_PA` as 'indirizzo_Ces_PA', `CLIENTI_CESSIONARI_PA`.`numeroCiv_CesPA` as 'numeroCiv_CesPA', `CLIENTI_CESSIONARI_PA`.`CAP_Ces_PA` as 'CAP_Ces_PA', `CLIENTI_CESSIONARI_PA`.`comune_Ces_PA` as 'comune_Ces_PA', IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') as 'pr_Ces_PA', `CLIENTI_CESSIONARI_PA`.`nazione_Ces_PA` as 'nazione_Ces_PA', `CLIENTI_CESSIONARI_PA`.`notes` as 'notes', if(`CLIENTI_CESSIONARI_PA`.`birthDate`,date_format(`CLIENTI_CESSIONARI_PA`.`birthDate`,'%Y-%m-%d'),'') as 'birthDate', `CLIENTI_CESSIONARI_PA`.`autorizzSanitaria_SAM` as 'autorizzSanitaria_SAM', `CLIENTI_CESSIONARI_PA`.`AutSanEmessa_SAM` as 'AutSanEmessa_SAM', `CLIENTI_CESSIONARI_PA`.`NrPresSan_SAM` as 'NrPresSan_SAM', `CLIENTI_CESSIONARI_PA`.`NrAutSan_SAM` as 'NrAutSan_SAM', if(`CLIENTI_CESSIONARI_PA`.`dataAutSan_SAM`,date_format(`CLIENTI_CESSIONARI_PA`.`dataAutSan_SAM`,'%Y-%m-%d'),'') as 'dataAutSan_SAM'",
			'creditDocument' => "`creditDocument`.`id` as 'id', `creditDocument`.`incomingTypeDoc` as 'incomingTypeDoc', `creditDocument`.`customerID` as 'customerID', `creditDocument`.`nrDoc` as 'nrDoc', if(`creditDocument`.`dateIncomingNote`,date_format(`creditDocument`.`dateIncomingNote`,'%Y-%m-%d'),'') as 'dateIncomingNote', `creditDocument`.`customerFirm` as 'customerFirm', `creditDocument`.`customerAddress` as 'customerAddress', `creditDocument`.`customerPostCode` as 'customerPostCode', `creditDocument`.`customerTown` as 'customerTown'",
			'electronicInvoice' => "`electronicInvoice`.`id` as 'id', IF(    CHAR_LENGTH(`countries3`.`country`), CONCAT_WS('',   `countries3`.`country`), '') as 'idPaese_TR_PA', IF(    CHAR_LENGTH(`companies1`.`idCodice_Ced_PA`), CONCAT_WS('',   `companies1`.`idCodice_Ced_PA`), '') as 'idCodice_TR_PA', `electronicInvoice`.`progressivoInvioPA` as 'progressivoInvioPA', `electronicInvoice`.`formatoTrasmissionePA` as 'formatoTrasmissionePA', IF(    CHAR_LENGTH(`companies1`.`codiceDestinatarioUff_PA`), CONCAT_WS('',   `companies1`.`codiceDestinatarioUff_PA`), '') as 'codiceDestinatarioPA', IF(    CHAR_LENGTH(`phones1`.`phoneNumber`), CONCAT_WS('',   `phones1`.`phoneNumber`), '') as 'telefonoPA', `electronicInvoice`.`emailPA` as 'emailPA', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'idFiscaleIVA_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`codiceFiscale_Ced_PA`), CONCAT_WS('',   `companies1`.`codiceFiscale_Ced_PA`), '') as 'codiceFiscale_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`codiceFiscale_Ced_PA`), CONCAT_WS('',   `companies1`.`codiceFiscale_Ced_PA`), '') as 'denominazione_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`nome_Ced_PA`), CONCAT_WS('',   `companies1`.`nome_Ced_PA`), '') as 'nome_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`cognome_Ced_PA`), CONCAT_WS('',   `companies1`.`cognome_Ced_PA`), '') as 'cognome_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`titolo_Ced_PA`), CONCAT_WS('',   `companies1`.`titolo_Ced_PA`), '') as 'titolo_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`codEORICed__PA`), CONCAT_WS('',   `companies1`.`codEORICed__PA`), '') as 'codEORI_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`alboProfessionale_Ced_PA`), CONCAT_WS('',   `companies1`.`alboProfessionale_Ced_PA`), '') as 'alboProfessionale_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`provinciaAlbo_Ced_PA`), CONCAT_WS('',   `companies1`.`provinciaAlbo_Ced_PA`), '') as 'provinciaAlbo_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`numeroIscrizione_Ced_AlboPA`), CONCAT_WS('',   `companies1`.`numeroIscrizione_Ced_AlboPA`), '') as 'nrIscrizioneAlbo_Ced_PA', IF(    CHAR_LENGTH(if(`companies1`.`dataIscrAlbo_Ced_PA`,date_format(`companies1`.`dataIscrAlbo_Ced_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`companies1`.`dataIscrAlbo_Ced_PA`,date_format(`companies1`.`dataIscrAlbo_Ced_PA`,'%Y-%m-%d'),'')), '') as 'dataIscAlbo_Ced_PA', IF(    CHAR_LENGTH(`companies1`.`regimeFiscalePA`), CONCAT_WS('',   `companies1`.`regimeFiscalePA`), '') as 'regimeFiscale_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`indirizzo_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`indirizzo_Ced_PA`), '') as 'indirizzo_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`numeroCivico_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`numeroCivico_Ced_PA`), '') as 'numeroCivico_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`CAP_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`CAP_Ced_PA`), '') as 'CAP_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`comune_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`comune_Ced_PA`), '') as 'comune_Ced_PA', IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') as 'provincia_Ced_PA', IF(    CHAR_LENGTH(`countries4`.`country`), CONCAT_WS('',   `countries4`.`country`), '') as 'nazione_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`altroIndirizzo_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`altroIndirizzo_Ced_PA`), '') as 'altroIndirizzo_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`altro_nr_Civico_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`altro_nr_Civico_Ced_PA`), '') as 'altro_nr_Civico_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`altroCAP_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`altroCAP_Ced_PA`), '') as 'altroCAP_Ced_PA', IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') as 'altro_Com_Ced_PA', IF(    CHAR_LENGTH(`addresses_PA1`.`altra_PR_Ced_PA`), CONCAT_WS('',   `addresses_PA1`.`altra_PR_Ced_PA`), '') as 'altro_PR_Ced_PA', IF(    CHAR_LENGTH(`countries4`.`country`), CONCAT_WS('',   `countries4`.`country`), '') as 'altraNazione_Ced_PA', IF(    CHAR_LENGTH(`vatRegister1`.`ufficio_Ced_PA`), CONCAT_WS('',   `vatRegister1`.`ufficio_Ced_PA`), '') as 'ufficio_Ced_PA', IF(    CHAR_LENGTH(`vatRegister1`.`numeroREA_Ced_PA`), CONCAT_WS('',   `vatRegister1`.`numeroREA_Ced_PA`), '') as 'numeroREA_Ced__PA', IF(    CHAR_LENGTH(`vatRegister1`.`capitaleSociale_Ced_PA`), CONCAT_WS('',   `vatRegister1`.`capitaleSociale_Ced_PA`), '') as 'capitaleSociale_Ced_PA', IF(    CHAR_LENGTH(`vatRegister1`.`socioUnico_Ced_PA`), CONCAT_WS('',   `vatRegister1`.`socioUnico_Ced_PA`), '') as 'socioUnico_Ced_PA', IF(    CHAR_LENGTH(`vatRegister1`.`statoLiquidazione_Ced_PA`), CONCAT_WS('',   `vatRegister1`.`statoLiquidazione_Ced_PA`), '') as 'statoLiquidazione_Ced_PA', IF(    CHAR_LENGTH(`contacts_companies1`.`telefonoCompanyPA`), CONCAT_WS('',   `contacts_companies1`.`telefonoCompanyPA`), '') as 'telefonoCompany_Ced_PA', IF(    CHAR_LENGTH(`contacts_companies1`.`telefonoCompanyPA`), CONCAT_WS('',   `contacts_companies1`.`telefonoCompanyPA`), '') as 'faxCompany_Ced_PA', IF(    CHAR_LENGTH(`contacts_companies2`.`telefonoCompanyPA`), CONCAT_WS('',   `contacts_companies2`.`telefonoCompanyPA`), '') as 'eMailCompany_Ced_PA', `electronicInvoice`.`rif_Amm_Ced_PA` as 'rif_Amm_Ced_PA', IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') as 'idPaeseRap_Fisc_PA', IF(    CHAR_LENGTH(`countries6`.`code`), CONCAT_WS('',   `countries6`.`code`), '') as 'idPaeseRap_CodPA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codiceFiscale_RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codiceFiscale_RF_PA`), '') as 'idCodFiscRap_Fisc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`denominazione_RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`denominazione_RF_PA`), '') as 'idDenominazioneRap_FiscPA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nome_RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nome_RF_PA`), '') as 'idNomeRap_Fisc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nome_RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nome_RF_PA`), '') as 'idCognRap_Fisc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`titolo_RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`titolo_RF_PA`), '') as 'idTitoloRap_Fisc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codEORI__RF_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codEORI__RF_PA`), '') as 'idEORI_Rap_Fisc_PA', IF(    CHAR_LENGTH(`countries2`.`code`), CONCAT_WS('',   `countries2`.`code`), '') as 'idPaeseCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`idCodice_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`idCodice_Ces_PA`), '') as 'idCodiceCess_PA', `electronicInvoice`.`idCodiceFiscCess_PA` as 'idCodiceFiscCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`Denominazione_Ces_PA`), '') as 'denominazioneCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), '') as 'nomeCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`cogn_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`cogn_Ces_PA`), '') as 'cognomeCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`tit_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`tit_Ces_PA`), '') as 'titoloCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`Cod_Ces_EORI_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`Cod_Ces_EORI_PA`), '') as 'codEORI_Cess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`indirizzo_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`indirizzo_Ces_PA`), '') as 'indirizzoCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`numeroCiv_CesPA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`numeroCiv_CesPA`), '') as 'nrCivicoCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`CAP_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`CAP_Ces_PA`), '') as 'CAP_Cess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`comune_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`comune_Ces_PA`), '') as 'comuneCess_PA', IF(    CHAR_LENGTH(`town3`.`district`), CONCAT_WS('',   `town3`.`district`), '') as 'provCess_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`nazione_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`nazione_Ces_PA`), '') as 'nazione_Cess_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`idPaeseIVA_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`idPaeseIVA_3_Int_PA`), '') as 'idPaese3intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`idCodice_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`idCodice_3_Int_PA`), '') as 'idCod_3intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codFiscale_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codFiscale_3_Int_PA`), '') as 'codFisc_3intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`denominazione_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`denominazione_3_Int_PA`), '') as 'denom_3intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), '') as 'nome_3_intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), '') as 'cogn_3_intSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nome_3_Int_PA`), '') as 'tit_3_IntSogEm_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codEORI_3_Int_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codEORI_3_Int_PA`), '') as 'codEORi_3_intSogEm_PA', `electronicInvoice`.`SoggettoEmittente_PA` as 'SoggettoEmittente_PA', IF(    CHAR_LENGTH(`orders1`.`tipo_Documento_PA`), CONCAT_WS('',   `orders1`.`tipo_Documento_PA`), '') as 'tipoDocumentoFEB_PA', IF(    CHAR_LENGTH(`orders1`.`divisa_PA`), CONCAT_WS('',   `orders1`.`divisa_PA`), '') as 'divisaFEB_PA', IF(    CHAR_LENGTH(if(`orders1`.`data_Ord_PA`,date_format(`orders1`.`data_Ord_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`orders1`.`data_Ord_PA`,date_format(`orders1`.`data_Ord_PA`,'%Y-%m-%d'),'')), '') as 'dataFEB_PA', IF(    CHAR_LENGTH(`orders1`.`multiOrder_nr_PA`), CONCAT_WS('',   `orders1`.`multiOrder_nr_PA`), '') as 'numeroFEB_PA', IF(    CHAR_LENGTH(`orders1`.`tipo_rit_PA`), CONCAT_WS('',   `orders1`.`tipo_rit_PA`), '') as 'tipoRiten_PA', IF(    CHAR_LENGTH(`orders1`.`imp_rit_PA`), CONCAT_WS('',   `orders1`.`imp_rit_PA`), '') as 'impRiten_PA', IF(    CHAR_LENGTH(`orders1`.`aliq_rit_PA`), CONCAT_WS('',   `orders1`.`aliq_rit_PA`), '') as 'aliqRiten_PA', IF(    CHAR_LENGTH(`orders1`.`causale_pag_rit_PA`), CONCAT_WS('',   `orders1`.`causale_pag_rit_PA`), '') as 'causPagRit_PA', IF(    CHAR_LENGTH(`orders1`.`nr_bollo_rit_PA`), CONCAT_WS('',   `orders1`.`nr_bollo_rit_PA`), '') as 'numBolloRit_PA', IF(    CHAR_LENGTH(`orders1`.`importo_Bollo_rit_PA`), CONCAT_WS('',   `orders1`.`importo_Bollo_rit_PA`), '') as 'impBolloRit_PA', IF(    CHAR_LENGTH(`orders1`.`tipo_cassa_Prev_PA`), CONCAT_WS('',   `orders1`.`tipo_cassa_Prev_PA`), '') as 'tipoCassaPrev_PA', IF(    CHAR_LENGTH(`orders1`.`al_cassa_Prev_PA`), CONCAT_WS('',   `orders1`.`al_cassa_Prev_PA`), '') as 'alCassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`importo_cont_cassa_prev_PA`), CONCAT_WS('',   `orders1`.`importo_cont_cassa_prev_PA`), '') as 'impContCassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`imponibile_cassa_Prev_PA`), CONCAT_WS('',   `orders1`.`imponibile_cassa_Prev_PA`), '') as 'imponCassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`aliq_IVA_cassa_prev_PA`), CONCAT_WS('',   `orders1`.`aliq_IVA_cassa_prev_PA`), '') as 'aliIVA_CassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`ritenuta_cassa_prev_PA`), CONCAT_WS('',   `orders1`.`ritenuta_cassa_prev_PA`), '') as 'ritCassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`natura_cassa_prev_PA`), CONCAT_WS('',   `orders1`.`natura_cassa_prev_PA`), '') as 'naturaCassaPr_PA', IF(    CHAR_LENGTH(`orders1`.`rif_amm_prev_PA`), CONCAT_WS('',   `orders1`.`rif_amm_prev_PA`), '') as 'rifAmmCasPr_PA', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'tipoScMag_PA', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'percScMag_PA', IF(    CHAR_LENGTH(`orders1`.`importo_Sc_Mg_PA`), CONCAT_WS('',   `orders1`.`importo_Sc_Mg_PA`), '') as 'impScMag_PA', IF(    CHAR_LENGTH(`orders1`.`importoTot_Doc_PA`), CONCAT_WS('',   `orders1`.`importoTot_Doc_PA`), '') as 'ImpTotDoc_PA', IF(    CHAR_LENGTH(`orders1`.`arrotondamento_PA`), CONCAT_WS('',   `orders1`.`arrotondamento_PA`), '') as 'arrotDoc_PA', IF(    CHAR_LENGTH(`orders1`.`causale_PA`), CONCAT_WS('',   `orders1`.`causale_PA`), '') as 'causale_Doc_PA', IF(    CHAR_LENGTH(`orders1`.`art73_PA`), CONCAT_WS('',   `orders1`.`art73_PA`), '') as 'art73_doc_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`nrLinea_PA`), CONCAT_WS('',   `ordersDetails1`.`nrLinea_PA`), '') as 'rifNumLineaDoc_PA', IF(    CHAR_LENGTH(`orders26`.`id`), CONCAT_WS('',   `orders26`.`id`), '') as 'idDocNum_PA', IF(    CHAR_LENGTH(if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), '') as 'dataOrder_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`noSell`), CONCAT_WS('',   `ordersDetails1`.`noSell`), '') as 'numItemDoc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codCom_Con_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codCom_Con_PA`), '') as 'codCommConvDoc_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codCUP_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codCUP_PA`), '') as 'codCUP_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`codGIG_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`codGIG_PA`), '') as 'codCIG_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`riferFase_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`riferFase_PA`), '') as 'RIFERIMENTO_FASE_PA', IF(    CHAR_LENGTH(`orders1`.`multiOrder_nr_PA`), CONCAT_WS('',   `orders1`.`multiOrder_nr_PA`), '') as 'NUMERO_DDT_PA', IF(    CHAR_LENGTH(if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), '') as 'dataDDT_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`nrLinea_PA`), CONCAT_WS('',   `ordersDetails1`.`nrLinea_PA`), '') as 'rifNumLinea_PA', IF(    CHAR_LENGTH(`companies1`.`idPaeseVett_PA`), CONCAT_WS('',   `companies1`.`idPaeseVett_PA`), '') as 'ID_PAESE_VET_PA', IF(    CHAR_LENGTH(`companies1`.`idFiscaleVet_PA`), CONCAT_WS('',   `companies1`.`idFiscaleVet_PA`), '') as 'idCodVet_PA', IF(    CHAR_LENGTH(`companies1`.`codFiscVet_PA`), CONCAT_WS('',   `companies1`.`codFiscVet_PA`), '') as 'codFiscVet_PA', IF(    CHAR_LENGTH(`companies1`.`denominazioneVet_PA`), CONCAT_WS('',   `companies1`.`denominazioneVet_PA`), '') as 'DENOMINAZIONE_ANAGR_VETT_PA', IF(    CHAR_LENGTH(`companies1`.`nomeVet_PA`), CONCAT_WS('',   `companies1`.`nomeVet_PA`), '') as 'nomeVett_PA', IF(    CHAR_LENGTH(`companies1`.`cognomeVett_PA`), CONCAT_WS('',   `companies1`.`cognomeVett_PA`), '') as 'cognVett_PA', IF(    CHAR_LENGTH(`companies1`.`titoloVet_PA`), CONCAT_WS('',   `companies1`.`titoloVet_PA`), '') as 'titVett_PA', IF(    CHAR_LENGTH(`companies1`.`codEORIVet_PA`), CONCAT_WS('',   `companies1`.`codEORIVet_PA`), '') as 'codEORI_Vet_PA', IF(    CHAR_LENGTH(`companies1`.`nrLicGuidaVet_PA`), CONCAT_WS('',   `companies1`.`nrLicGuidaVet_PA`), '') as 'nrLicenzaGuidaVet_PA', IF(    CHAR_LENGTH(`companies1`.`mezzoTrVet_PA`), CONCAT_WS('',   `companies1`.`mezzoTrVet_PA`), '') as 'mezzoTraspVet_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`causTrasp_PA`), CONCAT_WS('',   `ordersDetails1`.`causTrasp_PA`), '') as 'causaleTrsVet_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`packages`), CONCAT_WS('',   `ordersDetails1`.`packages`), '') as 'nrColliTrasp_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`descrizioneArt_PA`), CONCAT_WS('',   `ordersDetails1`.`descrizioneArt_PA`), '') as 'descrTrasp_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`UMRifPeso_PA`), CONCAT_WS('',   `ordersDetails1`.`UMRifPeso_PA`), '') as 'unMisPeso_PA', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'pesoLordoMerce_PA', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'pesoNettoMer_PA', IF(    CHAR_LENGTH(if(`orders1`.`data_Ord_PA`,date_format(`orders1`.`data_Ord_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`orders1`.`data_Ord_PA`,date_format(`orders1`.`data_Ord_PA`,'%Y-%m-%d'),'')), '') as 'dataOraRitMer_PA', IF(    CHAR_LENGTH(if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`ordersDetails1`.`sellDate`,date_format(`ordersDetails1`.`sellDate`,'%Y-%m-%d'),'')), '') as 'dataInTrMer_PA', IF(    CHAR_LENGTH(`orders1`.`tipoResa_PA`), CONCAT_WS('',   `orders1`.`tipoResa_PA`), '') as 'tipoResaTr_PA', IF(    CHAR_LENGTH(`orders1`.`indirizzoResa_PA`), CONCAT_WS('',   `orders1`.`indirizzoResa_PA`), '') as 'INDIRIZZO_RESA_PA', IF(    CHAR_LENGTH(`orders1`.`nrCivicoResa_PA`), CONCAT_WS('',   `orders1`.`nrCivicoResa_PA`), '') as 'nrCivResa_PA', IF(    CHAR_LENGTH(`town4`.`shipCode`), CONCAT_WS('',   `town4`.`shipCode`), '') as 'capResa_PA', IF(    CHAR_LENGTH(`town4`.`town`), CONCAT_WS('',   `town4`.`town`), '') as 'comuneResa_PA', IF(    CHAR_LENGTH(`town4`.`district`), CONCAT_WS('',   `town4`.`district`), '') as 'prResa_PA', IF(    CHAR_LENGTH(`countries7`.`code`), CONCAT_WS('',   `countries7`.`code`), '') as 'nazioneResa_PA', IF(    CHAR_LENGTH(if(`orders1`.`dataOraCons_PA`,date_format(`orders1`.`dataOraCons_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`orders1`.`dataOraCons_PA`,date_format(`orders1`.`dataOraCons_PA`,'%Y-%m-%d'),'')), '') as 'dataOraCons_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`normaRifer_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`normaRifer_PA`), '') as 'normaRif_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`nrFatturaPrinc_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`nrFatturaPrinc_PA`), '') as 'NR_FATT_PRINC_PA', IF(    CHAR_LENGTH(`sogg_Terzi_Rapp_PA1`.`dataFattPrinc_PA`), CONCAT_WS('',   `sogg_Terzi_Rapp_PA1`.`dataFattPrinc_PA`), '') as 'dataFattPrin_PA', `electronicInvoice`.`NUMERO_LINEA_BENI_SERV_PA` as 'NUMERO_LINEA_BENI_SERV_PA', `electronicInvoice`.`tipoCessPrest_PA` as 'tipoCessPrest_PA', `electronicInvoice`.`CODICE_TIPO_PA` as 'CODICE_TIPO_PA', `electronicInvoice`.`codiceVal_PA` as 'codiceVal_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`descrizioneArt_PA`), CONCAT_WS('',   `ordersDetails1`.`descrizioneArt_PA`), '') as 'descrizioneBene_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`QuantityReal`), CONCAT_WS('',   `ordersDetails1`.`QuantityReal`), '') as 'quantitaBene_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`UMRifPeso_PA`), CONCAT_WS('',   `ordersDetails1`.`UMRifPeso_PA`), '') as 'uniMisBene_PA', if(`electronicInvoice`.`dataInPeriodo_PA`,date_format(`electronicInvoice`.`dataInPeriodo_PA`,'%Y-%m-%d'),'') as 'dataInPeriodo_PA', if(`electronicInvoice`.`dataFinePeriodo_PA`,date_format(`electronicInvoice`.`dataFinePeriodo_PA`,'%Y-%m-%d'),'') as 'dataFinePeriodo_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`prezzoUn_PA`), CONCAT_WS('',   `ordersDetails1`.`prezzoUn_PA`), '') as 'prezzoUn_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`tipoScMAg_PA`), CONCAT_WS('',   `ordersDetails1`.`tipoScMAg_PA`), '') as 'TIPO_SCONTO_MAG_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`percScontoLinea_PA`), CONCAT_WS('',   `ordersDetails1`.`percScontoLinea_PA`), '') as 'perScMagBene_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`importoScontoMag_PA`), CONCAT_WS('',   `ordersDetails1`.`importoScontoMag_PA`), '') as 'impScMagBene_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`LineTotal`), CONCAT_WS('',   `ordersDetails1`.`LineTotal`), '') as 'prezzoTotaleBene_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`aliquotaIVA_PA`), CONCAT_WS('',   `ordersDetails1`.`aliquotaIVA_PA`), '') as 'aliqIVA_bene_PA', `electronicInvoice`.`ritenuta_bene_PA` as 'ritenuta_bene_PA', `electronicInvoice`.`naturaRitBene` as 'naturaRitBene', `electronicInvoice`.`rifAmm_PA` as 'rifAmm_PA', `electronicInvoice`.`TIPO_DATO_ALTRI_DATI_PA` as 'TIPO_DATO_ALTRI_DATI_PA', `electronicInvoice`.`rifTesto_altri_dati_PA` as 'rifTesto_altri_dati_PA', `electronicInvoice`.`rifNum_Altri_dati_PA` as 'rifNum_Altri_dati_PA', if(`electronicInvoice`.`rifData_altri_dati_PA`,date_format(`electronicInvoice`.`rifData_altri_dati_PA`,'%Y-%m-%d'),'') as 'rifData_altri_dati_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`aliquotaIVA_PA`), CONCAT_WS('',   `ordersDetails1`.`aliquotaIVA_PA`), '') as 'AL_IVA_RIEP_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`naturaRiep_PA`), CONCAT_WS('',   `ordersDetails1`.`naturaRiep_PA`), '') as 'naturaRiep_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`speseAccess_PA`), CONCAT_WS('',   `ordersDetails1`.`speseAccess_PA`), '') as 'speseAcc_Riep_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`arrotondamentoRiep_PA`), CONCAT_WS('',   `ordersDetails1`.`arrotondamentoRiep_PA`), '') as 'arrotRiep_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`imponibileImp_PA`), CONCAT_WS('',   `ordersDetails1`.`imponibileImp_PA`), '') as 'imponibileImpRiep_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`impostaRiep_PA`), CONCAT_WS('',   `ordersDetails1`.`impostaRiep_PA`), '') as 'impostaRiep_PA', IF(    CHAR_LENGTH(`ordersDetails1`.`esigibilitaIVA_PA`), CONCAT_WS('',   `ordersDetails1`.`esigibilitaIVA_PA`), '') as 'esigIVA_riep_PA', `electronicInvoice`.`rifNormRiep_PA` as 'rifNormRiep_PA', IF(    CHAR_LENGTH(if(`companies1`.`data_DatiVeic_PA`,date_format(`companies1`.`data_DatiVeic_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`companies1`.`data_DatiVeic_PA`,date_format(`companies1`.`data_DatiVeic_PA`,'%Y-%m-%d'),'')), '') as 'DATA_DATI_VEIC_PA', IF(    CHAR_LENGTH(`companies1`.`totalPercVeic_PA`), CONCAT_WS('',   `companies1`.`totalPercVeic_PA`), '') as 'totalePercorso_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`datiPag_PA`), CONCAT_WS('',   `firstCashNote1`.`datiPag_PA`), '') as 'BENEFIC_DATI_PAG_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`modPagam_PA`), CONCAT_WS('',   `firstCashNote1`.`modPagam_PA`), '') as 'modPagam_PA', IF(    CHAR_LENGTH(if(`firstCashNote1`.`dataRifTerPag_PA`,date_format(`firstCashNote1`.`dataRifTerPag_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`firstCashNote1`.`dataRifTerPag_PA`,date_format(`firstCashNote1`.`dataRifTerPag_PA`,'%Y-%m-%d'),'')), '') as 'dataRifTermPag_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`giorniTermPag_PA`), CONCAT_WS('',   `firstCashNote1`.`giorniTermPag_PA`), '') as 'giorniTermPag_PA', IF(    CHAR_LENGTH(if(`firstCashNote1`.`dataScadPag_PA`,date_format(`firstCashNote1`.`dataScadPag_PA`,'%Y-%m-%d'),'')), CONCAT_WS('',   if(`firstCashNote1`.`dataScadPag_PA`,date_format(`firstCashNote1`.`dataScadPag_PA`,'%Y-%m-%d'),'')), '') as 'dataScadPag_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`importoPag_PA`), CONCAT_WS('',   `firstCashNote1`.`importoPag_PA`), '') as 'imporPag_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`codUffPost_PA`), CONCAT_WS('',   `firstCashNote1`.`codUffPost_PA`), '') as 'codUffPostale_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`cognomeQuietanzante_PA`), CONCAT_WS('',   `firstCashNote1`.`cognomeQuietanzante_PA`), '') as 'cognomeQuietanzante_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`nomeQuietanzante_PA`), CONCAT_WS('',   `firstCashNote1`.`nomeQuietanzante_PA`), '') as 'nomeQuietanzante_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`codFiscQuietanzante_PA`), CONCAT_WS('',   `firstCashNote1`.`codFiscQuietanzante_PA`), '') as 'CF_Quietanzante_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`titoloQuietanzante_PA`), CONCAT_WS('',   `firstCashNote1`.`titoloQuietanzante_PA`), '') as 'titQuietanzante_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'IBAN_PA', `electronicInvoice`.`ABI_PA` as 'ABI_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'CAB_PA', `electronicInvoice`.`BIC_PA` as 'BIC_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'scontoPagAntic_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'dataLimPagAntic_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'penRitarPagam_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'dataDecPenale_PA', IF(    CHAR_LENGTH(`firstCashNote1`.`id`), CONCAT_WS('',   `firstCashNote1`.`id`), '') as 'codPagamento_PA', IF(    CHAR_LENGTH(`allegati_PA1`.`momeAlleg_PA`), CONCAT_WS('',   `allegati_PA1`.`momeAlleg_PA`), '') as 'ALLEGATI_NOME_ALL_PA', IF(    CHAR_LENGTH(`allegati_PA1`.`algoritmoComp_PA`), CONCAT_WS('',   `allegati_PA1`.`algoritmoComp_PA`), '') as 'algoritmoComp_PA', IF(    CHAR_LENGTH(`allegati_PA1`.`formatoAlleg_PA`), CONCAT_WS('',   `allegati_PA1`.`formatoAlleg_PA`), '') as 'formatoAttachement_PA', IF(    CHAR_LENGTH(`allegati_PA1`.`descrizAlleg_PA`), CONCAT_WS('',   `allegati_PA1`.`descrizAlleg_PA`), '') as 'descrizioneAttach_PA', IF(    CHAR_LENGTH(`allegati_PA1`.`file`), CONCAT_WS('',   `allegati_PA1`.`file`), '') as 'attachment_PA'",
			'countries' => "`countries`.`id` as 'id', `countries`.`country` as 'country', `countries`.`code` as 'code', `countries`.`ISOcode` as 'ISOcode'",
			'town' => "`town`.`id` as 'id', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'country', `town`.`idIstat` as 'idIstat', `town`.`town` as 'town', `town`.`district` as 'district', `town`.`region` as 'region', `town`.`prefix` as 'prefix', `town`.`shipCode` as 'shipCode', `town`.`fiscCode` as 'fiscCode', `town`.`inhabitants` as 'inhabitants', `town`.`link` as 'link'",
			'GPSTrackingSystem' => "`GPSTrackingSystem`.`id` as 'id', `GPSTrackingSystem`.`carTracked` as 'carTracked'",
			'kinds' => "`kinds`.`entity` as 'entity', `kinds`.`code` as 'code', `kinds`.`name` as 'name', `kinds`.`value` as 'value', `kinds`.`descriptions` as 'descriptions'",
			'Logs' => "`Logs`.`id` as 'id', `Logs`.`ip` as 'ip', `Logs`.`ts` as 'ts', `Logs`.`details` as 'details'",
			'attributes' => "`attributes`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'attribute', `attributes`.`value` as 'value', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'companies', IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') as 'products'",
			'addresses_PA' => "`addresses_PA`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `addresses_PA`.`indirizzo_Ced_PA` as 'indirizzo_Ced_PA', `addresses_PA`.`numeroCivico_Ced_PA` as 'numeroCivico_Ced_PA', IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') as 'CAP_Ced_PA', IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') as 'comune_Ced_PA', IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') as 'provincia_Ced_PA', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'nazione_Ced_PA', `addresses_PA`.`IBAN_PA` as 'IBAN_PA', `addresses_PA`.`ABI_PA` as 'ABI_PA', `addresses_PA`.`CAB_PA` as 'CAB_PA', `addresses_PA`.`BIC_PA` as 'BIC_PA', `addresses_PA`.`altroIndirizzo_Ced_PA` as 'altroIndirizzo_Ced_PA', `addresses_PA`.`altro_nr_Civico_Ced_PA` as 'altro_nr_Civico_Ced_PA', `addresses_PA`.`altroCAP_Ced_PA` as 'altroCAP_Ced_PA', `addresses_PA`.`altra_PR_Ced_PA` as 'altra_PR_Ced_PA', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'altraNazione_Ced_PA', `addresses_PA`.`indirizzo_Ces_PA` as 'indirizzo_Ces_PA', `addresses_PA`.`numeroCivico_Ces_PA` as 'numeroCivico_Ces_PA', `addresses_PA`.`CAP_Ces_PA` as 'CAP_Ces_PA', `addresses_PA`.`comune_Ces_PA` as 'comune_Ces_PA', `addresses_PA`.`prov_Ces_PA` as 'prov_Ces_PA', `addresses_PA`.`nazione_Ces_PA` as 'nazione_Ces_PA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company', `addresses_PA`.`map` as 'map', `addresses_PA`.`default` as 'default', `addresses_PA`.`ship` as 'ship', CONCAT('&euro;', FORMAT(`addresses_PA`.`scontoPagAnt_PA`, 2)) as 'scontoPagAnt_PA', if(`addresses_PA`.`dataPagAntic_PA`,date_format(`addresses_PA`.`dataPagAntic_PA`,'%Y-%m-%d'),'') as 'dataPagAntic_PA', `addresses_PA`.`penalRitardPag_PA` as 'penalRitardPag_PA', if(`addresses_PA`.`dataDecorPag_PA`,date_format(`addresses_PA`.`dataDecorPag_PA`,'%Y-%m-%d'),'') as 'dataDecorPag_PA', `addresses_PA`.`codPagam_PA` as 'codPagam_PA'",
			'phones' => "`phones`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `phones`.`phoneNumber` as 'phoneNumber', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company'",
			'PEC' => "`PEC`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `PEC`.`PEC_PA` as 'PEC_PA', `PEC`.`codiceUnivocoPA` as 'codiceUnivocoPA', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company'",
			'contacts_companies' => "`contacts_companies`.`id` as 'id', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`) || CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`cogn_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`, ' ', `CLIENTI_CESSIONARI_PA1`.`cogn_Ces_PA`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`companyName`) || CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyName`, ' - ', `companies1`.`companyCode`), '') as 'company', `contacts_companies`.`default` as 'default', `contacts_companies`.`telefonoCompanyPA` as 'telefonoCompanyPA', `contacts_companies`.`faxCompanyPA` as 'faxCompanyPA', `contacts_companies`.`eMailCompanyPA` as 'eMailCompanyPA', `contacts_companies`.`riferimentoAmministrazionePA` as 'riferimentoAmministrazionePA'",
			'allegati_PA' => "`allegati_PA`.`id` as 'id', `allegati_PA`.`momeAlleg_PA` as 'momeAlleg_PA', `allegati_PA`.`file` as 'file', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`id`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company', `allegati_PA`.`algoritmoComp_PA` as 'algoritmoComp_PA', `allegati_PA`.`thumbUse` as 'thumbUse', `allegati_PA`.`formatoAlleg_PA` as 'formatoAlleg_PA', `allegati_PA`.`descrizAlleg_PA` as 'descrizAlleg_PA'",
			'sogg_Terzi_Rapp_PA' => "`sogg_Terzi_Rapp_PA`.`id` as 'id', IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') as 'idPaese_RF_PA', `sogg_Terzi_Rapp_PA`.`idCodice_RF_PA` as 'idCodice_RF_PA', `sogg_Terzi_Rapp_PA`.`codiceFiscale_RF_PA` as 'codiceFiscale_RF_PA', `sogg_Terzi_Rapp_PA`.`denominazione_RF_PA` as 'denominazione_RF_PA', `sogg_Terzi_Rapp_PA`.`nome_RF_PA` as 'nome_RF_PA', `sogg_Terzi_Rapp_PA`.`cognome_RF_PA` as 'cognome_RF_PA', `sogg_Terzi_Rapp_PA`.`titolo_RF_PA` as 'titolo_RF_PA', `sogg_Terzi_Rapp_PA`.`codEORI__RF_PA` as 'codEORI__RF_PA', `sogg_Terzi_Rapp_PA`.`idPaeseIVA_3_Int_PA` as 'idPaeseIVA_3_Int_PA', `sogg_Terzi_Rapp_PA`.`idCodice_3_Int_PA` as 'idCodice_3_Int_PA', `sogg_Terzi_Rapp_PA`.`codFiscale_3_Int_PA` as 'codFiscale_3_Int_PA', `sogg_Terzi_Rapp_PA`.`denominazione_3_Int_PA` as 'denominazione_3_Int_PA', `sogg_Terzi_Rapp_PA`.`nome_3_Int_PA` as 'nome_3_Int_PA', `sogg_Terzi_Rapp_PA`.`cognome_3_Int_PA` as 'cognome_3_Int_PA', `sogg_Terzi_Rapp_PA`.`titolo_3_Int_PA` as 'titolo_3_Int_PA', `sogg_Terzi_Rapp_PA`.`codEORI_3_Int_PA` as 'codEORI_3_Int_PA', `sogg_Terzi_Rapp_PA`.`sogg_Emittente_PA` as 'sogg_Emittente_PA', `sogg_Terzi_Rapp_PA`.`rif_num_linea_PA` as 'rif_num_linea_PA', `sogg_Terzi_Rapp_PA`.`idDoc_PA` as 'idDoc_PA', if(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,date_format(`sogg_Terzi_Rapp_PA`.`data_orAcq_PA`,'%Y-%m-%d'),'') as 'data_orAcq_PA', `sogg_Terzi_Rapp_PA`.`numItem_PA` as 'numItem_PA', `sogg_Terzi_Rapp_PA`.`codCom_Con_PA` as 'codCom_Con_PA', `sogg_Terzi_Rapp_PA`.`codCUP_PA` as 'codCUP_PA', `sogg_Terzi_Rapp_PA`.`codGIG_PA` as 'codGIG_PA', `sogg_Terzi_Rapp_PA`.`datiCont_PA` as 'datiCont_PA', `sogg_Terzi_Rapp_PA`.`datiConv_PA` as 'datiConv_PA', `sogg_Terzi_Rapp_PA`.`datiRic_PA` as 'datiRic_PA', `sogg_Terzi_Rapp_PA`.`datiFatCol_PA` as 'datiFatCol_PA', `sogg_Terzi_Rapp_PA`.`datiSal_PA` as 'datiSal_PA', `sogg_Terzi_Rapp_PA`.`riferFase_PA` as 'riferFase_PA', `sogg_Terzi_Rapp_PA`.`normaRifer_PA` as 'normaRifer_PA', `sogg_Terzi_Rapp_PA`.`nrFatturaPrinc_PA` as 'nrFatturaPrinc_PA', DATE_FORMAT(`sogg_Terzi_Rapp_PA`.`dataFattPrinc_PA`, '%Y-%m-%d %H:%i') as 'dataFattPrinc_PA'"
		);

		if(isset($sql_fields[$table_name])){
			return $sql_fields[$table_name];
		}

		return false;
	}

	#########################################################

	function get_sql_from($table_name, $skip_permissions = false, $skip_joins = false) {
		$sql_from = array(   
			'orders' => "`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` LEFT JOIN `town` as town1 ON `town1`.`id`=`orders`.`CAP_Resa_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`orders`.`nazioneResa_PA` ",
			'ordersDetails' => "`ordersDetails` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`ordersDetails`.`order` LEFT JOIN `products` as products1 ON `products1`.`id`=`ordersDetails`.`productCode` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`ordersDetails`.`section` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders1`.`kind` ",
			'_resumeOrders' => "`_resumeOrders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`_resumeOrders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`_resumeOrders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`_resumeOrders`.`typedoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`_resumeOrders`.`customer` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`_resumeOrders`.`related` ",
			'products' => "`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ",
			'firstCashNote' => "`firstCashNote` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`firstCashNote`.`kind` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`firstCashNote`.`order` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders1`.`company` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`firstCashNote`.`customer` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`firstCashNote`.`idBank` ",
			'vatRegister' => "`vatRegister` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`vatRegister`.`idCompany` ",
			'companies' => "`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`companies`.`idPaese_Ced_PA` ",
			'CLIENTI_CESSIONARI_PA' => "`CLIENTI_CESSIONARI_PA` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`CLIENTI_CESSIONARI_PA`.`kind` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`CLIENTI_CESSIONARI_PA`.`idPaese_Ces_PA` LEFT JOIN `town` as town1 ON `town1`.`id`=`CLIENTI_CESSIONARI_PA`.`pr_Ces_PA` ",
			'creditDocument' => "`creditDocument` ",
			'electronicInvoice' => "`electronicInvoice` LEFT JOIN `phones` as phones1 ON `phones1`.`id`=`electronicInvoice`.`telefonoPA` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`electronicInvoice`.`idFiscaleIVA_Ced_PA` LEFT JOIN `addresses_PA` as addresses_PA1 ON `addresses_PA1`.`id`=`electronicInvoice`.`indirizzo_Ced_PA` LEFT JOIN `vatRegister` as vatRegister1 ON `vatRegister1`.`id`=`electronicInvoice`.`ufficio_Ced_PA` LEFT JOIN `contacts_companies` as contacts_companies1 ON `contacts_companies1`.`id`=`electronicInvoice`.`faxCompany_Ced_PA` LEFT JOIN `contacts_companies` as contacts_companies2 ON `contacts_companies2`.`id`=`electronicInvoice`.`eMailCompany_Ced_PA` LEFT JOIN `sogg_Terzi_Rapp_PA` as sogg_Terzi_Rapp_PA1 ON `sogg_Terzi_Rapp_PA1`.`id`=`electronicInvoice`.`idPaeseRap_Fisc_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`sogg_Terzi_Rapp_PA1`.`idPaese_RF_PA` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`electronicInvoice`.`idPaeseCess_PA` LEFT JOIN `countries` as countries2 ON `countries2`.`id`=`CLIENTI_CESSIONARI_PA1`.`idPaese_Ces_PA` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`electronicInvoice`.`tipoDocumentoFEB_PA` LEFT JOIN `ordersDetails` as ordersDetails1 ON `ordersDetails1`.`id`=`electronicInvoice`.`rifNumLineaDoc_PA` LEFT JOIN `firstCashNote` as firstCashNote1 ON `firstCashNote1`.`id`=`electronicInvoice`.`BENEFIC_DATI_PAG_PA` LEFT JOIN `allegati_PA` as allegati_PA1 ON `allegati_PA1`.`id`=`electronicInvoice`.`ALLEGATI_NOME_ALL_PA` LEFT JOIN `countries` as countries3 ON `countries3`.`id`=`companies1`.`idPaese_Ced_PA` LEFT JOIN `town` as town1 ON `town1`.`id`=`addresses_PA1`.`provincia_Ced_PA` LEFT JOIN `countries` as countries4 ON `countries4`.`id`=`addresses_PA1`.`nazione_Ced_PA` LEFT JOIN `countries` as countries6 ON `countries6`.`id`=`sogg_Terzi_Rapp_PA1`.`idPaese_RF_PA` LEFT JOIN `town` as town3 ON `town3`.`id`=`CLIENTI_CESSIONARI_PA1`.`pr_Ces_PA` LEFT JOIN `orders` as orders26 ON `orders26`.`id`=`ordersDetails1`.`order` LEFT JOIN `town` as town4 ON `town4`.`id`=`orders1`.`CAP_Resa_PA` LEFT JOIN `countries` as countries7 ON `countries7`.`id`=`orders1`.`nazioneResa_PA` ",
			'countries' => "`countries` ",
			'town' => "`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ",
			'GPSTrackingSystem' => "`GPSTrackingSystem` ",
			'kinds' => "`kinds` ",
			'Logs' => "`Logs` ",
			'attributes' => "`attributes` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`attributes`.`attribute` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`attributes`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`attributes`.`companies` LEFT JOIN `products` as products1 ON `products1`.`id`=`attributes`.`products` ",
			'addresses_PA' => "`addresses_PA` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`addresses_PA`.`kind` LEFT JOIN `town` as town1 ON `town1`.`id`=`addresses_PA`.`provincia_Ced_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`addresses_PA`.`nazione_Ced_PA` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`addresses_PA`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`addresses_PA`.`company` ",
			'phones' => "`phones` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`phones`.`kind` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`phones`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`phones`.`company` ",
			'PEC' => "`PEC` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`PEC`.`kind` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`PEC`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`PEC`.`company` ",
			'contacts_companies' => "`contacts_companies` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`contacts_companies`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`contacts_companies`.`company` ",
			'allegati_PA' => "`allegati_PA` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`allegati_PA`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`allegati_PA`.`company` ",
			'sogg_Terzi_Rapp_PA' => "`sogg_Terzi_Rapp_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`sogg_Terzi_Rapp_PA`.`idPaese_RF_PA` "
		);

		$pkey = array(   
			'orders' => 'id',
			'ordersDetails' => 'id',
			'_resumeOrders' => 'id',
			'products' => 'id',
			'firstCashNote' => 'id',
			'vatRegister' => 'id',
			'companies' => 'id',
			'CLIENTI_CESSIONARI_PA' => 'id',
			'creditDocument' => 'id',
			'electronicInvoice' => 'id',
			'countries' => 'id',
			'town' => 'id',
			'GPSTrackingSystem' => 'id',
			'kinds' => 'code',
			'Logs' => 'id',
			'attributes' => 'id',
			'addresses_PA' => 'id',
			'phones' => 'id',
			'PEC' => 'id',
			'contacts_companies' => 'id',
			'allegati_PA' => 'id',
			'sogg_Terzi_Rapp_PA' => 'id'
		);

		if(!isset($sql_from[$table_name])) return false;

		$from = ($skip_joins ? "`{$table_name}`" : $sql_from[$table_name]);

		if($skip_permissions) return $from . ' WHERE 1=1';

		// mm: build the query based on current member's permissions
		$perm = getTablePermissions($table_name);
		if($perm[2] == 1){ // view owner only
			$from .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and lcase(membership_userrecords.memberID)='" . getLoggedMemberID() . "'";
		}elseif($perm[2] == 2){ // view group only
			$from .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and membership_userrecords.groupID='" . getLoggedGroupID() . "'";
		}elseif($perm[2] == 3){ // view all
			$from .= ' WHERE 1=1';
		}else{ // view none
			return false;
		}

		return $from;
	}

	#########################################################

	function get_joined_record($table, $id, $skip_permissions = false){
		$sql_fields = get_sql_fields($table);
		$sql_from = get_sql_from($table, $skip_permissions);

		if(!$sql_fields || !$sql_from) return false;

		$pk = getPKFieldName($table);
		if(!$pk) return false;

		$safe_id = makeSafe($id, false);
		$sql = "SELECT {$sql_fields} FROM {$sql_from} AND `{$table}`.`{$pk}`='{$safe_id}'";
		$eo['silentErrors'] = true;
		$res = sql($sql, $eo);
		if($row = db_fetch_assoc($res)) return $row;

		return false;
	}

	#########################################################

	function get_defaults($table){
		/* array of tables and their fields, with default values (or empty), excluding automatic values */
		$defaults = array(
			'orders' => array(
				'id' => '',
				'kind' => '',
				'progressivNumber' => '',
				'consigneeID' => '',
				'company' => '',
				'typeDoc' => '',
				'multiOrder_nr_PA' => '',
				'formatoTrasmissione_PA' => 'SDI10',
				'tipo_Documento_PA' => 'TD01',
				'divisa_PA' => 'EUR',
				'importo_Sc_Mg_PA' => '',
				'importoTot_Doc_PA' => '',
				'arrotondamento_PA' => '',
				'causale_PA' => 'VENDITA',
				'art73_PA' => '',
				'data_Ord_PA' => '',
				'dataOraRit_PA' => '',
				'dataInizTrasp_PA' => '',
				'customer' => '',
				'supplier' => '',
				'employee' => '',
				'shipVia' => '',
				'Freight' => '',
				'pallets' => '',
				'mezzoTraspVet_PA' => '',
				'causaleTraspVet_PA' => '',
				'nrColliVett_PA' => '',
				'descTraspVet_PA' => '',
				'cashCredit' => '1',
				'trust' => '',
				'overdraft' => '',
				'commisionFee' => '',
				'commisionRate' => '',
				'related' => '',
				'document' => '',
				'tipo_rit_PA' => '',
				'imp_rit_PA' => '',
				'aliq_rit_PA' => '',
				'causale_pag_rit_PA' => '',
				'nr_bollo_rit_PA' => '',
				'importo_Bollo_rit_PA' => '',
				'tipo_cassa_Prev_PA' => '',
				'al_cassa_Prev_PA' => '',
				'importo_cont_cassa_prev_PA' => '',
				'imponibile_cassa_Prev_PA' => '',
				'aliq_IVA_cassa_prev_PA' => '',
				'ritenuta_cassa_prev_PA' => '',
				'natura_cassa_prev_PA' => '',
				'rif_amm_prev_PA' => '',
				'tipoResa_PA' => 'EXW',
				'indirizzoResa_PA' => '',
				'nrCivicoResa_PA' => '',
				'CAP_Resa_PA' => '',
				'comuneResa_PA' => '',
				'provResa_PA' => '',
				'nazioneResa_PA' => '',
				'dataOraCons_PA' => ''
			),
			'ordersDetails' => array(
				'id' => '',
				'order' => '',
				'manufactureDate' => '',
				'sellDate' => '',
				'expiryDate' => '',
				'daysToExpiry' => '',
				'codebar' => '',
				'productCode' => '',
				'batch' => '',
				'packages' => '',
				'noSell' => '',
				'quantity_PA' => '1',
				'QuantityReal' => '',
				'UMRifPeso_PA' => '',
				'prezzoUn_PA' => '',
				'aliquotaIVA_PA' => '',
				'prezzoTot_PA' => '',
				'tipoScMAg_PA' => '',
				'percScontoLinea_PA' => '',
				'section' => 'Magazzino Metaponto',
				'transaction_type' => 'Outgoing',
				'skBatches' => '',
				'averagePrice' => '',
				'averageWeight' => '',
				'commission' => '15.00',
				'return' => '1',
				'supplierCode' => '',
				'causTrasp_PA' => '',
				'nrLinea_PA' => '',
				'tipoCessionePrest_PA' => '',
				'codTipo_PA' => '',
				'codValore_PA' => '',
				'descrizioneArt_PA' => '',
				'percentualeScontoMag_PA' => '',
				'importoScontoMag_PA' => '',
				'imponibileImp_PA' => '',
				'impostaRiep_PA' => '',
				'LineTotal' => '',
				'esigibilitaIVA_PA' => 'D',
				'ritenuta_PA' => '',
				'natura_PA' => '',
				'rifAmmin_PA' => '',
				'tipoDato_PA' => '',
				'riferTesto_PA' => '',
				'rifNumero_PA' => '',
				'rifData_PA' => '',
				'aliquotaIVAriep_PA' => '',
				'naturaRiep_PA' => '',
				'speseAccess_PA' => '',
				'arrotondamentoRiep_PA' => '',
				'rifNormativoRiep_PA' => ''
			),
			'_resumeOrders' => array(
				'kind' => '',
				'company' => '',
				'typedoc' => '',
				'customer' => '',
				'TOT' => '',
				'MONTH' => '',
				'YEAR' => '',
				'DOCs' => '',
				'related' => '',
				'id' => ''
			),
			'products' => array(
				'id' => '',
				'codebar' => '',
				'productCode' => '',
				'productName' => '',
				'tax' => '',
				'increment' => '',
				'CategoryID' => '',
				'UM' => '',
				'tare' => '',
				'QuantityPerUnit' => '',
				'UnitPrice' => '',
				'sellPrice' => '',
				'UnitsInStock' => '',
				'UnitsOnOrder' => '0',
				'ReorderLevel' => '0',
				'balance' => '',
				'Discontinued' => '0',
				'manufactured_date' => '',
				'expiry_date' => '',
				'note' => '',
				'update_date' => ''
			),
			'firstCashNote' => array(
				'id' => '',
				'kind' => '',
				'order' => '',
				'operationDate' => '',
				'company' => '',
				'customer' => '',
				'documentNumber' => '',
				'causal' => '',
				'importoPag_PA' => '',
				'outputs' => '',
				'balance' => '',
				'idBank' => '',
				'istitutoFinanziario_PA' => '',
				'note' => '',
				'paymentDeadLine' => '',
				'payed' => '0',
				'datiPag_PA' => '',
				'modPagam_PA' => 'MP02',
				'dataRifTerPag_PA' => '',
				'giorniTermPag_PA' => '',
				'dataScadPag_PA' => '',
				'codUffPost_PA' => '',
				'cognomeQuietanzante_PA' => '',
				'nomeQuietanzante_PA' => '',
				'codFiscQuietanzante_PA' => '',
				'titoloQuietanzante_PA' => ''
			),
			'vatRegister' => array(
				'id' => '',
				'idCompany' => '',
				'companyName' => '',
				'tax' => '4%',
				'month' => '',
				'year' => '2018',
				'amount' => '',
				'ufficio_Ced_PA' => '',
				'numeroREA_Ced_PA' => '',
				'capitaleSociale_Ced_PA' => '',
				'socioUnico_Ced_PA' => 'SM',
				'statoLiquidazione_Ced_PA' => 'LN'
			),
			'companies' => array(
				'id' => '',
				'kind' => '',
				'companyCode' => '',
				'companyName' => '',
				'notes' => '',
				'codiceDestinatarioUff_PA' => '',
				'idPaese_Ced_PA' => 'IT',
				'idCodice_Ced_PA' => '',
				'codiceFiscale_Ced_PA' => '',
				'denominazione_Ced_PA' => '',
				'titolo_Ced_PA' => '',
				'nome_Ced_PA' => '',
				'cognome_Ced_PA' => '',
				'codEORICed__PA' => '',
				'alboProfessionale_Ced_PA' => '',
				'provinciaAlbo_Ced_PA' => '',
				'numeroIscrizione_Ced_AlboPA' => '',
				'dataIscrAlbo_Ced_PA' => '',
				'regimeFiscalePA' => 'RF01',
				'idPaeseVett_PA' => 'IT',
				'idFiscaleVet_PA' => '',
				'codFiscVet_PA' => '',
				'denominazioneVet_PA' => '',
				'titoloVet_PA' => '',
				'nomeVet_PA' => '',
				'cognomeVett_PA' => '',
				'codEORIVet_PA' => '',
				'nrLicGuidaVet_PA' => '',
				'data_DatiVeic_PA' => '',
				'totalPercVeic_PA' => '',
				'mezzoTrVet_PA' => ''
			),
			'CLIENTI_CESSIONARI_PA' => array(
				'id' => '',
				'kind' => '',
				'idPaese_Ces_PA' => 'IT',
				'idCodice_Ces_PA' => '',
				'codiceFiscale_Ces_PA' => '',
				'Denominazione_Ces_PA' => '',
				'tit_Ces_PA' => '',
				'nome_Ces_PA' => '',
				'cogn_Ces_PA' => '',
				'Cod_Ces_EORI_PA' => '',
				'indirizzo_Ces_PA' => '',
				'numeroCiv_CesPA' => '',
				'CAP_Ces_PA' => '',
				'comune_Ces_PA' => '',
				'pr_Ces_PA' => '',
				'nazione_Ces_PA' => 'IT',
				'notes' => '',
				'birthDate' => '',
				'autorizzSanitaria_SAM' => '',
				'AutSanEmessa_SAM' => '',
				'NrPresSan_SAM' => '',
				'NrAutSan_SAM' => '',
				'dataAutSan_SAM' => ''
			),
			'creditDocument' => array(
				'id' => '',
				'incomingTypeDoc' => '',
				'customerID' => '',
				'nrDoc' => '',
				'dateIncomingNote' => '',
				'customerFirm' => '',
				'customerAddress' => '',
				'customerPostCode' => '',
				'customerTown' => ''
			),
			'electronicInvoice' => array(
				'id' => '',
				'idPaese_TR_PA' => 'IT',
				'idCodice_TR_PA' => '',
				'progressivoInvioPA' => '',
				'formatoTrasmissionePA' => 'SDI10',
				'codiceDestinatarioPA' => '',
				'telefonoPA' => '',
				'emailPA' => '',
				'idFiscaleIVA_Ced_PA' => '',
				'codiceFiscale_Ced_PA' => '',
				'denominazione_Ced_PA' => '',
				'nome_Ced_PA' => '',
				'cognome_Ced_PA' => '',
				'titolo_Ced_PA' => '',
				'codEORI_Ced_PA' => '',
				'alboProfessionale_Ced_PA' => '',
				'provinciaAlbo_Ced_PA' => '',
				'nrIscrizioneAlbo_Ced_PA' => '',
				'dataIscAlbo_Ced_PA' => '',
				'regimeFiscale_Ced_PA' => '',
				'indirizzo_Ced_PA' => '',
				'numeroCivico_Ced_PA' => '',
				'CAP_Ced_PA' => '',
				'comune_Ced_PA' => '',
				'provincia_Ced_PA' => '',
				'nazione_Ced_PA' => '',
				'altroIndirizzo_Ced_PA' => '',
				'altro_nr_Civico_Ced_PA' => '',
				'altroCAP_Ced_PA' => '',
				'altro_Com_Ced_PA' => '',
				'altro_PR_Ced_PA' => '',
				'altraNazione_Ced_PA' => '',
				'ufficio_Ced_PA' => '',
				'numeroREA_Ced__PA' => '',
				'capitaleSociale_Ced_PA' => '',
				'socioUnico_Ced_PA' => '',
				'statoLiquidazione_Ced_PA' => '',
				'telefonoCompany_Ced_PA' => '',
				'faxCompany_Ced_PA' => '',
				'eMailCompany_Ced_PA' => '',
				'rif_Amm_Ced_PA' => '',
				'idPaeseRap_Fisc_PA' => '',
				'idPaeseRap_CodPA' => '',
				'idCodFiscRap_Fisc_PA' => '',
				'idDenominazioneRap_FiscPA' => '',
				'idNomeRap_Fisc_PA' => '',
				'idCognRap_Fisc_PA' => '',
				'idTitoloRap_Fisc_PA' => '',
				'idEORI_Rap_Fisc_PA' => '',
				'idPaeseCess_PA' => '',
				'idCodiceCess_PA' => '',
				'idCodiceFiscCess_PA' => '',
				'denominazioneCess_PA' => '',
				'nomeCess_PA' => '',
				'cognomeCess_PA' => '',
				'titoloCess_PA' => '',
				'codEORI_Cess_PA' => '',
				'indirizzoCess_PA' => '',
				'nrCivicoCess_PA' => '',
				'CAP_Cess_PA' => '',
				'comuneCess_PA' => '',
				'provCess_PA' => '',
				'nazione_Cess_PA' => '',
				'idPaese3intSogEm_PA' => '',
				'idCod_3intSogEm_PA' => '',
				'codFisc_3intSogEm_PA' => '',
				'denom_3intSogEm_PA' => '',
				'nome_3_intSogEm_PA' => '',
				'cogn_3_intSogEm_PA' => '',
				'tit_3_IntSogEm_PA' => '',
				'codEORi_3_intSogEm_PA' => '',
				'SoggettoEmittente_PA' => '',
				'tipoDocumentoFEB_PA' => '',
				'divisaFEB_PA' => '',
				'dataFEB_PA' => '',
				'numeroFEB_PA' => '',
				'tipoRiten_PA' => '',
				'impRiten_PA' => '',
				'aliqRiten_PA' => '',
				'causPagRit_PA' => '',
				'numBolloRit_PA' => '',
				'impBolloRit_PA' => '',
				'tipoCassaPrev_PA' => '',
				'alCassaPr_PA' => '',
				'impContCassaPr_PA' => '',
				'imponCassaPr_PA' => '',
				'aliIVA_CassaPr_PA' => '',
				'ritCassaPr_PA' => '',
				'naturaCassaPr_PA' => '',
				'rifAmmCasPr_PA' => '',
				'tipoScMag_PA' => '',
				'percScMag_PA' => '',
				'impScMag_PA' => '',
				'ImpTotDoc_PA' => '',
				'arrotDoc_PA' => '',
				'causale_Doc_PA' => '',
				'art73_doc_PA' => '',
				'rifNumLineaDoc_PA' => '',
				'idDocNum_PA' => '',
				'dataOrder_PA' => '',
				'numItemDoc_PA' => '',
				'codCommConvDoc_PA' => '',
				'codCUP_PA' => '',
				'codCIG_PA' => '',
				'RIFERIMENTO_FASE_PA' => '',
				'NUMERO_DDT_PA' => '',
				'dataDDT_PA' => '',
				'rifNumLinea_PA' => '',
				'ID_PAESE_VET_PA' => '',
				'idCodVet_PA' => '',
				'codFiscVet_PA' => '',
				'DENOMINAZIONE_ANAGR_VETT_PA' => '',
				'nomeVett_PA' => '',
				'cognVett_PA' => '',
				'titVett_PA' => '',
				'codEORI_Vet_PA' => '',
				'nrLicenzaGuidaVet_PA' => '',
				'mezzoTraspVet_PA' => '',
				'causaleTrsVet_PA' => '',
				'nrColliTrasp_PA' => '',
				'descrTrasp_PA' => '',
				'unMisPeso_PA' => '',
				'pesoLordoMerce_PA' => '',
				'pesoNettoMer_PA' => '',
				'dataOraRitMer_PA' => '',
				'dataInTrMer_PA' => '',
				'tipoResaTr_PA' => '',
				'INDIRIZZO_RESA_PA' => '',
				'nrCivResa_PA' => '',
				'capResa_PA' => '',
				'comuneResa_PA' => '',
				'prResa_PA' => '',
				'nazioneResa_PA' => '',
				'dataOraCons_PA' => '',
				'normaRif_PA' => '',
				'NR_FATT_PRINC_PA' => '',
				'dataFattPrin_PA' => '',
				'NUMERO_LINEA_BENI_SERV_PA' => '',
				'tipoCessPrest_PA' => '',
				'CODICE_TIPO_PA' => '',
				'codiceVal_PA' => '',
				'descrizioneBene_PA' => '',
				'quantitaBene_PA' => '',
				'uniMisBene_PA' => '',
				'dataInPeriodo_PA' => '',
				'dataFinePeriodo_PA' => '',
				'prezzoUn_PA' => '',
				'TIPO_SCONTO_MAG_PA' => '',
				'perScMagBene_PA' => '',
				'impScMagBene_PA' => '',
				'prezzoTotaleBene_PA' => '',
				'aliqIVA_bene_PA' => '',
				'ritenuta_bene_PA' => '',
				'naturaRitBene' => '',
				'rifAmm_PA' => '',
				'TIPO_DATO_ALTRI_DATI_PA' => '',
				'rifTesto_altri_dati_PA' => '',
				'rifNum_Altri_dati_PA' => '',
				'rifData_altri_dati_PA' => '',
				'AL_IVA_RIEP_PA' => '',
				'naturaRiep_PA' => '',
				'speseAcc_Riep_PA' => '',
				'arrotRiep_PA' => '',
				'imponibileImpRiep_PA' => '',
				'impostaRiep_PA' => '',
				'esigIVA_riep_PA' => '',
				'rifNormRiep_PA' => '',
				'DATA_DATI_VEIC_PA' => '',
				'totalePercorso_PA' => '',
				'BENEFIC_DATI_PAG_PA' => '',
				'modPagam_PA' => '',
				'dataRifTermPag_PA' => '',
				'giorniTermPag_PA' => '',
				'dataScadPag_PA' => '',
				'imporPag_PA' => '',
				'codUffPostale_PA' => '',
				'cognomeQuietanzante_PA' => '',
				'nomeQuietanzante_PA' => '',
				'CF_Quietanzante_PA' => '',
				'titQuietanzante_PA' => '',
				'IBAN_PA' => '',
				'ABI_PA' => '',
				'CAB_PA' => '',
				'BIC_PA' => '',
				'scontoPagAntic_PA' => '',
				'dataLimPagAntic_PA' => '',
				'penRitarPagam_PA' => '',
				'dataDecPenale_PA' => '',
				'codPagamento_PA' => '',
				'ALLEGATI_NOME_ALL_PA' => '',
				'algoritmoComp_PA' => '',
				'formatoAttachement_PA' => '',
				'descrizioneAttach_PA' => '',
				'attachment_PA' => ''
			),
			'countries' => array(
				'id' => '',
				'country' => '',
				'code' => '',
				'ISOcode' => ''
			),
			'town' => array(
				'id' => '',
				'country' => '',
				'idIstat' => '',
				'town' => '',
				'district' => '',
				'region' => '',
				'prefix' => '',
				'shipCode' => '',
				'fiscCode' => '',
				'inhabitants' => '',
				'link' => ''
			),
			'GPSTrackingSystem' => array(
				'id' => '',
				'carTracked' => ''
			),
			'kinds' => array(
				'entity' => '',
				'code' => '',
				'name' => '',
				'value' => '',
				'descriptions' => ''
			),
			'Logs' => array(
				'id' => '',
				'ip' => '',
				'ts' => '',
				'details' => ''
			),
			'attributes' => array(
				'id' => '',
				'attribute' => '',
				'value' => '',
				'contact' => '',
				'companies' => '',
				'products' => ''
			),
			'addresses_PA' => array(
				'id' => '',
				'kind' => '',
				'indirizzo_Ced_PA' => '',
				'numeroCivico_Ced_PA' => '',
				'CAP_Ced_PA' => '',
				'comune_Ced_PA' => '',
				'provincia_Ced_PA' => '',
				'nazione_Ced_PA' => 'IT',
				'IBAN_PA' => '',
				'ABI_PA' => '',
				'CAB_PA' => '',
				'BIC_PA' => '',
				'altroIndirizzo_Ced_PA' => '',
				'altro_nr_Civico_Ced_PA' => '',
				'altroCAP_Ced_PA' => '',
				'altra_PR_Ced_PA' => '',
				'altraNazione_Ced_PA' => '',
				'indirizzo_Ces_PA' => '',
				'numeroCivico_Ces_PA' => '',
				'CAP_Ces_PA' => '',
				'comune_Ces_PA' => '',
				'prov_Ces_PA' => '',
				'nazione_Ces_PA' => 'IT',
				'contact' => '',
				'company' => '',
				'map' => '',
				'default' => '0',
				'ship' => '0',
				'scontoPagAnt_PA' => '',
				'dataPagAntic_PA' => '',
				'penalRitardPag_PA' => '',
				'dataDecorPag_PA' => '',
				'codPagam_PA' => ''
			),
			'phones' => array(
				'id' => '',
				'kind' => '',
				'phoneNumber' => '',
				'contact' => '',
				'company' => ''
			),
			'PEC' => array(
				'id' => '',
				'kind' => '',
				'PEC_PA' => '',
				'codiceUnivocoPA' => '',
				'contact' => '',
				'company' => ''
			),
			'contacts_companies' => array(
				'id' => '',
				'contact' => '',
				'company' => '',
				'default' => '0',
				'telefonoCompanyPA' => '',
				'faxCompanyPA' => '',
				'eMailCompanyPA' => '',
				'riferimentoAmministrazionePA' => ''
			),
			'allegati_PA' => array(
				'id' => '',
				'momeAlleg_PA' => '',
				'file' => '',
				'contact' => '',
				'company' => '',
				'algoritmoComp_PA' => '',
				'thumbUse' => '0',
				'formatoAlleg_PA' => 'PDF',
				'descrizAlleg_PA' => 'Allegato Ft. in PDF'
			),
			'sogg_Terzi_Rapp_PA' => array(
				'id' => '',
				'idPaese_RF_PA' => '',
				'idCodice_RF_PA' => '',
				'codiceFiscale_RF_PA' => '',
				'denominazione_RF_PA' => '',
				'nome_RF_PA' => '',
				'cognome_RF_PA' => '',
				'titolo_RF_PA' => '',
				'codEORI__RF_PA' => '',
				'idPaeseIVA_3_Int_PA' => '',
				'idCodice_3_Int_PA' => '',
				'codFiscale_3_Int_PA' => '',
				'denominazione_3_Int_PA' => '',
				'nome_3_Int_PA' => '',
				'cognome_3_Int_PA' => '',
				'titolo_3_Int_PA' => '',
				'codEORI_3_Int_PA' => '',
				'sogg_Emittente_PA' => '',
				'rif_num_linea_PA' => '',
				'idDoc_PA' => '',
				'data_orAcq_PA' => '',
				'numItem_PA' => '',
				'codCom_Con_PA' => '',
				'codCUP_PA' => '',
				'codGIG_PA' => '',
				'datiCont_PA' => '',
				'datiConv_PA' => '',
				'datiRic_PA' => '',
				'datiFatCol_PA' => '',
				'datiSal_PA' => '',
				'riferFase_PA' => '',
				'normaRifer_PA' => '',
				'nrFatturaPrinc_PA' => '',
				'dataFattPrinc_PA' => ''
			)
		);

		return isset($defaults[$table]) ? $defaults[$table] : array();
	}

	#########################################################

	function logInMember(){
		$redir = 'index.php';
		if($_POST['signIn'] != ''){
			if($_POST['username'] != '' && $_POST['password'] != ''){
				$username = makeSafe(strtolower($_POST['username']));
				$hash = sqlValue("select passMD5 from membership_users where lcase(memberID)='{$username}' and isApproved=1 and isBanned=0");
				$password = $_POST['password'];

				if(password_match($password, $hash)) {
					$_SESSION['memberID'] = $username;
					$_SESSION['memberGroupID'] = sqlValue("SELECT `groupID` FROM `membership_users` WHERE LCASE(`memberID`)='{$username}'");

					if($_POST['rememberMe'] == 1){
						RememberMe::login($username);
					}else{
						RememberMe::delete();
					}

					// harden user's password hash
					password_harden($username, $password, $hash);

					// hook: login_ok
					if(function_exists('login_ok')){
						$args=array();
						if(!$redir=login_ok(getMemberInfo(), $args)){
							$redir='index.php';
						}
					}

					redirect($redir);
					exit;
				}
			}

			// hook: login_failed
			if(function_exists('login_failed')){
				$args=array();
				login_failed(array(
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'IP' => $_SERVER['REMOTE_ADDR']
					), $args);
			}

			if(!headers_sent()) header('HTTP/1.0 403 Forbidden');
			redirect("index.php?loginFailed=1");
			exit;
		}

		/* check if a rememberMe cookie exists and sign in user if so */
		if(RememberMe::check()) {
			$username = makeSafe(strtolower(RememberMe::user()));
			$_SESSION['memberID'] = $username;
			$_SESSION['memberGroupID'] = sqlValue("SELECT `groupID` FROM `membership_users` WHERE LCASE(`memberID`)='{$username}'");
		}
	}

	#########################################################

	function htmlUserBar(){
		global $adminConfig, $Translation;
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');

		ob_start();
		$home_page = (basename($_SERVER['PHP_SELF'])=='index.php' ? true : false);

		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden-print" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- application title is obtained from the name besides the yellow database icon in AppGini, use underscores for spaces -->
				<a class="navbar-brand" href="<?php echo PREPEND_PATH; ?>index.php"><i class="glyphicon glyphicon-home"></i> PDMS</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php if(!$home_page){ ?>
						<?php echo NavMenus(); ?>
					<?php } ?>
				</ul>

				<?php if(getLoggedAdmin()){ ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn hidden-xs" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn visible-xs btn-lg" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
					</ul>
				<?php } ?>

				<?php if(!$_GET['signIn'] && !$_GET['loginFailed']){ ?>
					<?php if(getLoggedMemberID() == $adminConfig['anonymousMember']){ ?>
						<p class="navbar-text navbar-right">&nbsp;</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success navbar-btn navbar-right"><?php echo $Translation['sign in']; ?></a>
						<p class="navbar-text navbar-right">
							<?php echo $Translation['not signed in']; ?>
						</p>
					<?php }else{ ?>
						<ul class="nav navbar-nav navbar-right hidden-xs" style="min-width: 330px;">
							<a class="btn navbar-btn btn-default" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<ul class="nav navbar-nav visible-xs">
							<a class="btn navbar-btn btn-default btn-lg visible-xs" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text text-center">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<script>
							/* periodically check if user is still signed in */
							setInterval(function(){
								$j.ajax({
									url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
									success: function(username){
										if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
									}
								});
							}, 60000);
						</script>
					<?php } ?>
				<?php } ?>
			</div>
		</nav>
		<?php

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function showNotifications($msg = '', $class = '', $fadeout = true){
		global $Translation;

		$notify_template_no_fadeout = '<div id="%%ID%%" class="alert alert-dismissable %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">' .
					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
					'%%MSG%%</div>' .
					'<script> jQuery(function(){ /* */ jQuery("#%%ID%%").show("slow"); }); </script>'."\n";
		$notify_template = '<div id="%%ID%%" class="alert %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">%%MSG%%</div>' .
					'<script>' .
						'jQuery(function(){' .
							'jQuery("#%%ID%%").show("slow", function(){' .
								'setTimeout(function(){ /* */ jQuery("#%%ID%%").hide("slow"); }, 4000);' .
							'});' .
						'});' .
					'</script>'."\n";

		if(!$msg){ // if no msg, use url to detect message to display
			if($_REQUEST['record-added-ok'] != ''){
				$msg = $Translation['new record saved'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-added-error'] != ''){
				$msg = $Translation['Couldn\'t save the new record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-updated-ok'] != ''){
				$msg = $Translation['record updated'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-updated-error'] != ''){
				$msg = $Translation['Couldn\'t save changes to the record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-ok'] != ''){
				$msg = $Translation['The record has been deleted successfully'];
				$class = 'alert-success';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-error'] != ''){
				$msg = $Translation['Couldn\'t delete this record'];
				$class = 'alert-danger';
				$fadeout = false;
			}else{
				return '';
			}
		}
		$id = 'notification-' . rand();

		$out = ($fadeout ? $notify_template : $notify_template_no_fadeout);
		$out = str_replace('%%ID%%', $id, $out);
		$out = str_replace('%%MSG%%', $msg, $out);
		$out = str_replace('%%CLASS%%', $class, $out);

		return $out;
	}

	#########################################################

	function parseMySQLDate($date, $altDate){
		// is $date valid?
		if(preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($date))){
			return trim($date);
		}

		if($date != '--' && preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($altDate))){
			return trim($altDate);
		}

		if($date != '--' && $altDate && intval($altDate)==$altDate){
			return @date('Y-m-d', @time() + ($altDate >= 1 ? $altDate - 1 : $altDate) * 86400);
		}

		return '';
	}

	#########################################################

	function parseCode($code, $isInsert=true, $rawData=false){
		if($isInsert){
			$arrCodes=array(
				'<%%creatorusername%%>' => $_SESSION['memberID'],
				'<%%creatorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%creatorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%creatorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%creationdate%%>' => ($rawData ? @date('Y-m-d') : @date('Y-n-j')),
				'<%%creationtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%creationdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('Y-n-j h:i:s a')),
				'<%%creationtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}else{
			$arrCodes=array(
				'<%%editorusername%%>' => $_SESSION['memberID'],
				'<%%editorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%editorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%editorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%editingdate%%>' => ($rawData ? @date('Y-m-d') : @date('Y-n-j')),
				'<%%editingtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%editingdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('Y-n-j h:i:s a')),
				'<%%editingtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}

		$pc=str_ireplace(array_keys($arrCodes), array_values($arrCodes), $code);

		return $pc;
	}

	#########################################################

	function addFilter($index, $filterAnd, $filterField, $filterOperator, $filterValue){
		// validate input
		if($index < 1 || $index > 80 || !is_int($index)) return false;
		if($filterAnd != 'or')   $filterAnd = 'and';
		$filterField = intval($filterField);

		/* backward compatibility */
		if(in_array($filterOperator, $GLOBALS['filter_operators'])){
			$filterOperator = array_search($filterOperator, $GLOBALS['filter_operators']);
		}

		if(!in_array($filterOperator, array_keys($GLOBALS['filter_operators']))){
			$filterOperator = 'like';
		}

		if(!$filterField){
			$filterOperator = '';
			$filterValue = '';
		}

		$_REQUEST['FilterAnd'][$index] = $filterAnd;
		$_REQUEST['FilterField'][$index] = $filterField;
		$_REQUEST['FilterOperator'][$index] = $filterOperator;
		$_REQUEST['FilterValue'][$index] = $filterValue;

		return true;
	}

	#########################################################

	function clearFilters(){
		for($i=1; $i<=80; $i++){
			addFilter($i, '', 0, '', '');
		}
	}

	#########################################################

	if(!function_exists('str_ireplace')){
		function str_ireplace($search, $replace, $subject){
			$ret=$subject;
			if(is_array($search)){
				for($i=0; $i<count($search); $i++){
					$ret=str_ireplace($search[$i], $replace[$i], $ret);
				}
			}else{
				$ret=preg_replace('/'.preg_quote($search, '/').'/i', $replace, $ret);
			}

			return $ret;
		} 
	} 

	#########################################################

	/**
	* Loads a given view from the templates folder, passing the given data to it
	* @param $view the name of a php file (without extension) to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_view (optional) associative array containing the data to pass to the view
	* @return the output of the parsed view as a string
	*/
	function loadView($view, $the_data_to_pass_to_the_view=false){
		global $Translation;

		$view = dirname(__FILE__)."/templates/$view.php";
		if(!is_file($view)) return false;

		if(is_array($the_data_to_pass_to_the_view)){
			foreach($the_data_to_pass_to_the_view as $k => $v)
				$$k = $v;
		}
		unset($the_data_to_pass_to_the_view, $k, $v);

		ob_start();
		@include($view);
		$out=ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	/**
	* Loads a table template from the templates folder, passing the given data to it
	* @param $table_name the name of the table whose template is to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_table associative array containing the data to pass to the table template
	* @return the output of the parsed table template as a string
	*/
	function loadTable($table_name, $the_data_to_pass_to_the_table = array()){
		$dont_load_header = $the_data_to_pass_to_the_table['dont_load_header'];
		$dont_load_footer = $the_data_to_pass_to_the_table['dont_load_footer'];

		$header = $table = $footer = '';

		if(!$dont_load_header){
			// try to load tablename-header
			if(!($header = loadView("{$table_name}-header", $the_data_to_pass_to_the_table))){
				$header = loadView('table-common-header', $the_data_to_pass_to_the_table);
			}
		}

		$table = loadView($table_name, $the_data_to_pass_to_the_table);

		if(!$dont_load_footer){
			// try to load tablename-footer
			if(!($footer = loadView("{$table_name}-footer", $the_data_to_pass_to_the_table))){
				$footer = loadView('table-common-footer', $the_data_to_pass_to_the_table);
			}
		}

		return "{$header}{$table}{$footer}";
	}

	#########################################################

	function filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo){
		$filterersArray = explode(',', $filterers);
		$parentFilterersArray = explode(',', $parentFilterers);
		$parentFiltererList = '`' . implode('`, `', $parentFilterersArray) . '`';
		$res=sql("SELECT `$parentPKField`, $parentCaption, $parentFiltererList FROM `$parentTable` ORDER BY 2", $eo);
		$filterableData = array();
		while($row=db_fetch_row($res)){
			$filterableData[$row[0]] = $row[1];
			$filtererIndex = 0;
			foreach($filterersArray as $filterer){
				$filterableDataByFilterer[$filterer][$row[$filtererIndex + 2]][$row[0]] = $row[1];
				$filtererIndex++;
			}
			$row[0] = addslashes($row[0]);
			$row[1] = addslashes($row[1]);
			$jsonFilterableData .= "\"{$row[0]}\":\"{$row[1]}\",";
		}
		$jsonFilterableData .= '}';
		$jsonFilterableData = '{'.str_replace(',}', '}', $jsonFilterableData);     
		$filterJS = "\nvar {$filterable}_data = $jsonFilterableData;";

		foreach($filterersArray as $filterer){
			if(is_array($filterableDataByFilterer[$filterer])) foreach($filterableDataByFilterer[$filterer] as $filtererItem => $filterableItem){
				$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filtererItem).'":{';
				foreach($filterableItem as $filterableItemID => $filterableItemData){
					$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filterableItemID).'":"'.addslashes($filterableItemData).'",';
				}
				$jsonFilterableDataByFilterer[$filterer] .= '},';
			}
			$jsonFilterableDataByFilterer[$filterer] .= '}';
			$jsonFilterableDataByFilterer[$filterer] = '{'.str_replace(',}', '}', $jsonFilterableDataByFilterer[$filterer]);

			$filterJS.="\n\n// code for filtering {$filterable} by {$filterer}\n";
			$filterJS.="\nvar {$filterable}_data_by_{$filterer} = {$jsonFilterableDataByFilterer[$filterer]}; ";
			$filterJS.="\nvar selected_{$filterable} = \$j('#{$filterable}').val();";
			$filterJS.="\nvar {$filterable}_change_by_{$filterer} = function(){";
			$filterJS.="\n\t$('{$filterable}').options.length=0;";
			$filterJS.="\n\t$('{$filterable}').options[0] = new Option();";
			$filterJS.="\n\tif(\$j('#{$filterer}').val()){";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()]){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()][{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}else{";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data[{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t\tif(selected_{$filterable} && selected_{$filterable} == \$j('#{$filterable}').val()){";
			$filterJS.="\n\t\t\tfor({$filterer}_item in {$filterable}_data_by_{$filterer}){";
			$filterJS.="\n\t\t\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[{$filterer}_item]){";
			$filterJS.="\n\t\t\t\t\tif({$filterable}_item == selected_{$filterable}){";
			$filterJS.="\n\t\t\t\t\t\t$('{$filterer}').value = {$filterer}_item;";
			$filterJS.="\n\t\t\t\t\t\tbreak;";
			$filterJS.="\n\t\t\t\t\t}";
			$filterJS.="\n\t\t\t\t}";
			$filterJS.="\n\t\t\t\tif({$filterable}_item == selected_{$filterable}) break;";
			$filterJS.="\n\t\t\t}";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}";
			$filterJS.="\n\t$('{$filterable}').highlight();";
			$filterJS.="\n};";
			$filterJS.="\n$('{$filterer}').observe('change', function(){ /* */ window.setTimeout({$filterable}_change_by_{$filterer}, 25); });";
			$filterJS.="\n";
		}

		$filterableCombo = new Combo;
		$filterableCombo->ListType = 0;
		$filterableCombo->ListItem = array_slice(array_values($filterableData), 0, 10);
		$filterableCombo->ListData = array_slice(array_keys($filterableData), 0, 10);
		$filterableCombo->SelectName = $filterable;
		$filterableCombo->AllowNull = true;

		return $filterJS;
	}

	#########################################################
	function br2nl($text){
		return  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
	}

	#########################################################

	if(!function_exists('htmlspecialchars_decode')){
		function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT){
			return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
		}
	}

	#########################################################

	function entitiesToUTF8($input){
		return preg_replace_callback('/(&#[0-9]+;)/', '_toUTF8', $input);
	}

	function _toUTF8($m){
		if(function_exists('mb_convert_encoding')){
			return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
		}else{
			return $m[1];
		}
	}

	#########################################################

	function func_get_args_byref() {
		if(!function_exists('debug_backtrace')) return false;

		$trace = debug_backtrace();
		return $trace[1]['args'];
	}

	#########################################################

	function permissions_sql($table, $level = 'all'){
		if(!in_array($level, array('user', 'group'))){ $level = 'all'; }
		$perm = getTablePermissions($table);
		$from = '';
		$where = '';
		$pk = getPKFieldName($table);

		if($perm[2] == 1 || ($perm[2] > 1 && $level == 'user')){ // view owner only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."')";
		}elseif($perm[2] == 2 || ($perm[2] > 2 && $level == 'group')){ // view group only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and membership_userrecords.groupID='".getLoggedGroupID()."')";
		}elseif($perm[2] == 3){ // view all
			// no further action
		}elseif($perm[2] == 0){ // view none
			return false;
		}

		return array('where' => $where, 'from' => $from, 0 => $where, 1 => $from);
	}

	#########################################################

	function error_message($msg, $back_url = '', $full_page = true){
		$curr_dir = dirname(__FILE__);
		global $Translation;

		ob_start();

		if($full_page) include_once($curr_dir . '/header.php');

		echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading"><h3 class="panel-title">' . $Translation['error:'] . '</h3></div>';
			echo '<div class="panel-body"><p class="text-danger">' . $msg . '</p>';
			if($back_url !== false){ // explicitly passing false suppresses the back link completely
				echo '<div class="text-center">';
				if($back_url){
					echo '<a href="' . $back_url . '" class="btn btn-danger btn-lg vspacer-lg"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}else{
					echo '<a href="#" class="btn btn-danger btn-lg vspacer-lg" onclick="history.go(-1); return false;"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

		if($full_page) include_once($curr_dir . '/footer.php');

		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	function toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format){
		// extract date elements
		$de=explode($sep, $formattedDate);
		$mySQLDate=intval($de[strpos($ord, 'Y')]).'-'.intval($de[strpos($ord, 'm')]).'-'.intval($de[strpos($ord, 'd')]);
		return $mySQLDate;
	}

	#########################################################

	function reIndex(&$arr){
		$i=1;
		foreach($arr as $n=>$v){
			$arr2[$i]=$n;
			$i++;
		}
		return $arr2;
	}

	#########################################################

	function get_embed($provider, $url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		if(!$url) return '';

		$providers = array(
			'youtube' => array('oembed' => 'http://www.youtube.com/oembed?'),
			'googlemap' => array('oembed' => '', 'regex' => '/^http.*\.google\..*maps/i')
		);

		if(!isset($providers[$provider])){
			return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
		}

		if(isset($providers[$provider]['regex']) && !preg_match($providers[$provider]['regex'], $url)){
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		if($providers[$provider]['oembed']){
			$oembed = $providers[$provider]['oembed'] . 'url=' . urlencode($url) . "&maxwidth={$max_width}&maxheight={$max_height}&format=json";
			$data_json = request_cache($oembed);

			$data = json_decode($data_json, true);
			if($data === null){
				/* an error was returned rather than a json string */
				if($retrieve == 'html') return "<div class=\"text-danger\">{$data_json}\n<!-- {$oembed} --></div>";
				return '';
			}

			return (isset($data[$retrieve]) ? $data[$retrieve] : $data['html']);
		}

		/* special cases (where there is no oEmbed provider) */
		if($provider == 'googlemap') return get_embed_googlemap($url, $max_width, $max_height, $retrieve);

		return '<div class="text-danger">Invalid provider!</div>';
	}

	#########################################################

	function get_embed_googlemap($url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		$url_parts = parse_url($url);
		$coords_regex = '/-?\d+(\.\d+)?[,+]-?\d+(\.\d+)?(,\d{1,2}z)?/'; /* https://stackoverflow.com/questions/2660201 */

		if(preg_match($coords_regex, $url_parts['path'] . '?' . $url_parts['query'], $m)){
			list($lat, $long, $zoom) = explode(',', $m[0]);
			$zoom = intval($zoom);
			if(!$zoom) $zoom = 10; /* default zoom */
			if(!$max_height) $max_height = 360;
			if(!$max_width) $max_width = 480;

			$api_key = '';
			$embed_url = "https://www.google.com/maps/embed/v1/view?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap";
			$thumbnail_url = "https://maps.googleapis.com/maps/api/staticmap?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap&size={$max_width}x{$max_height}";

			if($retrieve == 'html'){
				return "<iframe width=\"{$max_width}\" height=\"{$max_height}\" frameborder=\"0\" style=\"border:0\" src=\"{$embed_url}\"></iframe>";
			}else{
				return $thumbnail_url;
			}
		}else{
			return '<div class="text-danger">' . $Translation['cant retrieve coordinates from url'] . '</div>';
		}
	}

	#########################################################

	function request_cache($request, $force_fetch = false){
		$max_cache_lifetime = 7 * 86400; /* max cache lifetime in seconds before refreshing from source */

		/* membership_cache table exists? if not, create it */
		static $cache_table_exists = false;
		if(!$cache_table_exists && !$force_fetch){
			$te = sqlValue("show tables like 'membership_cache'");
			if(!$te){
				if(!sql("CREATE TABLE `membership_cache` (`request` VARCHAR(100) NOT NULL, `request_ts` INT, `response` TEXT NOT NULL, PRIMARY KEY (`request`))", $eo)){
					/* table can't be created, so force fetching request */
					return request_cache($request, true);
				}
			}
			$cache_table_exists = true;
		}

		/* retrieve response from cache if exists */
		if(!$force_fetch){
			$res = sql("select response, request_ts from membership_cache where request='" . md5($request) . "'", $eo);
			if(!$row = db_fetch_array($res)) return request_cache($request, true);

			$response = $row[0];
			$response_ts = $row[1];
			if($response_ts < time() - $max_cache_lifetime) return request_cache($request, true);
		}

		/* if no response in cache, issue a request */
		if(!$response || $force_fetch){
			$response = @file_get_contents($request);
			if($response === false){
				$error = error_get_last();
				$error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
				return $error_message;
			}elseif($cache_table_exists){
				/* store response in cache */
				$ts = time();
				sql("replace into membership_cache set request='" . md5($request) . "', request_ts='{$ts}', response='" . makeSafe($response, false) . "'", $eo);
			}
		}

		return $response;
	}

	#########################################################

	function check_record_permission($table, $id, $perm = 'view'){
		if($perm != 'edit' && $perm != 'delete') $perm = 'view';

		$perms = getTablePermissions($table);
		if(!$perms[$perm]) return false;

		$safe_id = makeSafe($id);
		$safe_table = makeSafe($table);

		if($perms[$perm] == 1){ // own records only
			$username = getLoggedMemberID();
			$owner = sqlValue("select memberID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner == $username) return true;
		}elseif($perms[$perm] == 2){ // group records
			$group_id = getLoggedGroupID();
			$owner_group_id = sqlValue("select groupID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner_group_id == $group_id) return true;
		}elseif($perms[$perm] == 3){ // all records
			return true;
		}

		return false;
	}

	#########################################################

	function NavMenus($options = array()){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		global $Translation;
		$prepend_path = PREPEND_PATH;

		/* default options */
		if(empty($options)){
			$options = array(
				'tabs' => 7
			);
		}

		$table_group_name = array_keys(get_table_groups()); /* 0 => group1, 1 => group2 .. */
		/* if only one group named 'None', set to translation of 'select a table' */
		if((count($table_group_name) == 1 && $table_group_name[0] == 'None') || count($table_group_name) < 1) $table_group_name[0] = $Translation['select a table'];
		$table_group_index = array_flip($table_group_name); /* group1 => 0, group2 => 1 .. */
		$menu = array_fill(0, count($table_group_name), '');

		$t = time();
		$arrTables = getTableList();
		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				/* ---- list of tables where hide link in nav menu is set ---- */
				$tChkHL = array_search($tn, array('_resumeOrders','creditDocument','sogg_Terzi_Rapp_PA'));

				/* ---- list of tables where filter first is set ---- */
				$tChkFF = array_search($tn, array());
				if($tChkFF !== false && $tChkFF !== null){
					$searchFirst = '&Filter_x=1';
				}else{
					$searchFirst = '';
				}

				/* when no groups defined, $table_group_index['None'] is NULL, so $menu_index is still set to 0 */
				$menu_index = intval($table_group_index[$tc[3]]);
				if(!$tChkHL && $tChkHL !== 0) $menu[$menu_index] .= "<li><a href=\"{$prepend_path}{$tn}_view.php?t={$t}{$searchFirst}\"><img src=\"{$prepend_path}" . ($tc[2] ? $tc[2] : 'blank.gif') . "\" height=\"32\"> {$tc[0]}</a></li>";
			}
		}

		// custom nav links, as defined in "hooks/links-navmenu.php" 
		global $navLinks;
		if(is_array($navLinks)){
			$memberInfo = getMemberInfo();
			$links_added = array();
			foreach($navLinks as $link){
				if(!isset($link['url']) || !isset($link['title'])) continue;
				if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
					$menu_index = intval($link['table_group']);
					if(!$links_added[$menu_index]) $menu[$menu_index] .= '<li class="divider"></li>';

					/* add prepend_path to custom links if they aren't absolute links */
					if(!preg_match('/^(http|\/\/)/i', $link['url'])) $link['url'] = $prepend_path . $link['url'];
					if(!preg_match('/^(http|\/\/)/i', $link['icon']) && $link['icon']) $link['icon'] = $prepend_path . $link['icon'];

					$menu[$menu_index] .= "<li><a href=\"{$link['url']}\"><img src=\"" . ($link['icon'] ? $link['icon'] : "{$prepend_path}blank.gif") . "\" height=\"32\"> {$link['title']}</a></li>";
					$links_added[$menu_index]++;
				}
			}
		}

		$menu_wrapper = '';
		for($i = 0; $i < count($menu); $i++){
			$menu_wrapper .= <<<EOT
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$table_group_name[$i]} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">{$menu[$i]}</ul>
				</li>
EOT;
		}

		return $menu_wrapper;
	}

	#########################################################

	function StyleSheet(){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		$prepend_path = PREPEND_PATH;

		$css_links = <<<EOT

			<link rel="stylesheet" href="{$prepend_path}resources/initializr/css/bootstrap.css">
			<link rel="stylesheet" href="{$prepend_path}resources/lightbox/css/lightbox.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/select2/select2.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/timepicker/bootstrap-timepicker.min.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}dynamic.css.php">
EOT;

		return $css_links;
	}

	#########################################################

	function getUploadDir($dir){
		global $Translation;

		if($dir==""){
			$dir=$Translation['ImageFolder'];
		}

		if(substr($dir, -1)!="/"){
			$dir.="/";
		}

		return $dir;
	}

	#########################################################

	function PrepareUploadedFile($FieldName, $MaxSize, $FileTypes = 'jpg|jpeg|gif|png', $NoRename = false, $dir = ''){
		global $Translation;
		$f = $_FILES[$FieldName];
		if($f['error'] == 4 || !$f['name']) return '';

		$dir = getUploadDir($dir);

		/* get php.ini upload_max_filesize in bytes */
		$php_upload_size_limit = trim(ini_get('upload_max_filesize'));
		$last = strtolower($php_upload_size_limit[strlen($php_upload_size_limit) - 1]);
		switch($last){
			case 'g':
				$php_upload_size_limit *= 1024;
			case 'm':
				$php_upload_size_limit *= 1024;
			case 'k':
				$php_upload_size_limit *= 1024;
		}

		$MaxSize = min($MaxSize, $php_upload_size_limit);

		if($f['size'] > $MaxSize || $f['error']){
			echo error_message(str_replace('<MaxSize>', intval($MaxSize / 1024), $Translation['file too large']));
			exit;
		}
		if(!preg_match('/\.(' . $FileTypes . ')$/i', $f['name'], $ft)){
			echo error_message(str_replace('<FileTypes>', str_replace('|', ', ', $FileTypes), $Translation['invalid file type']));
			exit;
		}

		$name = str_replace(' ', '_', $f['name']);
		if(!$NoRename) $name = substr(md5(microtime() . rand(0, 100000)), -17) . $ft[0];

		if(!file_exists($dir)) @mkdir($dir, 0777);

		if(!@move_uploaded_file($f['tmp_name'], $dir . $name)){
			echo error_message("Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.");
			exit;
		}

		@chmod($dir . $name, 0666);
		return $name;
	}

	#########################################################

	function get_home_links($homeLinks, $default_classes, $tgroup = ''){
		if(!is_array($homeLinks) || !count($homeLinks)) return '';

		$memberInfo = getMemberInfo();

		ob_start();
		foreach($homeLinks as $link){
			if(!isset($link['url']) || !isset($link['title'])) continue;
			if($tgroup != $link['table_group'] && $tgroup != '*') continue;

			/* fall-back classes if none defined */
			if(!$link['grid_column_classes']) $link['grid_column_classes'] = $default_classes['grid_column'];
			if(!$link['panel_classes']) $link['panel_classes'] = $default_classes['panel'];
			if(!$link['link_classes']) $link['link_classes'] = $default_classes['link'];

			if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
				?>
				<div class="col-xs-12 <?php echo $link['grid_column_classes']; ?>">
					<div class="panel <?php echo $link['panel_classes']; ?>">
						<div class="panel-body">
							<a class="btn btn-block btn-lg <?php echo $link['link_classes']; ?>" title="<?php echo preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", html_attr(strip_tags($link['description']))); ?>" href="<?php echo $link['url']; ?>"><?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?><strong><?php echo $link['title']; ?></strong></a>
							<div class="panel-body-description"><?php echo $link['description']; ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function quick_search_html($search_term, $label, $separate_dv = true){
		global $Translation;

		$safe_search = html_attr($search_term);
		$safe_label = html_attr($label);
		$safe_clear_label = html_attr($Translation['Reset Filters']);

		if($separate_dv){
			$reset_selection = "document.myform.SelectedID.value = '';";
		}else{
			$reset_selection = "document.myform.writeAttribute('novalidate', 'novalidate');";
		}
		$reset_selection .= ' document.myform.NoDV.value=1; return true;';

		$html = <<<EOT
		<div class="input-group" id="quick-search">
			<input type="text" id="SearchString" name="SearchString" value="{$safe_search}" class="form-control" placeholder="{$safe_label}">
			<span class="input-group-btn">
				<button name="Search_x" value="1" id="Search" type="submit" onClick="{$reset_selection}" class="btn btn-default" title="{$safe_label}"><i class="glyphicon glyphicon-search"></i></button>
				<button name="ClearQuickSearch" value="1" id="ClearQuickSearch" type="submit" onClick="\$j('#SearchString').val(''); {$reset_selection}" class="btn btn-default" title="{$safe_clear_label}"><i class="glyphicon glyphicon-remove-circle"></i></button>
			</span>
		</div>
EOT;
		return $html;
	}

	#########################################################

