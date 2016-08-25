<?php
defined('_JEXEC') or die('Restricted access');

/*
* A payment plugin called "example". This is the main file of the plugin.
*/

// You need to extend from the hikashopPaymentPlugin class which already define lots of functions in order to simplify your work
class plgHikashopPlg_hikabackpic extends JPlugin
{
	
public function onHikashopBeforeDisplayView() {
		
 if (JRequest::getVar('option')==='com_hikashop' AND JRequest::getVar('ctrl')==='product' AND JRequest::getVar('task')==='show') {

				$articleId = JRequest::getInt('cid');		
		}else {
			return false;
		}
			
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			
		
			$query->select('*');
			$query->from('#__backpic');
			$query->where('article_id = ' . $articleId);
			$query->where('published = 1');
			$query->where('type = 4');
				 
			$db->setQuery($query);
			$row = $db->loadAssoc();
			if ($row['published'] == 1 AND $row['type'] == 4) {
				
				$row['pic'] 			= htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8');
				$row['width'] 			= htmlspecialchars($row['width'], ENT_QUOTES, 'UTF-8');
				$row['height'] 			= htmlspecialchars($row['height'], ENT_QUOTES, 'UTF-8');
				$row['custom'] 			= htmlspecialchars($row['custom'], ENT_QUOTES, 'UTF-8');
				$row['menudbid']		= htmlspecialchars($row['menudbid'], ENT_QUOTES, 'UTF-8');
				$row['template_name']	= htmlspecialchars($row['template_name'], ENT_QUOTES, 'UTF-8');
			
				
			if (!empty($row['template_name']) AND !empty($row['template_name'] == 0)) {

					$selectsetTemplate = JFactory::getApplication();
			 		$selectsetTemplate->setTemplate("{$row['template_name']}", null);
				}
				
			$doc = JFactory::getDocument();
			$UrlSite = JURI::root();
				if (!empty($row['pic'])) {
					$doc->addStyleDeclaration("
						body {background: url('{$UrlSite}{$row['pic']}') no-repeat;background-size: {$row['width']} {$row['height']};}
				");
				}
				
				if (!empty($row['custom'])) {
					$doc->addStyleDeclaration("
						{$row['custom']}
				");
				}
			}

	}
}
?>
