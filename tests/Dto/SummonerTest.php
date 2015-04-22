<?php

class DtoSummonerTest extends PHPUnit_Framework_TestCase {

	public function testRunePage()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([
			'runePages' => [
				1 => 'runePage1',
				2 => 'runePage2',
				3 => 'runePage3',
			],
		]);

		$runePage = $summoner->runePage(2);
		$this->assertEquals('runePage2', $runePage);
	}

	public function testRunePageNotFound()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([
			'runePages' => [
				1 => 'runePage1',
				2 => 'runePage2',
				3 => 'runePage3',
			],
		]);

		$runePage = $summoner->runePage(5);
		$this->assertTrue(is_null($runePage));
	}

	public function testNoRunePages()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([]);

		$runePage = $summoner->runePage(1);
		$this->assertTrue(is_null($runePage));
	}

	public function testMasteryPage()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([
			'masteryPages' => [
				1 => 'masteryPage1',
				2 => 'masteryPage2',
				3 => 'masteryPage3',
			],
		]);

		$masteryPage = $summoner->masteryPage(2);
		$this->assertEquals('masteryPage2', $masteryPage);
	}

	public function testMasteryPageNotFound()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([
			'masteryPages' => [
				1 => 'masteryPage1',
				2 => 'masteryPage2',
				3 => 'masteryPage3',
			],
		]);

		$masteryPage = $summoner->masteryPage(5);
		$this->assertTrue(is_null($masteryPage));
	}

	public function testNoMasteryPages()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([]);

		$masteryPage = $summoner->masteryPage(1);
		$this->assertTrue(is_null($masteryPage));
	}

	public function testNoRecentGames()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([]);

		$recentGame = $summoner->recentGame(1);
		$this->assertTrue(is_null($recentGame));
	}

	public function testNoLeague()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([]);
		
		$league = $summoner->league(1);
		$this->assertTrue(is_null($league));
	}

	public function testEmptyLeague()
	{
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner(['leagues' => []]);
		
		$league = $summoner->league(1);
		$this->assertTrue(is_null($league));
	}

	public function testLeaguePlayerOrTeam()
	{
		$league1 = new JeffreyVdb\LeagueWrap\Dto\League([]);
		$league2 = new JeffreyVdb\LeagueWrap\Dto\League([
			'id'      => 2, 
			'entries' => [
				[
					'playerOrTeamId' => 2,
				],
			],
		]);
		$summoner = new JeffreyVdb\LeagueWrap\Dto\Summoner([
			'leagues' => [
				$league1,
				$league2,
			],
		]);
		
		$league = $summoner->league(2);
		$this->assertEquals(spl_object_hash($league2), spl_object_hash($league));
	}
}
