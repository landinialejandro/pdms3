<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir = dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('ordersDetails');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk = $_GET['mfk'];
	$id = makeSafe($_GET['id']);
	$rnd1 = intval($_GET['rnd1']); if(!$rnd1) $rnd1 = '';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'order':
			if(!$id){
				?>
				$j('#transaction_type<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `orders`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `orders`.`progressivNumber` as 'progressivNumber', `orders`.`consigneeID` as 'consigneeID', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typeDoc', `orders`.`multiOrder_nr_PA` as 'multiOrder_nr_PA', `orders`.`formatoTrasmissione_PA` as 'formatoTrasmissione_PA', `orders`.`tipo_Documento_PA` as 'tipo_Documento_PA', `orders`.`divisa_PA` as 'divisa_PA', CONCAT('&euro;', FORMAT(`orders`.`importo_Sc_Mg_PA`, 2)) as 'importo_Sc_Mg_PA', CONCAT('&euro;', FORMAT(`orders`.`importoTot_Doc_PA`, 2)) as 'importoTot_Doc_PA', CONCAT('&euro;', FORMAT(`orders`.`arrotondamento_PA`, 2)) as 'arrotondamento_PA', `orders`.`causale_PA` as 'causale_PA', `orders`.`art73_PA` as 'art73_PA', if(`orders`.`data_Ord_PA`,date_format(`orders`.`data_Ord_PA`,'%Y-%m-%d'),'') as 'data_Ord_PA', if(`orders`.`dataOraRit_PA`,date_format(`orders`.`dataOraRit_PA`,'%Y-%m-%d'),'') as 'dataOraRit_PA', if(`orders`.`dataInizTrasp_PA`,date_format(`orders`.`dataInizTrasp_PA`,'%Y-%m-%d'),'') as 'dataInizTrasp_PA', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') as 'supplier', IF(    CHAR_LENGTH(`CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), CONCAT_WS('',   `CLIENTI_CESSIONARI_PA1`.`nome_Ces_PA`), '') as 'employee', IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') as 'shipVia', `orders`.`Freight` as 'Freight', `orders`.`pallets` as 'pallets', if(CHAR_LENGTH(`orders`.`mezzoTraspVet_PA`)>80, concat(left(`orders`.`mezzoTraspVet_PA`,80),' ...'), `orders`.`mezzoTraspVet_PA`) as 'mezzoTraspVet_PA', `orders`.`causaleTraspVet_PA` as 'causaleTraspVet_PA', `orders`.`nrColliVett_PA` as 'nrColliVett_PA', `orders`.`descTraspVet_PA` as 'descTraspVet_PA', concat('<i class=\"glyphicon glyphicon-', if(`orders`.`cashCredit`, 'check', 'unchecked'), '\"></i>') as 'cashCredit', `orders`.`trust` as 'trust', `orders`.`overdraft` as 'overdraft', `orders`.`commisionFee` as 'commisionFee', `orders`.`commisionRate` as 'commisionRate', `orders`.`related` as 'related', `orders`.`document` as 'document', `orders`.`tipo_rit_PA` as 'tipo_rit_PA', `orders`.`imp_rit_PA` as 'imp_rit_PA', FORMAT(`orders`.`aliq_rit_PA`, 2) as 'aliq_rit_PA', `orders`.`causale_pag_rit_PA` as 'causale_pag_rit_PA', `orders`.`nr_bollo_rit_PA` as 'nr_bollo_rit_PA', FORMAT(`orders`.`importo_Bollo_rit_PA`, 2) as 'importo_Bollo_rit_PA', `orders`.`tipo_cassa_Prev_PA` as 'tipo_cassa_Prev_PA', FORMAT(`orders`.`al_cassa_Prev_PA`, 2) as 'al_cassa_Prev_PA', FORMAT(`orders`.`importo_cont_cassa_prev_PA`, 2) as 'importo_cont_cassa_prev_PA', FORMAT(`orders`.`imponibile_cassa_Prev_PA`, 2) as 'imponibile_cassa_Prev_PA', FORMAT(`orders`.`aliq_IVA_cassa_prev_PA`, 2) as 'aliq_IVA_cassa_prev_PA', `orders`.`ritenuta_cassa_prev_PA` as 'ritenuta_cassa_prev_PA', `orders`.`natura_cassa_prev_PA` as 'natura_cassa_prev_PA', `orders`.`rif_amm_prev_PA` as 'rif_amm_prev_PA', `orders`.`tipoResa_PA` as 'tipoResa_PA', `orders`.`indirizzoResa_PA` as 'indirizzoResa_PA', `orders`.`nrCivicoResa_PA` as 'nrCivicoResa_PA', IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') as 'CAP_Resa_PA', IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') as 'comuneResa_PA', IF(    CHAR_LENGTH(`town1`.`district`), CONCAT_WS('',   `town1`.`district`), '') as 'provResa_PA', IF(    CHAR_LENGTH(`countries1`.`code`), CONCAT_WS('',   `countries1`.`code`), '') as 'nazioneResa_PA', if(`orders`.`dataOraCons_PA`,date_format(`orders`.`dataOraCons_PA`,'%Y-%m-%d'),'') as 'dataOraCons_PA' FROM `orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `CLIENTI_CESSIONARI_PA` as CLIENTI_CESSIONARI_PA1 ON `CLIENTI_CESSIONARI_PA1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` LEFT JOIN `town` as town1 ON `town1`.`id`=`orders`.`CAP_Resa_PA` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`orders`.`nazioneResa_PA`  WHERE `orders`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#transaction_type<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['kind']))); ?>&nbsp;');
			<?php
			break;

		case 'productCode':
			if(!$id){
				?>
				$j('#codebar<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#batch<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#UMRifPeso_PA<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#descrizioneArt_PA<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `products`.`id` as 'id', `products`.`codebar` as 'codebar', if(CHAR_LENGTH(`products`.`productCode`)>100, concat(left(`products`.`productCode`,100),' ...'), `products`.`productCode`) as 'productCode', if(CHAR_LENGTH(`products`.`productName`)>100, concat(left(`products`.`productName`,100),' ...'), `products`.`productName`) as 'productName', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'tax', `products`.`increment` as 'increment', IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') as 'CategoryID', `products`.`UM` as 'UM', `products`.`tare` as 'tare', `products`.`QuantityPerUnit` as 'QuantityPerUnit', CONCAT('&euro;', FORMAT(`products`.`UnitPrice`, 2)) as 'UnitPrice', CONCAT('&euro;', FORMAT(`products`.`sellPrice`, 2)) as 'sellPrice', `products`.`UnitsInStock` as 'UnitsInStock', `products`.`UnitsOnOrder` as 'UnitsOnOrder', `products`.`ReorderLevel` as 'ReorderLevel', `products`.`balance` as 'balance', concat('<i class=\"glyphicon glyphicon-', if(`products`.`Discontinued`, 'check', 'unchecked'), '\"></i>') as 'Discontinued', if(`products`.`manufactured_date`,date_format(`products`.`manufactured_date`,'%Y-%m-%d'),'') as 'manufactured_date', if(`products`.`expiry_date`,date_format(`products`.`expiry_date`,'%Y-%m-%d'),'') as 'expiry_date', `products`.`note` as 'note', if(`products`.`update_date`,date_format(`products`.`update_date`,'%Y-%m-%d %h:%i %p'),'') as 'update_date' FROM `products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID`  WHERE `products`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#codebar<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['codebar']))); ?>&nbsp;');
			$j('#batch<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['productCode'].'-'.$row['id']))); ?>&nbsp;');
			$j('#UMRifPeso_PA<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['UM']))); ?>&nbsp;');
			$j('#descrizioneArt_PA<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['productName']))); ?>&nbsp;');
			<?php
			break;


	}

?>