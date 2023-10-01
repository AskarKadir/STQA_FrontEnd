<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index()
    {
        $orders = Order::orderByRaw("FIELD(status,
                'menunggu pembayaran',
                'diproses',
                'ditolak',
                'selesai') ASC")->get();
        return response()->json([
            'status' => 'success',
            'data'   => $orders
        ], 200);
    }

    function store(Request $request)
    {
        $order = Order::create([
            'user_id' => User::where('username', $request->user_id)
                ->orWhere('email', $request->user_id)
                ->get()->first()->id,
            'menu_id' => $request->menu_id,
            'jumlah'  => $request->jumlah,
            'total'   => $request->total,
            'status'  => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $order
        ], 201);
    }

    function update(Request $request, $id)
    {
        $order = Order::find($id);
        $total = $request->jumlah * $order->menu->price;
        $order->update([
            'menu_id' => $request->menu_id,
            'jumlah'  => $request->jumlah,
            'total'   => $total,
            'status'  => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $order
        ], 200);
    }

    function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return response()->json([
            'status' => 'success',
            'data'   => $order
        ], 200);
    }

    function search(Request $request)
    {
        $keyword = $request->keyword;
        $orders  = Order::where('menu_id', 'like', "%" . $keyword . "%")
            ->orWhere('qty', 'like', "%" . $keyword . "%")
            ->orWhere('total', 'like', "%" . $keyword . "%")
            ->orWhere('status', 'like', "%" . $keyword . "%")
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $orders
        ], 200);
    }

    function indexuser(Request $request)
    {
        // get id from username
        $user   = User::where('username', $request->username)->first();
        $orders = Order::where('user_id', $user->id)->orderByRaw("FIELD(status,
                'menunggu pembayaran',
                'diproses',
                'ditolak',
                'selesai') ASC")->get();
        // sort by status from menunggu pembayaran, diproses, ditolak, selesai

        return response()->json([
            'status' => 'success',
            'data'   => $orders
        ], 200);
    }

    function incoming(Request $request)
    {
        $orders = Order::where('status', 'menunggu pembayaran')
            ->orWhere('status', 'diproses')
            ->orderByRaw("FIELD(status,
            'menunggu pembayaran',
            'diproses') ASC")
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $orders
        ], 200);
    }

    function done(Request $request)
    {
        $today  = Carbon::now()->format('Y-m-d');
        $orders = Order::where('status', 'selesai')
            ->where('updated_at', 'like', "%" . $today . "%")
            ->get();
        return response()->json([
            'status' => 'success',
            'data'   => $orders,
        ], 200);
    }

    function totalitemssales(Request $request)
    {
        $totalitems = Order::where('status', 'selesai')->sum('jumlah');
        return response()->json([
            'status' => 'success',
            'data'   => $totalitems,
        ], 200);
    }

    function totalsales(Request $request)
    {
        $totalsales = Order::where('status', 'selesai')->sum('total');
        return response()->json([
            'status' => 'success',
            'data'   => $totalsales,
        ], 200);
    }
}