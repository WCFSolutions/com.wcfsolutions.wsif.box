<?php
// wsif imports
require_once(WSIF_DIR.'lib/data/entry/comment/EntryComment.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/box/tab/BoxTab.class.php');
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the entry comments box tab data.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.box
 * @subpackage	system.cache
 * @category	Infinite Filebase
 */
class CacheBuilderEntryCommentsBoxTabType implements CacheBuilder {
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
		$sql = "SELECT		entry_comment.commentID, entry_comment.userID, entry_comment.username,
					entry_comment.subject, entry_comment.time
			FROM		wsif".WSIF_N."_entry_comment entry_comment
			LEFT JOIN	wsif".WSIF_N."_entry entry
			ON		(entry.entryID = entry_comment.entryID)
			WHERE		entry.categoryID IN (".$boxTab->categoryIDs.")
					".(!empty($languageIDs) ? " AND entry.languageID IN (".$languageIDs.")" : '')."
					AND entry.isDeleted = 0
					AND entry.isDisabled = 0
			ORDER BY	time DESC";
		$result = WCF::getDB()->sendQuery($sql, $boxTab->maxEntryComments);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new EntryComment(null, $row);
		}
		
		return $data;
	}
}
?>