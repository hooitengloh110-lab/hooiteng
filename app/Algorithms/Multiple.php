<?php
namespace App\Algorithms;

use Illuminate\Support\Facades\Log;

class Multiple
{
    public function generate(int $num, int $num2)
    {
        if ($num == 0 && $num2 == 0) return 0;

        $mul = $num * $num2;

        return $mul;
    }
}
