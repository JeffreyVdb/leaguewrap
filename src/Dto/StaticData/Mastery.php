<?php
namespace JeffreyVdb\LeagueWrap\Dto\StaticData;

use JeffreyVdb\LeagueWrap\Dto\AbstractDto;

class Mastery extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}

		parent::__construct($info);
	}
}
