<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Algorithms\PrimeSieve;
use App\Algorithms\Fibonacci;
use Illuminate\Support\Facades\Validator;

class MathController extends Controller
{
    public function primes(Request $request, PrimeSieve $primeSieve)
    {        
        $limit = $request->query('limit', 50);
        if (!is_numeric($limit) || $limit < 2) {
            return response()->json(['error' => 'Value must be greater than or equal to 2'], 400);
        }
        if($limit > 100000) {
            return response()->json(['error' => 'Limit too large (MAX 100000 for Primes)'], 400);
        }

        return response()->json([
            'limit' => (int)$limit,
            'primes' => $primeSieve->generate((int)$limit)
        ]);
    }

    public function fibonacci(Request $request, Fibonacci $fibonacci)
    {
        $n = $request->query('n', 10);
        if (!is_numeric($n)) {
            return response()->json(['error' => 'Value must be a number'], 400);
        }
        if ($n > 92) {
            return response()->json(['error' => 'N too large (MAX 92 for Fibonacci)'], 400);
        }

        return response()->json([
            'n' => (int)$n,
            'recursive' => $fibonacci->nthFib($n),
            'iterative' => $fibonacci->nthFibIterative($n),
        ]);
    }
}
