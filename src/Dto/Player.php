<?php
namespace JeffreyVdb\LeagueWrap\Dto;

class Player extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'championId' => 'champion',
	];
}
