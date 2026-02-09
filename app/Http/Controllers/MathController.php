<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Algorithms\PrimeSieve;
use App\Algorithms\Fibonacci;
use App\Models\Primes;
use App\Models\Fibonacci as Fib;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

        $result = $primeSieve->generate((int)$limit); 
        $data = Primes::where('value', $limit)->whereNull('deleted_at')->orderBy('id','desc')->first();
        if (!$data) {
            $data = new Primes;
        }
        $data->value = $limit;
        $data->result = json_encode($result);
        $data->save();
        
        return response()->json([
            'limit' => (int)$limit,
            'primes' => $result,
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

        $recursive = $fibonacci->nthFib($n);
        $iterative = $fibonacci->nthFibIterative($n);
        Log::info("Result");

        $data = Fib::where('value', (int)$n)->whereNull('deleted_at')->orderBy('id', 'desc')->first();
        if(!$data) {
            $data = new Fib;
        }
        $data->value = (int)$n;
        $data->recursive = json_encode($recursive);
        $data->iterative = json_encode($iterative);
        $data->save();

        return response()->json([
            'n' => (int)$n,
            'recursive' => $recursive,
            'iterative' => $iterative,
        ]);
    }

    public function getList(Request $request) {
        $fibPage = $request->input('fib_page', 1);
        $primePage = $request->input('prime_page', 1);
        $perPage = $request->input('per_page', 10);

        $fibonacci = Fib::whereNull('deleted_at')->orderBy('id', 'desc')->paginate($perPage, ['*'], 'fib_page', $fibPage);
        $primes = Primes::whereNull('deleted_at')->orderBy('id', 'desc')->paginate($perPage, ['*'], 'prime_page', $primePage);

        return response()->json([
            'fibonacci' => $fibonacci,
            'primes' => $primes
        ]);
    }
}
