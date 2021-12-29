<?php

require_once 'App/Lib/Path.php';

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{

    /**
     * @covers Path::get_path
     * @covers Path::array_to_string
     */
    public function testGetPath_model()
    {
        self::assertStringEndsWith("/Model/Grid.php", Path::get_path("m", "Grid"));
        self::assertStringEndsWith("/Model/messages/MessageAdapter.php", Path::get_path("m", ["messages", "MessageAdapter"]));
    }

    /**
     * @covers Path::get_path
     * @covers Path::array_to_string
     */
    public function testGetPath_lib()
    {
        self::assertStringEndsWith("/Lib/Config.php", Path::get_path("l", "Config"));
    }

    /**
     * @covers Path::get_path
     * @covers Path::array_to_string
     */
    public function testGetPath_controller()
    {
        self::assertStringEndsWith("/Controller/APIController.php", Path::get_path("c", "APIController"));
    }

    /**
     * @covers Path::get_path
     * @covers Path::array_to_string
     */
    public function testGetPath_view()
    {
        self::assertStringEndsWith("/view/template.php", Path::get_path("v", "template"));
    }

    /**
     * @covers Path::get_path
     * @covers Path::array_to_string
     */
    public function testGetPath_edgeCase_badType()
    {
        $this->expectException("RuntimeException");
        Path::get_path("badtype", "File");
    }
}
