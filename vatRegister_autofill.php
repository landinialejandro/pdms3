<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir = dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('vatRegister');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk = $_GET['mfk'];
	$id = makeSafe($_GET['id']);
	$rnd1 = intval($_GET['rnd1']); if(!$rnd1) $rnd1 = '';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'idCompany':
			if(!$id){
				?>
				$j('#companyName<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `companies`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', if(CHAR_LENGTH(`companies`.`companyCode`)>100, concat(left(`companies`.`companyCode`,100),' ...'), `companies`.`companyCode`) as 'companyCode', if(CHAR_LENGTH(`companies`.`companyName`)>100, concat(left(`companies`.`companyName`,100),' ...'), `companies`.`companyName`) as 'companyName', `companies`.`notes` as 'notes', `companies`.`codiceDestinatarioUff_PA` as 'codiceDestinatarioUff_PA', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'idPaese_Ced_PA', `companies`.`idCodice_Ced_PA` as 'idCodice_Ced_PA', `companies`.`codiceFiscale_Ced_PA` as 'codiceFiscale_Ced_PA', `companies`.`denominazione_Ced_PA` as 'denominazione_Ced_PA', `companies`.`titolo_Ced_PA` as 'titolo_Ced_PA', `companies`.`nome_Ced_PA` as 'nome_Ced_PA', `companies`.`cognome_Ced_PA` as 'cognome_Ced_PA', `companies`.`codEORICed__PA` as 'codEORICed__PA', `companies`.`alboProfessionale_Ced_PA` as 'alboProfessionale_Ced_PA', `companies`.`provinciaAlbo_Ced_PA` as 'provinciaAlbo_Ced_PA', `companies`.`numeroIscrizione_Ced_AlboPA` as 'numeroIscrizione_Ced_AlboPA', if(`companies`.`dataIscrAlbo_Ced_PA`,date_format(`companies`.`dataIscrAlbo_Ced_PA`,'%Y-%m-%d'),'') as 'dataIscrAlbo_Ced_PA', `companies`.`regimeFiscalePA` as 'regimeFiscalePA', `companies`.`idPaeseVett_PA` as 'idPaeseVett_PA', `companies`.`idFiscaleVet_PA` as 'idFiscaleVet_PA', `companies`.`codFiscVet_PA` as 'codFiscVet_PA', `companies`.`denominazioneVet_PA` as 'denominazioneVet_PA', `companies`.`titoloVet_PA` as 'titoloVet_PA', `companies`.`nomeVet_PA` as 'nomeVet_PA', `companies`.`cognomeVett_PA` as 'cognomeVett_PA', `companies`.`codEORIVet_PA` as 'codEORIVet_PA', `companies`.`nrLicGuidaVet_PA` as 'nrLicGuidaVet_PA', if(`companies`.`data_DatiVeic_PA`,date_format(`companies`.`data_DatiVeic_PA`,'%Y-%m-%d'),'') as 'data_DatiVeic_PA', `companies`.`totalPercVeic_PA` as 'totalPercVeic_PA', `companies`.`mezzoTrVet_PA` as 'mezzoTrVet_PA' FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`companies`.`idPaese_Ced_PA`  WHERE `companies`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#companyName<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['companyName']))); ?>&nbsp;');
			<?php
			break;


	}

?>