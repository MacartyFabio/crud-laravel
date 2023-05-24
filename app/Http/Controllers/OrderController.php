<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if (is_null($search)) {
            $orders = Order::orderByDesc('id')->get();
            return view('orders.index', compact('orders', 'search'));
        }

        $orders = Order::where(function ($query) use ($search) {
            $query->where('delivery_date', 'LIKE', '%' . $search . '%')
                ->orWhere('freight_value', 'LIKE', '%' . $search . '%');
        });

        if (is_numeric($search)) {
            $orders->orWhere('id', $search);
        }

        $orders = $orders->get();
        return view('orders.index', compact('orders','search'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        try{
            $order = new Order;
            $order->delivery_date = $request->input('delivery_date');
            $order->freight_value = str_replace(',','.',$request->input('freight_value'));
            $order->user_id = auth()->user()->id;
            $order->save();

            return redirect()->route('orders.index')->with('success', 'Pedido salvo com sucesso.');;
        }catch( \Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel salvar o pedido.']);
        }
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->withErrors(['error' => 'Não há aquivos importados.']);
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if ($extension !== 'json' && $extension !== 'csv') {
            return redirect()->back()->withErrors(['error' => 'Arquivo de tipo inválido. Somente JSON e CSV são permitidos.']);
        }

        $ordersData = $extension === 'json' ?
         json_decode(file_get_contents($file->getPathname()), true) :
         $this->parseCsvFile($file->getPathname());
        if (empty($ordersData) && !is_array($ordersData)) {
            return redirect()->back()->withErrors(['error' => 'formato inválido ou arquivo vazio.']);
        }
        foreach ($ordersData as $data) {
            if (isset($data['delivery_date']) && isset($data['freight_value'])) {
                $order = new Order();
                $order->delivery_date = Carbon::parse($data['delivery_date']);
                $order->freight_value = str_replace(',','.',$data['freight_value']);
                $order->user_id = auth()->user()->id;
                $order->save();
            }
        }
        return redirect()->route('orders.index')->with('success', 'Pedidos importadas com sucesso.');

    }

    private function parseCsvFile($filePath)
    {
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = null;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($handle);
        }

        return $data;
    }

    public function exportToPDF()
    {
        try {
            $orders = Order::all();
            $pdf = new Dompdf();
            $pdf->loadHtml(View::make('orders.export', compact('orders')));
            $pdf->render();
            $filename = 'pedidos.pdf';
            return $pdf->stream($filename);
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel exportar o pedido.']);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::find($id);
            if (!$order){
                throw new \Exception();
            }
            return view('orders.show', compact('order'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel encontrar o pedido.']);
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::find($id);
            if (!$order){
                throw new \Exception();
            }
            return view('orders.edit', compact('order'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel encontrar o pedido.']);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $order = Order::find($id);
            if (!$order){
                throw new \Exception('Não foi possivel encontrar o pedido.');
            }
            $order->delivery_date = $request->input('delivery_date');
            $order->freight_value = str_replace(',','.',$request->input('freight_value'));
            $order->save();

            return redirect()->route('orders.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel atualizar o pedido.']);
        }
    }

    public function destroy($id)
    {
        try{
            $order = Order::find($id);
            if (!$order){
                throw new \Exception('Não foi possivel encontrar o pedido.');
            }
            $order->delete();
            return redirect()->route('orders.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => 'Não foi possivel deletar o pedido.']);
        }
    }
}
