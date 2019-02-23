<?php

//----------------------------------------------------------
/*
                        mkbuttons
*/
//----------------------------------------------------------




function mkbuttons($table, $selectedID, &$buttons) {

	// most of this is pulled from Ahmad's online course,
	// but considerably restructered to make it programmable

 	// no buttons in print preview
	if(isset($_REQUEST['dvprint_x'])) return;

	// initialize the html buffers

	$html = "<p></p>";
	$onclick = '';

	foreach ($buttons as $group => $buttongroup) {

		// open the button group

		$html .= '<div id="mkb_'.$group.'" class="btn-group-vertical btn-group-lg" style="width: 100%;">';

		foreach ($buttongroup as $buttonid => $button) {

			// skip buttons as directed

			if ($selectedID) {
				if ($button['update'] === false) continue;
			} else {
				if ($button['insert'] === false) continue;
			}

			// use defaults where needed

			if ($button['name']) {
				$name = $button['name'];
			} else {
				$name = '[ UNKNOWN ]';
			}

			if ($button['style']) {
				$style = $button['style'];
			} else {
				$style = 'default';
			}

			if ($button['icon']) {
				$icon = '<i class="'.$button['icon'].'"></i> ';
			} else {
				$icon = '';
			}

                        if ($button['attr']) {
                            $attr = $button['attr'].' ';
                        }else{
                            $attr = '';
                        }
                        
			// conventions for button ID and default PHP

//			$btnid = "{$table}_{$group}_{$buttonid}";
                        // get only the name button like id
			$btnid = "{$buttonid}";
			$phpid = "{$table}-{$group}-{$buttonid}.php";

			// output the button code

			$html .= '<button type="button" '
			       . 'id="'.$btnid.'" '.$attr
			       . 'class="btn btn-'.$style.' btn-lg">'
			       . $icon
			       . $name
			       . '</button>';

			// generate the jquery code

			$onclick .= "  \$j('#{$btnid}').on('click', function(){\n    ";

			if ($button['confirm'])
			  $onclick .= "if (confirm(\"".$button['confirm']."\")) { ";

			$action = explode('|', $button['onclick']);

			switch ($action[0]) {
                                case 'alert':
                                case 'alert-ok':
                                        $onclick .= 'alert("'.$action[1].'"); return true; ';
                                        break;
                                case 'alert-cancel':
                                        $onclick .= 'alert("'.$action[1].'"); return false; ';
                                        break;
                                case 'script':
                                        $onclick .= $action[1].'; ';
                                        break;
                                case 'location':
                                        $onclick .= 'window.location="'.$action[1].'"; ';
                                        break;
                                case 'location-id':
                                        $phpid = $action[1];
                                default:

                                        $onclick .= 'window.location="'.$phpid.'?SelectedID='.urlencode($selectedID).'"; ';
			}

			if ($button['confirm']) $onclick .= "}";

			$onclick .= "\n  });\n";

		}
	
		// close the button group

		$html .= "</div><p></p>";

	}

        // now add the jquery code to insert the button html

	$html = "<script>\n"
	        . "\$j(function(){\n"
		. "  \$j('#{$table}_dv_action_buttons .btn-toolbar').append(\n"
		. "    '{$html}'\n"
		. "  );\n"
		. "\n"
		. $onclick
		. "\n"
		. "});\n"
	        . "</script>\n";

	// pass our custom html back to our caller

	return $html;
}


//----------------------------------------------------------
// EOF(_mkbuttons.php)
//-----------------------------------------------------------