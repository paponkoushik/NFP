<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use App\Mail\UserInvitationEmail;
use App\Actions\Filters\UserFilter;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDeletionNotifyEmail;
use App\Actions\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function index(): View
    {
        return view('user.index');
    }

    public function getUsers(UserFilter $filters, $organisaitonId = null): AnonymousResourceCollection
    {
        $query = User::filter($filters)->ofOrganisation($organisaitonId)->latest();

        if (Auth::user()->role == "legal-admin") {
            $query->whereIn('role', ["legal-admin", "lawyer"]);
        }elseif (Auth::user()->role == "nfp-admin") {
            $query->whereNotIn('role', ["super-admin"]);
        }

        return UserResource::collection($query->paginate(request('limit') ?? PAGINATE_LIMIT));
    }

    public function show(string $id): UserResource
    {
        return new UserResource(User::findOrFail($id));
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, $this->rules());

        try {
            // if ($request->hasFile('avatar')) {
            //     $request->request->add(['hasFile' => true]);
            // }
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make('p@ssword'),
                'role' => $request->role,
                'phone' => $request->phone,
                'email_verified_at' => now(),
            ]);

            // $this->userRepo->registerUser($request->all());

            return response()->json(['message' => 'User successfully created.'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => $e->getMessage()], 500);
            return response()->json(['message' => FAIL], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $id . '',
        ]);

        try {
            $user = User::findOrFail($id);
            $payload = $this->setData($request);

            if ($user->update($payload) && $request->hasFile('avatar')) {
                \UploadBuilder::deleteFileFromLocalDisk($user->avatar);
            }

            return response()->json(['message' => 'User successfully updated.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            // if ($user->delete()) {
            //     $this->sendUserDestroyEmail($user);
            // }

            return response()->json(['message' => DELETE_SUCCESS]);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'role' => [
                'required',
                Rule::in(['nfp-admin', 'client-admin', 'legal-admin', 'lawyer'])
            ],
        ];
    }

    protected function setData(Request $request): array
    {
        $data = $request->only('first_name', 'last_name', 'email', 'phone', 'role', 'status');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = \UploadBuilder::uploadFile($request->avatar, 'images/avatars')->save();
            // $data['avatar'] = \UploadBuilder::storeFile($request->avatar, 'images/avatars', 'public');
        }

        return $data;
    }

    protected function isUserLimitExceed(string | null $organisaitonId): bool
    {
        if (empty($organisaitonId) || $organisaitonId == 'null') {
            return false;
        }
        $limit = Organisation::findOrFail($organisaitonId)->max_user;
        $createdUser = User::ofOrganisation($organisaitonId)->count();

        return ($createdUser >= $limit) ? true : false;
    }

    protected function sendUserDestroyEmail(User $user): void
    {
        Mail::to($user->email)->send(new UserDeletionNotifyEmail($user));
    }

    public function updateUserRole(Request $request): JsonResponse
    {
        $this->validate($request, [
            'user_id' => 'required',
            'action_to' => 'required'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            if (request('action_to') == 'admin') {
                $user->role = ($user->role == 'user') ? 'client_admin' : 'legal_admin';
            } else {
                $user->role = ($user->role == 'client_admin') ? 'user' : 'lawyer';
            }
            $user->update();

            return response()->json(['message' => "User role updated successfully."]);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL], 500);
        }
    }

    public function resendInvitation(string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            Mail::to($user->email)->send(new UserInvitationEmail($user));

            return response()->json(['message' => "Invitation resend successful."]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Failed to resend invitation."], 500);
        }
    }
}
