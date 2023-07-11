<?php

namespace App\Http\Controllers;

use App\Models\CopyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LendController extends Controller
{
    public function index(Request $request)
    {
        $q = \request()->get('query');
        $records = CopyUser::query();
        if ($q) {
            $records->where('user_id', 'like', '%'.$q)->orWhere('copy_id', 'like', '%'.$q);
        }

        return view('lends.index', ['records' => $records->paginate()]);
    }

    public function takeBackPage()
    {
        return view('lends.take-back-page');
    }

    public function takeBack(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'copy_id' => 'required|exists:copies,id',
        ]);

        if (! CopyUser::query()->where('returned', false)->where('user_id', $request->get('user_id'))->where('copy_id', $request->get('copy_id'))->exists()) {
            return redirect()->back()->withErrors('This user does not hold this copy');
        }
        try {
            CopyUser::query()->where('returned', false)->where('user_id', $request->get('user_id'))->where('copy_id', $request->get('copy_id'))->update(['returned' => true]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/lends/take-back-page')->withErrors($th->getMessage());
        }

        return redirect(route('admin.lends.index'));
    }

    public function borrowPage()
    {
        return view('lends.borrow-page');
    }

    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'copy_id' => 'required|exists:copies,id',
        ]);

        try {
            if (CopyUser::query()->where('returned', false)->where('copy_id', $request->get('copy_id'))->exists()) {
                return redirect()->back()->withErrors('This copy/book is already borrowed');
            }

            if (CopyUser::query()->where('returned', false)->where('user_id', $request->get('user_id'))->count() >= 3) {
                return redirect()->back()->withErrors('This user already has enough books!');
            }

            CopyUser::query()->create(['user_id' => $request->get('user_id'), 'copy_id' => $request->get('copy_id'), 'due_date' => now()->addWeeks(2)]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect(route('admin.lends.index'))->withErrors($th->getMessage());
        }

        return redirect(route('admin.lends.index'));
    }
}
