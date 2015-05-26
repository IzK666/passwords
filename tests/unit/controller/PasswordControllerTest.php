<?php
namespace OCA\Passwords\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\Passwords\Service\NotFoundException;


class PasswordControllerTest extends PHPUnit_Framework_TestCase {

    protected $controller;
    protected $service;
    protected $userId = 'john';
    protected $request;

    public function setUp() {
        $this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
        $this->service = $this->getMockBuilder('OCA\Passwords\Service\PasswordService')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new PasswordController(
            'passwords', $this->request, $this->service, $this->userId
        );
    }

    public function testUpdate() {
        $password = 'just check if this value is returned correctly';
        $this->service->expects($this->once())
            ->method('update')
            ->with($this->equalTo(3),
                    $this->equalTo('title'),
                    $this->equalTo('content'),
                   $this->equalTo($this->userId))
            ->will($this->returnValue($password));

        $result = $this->controller->update(3, 'title', 'content');

        $this->assertEquals($password, $result->getData());
    }


    public function testUpdateNotFound() {
        // test the correct status code if no password is found
        $this->service->expects($this->once())
            ->method('update')
            ->will($this->throwException(new NotFoundException()));

        $result = $this->controller->update(3, 'title', 'content');

        $this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
    }

}