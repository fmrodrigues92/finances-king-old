<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';

defineProps({
    credit_cards: Array,
});
</script>

<template>
    <Head title="Credit Cards" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight">Credit Cards</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">

                        <div>
                            <a href="#" class="float-right px-5 py-2 text-sm bg-zinc-600 text-white hover:bg-zinc-700 rounded-lg transition duration-100 ease-in-out">Adicionar Cartão</a>
                        </div>

                        <div class="min-w-full flex flex-col mt-6">
                            <table class="table-auto" >
                                <thead>
                                    <tr class="bg-zinc-700 text-white">
                                        <th class="text-sm font-medium px-6 py-4 text-left">#</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Nome</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Limite</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Fechamento</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Vencimento</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Ações</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr class="border-t border-slate-300 " v-for="credit_card in credit_cards">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium w-10">{{ credit_card.id }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ credit_card.name }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(credit_card.limit) }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ credit_card.closing_day }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ credit_card.payment_day }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap w-30">
                                            <a :href="route('credit-card.transactions.index', credit_card.id)" class="text-indigo-600 hover:text-indigo-900">Abrir</a>
                                            <a href="#" class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <a href="#" class="ml-4 text-indigo-600 hover:text-indigo-900">Excluir</a>
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
