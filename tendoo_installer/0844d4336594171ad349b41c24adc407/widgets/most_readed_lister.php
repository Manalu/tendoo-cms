<?php
class aflearlep_news_common_widget
{
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=&	$this->data['theme'];
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		// var_dump($this->data['currentWidget']);
		$this->news		=	new News_smart;
		$setting		=	$this->news->getBlogsterSetting();
		// var_dump($this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS']);
		$LIMIT			=	$this->data['currentWidget']['WIDGET_INFO']['WIDGET_PARAMETERS'];
		
		$this->data['mostViewed']	=	$this->news->getMostViewed(0,$LIMIT);
		$end			=	'<ul>';
		$controller		=	$this->instance->tendoo->getControllersAttachedToModule($this->data['currentWidget']['WIDGET_MODULE']['NAMESPACE']);
		foreach($this->data['mostViewed'] as $t)
		{
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array($controller[0]['PAGE_CNAME'])).'/lecture/'.$t['URL_TITLE'].'">'.$t['TITLE'].'</a></li>';
		}
		$end			.=	'</ul>';
		// For Zones
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$rZone		=&	$this->data['widgets']['requestedZone']; // requestedZone
			if($rZone == 'LEFT')
			{
				$this->theme->defineLeftWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
			elseif($rZone == 'RIGHT')
			{
				$this->theme->defineRightWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
			else
			{
				$this->theme->defineBottomWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_TITLE'],$end);
			}
		}
		
	}
}