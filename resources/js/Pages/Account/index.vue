<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';

defineProps({
    accounts: Array,
});
</script>

<template>
    <Head title="Accounts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Banking Accounts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">

                        <div>
                            <a href="#" class="float-right">Adicionar Conta</a>
                        </div>

                        <div class="min-w-full flex flex-col mt-6">
                            <table class="table-auto border-slate-700 border" >
                                <thead>
                                    <tr>
                                        <th class="text-sm font-medium px-6 py-4 text-left">#</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Nome</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Saldo</th>
                                        <th class="text-sm font-medium px-6 py-4 text-left">Ações</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr class="border-t border-slate-700 " v-for="account in accounts">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium w-10">{{ account.id }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ account.name }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap">{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(account.balance) }}</td>
                                        <td class="text-sm font-light px-6 py-4 whitespace-nowrap w-30">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Editar</a>
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
