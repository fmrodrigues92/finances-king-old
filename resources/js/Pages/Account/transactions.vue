<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';

defineProps({
    transactions: Array,
    sum: Number,
});

//array from 2022 to 2050
const years = Array.from({ length: 10 }, (v, k) => k + 2022);

//array from jan to dec
const months = Array.from({ length: 12 }, (v, k) => k + 1);


//current mount
const currentMonth = new Date().getMonth() + 1;

//current year
const currentYear = new Date().getFullYear();

//capitalize first letter
const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

//====================
//====================

//get all url params
const urlParams = new URLSearchParams(window.location.search);

//current month params in url querystring
const monthUrl = urlParams.get('month');

//current year params in url
const yearUrl = urlParams.get('year');

</script>

<template>
    <Head title="Account transactions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight">Account transactions</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">

                        <div class="flex justify-between">
                            <form method="GET">
                                <div class="flex mb-6">
                                    <div class="flex flex-col">
                                        <label for="month" class="text-sm font-medium text-gray-700">Mês</label>
                                        <select name="month" id="month">
                                            <option value="">Selecione um...</option>
                                            <option class="uppercase" v-for="month in months" :selected="(monthUrl === null && currentMonth == month) || (monthUrl == month)" :value="month">
                                                {{ capitalizeFirstLetter( new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(new Date(2021, month - 1, 1)) ) }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col ml-2 mr-2">
                                        <label for="year" class="text-sm font-medium text-gray-700">Ano</label>
                                        <select name="year" id="year">
                                            <option value="">Selecione um...</option>
                                            <option v-for="year in years" :selected="(yearUrl === null && currentYear == year) || (yearUrl == year)">{{ year }}</option>
                                        </select>
                                    </div>
                                    <!-- submit -->
                                    <div class="flex flex-col justify-end">
                                        <button type="submit" class="px-6 py-3 text-sm bg-zinc-600 text-white hover:bg-zinc-700 rounded-lg transition duration-100 ease-in-out">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="flex flex-col justify-center">
                                <h1 class="text-xl font-extrabold float-right text-gray-700 ml-2">{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(sum) }}</h1>
                            </div>
                        </div>

                        <hr class="mb-4 mt-4" />

                        <div>
                            <a href="#" class="float-right px-5 py-2 text-sm bg-zinc-600 text-white hover:bg-zinc-700 rounded-lg transition duration-100 ease-in-out">Adicionar Transação</a>
                        </div>

                        <div class="min-w-full flex flex-col mt-6">
                            <table class="table-auto" >
                                <thead>
                                    <tr class="bg-zinc-700 text-white">
                                        <th class="text-sm font-medium px-6 py-4 text-left">#</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Nome</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Valor</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Data</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr class="border-t border-slate-300 " v-for="transaction in transactions">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium w-10">{{ transaction.id }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ transaction.name }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(transaction.amount) }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ transaction.date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
