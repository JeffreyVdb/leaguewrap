<?php
namespace JeffreyVdb\LeagueWrap\Dto;

class Mastery extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'masteryId' => 'mastery',
	];
}
