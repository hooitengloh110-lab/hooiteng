<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Math Calculation App</title>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="p-6 bg-gray-50">
<div id="app" class="relative mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6 text-center">Math Calculation App</h1>

    <!-- Tabs -->
    <div class="flex mb-4">
        <button @click="tab='primes'" :class="tab==='primes' ? 'bg-slate-500 text-white' : 'bg-gray-200 text-gray-700'" 
                class="px-4 py-2 rounded-l transition-colors">
            Primes
        </button>
        <button @click="tab='fibonacci'" :class="tab==='fibonacci' ? 'bg-slate-500 text-white' : 'bg-gray-200 text-gray-700'"
                class="px-4 py-2 transition-colors">
            Fibonacci
        </button>
        <button @click="tab='multiple'" :class="tab==='multiple' ? 'bg-slate-500 text-white' : 'bg-gray-200 text-gray-700'"
                class="px-4 py-2 rounded-r transition-colors">
            Multiple
        </button>
    </div>

    <!-- Primes Tab -->
    <div v-if="tab==='primes'">
        <form @submit.prevent="getPrimes">
            <label class="block mb-2 font-semibold">Limit:</label>
            <input type="number" v-model.number="primeLimit" class="border p-2 rounded w-80 mb-4" min="2" max="100000">
            <button :disabled="loading" class="bg-blue-900 text-white px-4 py-2 rounded ml-3">Calculate</button>
        </form>
        <div v-if="errorP" class="mt-4 text-red-500">@{{ errorP }}</div>

        <!-- Result -->
        <div v-if="primes.length" class="mt-4 break-words mb-4">
            <div class="font-semibold mb-3">Result : </div>
            <span v-for="(num, index) in primes" :key="index" class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ num }}
            </span>
        </div>

        <!-- Primes Table -->
        <button @click="getPrimesAll" class="bg-blue-900 text-white px-4 py-2 rounded mb-4 mt-2">Load Primes</button>

        <table v-if="primesAll.length" class="border-collapse border border-gray-400 w-full">
            <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-400 px-2 py-1">Prime</th>
                <th class="border border-gray-400 px-2 py-1">Result</th>
                <th class="border border-gray-400 px-2 py-1">Created At</th>
                <th class="border border-gray-400 px-2 py-1">Updated At</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="prime in primesAll" :key="prime.id">
                <td class="border border-gray-400 px-2 py-1">@{{ prime.value }}</td>
                <td class="border border-gray-400 px-2 py-1">@{{ prime.result.join(', ') }}</td>
                <td class="border border-gray-400 px-2 py-1 text-center">@{{ formatDate(prime.created_at) }}</td>
                <td class="border border-gray-400 px-2 py-1 text-center">@{{ formatDate(prime.updated_at) }}</td>
            </tr>
            </tbody>
        </table>
        
    </div>

    <!-- Fibonacci Tab -->
    <div v-if="tab==='fibonacci'">
        <form @submit.prevent="getFibonacci">
            <label class="block mb-2 font-semibold">N:</label>
            <input type="number" v-model.number="fibN" class="border p-2 rounded w-80 mb-4" max=92>
            <button @click="getFibonacci" class="bg-blue-900 text-white px-4 py-2 rounded ml-3">Calculate</button>
        </form>
        <div v-if="errorF" class="mt-4 text-red-500">@{{ errorF }}</div>

        <!-- Result -->
        <div v-if="fibonacci.length" class="mt-4 break-words">
            <span class="font-semibold">Recursive : </span>@{{ fibonacci }}
        </div>

        <div v-if="fibonacciList.length" class="mt-4 break-words">
            <span v-for="(num, index) in fibonacciList" :key="index" class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ num }}
            </span>
        </div>

        <div v-if="iterValue.length" class="mt-4 break-words">
            <span class="font-semibold">Iterative : </span>@{{ iterValue }}
        </div>
        <div v-if="iterList.length" class="mt-4 break-words mb-4">
            <span v-for="(num, index) in iterList" :key="index" class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ num }}
            </span>
        </div>

        <!-- Fibonacci Table -->
        <button @click="getFibonacciAll" class="bg-blue-900 text-white px-4 py-2 rounded mb-4 mt-2">Load Fibonacci</button>

        <table v-if="fibonacciAll.length" class="border-collapse border border-gray-400 w-full">
            <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-400 px-2 py-1">Fibonacci</th>
                <th class="border border-gray-400 px-2 py-1">Recursive Value</th>
                <th class="border border-gray-400 px-2 py-1">Recursive List</th>
                <th class="border border-gray-400 px-2 py-1">Iterative Value</th>
                <th class="border border-gray-400 px-2 py-1">Iterative List</th>
                <th class="border border-gray-400 px-2 py-1">Created At</th>
                <th class="border border-gray-400 px-2 py-1">Updated At</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="fib in fibonacciAll" :key="fib.id">
                <td class="border border-gray-400 px-2 py-1">@{{ fib.value }}</td>
                <td class="border border-gray-400 px-2 py-1">@{{ fib.recursive.value }}</td>
                <td class="border border-gray-400 px-2 py-1">@{{ fib.recursive.list.join(', ') }}</td>
                <td class="border border-gray-400 px-2 py-1">@{{ fib.iterative.value }}</td>
                <td class="border border-gray-400 px-2 py-1">@{{ fib.iterative.list.join(', ') }}</td>
                <td class="border border-gray-400 px-2 py-1 text-center">@{{ formatDate(fib.created_at) }}</td>
                <td class="border border-gray-400 px-2 py-1 text-center">@{{ formatDate(fib.updated_at) }}</td>
            </tr>
            </tbody>
        </table>

    </div>

    <div v-if="tab==='multiple'">
        <form @submit.prevent="getMultiple">
            <label class="block mb-2 font-semibold">Input:</label>
            <input type="number" v-model.number="multipleLimit" class="border p-2 rounded w-80 mb-4" min="2" max="100000">
            <input type="number" v-model.number="multipleLimit2" class="border p-2 rounded w-80 mb-4" min="2" max="100000">
            <button :disabled="loading" class="bg-blue-900 text-white px-4 py-2 rounded ml-3">Calculate</button>
        </form>
        <div v-if="errorM" class="mt-4 text-red-500">@{{ errorM }}</div>

        <!-- Result -->
        <div v-if="multiple" class="mt-4 break-words mb-4">
            <div class="font-semibold mb-3">Result : </div>
            <span class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ multiple }}
            </span>
        </div>
        
    </div>

    <div v-if="showNoRecordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @click="showNoRecordModal = false">
        <div class="bg-white rounded-lg w-96 shadow-lg">
            <div class="px-4 py-3 border-b">
                <h5 class="text-lg font-semibold">Information</h5>
            </div>

            <div class="px-4 py-4 text-center">
                No records found
            </div>

            <div class="px-4 py-3 border-t text-right">
                <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700" @click="showNoRecordModal = false">
                    Close
                </button>
            </div>
        </div>
    </div>

    <div v-if="loading" class="absolute inset-0 bg-white/70 flex items-center justify-center rounded">
        <svg class="animate-spin h-10 w-10 text-blue-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    </div>

