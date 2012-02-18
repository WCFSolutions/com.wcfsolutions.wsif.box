<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Clears the box tab type cache of the filebase.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.box
 * @subpackage	system.event.listener
 * @category 	Infinite Filebase
 */
class WSIFBoxTabTypeClearCacheListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		switch ($className) {
			case 'EntryCommentAddForm':
			case 'EntryCommentEditForm':
			case 'EntryCommentDeleteAction':
				require_once(WCF_DIR.'lib/data/box/tab/BoxTab.class.php');
				BoxTab::resetBoxTabCacheByBoxTabType('entryComments');
				break;
			case 'EntryAddForm':
			case 'EntryEditForm':
			case 'EntryPrefixEditAction':
			case 'EntrySubjectEditAction':
				require_once(WCF_DIR.'lib/data/box/tab/BoxTab.class.php');
				BoxTab::resetBoxTabCacheByBoxTabType('entries');
				break;
			case 'EntryDeleteAction':
			case 'EntryDeleteMarkedAction':
			case 'EntryDisableAction':
			case 'EntryEnableAction':
			case 'EntryRecoverAction':
			case 'EntryRecoverMarkedAction':
			case 'EntryTrashAction':
				require_once(WCF_DIR.'lib/data/box/tab/BoxTab.class.php');
				BoxTab::resetBoxTabCacheByBoxTabType('entries');
				BoxTab::resetBoxTabCacheByBoxTabType('entryComments');
				break;
		}
	}
}
?>