<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\BankInformation;
use App\Models\FootballPitch;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $title = "Trang chủ";
        $footballPitches = FootballPitch::query()->with('pitchType')->with('images')->get();
        $dateTimeDay = [
            'start' => new Carbon(),
            'end' => new Carbon(),
        ];
        $dateTimeDay['start']->startOfDay();
        $dateTimeDay['end']->endOfDay();
        $dateTimeMonth = [
            'start' => new Carbon(),
            'end' => new Carbon(),
        ];
        $dateTimeMonth['start']->startOfMonth();
        $dateTimeMonth['end']->endOfMonth();

        $orders = Order::query()->whereBetween('created_at', [
            $dateTimeDay['start']->toDateTimeString(),
            $dateTimeDay['end']->toDateTimeString(),
        ])->with('footballPitch')->where('status', '>=', OrderStatusEnum::Finish)->get([
            'name',
            'football_pitch_id',
            'start_at',
            'end_at',
        ]);

        $orderWithMonth = Order::query()->whereBetween('created_at', [
            $dateTimeMonth['start']->toDateTimeString(),
            $dateTimeMonth['end']->toDateTimeString(),
        ])->with('footballPitch')->where('status', '>=', OrderStatusEnum::Finish)->get([
            'name',
            'football_pitch_id',
            'start_at',
            'end_at',
        ]);
        return view('client.home.index', [
            'title' => $title,
            'footballPitches' => $footballPitches,
            'orders' => $orders,
            'orderWithMonth' => $orderWithMonth,
        ]);
    }

    public function footballPitchDetail(string $id)
    {
        $title = "Chi tiết sân bóng";
        $footballPitch = FootballPitch::query()->with('pitchType')->with('images')->with('orders')->find($id);
        return view('client.home.footballPitchDetail', [
            'title' => $title,
            'footballPitch' => $footballPitch,
        ]);
    }

    public function checkout(string $id)
    {
        $title = "Thông tin đặt sân";
        $order = Order::query()->with('footballPitch')->where('status', OrderStatusEnum::Wait)->find($id);
        if (!$order) {
            return to_route('client.index');
        }
        $bankInfo = BankInformation::query()->where('isShow', 1)->get();
        return view('client.home.checkout', [
            'title' => $title,
            'order' => $order,
            'bankInfo' => $bankInfo,
        ]);
    }

    public function findOrderByCode(Request $request)
    {
        $title = "Tra cứu";
        $order = Order::query()->where('code', $request->get('code'))->get()->first();
        $status = [];
        if ($order) {
            switch ($order->status) {
                case OrderStatusEnum::Cancel:
                    $status['message'] = 'Đã hủy';
                    $status['bg'] = 'danger';
                    break;
                case OrderStatusEnum::Wait:
                    $status['message'] = 'Chờ xử lý';
                    $status['bg'] = 'warning';
                    break;
                case OrderStatusEnum::Finish:
                    $status['message'] = 'Đặt sân thành công';
                    $status['bg'] = 'success';
                    break;
                case OrderStatusEnum::Paid:
                    $status['message'] = 'Đã thanh toán';
                    $status['bg'] = 'info';
                    break;
            }
        }
        return view('client.home.findOrderByCode', [
            'title' => $title,
            'order' => $order,
            'status' => $status,
            'code' => $request->get('code')
        ]);
    }

    public function profile()
    {
        $title = "Cá nhân";
        $user = auth()->user();

        return view('client.home.profile', [
            'title' => $title,
            'user' => $user,
        ]);
    }

    public function orderByMe()
    {
        $title = "Đặt sân";
        $user = auth()->user();
        $orders = Order::query()->where('by_user_id', $user->id)->orderByDesc('updated_at')
            ->with('footballPitch')->paginate(5);
        return view('client.home.order_by_me', [
            'title' => $title,
            'orders' => $orders,
        ]);
    }
}
