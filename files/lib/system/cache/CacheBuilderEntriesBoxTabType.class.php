<?php
// wsif imports
require_once(WSIF_DIR.'lib/data/entry/ViewableEntry.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/box/tab/BoxTab.class.php');
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the entries box tab data.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.box
 * @subpackage	system.cache
 * @category	Infinite Filebase
 */
class CacheBuilderEntriesBoxTabType implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$information = explode('-', $cacheResource['cache']);
		$boxTabID = $information[1];
		$languageIDs = '';
		if (count($information) == 3) {
			$languageIDs = $information[2];
		}
		
		$data = array();
		
		// get box tab
		try {
			$boxTab = new BoxTab($boxTabID);
		}
		catch (IllegalLinkException $e) {
			return $data;
		}
		if (!$boxTab->categoryIDs) return $data;
		
		// get entries
		if ($boxTab->displayType == 'list') {
			$sql = "SELECT		entryID, subject, time
				FROM		wsif".WSIF_N."_entry
				WHERE		categoryID IN (".$boxTab->categoryIDs.")
						".(!empty($languageIDs) ? " AND languageID IN (".$languageIDs.")" : '')."
						AND isDeleted = 0
						AND isDisabled = 0
				ORDER BY	time DESC";
		}
		else {
			$sql = "SELECT		entry.entryID, entry.userID, entry.username, 
                                entry.subject, entry.time, entry.defaultImageID, 
                                entry_image.imageID, entry_image.hasThumbnail
				FROM		wsif".WSIF_N."_entry entry
				LEFT JOIN	wsif".WSIF_N."_entry_image entry_image
				ON		(entry_image.imageID = entry.defaultImageID)
				WHERE		entry.categoryID IN (".$boxTab->categoryIDs.")
						".(!empty($languageIDs) ? " AND entry.languageID IN (".$languageIDs.")" : '')."
						AND entry.isDeleted = 0
						AND entry.isDisabled = 0
				ORDER BY	entry.time DESC";
		}
		$result = WCF::getDB()->sendQuery($sql, $boxTab->maxEntries);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new ViewableEntry(null, $row);
		}
		
		return $data;
	}
}
?>
