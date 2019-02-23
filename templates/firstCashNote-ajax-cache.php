<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'firstCashNote';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			order: <?php echo json_encode(array('id' => $rdata['order'], 'value' => $rdata['order'], 'text' => $jdata['order'])); ?>,
			company: <?php echo json_encode($jdata['company']); ?>,
			customer: <?php echo json_encode(array('id' => $rdata['customer'], 'value' => $rdata['customer'], 'text' => $jdata['customer'])); ?>,
			idBank: <?php echo json_encode(array('id' => $rdata['idBank'], 'value' => $rdata['idBank'], 'text' => $jdata['idBank'])); ?>,
			istitutoFinanziario_PA: <?php echo json_encode($jdata['istitutoFinanziario_PA']); ?>
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

		/* saved value for order */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'order' && d.id == data.order.id)
				return { results: [ data.order ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for customer */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'customer' && d.id == data.customer.id)
				return { results: [ data.customer ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for customer autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'customer' && d.id == data.customer.id){
				$j('#istitutoFinanziario_PA' + d[rnd]).html(data.istitutoFinanziario_PA);
				return true;
			}

			return false;
		});

		/* saved value for idBank */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idBank' && d.id == data.idBank.id)
				return { results: [ data.idBank ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idBank autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idBank' && d.id == data.idBank.id){
				$j('#company' + d[rnd]).html(data.company);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

