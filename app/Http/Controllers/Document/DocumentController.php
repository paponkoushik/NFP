<?php

namespace App\Http\Controllers\Document;

use App\Models\Order;
use App\Models\Document;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Filters\DocumentFilter;
use App\Http\Resources\DocumentResource;

class DocumentController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display tag listing view page.
     *
     * @return \Illuminate\Http\Response;
     */
    public function index()
    {
        return view('documents.index');
    }

    /**
     * Display tag listing view page.
     *
     * @return \Illuminate\Http\Response;
     */
    public function purchaseDocument()
    {
        return view('documents.purchase-document');
    }

    /**
     * Display a listing of the tags.
     *
     * @return \Illuminate\Http\Response;
     */
    public function getDocuments(DocumentFilter $filters)
    {

        $loggedInUserId = auth()->id();

        $documents = Document::loadRelation()
            ->where('price', 0)
            ->filter($filters)
            ->latest()
            ->paginate(request('limit') ?? PAGINATE_LIMIT);

        $userOrders = Order::where('user_id', $loggedInUserId)->with('orderDetails')->get();

        $documentIdsInUserOrders = $userOrders->pluck('orderDetails.*.document_id')->flatten();

        $documents->transform(function ($document) use ($documentIdsInUserOrders) {
            if ($documentIdsInUserOrders->contains($document->id)) {
                $document->status = "Already Buy";
            }

            return $document;
        });

        return DocumentResource::collection($documents);

        // return DocumentResource::collection(
        //     Document::loadRelation()->filter($filters)->latest()->paginate(request('limit') ?? PAGINATE_LIMIT)
        // );
    }

    public function getPurchaseDocuments(DocumentFilter $filters)
    {
        $documents = Document::loadRelation()->filter($filters)->latest()->paginate(request('limit') ?? PAGINATE_LIMIT);
        return DocumentResource::collection($documents);
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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


    public function getCartItems(): JsonResponse
    {
        return response()->json($this->cartService->cartItems());
    }

    public function destroyCartItem(string $id)
    {
        try {
            $carItem = $this->cartService->removeItemFromSession($id);
            return response()->json(['message' => "Item successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    public function storeCartItems()
    {
        return response()->json(($this->cartService)->saveCartItems());
    }

    public function orderDetails()
    {
        return ($this->cartService)->orderDetails();
    }


    public function getUserOrderInfo()
    {
        return ($this->cartService)->getUserOrderInfo();
    }

    /**
     * Update the specified tag in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    /**
     * Remove the specified tag from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Tag::findOrFail($id)->delete();
            Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    /**
     * Define message for validation.
     */
    protected function message()
    {
        return [
            'name.regex' => 'The :attribute field can contain alphabetic character, dash and underscore.',
        ];
    }
}
