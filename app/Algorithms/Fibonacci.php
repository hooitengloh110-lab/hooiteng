<?php
namespace App\Algorithms;

use Illuminate\Support\Facades\Log;

class Fibonacci
{
    private array $dp = [];
    private array $list = [];

    public function nthFib(int $n)
    {
        if ($n > 92) return [];

        $this->dp = array_fill(0, max(1, $n) + 1, -1);
        $this->list = [];

        if ($n <= 1) {
            return [
                'value' => $n,
                'list'  => [$n],
            ];
        }

        // greater than 2 will do calculation
        $value = $this->nthFibUtil($n);
        ksort($this->list);

        return [
            'value' => $value,
            'list'  => array_values($this->list),
        ];
    }

    public function nthFibUtil(int $n)
    {
        if ($n <= 1) {
            $this->list[$n] = $n;
            return $n;
        }
        
        if ($this->dp[$n] !== -1) {
            return $this->dp[$n];
        }

        $this->dp[$n] = $this->nthFibUtil($n - 1) + $this->nthFibUtil($n - 2);
        $this->list[$n] = $this->dp[$n];

        return $this->dp[$n];
    }

    public function nthFibIterative(int $n): array
    {
        if ($n <= 1) {
            return [
                'value' => $n,
                'list'  => [$n],
            ];
        }

        $list = [0, 1];
        $prev = 0;
        $curr = 1;

        for ($i = 2; $i <= $n; $i++) {
            $next = $prev + $curr;
            $list[] = $next;

            $prev = $curr;
            $curr = $next;
        }

        return [
            'value' => $curr,
            'list'  => $list,
        ];
    }
}
