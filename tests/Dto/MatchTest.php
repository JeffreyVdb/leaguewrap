<?php

class DtoMatchTest extends PHPUnit_Framework_TestCase {

	public function testParticipantNotFound()
	{
		$match = new JeffreyVdb\LeagueWrap\Dto\Match([]);
		$this->assertEquals(null, $match->participant(1));
	}

	public function testIdentityNotFound()
	{
		$match = new JeffreyVdb\LeagueWrap\Dto\Match([]);
		$this->assertEquals(null, $match->identity(1));
	}

	public function testTeamsNotFound()
	{
		$match = new JeffreyVdb\LeagueWrap\Dto\Match([]);
		$this->assertEquals(null, $match->team(1));
	}

}
