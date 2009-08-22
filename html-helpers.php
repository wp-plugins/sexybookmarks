<?
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
?>
