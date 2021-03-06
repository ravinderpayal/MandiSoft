<?php

namespace PHPOnCouch\Exceptions;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-04-08 at 05:09:45.
 */
class CouchExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CouchException
	 */

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		
	}

	private function httpResponseMock($statusCode, $body = "", $message = "OK", $contentType = null)
	{
		$contentTypeText = !empty($contentType) ? "\r\nContent-Type: $contentType" : "";
		return "HTTP/1.1 $statusCode $message
Cache-Control: must-revalidate
Content-Length: 91$contentTypeText
Date: Sat, 08 Apr 2017 03:19:23 GMT
Server: CouchDB/2.0.0 (Erlang OTP/17)
X-Couch-Request-ID: b020b03943
X-CouchDB-Body-Time: 0\r\n\r\n$body";
	}

	/**
	 * @covers PHPOnCouch\Exceptions\CouchException::__construct
	 */
	public function testConstruct()
	{
		$bodyStr = "{\"error\":\"unauthorized\",\"reason\":\"You are not a server admin.\"}";
		$response = $this->httpResponseMock("404", $bodyStr, "Unauthorized", "application/json");
		$except = new CouchException($response);

		//Check inheritance
		$this->assertContains('Exception', class_parents(CouchException::class));
		$this->assertEquals('404', $except->getCode());
		$this->assertContains("You are not a server admin.", $except->getMessage());
	}

	/**
	 * @covers PHPOnCouch\Exceptions\CouchException::factory
	 * @dataProvider testFactoryProvider
	 */
	public function testFactory($statusCode, $message, $expectedException)
	{
		$mock = $this->httpResponseMock($statusCode, null, $message);
		$except = CouchException::factory($mock, null, null, null);
		$this->assertEquals($expectedException, get_class($except));
		$this->assertEquals($statusCode, $except->getCode());
	}

	public function testFactoryProvider()
	{
		return [
			[
				401, "Error", CouchUnauthorizedException::class
			],
			[
				403, "Error", CouchForbiddenException::class
			],
			[
				404, "Error", CouchNotFoundException::class
			],
			[
				417, "Error", CouchExpectationException::class
			],
			[
				0, "Error", CouchException::class
			],
			[
				0, "Conflict", CouchConflictException::class
			]
		];
	}

	/**
	 * @covers PHPOnCouch\Exceptions\CouchException::getBody
	 */
	public function testGetBody()
	{
		$bodyStr = "{\"error\":\"unauthorized\",\"reason\":\"You are not a server admin.\"}";
		$response = $this->httpResponseMock("404", $bodyStr, 'Unauthorized', "application/json");
		$except = new CouchException($response);
		$body = $except->getBody();
		$this->assertEquals((array) $body, json_decode($bodyStr, true));
	}

	/**
	 * @covers PHPOnCouch\Exceptions\CouchException::parseRawResponse
	 */
	public function testParseRawResponse()
	{
		//Response code
		$mockCode = $this->httpResponseMock("202");
		$resultCode = CouchException::parseRawResponse($mockCode);
		$this->assertEquals($resultCode['status_code'], '202');
		$this->assertEquals($resultCode['status_message'], 'OK');
		$this->assertEquals($resultCode['body'], null);

		//Body
		$body1 = "{\"name\":\"value\"}";
		$mockBody1 = $this->httpResponseMock("200", $body1, "OK", "application/json");
		$resultBody1 = CouchException::parseRawResponse($mockBody1, true);
		$this->assertEquals($resultBody1['status_code'], '200');
		$this->assertEquals($resultBody1['status_message'], 'OK');
		$this->assertEquals($resultBody1['body'], json_decode($body1, true));

		$body2 = "justastring";
		$mockBody2 = $this->httpResponseMock("200", $body2, "OOPS");
		$resultBody2 = CouchException::parseRawResponse($mockBody2, true);
		$this->assertEquals($resultBody2['status_message'], 'OOPS');
		$this->assertEquals($resultBody2['body'], $body2);


		$this->expectException("InvalidArgumentException");
		CouchException::parseRawResponse("");
	}

}
