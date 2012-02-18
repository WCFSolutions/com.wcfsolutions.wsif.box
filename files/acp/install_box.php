<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();

// create a default box layout
require_once(WCF_DIR.'lib/data/box/layout/BoxLayoutEditor.class.php');
$boxLayout = BoxLayoutEditor::create('WCF Solutions Infinite Filebase Standard', $packageID);
$boxLayout->setAsDefault($packageID);
?>