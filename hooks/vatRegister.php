<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function vatRegister_init(&$options, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_header($contentType, $memberInfo, &$args){
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

	function vatRegister_footer($contentType, $memberInfo, &$args){
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

	function vatRegister_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_after_update($data, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}

	function vatRegister_after_delete($selectedID, $memberInfo, &$args){

	}

	function vatRegister_dv($selectedID, $memberInfo, &$html, &$args){

	}

	function vatRegister_csv($query, $memberInfo, &$args){

		return $query;
	}
	function vatRegister_batch_actions(&$args){

		return array();
	}
