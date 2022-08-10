<?php
/*
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

class plgSystemBuyingBuddy extends CMSPlugin
{

	/**
	 * Application object
	 *
	 * @var    \Joomla\CMS\Application\CMSApplication
	 * @since  4.0.0
	 */
	protected $app;

	public function onBeforeCompileHead()
	{

		if ($this->app->isClient('administrator'))
		{
			return;
		}

		$web_property_id = $this->params->get('web_property_id');
		$gmap_id         = $this->params->get('gmap_id');

		if (empty($web_property_id) || empty($gmap_id))
		{
			return;
		}

		$wa = $this->app->getDocument()->getWebAssetManager();

		$wa->registerAndUseScript('gmap', 'https://maps.googleapis.com/maps/api/js?key=' . $gmap_id);
		$wa->registerAndUseScript('mbb2_1', 'https://www.mbb2.com/version3/css/theme/acid/' . $web_property_id);
		$wa->registerAndUseScript('mbb2_2', 'https://www.mbb2.com/scripts/my-buying-buddy.4.0.js');

		$js = <<<JS
var MBB = { mbbUrl: 'https://www.mbb2.com/version3', seo : 'false' };
MBB.data = { acid : '$web_property_id' };
JS;
		$wa->addInlineScript($js);

	}
}
