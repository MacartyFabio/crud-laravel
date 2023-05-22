@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Data de Entrega</th>
                <th>Valor do Frete</th>
                <th>Data do pedido</th>
                <th>Data da Última Atualização do Pedido</th>
                <th>Usuário</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $order->freight_value }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $order->user_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
