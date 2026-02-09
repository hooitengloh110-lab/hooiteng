<?php
namespace App\Algorithms;

use Illuminate\Support\Facades\Log;

class PrimeSieve
{
    public function generate(int $limit): array
    {
        if ($limit < 2) return [];

        $sieve = array_fill(0, $limit + 1, true);
        $sieve[0] = $sieve[1] = false;

        for ($i = 2; $i * $i <= $limit; $i++) {
            if ($sieve[$i]) {
                for ($j = $i * $i; $j <= $limit; $j += $i) {
                    $sieve[$j] = false;

                }

            }
        }

        $primes = [];
        for ($i = 2; $i <= $limit; $i++) {
            if ($sieve[$i]) $primes[] = $i;
        }

        return $primes;
    }
}
