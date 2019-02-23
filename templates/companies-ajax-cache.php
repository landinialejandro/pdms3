<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'companies';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			idPaese_Ced_PA: <?php echo json_encode(array('id' => $rdata['idPaese_Ced_PA'], 'value' => $rdata['idPaese_Ced_PA'], 'text' => $jdata['idPaese_Ced_PA'])); ?>
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

		/* saved value for idPaese_Ced_PA */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idPaese_Ced_PA' && d.id == data.idPaese_Ced_PA.id)
				return { results: [ data.idPaese_Ced_PA ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

