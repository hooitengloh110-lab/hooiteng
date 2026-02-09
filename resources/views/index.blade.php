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
<div id="app" class="relative max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6 text-center">Math Calculation App</h1>

    <!-- Tabs -->
    <div class="flex mb-4">
        <button @click="tab='primes'" :class="tab==='primes' ? 'bg-slate-500 text-white' : 'bg-gray-200 text-gray-700'" 
                class="px-4 py-2 rounded-l transition-colors">
            Primes
        </button>
        <button @click="tab='fibonacci'" :class="tab==='fibonacci' ? 'bg-slate-500 text-white' : 'bg-gray-200 text-gray-700'"
                class="px-4 py-2 rounded-r transition-colors">
            Fibonacci
        </button>
    </div>

    <!-- Primes Tab -->
    <div v-if="tab==='primes'">
        <form @submit.prevent="getPrimes">
            <label class="block mb-2 font-semibold">Limit:</label>
            <input type="number" v-model.number="primeLimit" class="border p-2 rounded w-full mb-4" min="2" max="100000">
            <button :disabled="loading" class="bg-blue-900 text-white px-4 py-2 rounded">Calculate</button>
        </form>
        <div v-if="errorP" class="mt-4 text-red-500">@{{ errorP }}</div>

        <!-- Result -->
        <div v-if="primes.length" class="mt-4 break-words">
            <div class="font-semibold mb-3">Result : </div>
            <span v-for="(num, index) in primes" :key="index" class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ num }}
            </span>
        </div>
    </div>

    <!-- Fibonacci Tab -->
    <div v-if="tab==='fibonacci'">
        <form @submit.prevent="getFibonacci">
            <label class="block mb-2 font-semibold">N:</label>
            <input type="number" v-model.number="fibN" class="border p-2 rounded w-full mb-4" max=92>
            <button @click="getFibonacci" class="bg-blue-900 text-white px-4 py-2 rounded">Calculate</button>
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
        <div v-if="iterList.length" class="mt-4 break-words">
            <span v-for="(num, index) in iterList" :key="index" class="inline-block bg-gray-200 px-2 py-1 rounded mr-1 mb-1">
                @{{ num }}
            </span>
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

createApp({
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
        const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

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

        return {
            tab,
            primeLimit,
            fibN,
            primes,
            fibonacci,
            fibonacciList,
            iterValue,
            iterList,
            loading,
            errorP,
            errorF,
            getPrimes,
            getFibonacci
        };
    }
}).mount('#app');

</script>


</body>
</html>