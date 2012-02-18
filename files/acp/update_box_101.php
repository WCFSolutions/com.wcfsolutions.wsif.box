<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();
$parentPackageID = $this->installation->getPackage()->getParentPackage()->getPackageID();

// delete deprecated files
$deprecatedFiles = array(
	'lib/data/box/type/LastEntriesBoxType.class.php',
	'lib/data/box/type/LastEntryCommentsBoxType.class.php',
	'lib/system/cache/CacheBuilderLastEntriesBoxType.class.php',
	'lib/system/cache/CacheBuilderLastEntryCommentsBoxType.class.php'
);

$sql = "DELETE FROM	wcf".WCF_N."_package_installation_file_log
	WHERE		filename IN ('".implode("','", array_map('escapeString', $deprecatedFiles))."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedFiles as $file) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().$file);
}

// delete deprecated templates
$deprecatedTemplates = array(
	'lastEntriesBoxType.tpl',
	'lastEntryCommentsBoxType.tpl'
);

$sql = "DELETE FROM	wcf".WCF_N."_template
	WHERE		templateName IN ('".implode("','", array_map('escapeString', $deprecatedTemplates))."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedTemplates as $template) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().'templates/'.$template.'.tpl');
}

// update entries box
$sql = "UPDATE 	wcf".WCF_N."_box_tab
	SET	boxTabType = 'entries'
	WHERE	boxTabType = 'lastEntries'
		AND packageID = ".$parentPackageID;
WCF::getDB()->sendQuery($sql);

$sql = "UPDATE 	wcf".WCF_N."_box_tab_type
	SET	boxTabType = 'entries'
	WHERE	boxTabType = 'lastEntries'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

$sql = "UPDATE 	wcf".WCF_N."_box_tab_option
	SET	boxTabType = 'entries'
	WHERE	boxTabType = 'lastEntries'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

// update entry comments box
$sql = "UPDATE 	wcf".WCF_N."_box_tab
	SET	boxTabType = 'entryComments'
	WHERE	boxTabType = 'lastEntryComments'
		AND packageID = ".$parentPackageID;
WCF::getDB()->sendQuery($sql);

$sql = "UPDATE 	wcf".WCF_N."_box_tab_type
	SET	boxTabType = 'entryComments'
	WHERE	boxTabType = 'lastEntryComments'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

$sql = "UPDATE 	wcf".WCF_N."_box_tab_option
	SET	boxTabType = 'entryComments'
	WHERE	boxTabType = 'lastEntryComments'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);
?>