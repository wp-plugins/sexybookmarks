<?php
function sexy_network_input_select($name, $hint) {
	global $sexy_plugopts;
	return sprintf('<label class="%s" title="%s"><input %sname="bookmark[]" type="checkbox" value="%s"  id="%s" /></label>',
		$name,
		$hint,
		@in_array($name, $sexy_plugopts['bookmark'])?'checked="checked" ':"",
		$name,
		$name
	);
}

// returns the option tag for a form select element
// $opts array expecting keys: field, value, text
function sexy_form_select_option($opts) {
	global $sexy_plugopts;
	$opts=array_merge(
		array(
			'field'=>'',
			'value'=>'',
			'text'=>'',
		),
		$opts
	);
	return sprintf('<option%s value="%s">%s</option>'
		($sexy_plugopts[$opts['field']]==$opts['value'])?' selected="selected"':"",
		$opts['value'],
		$opts['text']
	);
}

// given an array $options of data and $field to feed into sexy_form_select_option
function sexy_select_option_group($field, $options) {
	$h='';
	foreach ($options as $value=>$text) {
		$h.=sexy_form_select_option(array(
			'field'=>$field,
			'value'=>$value,
			'text'=>$text,
		));
	}
	return $h;
}
?>
