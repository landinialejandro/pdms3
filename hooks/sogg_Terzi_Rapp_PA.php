<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function sogg_Terzi_Rapp_PA_init(&$options, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_header($contentType, $memberInfo, &$args){
		$header='';

		switch($contentType){
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	function sogg_Terzi_Rapp_PA_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	function sogg_Terzi_Rapp_PA_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_after_update($data, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}

	function sogg_Terzi_Rapp_PA_after_delete($selectedID, $memberInfo, &$args){

	}

	function sogg_Terzi_Rapp_PA_dv($selectedID, $memberInfo, &$html, &$args){

	}

	function sogg_Terzi_Rapp_PA_csv($query, $memberInfo, &$args){

		return $query;
	}
	function sogg_Terzi_Rapp_PA_batch_actions(&$args){

		return array();
	}