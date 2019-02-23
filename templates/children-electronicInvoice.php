<?php if(!isset($Translation)) die('No direct access allowed.'); ?>
<?php $current_table = 'electronicInvoice'; ?>
<?php
	$cleaner = new CI_Input();
	$cleaner->charset = datalist_db_encoding;
?>
<script>
	<?php echo $current_table; ?>GetChildrenRecordsList = function(command){
		var param = {
			ChildTable: "<?php echo $parameters['ChildTable']; ?>",
			ChildLookupField: "<?php echo $parameters['ChildLookupField']; ?>",
			SelectedID: "<?php echo addslashes($parameters['SelectedID']); ?>",
			Page: <?php echo addslashes($parameters['Page']); ?>,
			SortBy: <?php echo ($parameters['SortBy'] === false ? '""' : $parameters['SortBy']); ?>,
			SortDirection: '<?php echo $parameters['SortDirection']; ?>',
			AutoClose: <?php echo ($config['auto-close'] ? 'true' : 'false'); ?>
		};
		var panelID = "panel_<?php echo "{$parameters['ChildTable']}-{$parameters['ChildLookupField']}"; ?>";
		var mbWidth = window.innerWidth * 0.9;
		var mbHeight = window.innerHeight * 0.8;
		if(mbWidth > 1000){ mbWidth = 1000; }
		if(mbHeight > 800){ mbHeight = 800; }

		switch(command.Verb){
			case 'sort': /* order by given field index in 'SortBy' */
				post("parent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: param.Page,
					SortBy: command.SortBy,
					SortDirection: command.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
				break;
			case 'page': /* next or previous page as provided by 'Page' */
				if(command.Page.toLowerCase() == 'next'){ command.Page = param.Page + 1; }
				else if(command.Page.toLowerCase() == 'previous'){ command.Page = param.Page - 1; }

				if(command.Page < 1 || command.Page > <?php echo ceil($totalMatches / $config['records-per-page']); ?>){ return; }
				post("parent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: command.Page,
					SortBy: param.SortBy,
					SortDirection: param.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
				break;
			case 'new': /* new record */
				var parentId = $j('[name=SelectedID]').val();
				var url = param.ChildTable + '_view.php?' + 
					'filterer_' + param.ChildLookupField + '=' + encodeURIComponent(parentId) +
					'&addNew_x=1' + 
					'&Embedded=1' + 
					(param.AutoClose ? '&AutoClose=1' : '');
				modal_window({
					url: url,
					close: function(){ /* */ <?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); },
					size: 'full',
					title: '<?php echo addslashes("{$config['tab-label']}: {$Translation['Add New']}"); ?>'
				});
				break;
			case 'open': /* opens the detail view for given child record PK provided in 'ChildID' */
				var url = param.ChildTable + '_view.php?Embedded=1&SelectedID=' + escape(command.ChildID) + (param.AutoClose ? '&AutoClose=1' : '');
				modal_window({
					url: url,
					close: function(){ /* */ <?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); },
					size: 'full',
					title: '<?php echo addslashes($config['tab-label']); ?>'
				});
				break;
			case 'reload': /* just a way of refreshing children, retaining sorting and pagination & without reloading the whole page */
				post("parent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: param.Page,
					SortBy: param.SortBy,
					SortDirection: param.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
				break;
		}
	};
</script>

<div class="row">
	<div class="col-xs-11 col-md-12">

		<?php if($config['display-add-new']){ ?>
			<?php if(stripos($_SERVER['HTTP_USER_AGENT'], 'msie ')){ ?>
				<a href="<?php echo $parameters['ChildTable']; ?>_view.php?filterer_<?php echo $parameters['ChildLookupField']; ?>=<?php echo urlencode($parameters['SelectedID']); ?>&addNew_x=1" target="_viewchild" class="btn btn-success hspacer-sm vspacer-md"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo html_attr($Translation['Add New']); ?></a>
			<?php }else{ ?>
				<a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'new' }); return false;" class="btn btn-success hspacer-sm vspacer-md"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo html_attr($Translation['Add New']); ?></a>
			<?php } ?>
		<?php } ?>
		<?php if($config['display-refresh']){ ?><a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); return false;" class="btn btn-default hspacer-sm vspacer-md"><i class="glyphicon glyphicon-refresh"></i></a><?php } ?>


		<div class="table-responsive">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<?php if($config['open-detail-view-on-click']){ ?>
							<th>&nbsp;</th>
						<?php } ?>
						<?php if(is_array($config['display-fields'])) foreach($config['display-fields'] as $fieldIndex => $fieldLabel){ ?>
							<th 
								<?php if($config['sortable-fields'][$fieldIndex]){ ?>
									onclick="<?php echo $current_table; ?>GetChildrenRecordsList({
										Verb: 'sort', 
										SortBy: <?php echo $fieldIndex; ?>, 
										SortDirection: '<?php echo ($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'asc' ? 'desc' : 'asc'); ?>'
									});" 
									style="cursor: pointer;" 
								<?php } ?>
								class="<?php echo "{$current_table}-{$config['display-field-names'][$fieldIndex]}"; ?>">
								<?php echo $fieldLabel; ?>
								<?php if($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'desc'){ ?>
									<i class="glyphicon glyphicon-sort-by-attributes-alt text-warning"></i>
								<?php }elseif($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'asc'){ ?>
									<i class="glyphicon glyphicon-sort-by-attributes text-warning"></i>
								<?php } ?>
							</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($records)) foreach($records as $pkValue => $record){ ?>
					<tr>
						<?php if($config['open-detail-view-on-click']){ ?>
							<?php if(stripos($_SERVER['HTTP_USER_AGENT'], 'msie ')){ ?>
								<td class="text-center view-on-click"><a href="<?php echo $parameters['ChildTable']; ?>_view.php?SelectedID=<?php echo urlencode($record[$config['child-primary-key-index']]); ?>" target="_viewchild" class="h6"><i class="glyphicon glyphicon-new-window hspacer-md"></i></a></td>
							<?php }else{ ?>
								<td class="text-center view-on-click"><a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'open', ChildID: '<?php echo html_attr($record[$config['child-primary-key-index']]); ?>'}); return false;" class="h6"><i class="glyphicon glyphicon-new-window hspacer-md"></i></a></td>
							<?php } ?>
						<?php } ?>

						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][1]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][1]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[1]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][2]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][2]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[2]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][3]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][3]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[3]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][4]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][4]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[4]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][5]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][5]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[5]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][6]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][6]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[6]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][7]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][7]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[7]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][8]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][8]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[8]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][9]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][9]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[9]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][10]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][10]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[10]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][11]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][11]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[11]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][12]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][12]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[12]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][13]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][13]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[13]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][14]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][14]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[14]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][15]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][15]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[15]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][16]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][16]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[16]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][17]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][17]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[17]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][18]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][18]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[18]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][19]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][19]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[19]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][20]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][20]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[20]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][21]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][21]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[21]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][22]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][22]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[22]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][23]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][23]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[23]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][24]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][24]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[24]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][25]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][25]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[25]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][26]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][26]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[26]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][27]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][27]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[27]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][28]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][28]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[28]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][29]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][29]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[29]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][30]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][30]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[30]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][31]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][31]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[31]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][32]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][32]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[32]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][33]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][33]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[33]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][34]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][34]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[34]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][35]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][35]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[35]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][36]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][36]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[36]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][37]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][37]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[37]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][38]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][38]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[38]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][39]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][39]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[39]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][40]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][40]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[40]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][41]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][41]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[41]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][42]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][42]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[42]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][43]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][43]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[43]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][44]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][44]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[44]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][45]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][45]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[45]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][46]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][46]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[46]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][47]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][47]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[47]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][48]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][48]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[48]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][49]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][49]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[49]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][50]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][50]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[50]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][51]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][51]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[51]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][52]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][52]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[52]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][53]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][53]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[53]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][54]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][54]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[54]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][55]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][55]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[55]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][56]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][56]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[56]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][57]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][57]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[57]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][58]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][58]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[58]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][59]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][59]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[59]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][60]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][60]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[60]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][61]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][61]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[61]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][62]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][62]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[62]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][63]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][63]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[63]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][64]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][64]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[64]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][65]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][65]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[65]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][66]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][66]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[66]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][67]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][67]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[67]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][68]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][68]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[68]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][69]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][69]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[69]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][70]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][70]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[70]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][71]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][71]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[71]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][72]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][72]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[72]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][73]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][73]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[73]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][74]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][74]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[74]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][75]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][75]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[75]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][76]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][76]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[76]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][77]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][77]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[77]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][78]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][78]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[78]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][79]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][79]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[79]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][80]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][80]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[80]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][81]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][81]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[81]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][82]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][82]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[82]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][83]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][83]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[83]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][84]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][84]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[84]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][85]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][85]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[85]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][86]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][86]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[86]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][87]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][87]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[87]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][88]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][88]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[88]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][89]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][89]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[89]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][90]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][90]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[90]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][91]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][91]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[91]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][92]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][92]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[92]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][93]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][93]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[93]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][94]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][94]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[94]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][95]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][95]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[95]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][96]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][96]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[96]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][97]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][97]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[97]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][98]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][98]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[98]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][99]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][99]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[99]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][100]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][100]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[100]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][101]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][101]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[101]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][102]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][102]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[102]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][103]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][103]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[103]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][104]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][104]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[104]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][105]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][105]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[105]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][106]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][106]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[106]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][107]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][107]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[107]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][108]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][108]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[108]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][109]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][109]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[109]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][110]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][110]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[110]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][111]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][111]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[111]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][112]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][112]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[112]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][113]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][113]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[113]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][114]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][114]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[114]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][115]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][115]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[115]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][116]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][116]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[116]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][117]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][117]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[117]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][118]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][118]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[118]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][119]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][119]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[119]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][120]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][120]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[120]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][121]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][121]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[121]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][122]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][122]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[122]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][123]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][123]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[123]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][124]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][124]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[124]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][125]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][125]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[125]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][126]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][126]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[126]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][127]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][127]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[127]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][128]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][128]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[128]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][129]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][129]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[129]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][130]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][130]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[130]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][131]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][131]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[131]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][132]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][132]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[132]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][133]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][133]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[133]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][134]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][134]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[134]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][135]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][135]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[135]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][136]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][136]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[136]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][137]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][137]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[137]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][138]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][138]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[138]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][139]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][139]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[139]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][140]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][140]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[140]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][141]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][141]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[141]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][142]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][142]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[142]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][143]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][143]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[143]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][144]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][144]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[144]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][145]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][145]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[145]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][146]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][146]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[146]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][147]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][147]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[147]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][148]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][148]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[148]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][149]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][149]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[149]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][150]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][150]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[150]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][151]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][151]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[151]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][152]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][152]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[152]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][153]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][153]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[153]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][154]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][154]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[154]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][155]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][155]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[155]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][156]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][156]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[156]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][157]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][157]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[157]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][158]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][158]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[158]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][159]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][159]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[159]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][160]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][160]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[160]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][161]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][161]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[161]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][162]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][162]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[162]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][163]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][163]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[163]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][164]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][164]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[164]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][165]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][165]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[165]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][166]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][166]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[166]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][167]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][167]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[167]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][168]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][168]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[168]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][169]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][169]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[169]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][170]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][170]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[170]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][171]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][171]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[171]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][172]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][172]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[172]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][173]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][173]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[173]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][174]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][174]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[174]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][175]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][175]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[175]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][176]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][176]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[176]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][177]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][177]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[177]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][178]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][178]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[178]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][179]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][179]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[179]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][180]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][180]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[180]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][181]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][181]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[181]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][182]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][182]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[182]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][183]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][183]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[183]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][184]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][184]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[184]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][185]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][185]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[185]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][186]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][186]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[186]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][187]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][187]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[187]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][188]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][188]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[188]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][189]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][189]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[189]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][190]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][190]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[190]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][191]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][191]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[191]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][192]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][192]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[192]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][193]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][193]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[193]); ?></td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="<?php echo (count($config['display-fields']) + ($config['open-detail-view-on-click'] ? 1 : 0)); ?>">
							<?php if($totalMatches){ ?>
								<?php if($config['show-page-progress']){ ?>
									<span style="margin: 10px;">
										<?php $firstRecord = ($parameters['Page'] - 1) * $config['records-per-page'] + 1; ?>
										<?php echo str_replace(array('<FirstRecord>', '<LastRecord>', '<RecordCount>'), array($firstRecord, $firstRecord + count($records) - 1, $totalMatches), $Translation['records x to y of z']); ?>
									</span>
								<?php } ?>
							<?php }else{ ?>
								<span class="text-danger" style="margin: 10px;"><?php echo $Translation['No matches found!']; ?></span>
							<?php } ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php if($totalMatches){ ?>
			<div class="row hidden-print">
				<div class="col-xs-12">
					<button type="button" class="btn btn-default" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'page', Page: 'previous' });"><i class="glyphicon glyphicon-chevron-left"></i></button>
					<button type="button" class="btn btn-default" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'page', Page: 'next' });"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-xs-1 md-hidden lg-hidden"></div>
</div>
<script>$j(function(){ /* */ $j('img[src^="thumbnail.php?i=&"').parent().hide(); });</script>
