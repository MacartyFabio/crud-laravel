<x-app-layout>
    <div class="flex justify-center">
        <div class="container mx-auto mt-8">
            <form method="POST" action="{{ route('orders.update', $order->id) }}" class="shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <x-input-label class="block text-white text-sm font-bold mb-2" for="delivery_date" :value="__('Data do Pedido:')"/>
                    <x-text-input type="date" name="delivery_date" id="delivery_date" placeholder="Delivery Date" :value="\Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d')" required class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                </div>
                <div class="mb-4">
                    <x-input-label class="block text-white text-sm font-bold mb-2" for="freight_value" :value="__('Valor do Frete:')"/>
                    <x-text-input type="text" name="freight_value" id="freight_value" placeholder="Valor do Frete" :value="str_replace('.',',',$order->freight_value)" required class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-primary-button>
                        Atualizar Pedido
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
