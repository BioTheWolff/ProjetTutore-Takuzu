<?php

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Config');

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    /**
     * @covers Config
     * @covers Path
     */
    public function testGet()
    {
        $this->assertThat(
            Config::getInstance()->get("test.my.string"),
            $this->logicalOr(
                $this->isNull(),
                $this->isType("string")
            )
        );
    }
}
