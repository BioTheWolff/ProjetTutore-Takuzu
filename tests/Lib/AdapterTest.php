<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Adapter');

class AdapterTest extends TestCase
{

    const G = Adapter::GAP_PHP;

    private $message_full = "4:1010010101101001";
    private $grid_full = [
        [1, 0, 1, 0],
        [0, 1, 0, 1],
        [0, 1, 1, 0],
        [1, 0, 0, 1]
    ];

    private $message_partial = "4:1_0_00__11__0_1_";
    private $grid_partial = [
        [1, self::G, 0, self::G],
        [0, 0, self::G, self::G],
        [1, 1, self::G, self::G],
        [0, self::G, 1, self::G]
    ];

    public function testGrid_to_message()
    {
        self::assertEquals($this->message_full, Adapter::grid_to_message($this->grid_full));
        self::assertEquals($this->message_partial, Adapter::grid_to_message($this->grid_partial));
    }

    public function testMessage_to_grid()
    {
        self::assertEquals($this->grid_full, Adapter::message_to_grid($this->message_full));
        self::assertEquals($this->grid_partial, Adapter::message_to_grid($this->message_partial));
    }
}
