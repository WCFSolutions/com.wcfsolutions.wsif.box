<?php
// wsif imports
require_once(WSIF_DIR.'lib/data/category/Category.class.php');
require_once(WSIF_DIR.'lib/data/entry/ViewableEntry.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/box/tab/type/AbstractBoxTabType.class.php');

/**
 * Represents the entries box tab.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.box
 * @subpackage	data.box.tab.type
 * @category	Infinite Filebase
 */
class EntriesBoxTabType extends AbstractBoxTabType {
	/**
	 * list of box tab ids
	 * 
	 * @var	array
	 */
	public $boxTabIDArray = array();
	
	/**
	 * language cache name
	 * 
	 * @var	string
	 */
	public $languageCacheName = null;
	
	/**
	 * language filename
	 * 
	 * @var	string
	 */
	public $languageFilename = '';
	
	/**
	 * @see	BoxTabType::cache()
	 */
	public function cache(BoxTab $boxTab) {
		if ($this->languageCacheName === null) {
			$languageIDArray = WCF::getSession()->getVisibleLanguageIDArray();
			if (count($languageIDArray)) {
				$this->languageCacheName = '-'.implode(',', $languageIDArray);
				$this->languageFilename = '-'.StringUtil::getHash(implode('-', $languageIDArray));
			}
		}
		if (!in_array($boxTab->boxTabID, $this->boxTabIDArray)) {
			$this->boxTabIDArray[] = $boxTab->boxTabID;
			
			// add cache resource
			WCF::getCache()->addResource('entriesBoxTabType-'.$boxTab->boxTabID.$this->languageCacheName, WSIF_DIR.'cache/cache.entriesBoxTabType-'.$boxTab->boxTabID.$this->languageFilename.'.php', WSIF_DIR.'lib/system/cache/CacheBuilderEntriesBoxTabType.class.php');
		}
	}
	
	/**
	 * @see	BoxTabType::getData()
	 */
	public function getData(BoxTab $boxTab) {
		return WCF::getCache()->get('entriesBoxTabType-'.$boxTab->boxTabID.$this->languageCacheName);
	}
	
	/**
	 * @see	BoxTabType::resetCache()
	 */
	public function resetCache(BoxTab $boxTab) {
		WCF::getCache()->clear(WSIF_DIR.'cache/', 'cache.entriesBoxTabType-'.$boxTab->boxTabID.'(-*)?.php', true);
	}
	
	/**
	 * @see	BoxTabType::getTemplateName()
	 */	
	public function getTemplateName() {
		return 'entriesBoxTabType';
	}
}
?>