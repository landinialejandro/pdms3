<?php


	function orders_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-09-26 02:07:33 */
		$options->FilterPage = 'hooks/orders_filter.php';
		/* End of Search Page Maker for AppGini code */

//                 $options->TemplateDV = 'hooks/orders_templateDV_lte.html';
                 
                if (isset($_REQUEST['SelectedID']) && $_REQUEST['SelectedID']){
                    $selectedID = intval(makeSafe($_REQUEST['SelectedID']));
                    $doc = sqlValue("select document from orders where id = {$selectedID}");
                    if ($doc){
                        //read only form
                        $options->TemplateDV = 'templates/orders_templateDVR.html';
                    }
                }
                if (isset($_REQUEST['ok'])){
                            $ok = makeSafe($_REQUEST['ok']);
                            addFilter(1, 'and', 2, 'Equal to', $ok);
                }
		return TRUE;
	}

	function orders_header($contentType, $memberInfo, &$args){
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


	function orders_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
                                if (isset($_REQUEST['ok'])){
                                    echo title_tv(makeSafe($_REQUEST['ok']),"?ok=".makeSafe($_REQUEST['ok']));
                                }
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


	function orders_before_insert(&$data, $memberInfo, &$args){
                //check if the oreder number is the last bofore insert
                if(!function_exists('getNextValue')){
                    include'orders_AJX.php';
                }
                if($data['kind'] === 'OUT'){
                    $numOrder = getNextValue($data['typeDoc'],$data['company']);
                    if (intval($numOrder) !== intval($data['multiOrder'])){
                        $data['multiOrder']=$numOrder;
                    }
                }
		return TRUE;
	}


	function orders_after_insert($data, $memberInfo, &$args){
            // add prima nota
            setFirstCash($data);
            
            return TRUE;
	}


	function orders_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function orders_after_update($data, $memberInfo, &$args){
            setFirstCash($data);
		return TRUE;
	}


	function orders_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function orders_after_delete($selectedID, $memberInfo, &$args){

	}


	function orders_dv($selectedID, $memberInfo, &$html, &$args){
            if (isset($_REQUEST['addNew_x'])){
                if (isset($_REQUEST['ok']) || (isset($_REQUEST['FilterValue']) && isset($_REQUEST['FilterField']))){
                    if (isset($_REQUEST['ok'])){
                        $orderKind = getKindsData(makeSafe($_REQUEST['ok']));
                        //    $ok_id = makeSafe($_REQUEST['ok']);
                        //    $ok_text = sqlValue("select name from kinds where code = '{$ok_id}'");
                    }
                    if (isset($_REQUEST['FilterValue'])){
                        $orderKind = getKindsData("", makeSafe($_REQUEST['FilterValue'][1]));
                        // $ok_text = makeSafe($_REQUEST['FilterValue'][1]);
                        // $ok_id = sqlValue("select code from kinds where name = '{$ok_text}'");
                    }
                }

                if (isset($_REQUEST['mc']) && isset($_REQUEST['dk'])){
                    $mc_id = intval(makeSafe($_REQUEST['mc']));
                    $mc = getDataTable_Values('companies',"AND companies.id = {$mc_id}");
                    // $mc_name = sqlValue("select companyName from companies where id = {$mc_id}");
                    // $mc_code = sqlValue("select companyCode from companies where id = {$mc_id}");
                    $mc_text = $mc['companyCode'] . " - " . $mc['companyName'];
                    // $dk_id = makeSafe($_REQUEST['dk']);
                    $documentKind = getKindsData(makeSafe($_REQUEST['dk']));
                    // $dk_text = $dk_id . " - " . $dk['name'];
                }
                ob_start();
                ?>
                    <!-- insert HTML code-->
                    <?php echo title_tv($orderKind['name'],"?ok={$orderKind['name']}"); ?>
                    <script>
                     function autoSet(){
                         setTimeout(function(){
                             $j('#s2id_company-container').select2("data", {id: "<?php echo $mc_id; ?>", text: "<?php echo $mc_text; ?>"});
                             $j('#company').val("<?php echo $mc_id; ?>");
                             $j('#s2id_typeDoc-container').select2("data", {id: "<?php echo $documentKind['code']; ?>", text: "<?php echo $documentKind['name']; ?>"});
                             $j('#typeDoc').val("<?php echo  $documentKind['code']; ?>");
                             $j('#s2id_kind-container').select2("data", {id: "<?php echo $orderKind['code']; ?>", text: "<?php echo $orderKind['name']; ?>"});
                             $j('#kind').val("<?php echo $orderKind['code']; ?>");
                             orderNumber();
                         },1000);
                     }  
                    </script>
                <?php
                $html_code = ob_get_contents();
                ob_end_clean();
                
                $html .= $html_code;
                
            }else{
            
                $buttons = [];
                $buttons['print']['invoice']['name'] = 'Print Invoice';
                $buttons['print']['invoice']['insert'] = false;
                $buttons['print']['invoice']['update'] = true;
                $buttons['print']['invoice']['style'] = 'default';
                $buttons['print']['invoice']['icon'] = 'fa fa-files-o';
                $buttons['print']['invoice']['onclick'] = '';
                $buttons['print']['invoice']['confirm'] = '';

                $html .= mkbuttons('orders', $selectedID, $buttons);
            }
	}

	function orders_csv($query, $memberInfo, &$args){

		return $query;
	}

	function orders_batch_actions(&$args){

		return array();
	}

        function setFirstCash($data){
            $currDir = dirname(__FILE__);
            if(!function_exists('firstCashNote_update')){
                include ("$currDir/../firstCashNote_dml.php");
            }
            $where_id = "AND  firstCashNote.order = '{$data['id']}' order by id asc limit 1;";
            $fc = getDataTable_Values('firstCashNote', $where_id );
            // $res = sql("select * from firstCashNote where firstCashNote.`order` = '{$data['id']}' order by id asc limit 1;",$eo);
            // $fc = db_fetch_assoc($res);
            $fc['order'] = $data['id'];
            $dk_name = getKindsData($data['kind']);
            $fc['causal'] = ( $dk_name ? $dk_name['name'] : $data['kind']);
            
            if($data['kind'] === 'IN'){
                $fc['outputs']=$data['orderTotal'];
                $fc['kind']="CN_OUT";
            }else{
                $fc['revenue']=$data['orderTotal'];
                $fc['kind']="CN_IN";
            }
            
            if ($res->lengths){
                //update fc
                firstCashNote_update($fc['id'],$fc);
            }else{
                //new fcNote
                firstCashNote_insert($fc);
            }
            return;
        }