</div>

<script>

const { createApp, ref } = Vue;

const app = createApp({
    setup() {
        const tab = ref('primes');
        const primeLimit = ref(50);
        const fibN = ref(10);

        const primes = ref([]);
        const fibonacci = ref([]);
        const fibonacciList = ref([]);
        const iterValue = ref([]);
        const iterList = ref([]);
        const loading = ref(false);
        const errorP = ref('');
        const errorF = ref('');
        const errorM = ref('');
        const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));
        const showNoRecordModal = ref(false);

        const multiple = ref('');
        const multipleLimit = ref('');
        const multipleLimit2 = ref('');
        
        // Primes
        const primesAll = ref([]);
        const primePage = ref(1);
        const primeTotal = ref(0);

        // Fibonacci
        const fibonacciAll = ref([]);
        const fibPage = ref(1);
        const fibTotal = ref(0);

        const getPrimesAll = async () => {
            loading.value = true;
            try {
                const res = await axios.get('/api/math/all', {
                    params: { prime_page: primePage.value, per_page: 10 }
                });
                primesAll.value = res.data.primes.data;
                primeTotal.value = res.data.primes.total;

                showNoRecordModal.value = !res.data.primes.data || res.data.primes.data.length === 0;
            } catch (err) {
                loading.value = false;
                console.error(err);
            } finally {
                loading.value = false;
            }
        };

        const getFibonacciAll = async () => {
            loading.value = true;
            try {
                const res = await axios.get('/api/math/all', {
                    params: { fib_page: fibPage.value, per_page: 10 }
                });
                fibonacciAll.value = res.data.fibonacci.data;
                fibTotal.value = res.data.fibonacci.total;

                showNoRecordModal.value = !res.data.fibonacci.data || res.data.fibonacci.data.length === 0;
            } catch (err) {
                loading.value = false;
                console.error(err);
            } finally {
                loading.value = false;
            }
        };

        const formatDate = (utc) => {
            const d = new Date(utc);
            return d.toLocaleString('sv-SE', {
                timeZone: 'Asia/Kuala_Lumpur',
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace('T', ' ');
        };

        const getPrimes = async () => {
            loading.value = true;
            errorP.value = '';
            primes.value = [];
            const start = Date.now();

            try {
                const res = await axios.get('/api/math/primes', {
                    params: { 
                        limit: primeLimit.value 
                    }
                });
                primes.value = res.data.primes;
            } catch (err) {
                errorP.value = err.response?.data?.error || 'API Error';
            } finally {
                await sleep(300);    
                loading.value = false;
                
            }
        };

        const getFibonacci = async () => {
            loading.value = true;
            errorF.value = '';
            fibonacci.value = '';
            fibonacciList.value = [];
            iterValue.value = '';
            iterList.value = [];
            const start = Date.now();

            try {
                const res = await axios.get('/api/math/fibonacci', {
                    params: { 
                        n: fibN.value 
                    }
                });
                fibonacci.value = res.data.recursive.value.toString();
                fibonacciList.value = res.data.recursive.list;
                iterValue.value = res.data.iterative.value.toString();
                iterList.value = res.data.iterative.list;
            } catch (err) {
                errorF.value = err.response?.data?.error || 'API Error';
            } finally {
                await sleep(300);
                loading.value = false;
            }
        };

        const getMultiple = async () => {
            loading.value = true;
            errorM.value = '';
            multiple.value = '';

            try {
                const res = await axios.get('/api/math/multiple', {
                    params: { 
                        num: multipleLimit.value,
                        num2: multipleLimit2.value
                    }
                });
                multiple.value = res.data.multiple;
            } catch (err) {
                errorM.value = err.response?.data?.error || 'API Error';
            } finally {
                await sleep(300);    
                loading.value = false;
                
            }
        };

        return {
            tab,
            primeLimit,
            fibN,
            primes,
            fibonacci,
            fibonacciList,
            iterValue,
            iterList,
            getPrimes,
            getFibonacci,
            multiple,
            multipleLimit,
            multipleLimit2,
            getMultiple,

            loading,
            errorP,
            errorF,
            errorM,
            formatDate,
            showNoRecordModal,

            primesAll, primePage, primeTotal, getPrimesAll,
            fibonacciAll, fibPage, fibTotal, getFibonacciAll,
        };
    }
});
app.mount('#app');

</script>


</body>
</html>