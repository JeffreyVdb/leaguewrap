<?php
namespace JeffreyVdb\LeagueWrap\Dto\StaticData;

use JeffreyVdb\LeagueWrap\Dto\AbstractDto;

class Recommended extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['blocks']))
		{
			$blocks = [];
			foreach ($info['blocks'] as $key => $block)
			{
				$blocks[$key] = new Block($block);
			}
			$info['blocks'] = $blocks;
		}
		parent::__construct($info);
	}
}

