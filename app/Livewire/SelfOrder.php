<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Http;

class SelfOrder extends Component
{
    public $search = '';
    public $product;
    public $order;
    public $total_price;
    public $paid_amount;

    public function render()
    {
        $orderResponse = Http::get(route('api.orders.latest'));
        $productResponse = Http::get(route('api.products'), ['search' => $this->search]);

        $this->order = $orderResponse->json();
        $this->total_price = $this->order['total_price'] ?? 0;

        return view('livewire.self-order', [
            'products' => $productResponse->json(),
            'order' => $this->order
        ]);
    }   

    public function createOrder()
    {
        $this->order = Order::where('done_at', null)
                ->latest()
                ->first();

        if ($this->order ==  null) {
            $this->order = Order::create([
                'invoice_number' => $this->generateUniqueCode()
            ]);
        }
        session()->flash('message', 'Sukses mulai transaksi, silakan pilih produk.');
    }

    public function updateCart($productId, $isAdded = true)
    {
        try {
            if ($this->order) {
                $product = Product::findOrFail($productId);
                $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $productId)
                    ->first();
                
                if ($orderProduct) {
                    if ($isAdded) {
                        $orderProduct->increment('quantity', 1);
                    } else {
                        $orderProduct->decrement('quantity', 1);
                        if ($orderProduct->quantity < 1) {
                            $orderProduct->delete();
                            session()->flash('message', 'Produk berhasil dihapus dari keranjang');
                            return;
                        }
                    }
                    $orderProduct->save();
                } else {
                    if ($isAdded) {
                        OrderProduct::create([
                            'order_id' => $this->order->id,
                            'product_id' => $product->id,
                            'unit_price' => $product->selling_price,
                            'quantity' => 1
                        ]);
                    }
                }
                $this->total_price = $this->order->total_price ?? 0;

                session()->flash('message', $isAdded ? 'Produk berhasil ditambahkan' : 'Produk berhasil dihapus dari keranjang');
            } else {
                session()->flash('message', 'Klik Mulai Transaksi Dahulu');
            }
            
        } catch (ValidationException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function done()
    {
        if (!$this->order || $this->order->orderProducts->isEmpty()) {
            session()->flash('error', 'Keranjang masih kosong. Silakan masukkan menu pesanan terlebih dahulu.');
            return;
        }

        $this->validate([
            'paid_amount' => 'required|numeric|min:0'
        ]);

        if ($this->paid_amount < $this->total_price) {
            session()->flash('error', 'Uang yang dibayarkan kurang. Silakan masukkan jumlah yang benar.');
            return;
        }

        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'done_at' => now()
        ]);

        session()->flash('message', 'Order/Transaksi selesai');
        return redirect()->route('self-order');
    }

    function generateUniqueCode($length = 6) {
        $number = uniqid();
        $varray = str_split($number);
        $len = sizeof($varray);
        $uniq = array_slice($varray, $len-6, $len);
        $uniq = implode(",", $uniq);
        $uniq = str_replace(',', '', $uniq);

        return $uniq;
    }
}
