@php
    use Carbon\Carbon;
@endphp
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<x-app-layout>
    <div class="flex justify-center">
        <div class="container mx-auto mt-8">
            <div class="overflow-hidden mb-4">
                <form method="POST" action="{{ route('orders.import') }}" enctype="multipart/form-data" class="rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    <div class="mb-4 ml-2">
                        <label class="block text-white text-sm font-bold mb-2" for="file">Importar Pedidos:</label>
                        <input type="file" name="file" id="file" accept=".json,.csv" required class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <x-primary-button class="ml-2">
                            Importar Pedidos
                        </x-primary-button>
                    </div>
                </form>
            </div>
            <div class="mb-6 flex justify-between">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="flex">
                        <x-text-input type="text" name="search" placeholder="Pesquisar Pedido" class="border border-gray-300 rounded-l py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                        <x-primary-button class="ml-2">Buscar</x-primary-button>
                    </div>
                </form>
                <div>
                    <x-primary-button class="mb-4 justify-end">
                        <a href="{{ route('orders.export') }}">Exportar</a>
                    </x-primary-button>
                    <x-primary-button>
                        <a href="{{ route('orders.create') }}">Criar Pedido</a>
                    </x-primary-button>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Id</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data de Entrega</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Valor do Frete</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Criado em</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Atualizado em</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                        @foreach ($orders as $order)
                            @if (!is_numeric($search) || $order->id == $search)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500">
                                        <a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ str_replace('.',',',$order->freight_value) }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        @if ($order->delivery_date < $order->updated_at)
                                            Entregue
                                        @else
                                            Ativa
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-right">
                                            <x-primary-button class="mr-2">
                                                <a href="{{ route('orders.edit', $order->id) }}">Editar</a>
                                            </x-primary-button>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Excluir</x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
