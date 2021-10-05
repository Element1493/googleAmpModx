<?php

$settings = array();

$tmp = array(
	'get' => array(	
        'xtype'    =>'textfield',
        'value'    =>'amp',
    ),
    'cache' => array(	
        'xtype'    =>'combo-boolean',
        'value'    =>'1',
    ),
	'template' => array(	
        'xtype'    =>'modx-combo-template',
        'value'    =>'0',
    ),
	'warnings' => array(	
        'xtype'    =>'combo-boolean',
        'value'    =>'0',
    ),

);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'googleAmpModx_' . $k,
			'namespace' => PKG_NAME_LOWER,
			'area'     =>''
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
