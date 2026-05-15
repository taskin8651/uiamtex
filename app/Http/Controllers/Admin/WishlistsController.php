<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWishlistRequest;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;
use App\Models\EndUser;
use App\Models\Product;
use App\Models\Wishlist;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WishlistsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('wishlist_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Wishlist::with(['user', 'product'])->select(sprintf('%s.*', (new Wishlist)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'wishlist_show';
                $editGate      = 'wishlist_edit';
                $deleteGate    = 'wishlist_delete';
                $crudRoutePart = 'wishlists';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'product']);

            return $table->make(true);
        }

        return view('admin.wishlists.index');
    }

    public function create()
    {
        abort_if(Gate::denies('wishlist_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = EndUser::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.wishlists.create', compact('products', 'users'));
    }

    public function store(StoreWishlistRequest $request)
    {
        $wishlist = Wishlist::create($request->all());

        return redirect()->route('admin.wishlists.index');
    }

    public function edit(Wishlist $wishlist)
    {
        abort_if(Gate::denies('wishlist_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = EndUser::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wishlist->load('user', 'product');

        return view('admin.wishlists.edit', compact('products', 'users', 'wishlist'));
    }

    public function update(UpdateWishlistRequest $request, Wishlist $wishlist)
    {
        $wishlist->update($request->all());

        return redirect()->route('admin.wishlists.index');
    }

    public function show(Wishlist $wishlist)
    {
        abort_if(Gate::denies('wishlist_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wishlist->load('user', 'product');

        return view('admin.wishlists.show', compact('wishlist'));
    }

    public function destroy(Wishlist $wishlist)
    {
        abort_if(Gate::denies('wishlist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wishlist->delete();

        return back();
    }

    public function massDestroy(MassDestroyWishlistRequest $request)
    {
        $wishlists = Wishlist::find(request('ids'));

        foreach ($wishlists as $wishlist) {
            $wishlist->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
