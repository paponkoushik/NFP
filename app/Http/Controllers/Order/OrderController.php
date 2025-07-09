<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Enums\UserRoles;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\InvoiceService;
use App\Actions\Filters\OrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->service = $invoiceService;
    }

    public function index(): View
    {
        return view('orders.index');
    }

    public function invoice(string $id): View
    {
        $invoice = $this->service->getInvoiceDetails($id);

        return view('orders.invoice', compact('invoice'));
    }

    public function invoicePdf(Request $request): View
    {
        $invoice = $this->service->getInvoiceDetails($request->id);

        if ($request->has('download')) {
            $pdf = Pdf::loadView('orders.invoice-download', compact('invoice'));
            return $pdf->download('invoice-' . date('d-m-Y') . '.pdf');
        }

        return view('orders.invoice', compact('invoice'));
    }

    public function checkout(): View
    {
        return view('orders.checkout');
    }

    public function getAllOrders(OrderFilter $filters): AnonymousResourceCollection
    {
        $user = auth()->user();

        $query = Order::with('orderDetails');

        if ($user->role !== UserRoles::NfpAdmin->value && $user->role !== UserRoles::SuperAdmin->value) {
            $query->where('user_id', $user->id);
        }
        $query->filter($filters);

        $orders = $query->latest()->paginate(request('limit') ?? PAGINATE_LIMIT);

        return OrderResource::collection($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'document_id' => 'required',
        ]);

        try {
            $documentIds = session('cart_documents') ?? [];
            if (in_array($request->document_id, $documentIds) === true) {
                return response()->json(['message' => 'Document already exists in cart!'], 500);
            }

            array_push($documentIds, $request->document_id);
            session(['cart_documents' => $documentIds]);

            return response()->json(['message' => 'Document successfully added in cart.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string | int $id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z_-]*$/|unique:tags,name,' . $id . '',
        ], $this->message());

        try {
            Tag::findOrFail($id)->update($request->only('name'));
            Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully updated."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL], 500);
        }
    }

    public function destroy(int | string $id): JsonResponse
    {
        try {
            Tag::findOrFail($id)->delete();
            Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    protected function message(): array
    {
        return [
            'name.regex' => 'The :attribute field can contain alphabetic character, dash and underscore.',
        ];
    }
}
