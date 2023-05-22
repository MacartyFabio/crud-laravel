@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <br>
    <div class="flex justify-center">
        <div class="container mx-auto mt-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <p class="text-lg font-semibold text-gray-500">Id: {{ $order->id }}</p>
                    <p class="text-lg font-semibold text-gray-500">Data de Entrega: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y H:i:s') }}</p>
                    <p class="text-lg font-semibold text-gray-500">Valor do Frete: {{ $order->freight_value }}</p>
                    <p class="text-lg font-semibold text-gray-500">Data do Pedido: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</p>
                    <p class="text-lg font-semibold text-gray-500">Data da Última Atualização do Pedido: {{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            <br>
            <div class="flex justify-between">
                <x-primary-button>
                    <a href="{{ route('orders.edit', $order->id) }}">Editar</a>
                </x-primary-button>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-danger-button>Excluir</x-danger-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

