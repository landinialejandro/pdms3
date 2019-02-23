<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'addresses_PA';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			CAP_Ced_PA: <?php echo json_encode($jdata['CAP_Ced_PA']); ?>,
			comune_Ced_PA: <?php echo json_encode($jdata['comune_Ced_PA']); ?>,
			provincia_Ced_PA: <?php echo json_encode(array('id' => $rdata['provincia_Ced_PA'], 'value' => $rdata['provincia_Ced_PA'], 'text' => $jdata['provincia_Ced_PA'])); ?>,
			nazione_Ced_PA: <?php echo json_encode(array('id' => $rdata['nazione_Ced_PA'], 'value' => $rdata['nazione_Ced_PA'], 'text' => $jdata['nazione_Ced_PA'])); ?>,
			altraNazione_Ced_PA: <?php echo json_encode($jdata['altraNazione_Ced_PA']); ?>,
			contact: <?php echo json_encode(array('id' => $rdata['contact'], 'value' => $rdata['contact'], 'text' => $jdata['contact'])); ?>,
			company: <?php echo json_encode(array('id' => $rdata['company'], 'value' => $rdata['company'], 'text' => $jdata['company'])); ?>
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

		/* saved value for provincia_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'provincia_Ced_PA' && d.id == data.provincia_Ced_PA.id)
				return { results: [ data.provincia_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for provincia_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'provincia_Ced_PA' && d.id == data.provincia_Ced_PA.id){
				$j('#CAP_Ced_PA' + d[rnd]).html(data.CAP_Ced_PA);
				$j('#comune_Ced_PA' + d[rnd]).html(data.comune_Ced_PA);
				return true;
			}

			return false;
		});

		/* saved value for nazione_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'nazione_Ced_PA' && d.id == data.nazione_Ced_PA.id)
				return { results: [ data.nazione_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for nazione_Ced_PA autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'nazione_Ced_PA' && d.id == data.nazione_Ced_PA.id){
				$j('#altraNazione_Ced_PA' + d[rnd]).html(data.altraNazione_Ced_PA);
				return true;
			}

			return false;
		});

		/* saved value for contact */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'contact' && d.id == data.contact.id)
				return { results: [ data.contact ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for company */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'company' && d.id == data.company.id)
				return { results: [ data.company ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

