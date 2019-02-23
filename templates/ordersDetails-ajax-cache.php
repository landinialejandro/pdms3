<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'ordersDetails';

		/* data for selected record, or defaults if none is selected */
		var data = {
			order: <?php echo json_encode(array('id' => $rdata['order'], 'value' => $rdata['order'], 'text' => $jdata['order'])); ?>,
			codebar: <?php echo json_encode($jdata['codebar']); ?>,
			productCode: <?php echo json_encode(array('id' => $rdata['productCode'], 'value' => $rdata['productCode'], 'text' => $jdata['productCode'])); ?>,
			batch: <?php echo json_encode($jdata['batch']); ?>,
			UMRifPeso_PA: <?php echo json_encode($jdata['UMRifPeso_PA']); ?>,
			section: <?php echo json_encode(array('id' => $rdata['section'], 'value' => $rdata['section'], 'text' => $jdata['section'])); ?>,
			transaction_type: <?php echo json_encode($jdata['transaction_type']); ?>,
			descrizioneArt_PA: <?php echo json_encode($jdata['descrizioneArt_PA']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for order */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'order' && d.id == data.order.id)
				return { results: [ data.order ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for order autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'order' && d.id == data.order.id){
				$j('#transaction_type' + d[rnd]).html(data.transaction_type);
				return true;
			}

			return false;
		});

		/* saved value for productCode */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'productCode' && d.id == data.productCode.id)
				return { results: [ data.productCode ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for productCode autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'productCode' && d.id == data.productCode.id){
				$j('#codebar' + d[rnd]).html(data.codebar);
				$j('#batch' + d[rnd]).html(data.batch);
				$j('#UMRifPeso_PA' + d[rnd]).html(data.UMRifPeso_PA);
				$j('#descrizioneArt_PA' + d[rnd]).html(data.descrizioneArt_PA);
				return true;
			}

			return false;
		});

		/* saved value for section */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'section' && d.id == data.section.id)
				return { results: [ data.section ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

