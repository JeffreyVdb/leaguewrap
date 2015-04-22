<?php

class ResponseTest extends PHPUnit_Framework_TestCase {

	public function testSetCode()
	{
		$response = new JeffreyVdb\LeagueWrap\Response('foo...bar!', 200);
		$this->assertEquals(200, $response->GetCode());
	}
}
