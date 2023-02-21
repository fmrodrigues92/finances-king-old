<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    import { Head } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';

    import axios from 'axios';

    import { Chart, registerables } from "chart.js";
    import { LineChart } from 'vue-chart-3';
    Chart.register(...registerables);

    const props = defineProps({
        credit_card: Object,
        transactions: Array,
        sum: Number,
        days: Array,
        limit_used: Array
    });

    //capitalize first letter
    const capitalizeFirstLetter = (string) => {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    //====================

    const testData = {
      datasets: [
        {
          label: 'Gastos',
          data: props.limit_used,
          backgroundColor: '#77CEFF',
        }
      ],
    };


    //options
    const options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    };

    //====================
    //====================

    //array from 2022 to 2050
    const years = Array.from({ length: 10 }, (v, k) => k + 2022);

    //array from jan to dec
    const months = Array.from({ length: 12 }, (v, k) => k + 1);

    //====================

    //current mount
    const currentMonth = new Date().getMonth() + 1;

    //current year
    const currentYear = new Date().getFullYear();

    //====================

    //get all url params
    const urlParams = new URLSearchParams(window.location.search);

    //current month params in url querystring
    const monthUrl = urlParams.get('month');

    //current year params in url
    const yearUrl = urlParams.get('year');

    //====================
    //====================

    const refreshData = (response) => {

        router.get(route('credit-card.transactions.index', [props.credit_card.id]) + '?month=' + (monthUrl ?? currentMonth) + '&year=' + (yearUrl ?? currentYear));
    }
    //====================
    const toAdd = () => {
        //push new transaction prepend
        props.transactions.unshift({
            id: null,
            name: '',
            amount: 0,
            date_in: '',
            date_out: '',
            edit: true,
        });
    }

    const toEdit = (transaction) => {
        transaction.edit = true;
    }
    //====================
    const toCancel = (transaction) => {
        if(transaction.id === null) {
            props.transactions.shift();
        } else {
            transaction.edit = false;
        }
    }
    //====================
    const toSave = (transaction) => {

        if(transaction.id === null) {

            //call api to save
            axios.post(route('credit-card.transactions.store', [props.credit_card.id]) + '?month=' + (monthUrl ?? currentMonth) + '&year=' + (yearUrl ?? currentYear),
            {
                name: transaction.name,
                amount: transaction.amount,
                date_in: transaction.date_in,
                date_out: transaction.date_out,
            }).then(response => {
                transaction.edit = false;
                refreshData(response);
            });


        } else {

            //call api to save
            axios.put(
                route('credit-card.transactions.update', [props.credit_card.id, transaction.id]) + '?month=' + (monthUrl ?? currentMonth) + '&year=' + (yearUrl ?? currentYear),
                {
                    name: transaction.name,
                    amount: transaction.amount,
                    date_in: transaction.date_in,
                    date_out: transaction.date_out,
                }
            ).then(response => {
                transaction.edit = false;
                refreshData(response);
            });

        }

    }

    const toDelete = (transaction) => {

        //confirm
        if(!confirm('Tem certeza que deseja excluir?')) {
            return;
        }

        //call api to delete
        axios.delete(
            route('credit-card.transactions.destroy', [props.credit_card.id, transaction.id]) + '?month=' + (monthUrl ?? currentMonth) + '&year=' + (yearUrl ?? currentYear)
        ).then(response => {
            refreshData(response);
        });

        //remove from array
        props.transactions.splice(props.transactions.indexOf(transaction), 1);
    }

</script>

<template>
    <Head title="Credit Card Transactions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight">Credit Card Transactions</h2>
        </template>

        <div class="pt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex flex-col ">

                        <!-- Chart Here -->
                        <LineChart :chartData="testData" :options="options" />

                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 pb-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">

                        <div class="flex justify-between">
                            <form method="GET">
                                <div class="flex mb-6 flex-wrap">
                                    <div class="flex flex-col mr-2">
                                        <label for="month" class="text-sm font-medium text-gray-700">Mês</label>
                                        <select name="month" id="month">
                                            <option value="">Selecione um...</option>
                                            <option class="uppercase" v-for="month in months" :selected="(monthUrl === null && currentMonth == month) || (monthUrl == month)" :value="month">
                                                {{ capitalizeFirstLetter( new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(new Date(2021, month - 1, 1)) ) }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col mr-2">
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
                            <a href="javascript:void(0)" class="float-right px-5 py-2 text-sm bg-zinc-600 text-white hover:bg-zinc-700 rounded-lg transition duration-100 ease-in-out" @click="toAdd()">Adicionar Transação</a>
                        </div>

                        <div class="min-w-full flex flex-col mt-6 overflow-x-auto">
                            <table class="table-auto" >
                                <thead>
                                    <tr class="bg-zinc-700 text-white">
                                        <th class="text-sm font-medium px-6 py-4 text-left border">#</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left border">Nome</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left border">Valor</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left border">Data de Entrada</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left border">Data de Cancelamento</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left border text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr class="border-t border-slate-300 " v-for="(transaction, i) in props.transactions">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium w-10">
                                            <span v-if="transaction.edit != false">-</span>
                                            <span v-else>{{ transaction.id }}</span>
                                        </td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                                            <input v-if="transaction.edit != false" type="text" v-model="transaction.name" placeholder="Nome" />
                                            <span v-else>{{ transaction.name }}</span>
                                        </td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                                            <input v-if="transaction.edit != false" type="number" step="0.01" v-model="transaction.amount" />
                                            <span v-else>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(transaction.amount) }}</span>
                                        </td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                                            <input v-if="transaction.edit != false" type="date" v-model="transaction.date_in"  />
                                            <span v-else>{{ transaction.date_in }}</span>
                                        </td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                                            <div v-if="transaction.edit != false">
                                                <div class="flex flex-row">
                                                    <input type="date" v-model="transaction.date_out"  />
                                                </div>
                                            </div>
                                            <span v-else>{{ transaction.date_out ?? '-' }}</span>
                                        </td>
                                        <td  class="w-[53px]">
                                            <div v-if="transaction.edit == true" class="flex justify-center flex-row">
                                                <button  class="align-center py-2 px-2 bg-green-700 hover:bg-green-800 text-white rounded-md" @click="toSave(transaction)">Salvar</button>
                                                <button  class="align-center py-2 px-2 ml-1 bg-red-700 hover:bg-red-800 text-white rounded-md" @click="toCancel(transaction)">Cancelar</button>
                                            </div>
                                            <div v-else class="flex justify-center flex-row">
                                                <button class="align-center py-1 px-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md" @click="toEdit(transaction)">Editar</button>
                                                <button class="align-center py-1 px-2 ml-1 bg-red-600 hover:bg-red-700 text-white rounded-md" @click="toDelete(transaction)">Apagar</button>
                                            </div>
                                        </td>
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
