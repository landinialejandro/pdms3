<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'orders';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			company: <?php echo json_encode(array('id' => $rdata['company'], 'value' => $rdata['company'], 'text' => $jdata['company'])); ?>,
			typeDoc: <?php echo json_encode(array('id' => $rdata['typeDoc'], 'value' => $rdata['typeDoc'], 'text' => $jdata['typeDoc'])); ?>,
			customer: <?php echo json_encode(array('id' => $rdata['customer'], 'value' => $rdata['customer'], 'text' => $jdata['customer'])); ?>,
			supplier: <?php echo json_encode(array('id' => $rdata['supplier'], 'value' => $rdata['supplier'], 'text' => $jdata['supplier'])); ?>,
			employee: <?php echo json_encode(array('id' => $rdata['employee'], 'value' => $rdata['employee'], 'text' => $jdata['employee'])); ?>,
			shipVia: <?php echo json_encode(array('id' => $rdata['shipVia'], 'value' => $rdata['shipVia'], 'text' => $jdata['shipVia'])); ?>,
			CAP_Resa_PA: <?php echo json_encode(array('id' => $rdata['CAP_Resa_PA'], 'value' => $rdata['CAP_Resa_PA'], 'text' => $jdata['CAP_Resa_PA'])); ?>,
			comuneResa_PA: <?php echo json_encode($jdata['comuneResa_PA']); ?>,
			provResa_PA: <?php echo json_encode($jdata['provResa_PA']); ?>,
			nazioneResa_PA: <?php echo json_encode(array('id' => $rdata['nazioneResa_PA'], 'value' => $rdata['nazioneResa_PA'], 'text' => $jdata['nazioneResa_PA'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for kind */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'kind' && d.id == data.kind.id)
				return { results: [ data.kind ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for company */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'company' && d.id == data.company.id)
				return { results: [ data.company ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for typeDoc */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'typeDoc' && d.id == data.typeDoc.id)
				return { results: [ data.typeDoc ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for customer */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'customer' && d.id == data.customer.id)
				return { results: [ data.customer ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for supplier */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'supplier' && d.id == data.supplier.id)
				return { results: [ data.supplier ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for employee */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'employee' && d.id == data.employee.id)
				return { results: [ data.employee ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for shipVia */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'shipVia' && d.id == data.shipVia.id)
				return { results: [ data.shipVia ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for CAP_Resa_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'CAP_Resa_PA' && d.id == data.CAP_Resa_PA.id)
				return { results: [ data.CAP_Resa_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for CAP_Resa_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'CAP_Resa_PA' && d.id == data.CAP_Resa_PA.id){
				$j('#comuneResa_PA' + d[rnd]).html(data.comuneResa_PA);
				$j('#provResa_PA' + d[rnd]).html(data.provResa_PA);
				return true;
			}

			return false;
		});

		/* saved value for nazioneResa_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'nazioneResa_PA' && d.id == data.nazioneResa_PA.id)
				return { results: [ data.nazioneResa_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

