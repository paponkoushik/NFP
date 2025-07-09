<?php

namespace App\Actions\Repository;

use App\Models\User;
use App\Models\OrgUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Events\UserCreated;
use App\Models\Organisation;

class UserRepository
{
    /**
     * The user associated with the repository.
     *
     * @var object
     */
    protected $user;

    /**
     * The organisation of the user.
     *
     * @var object
     */
    protected $organisation;

    /**
     * Register a new user with organisation user.
     *
     * @param  array $request
     * @return bool
     */
    public function registerUser(array $request)
    {
        try {
            return DB::transaction(function () use($request) {
                $this->getOrganisation($request['organisation_id'])
                    ->createUser($request)
                    ->createPivotOrgUser($request);
                return $this->user ?? false;
            });


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get organisation associated with the user.
     *
     * @param  char $organisationId
     * @return $this
     */
    public function getOrganisation($organisationId)
    {
        $organisation = Organisation::findOrFail($organisationId);
        if (!$organisation) {
            throw new \Exception('Organisation not found!');
        }
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  array $request
     * @return $this
     */
    protected function createUser($request)
    {
        $user = User::create($this->setData($request));

        if (!$user) {
            throw new \Exception('Failed to create user!');
        }
        event(new UserCreated($user));
        $this->user = $user;

        return $this;
    }

    /**
     * Set request data to create user.
     *
     * @param  array $request
     * @return array
     */
    protected function setData($request)
    {
        $payload = [
            'first_name' => $request['first_name'] ?? null,
            'last_name' => $request['last_name'] ?? null,
            'email' => $request['email'],
//            'password' => bcrypt($request['password'] ?? Str::random(8)),
            'password' => Hash::make('p@ssword'),
            'role' => $request['role'],
            'invitation_token' => Str::random(60),
            'email_verified_at' => now()
        ];

//        if (isset($request['hasFile']) && $request['hasFile'] === true) {
//            $payload['avatar'] = \UploadBuilder::storeFile($request['avatar'], 'images/avatar', 'public');
//        }

        return $payload;
    }

    /**
     * Create pivot organisation user.
     *
     * @param  array $request
     * @return $this
     */
    public function createPivotOrgUser($request)
    {
        if (!$this->checkIsPivotOrgUserExists()) {
            $orgUser = OrgUser::create([
                'organisation_id' => $this->organisation->id,
                'user_id' => $this->user->id,
            ]);

            if (!$orgUser) {
                throw new \Exception('Failed to create organisation user!');
            }
        }

        return true;
    }

    /**
     * Check is organisation user exists.
     *
     * @return int
     */
    public function checkIsPivotOrgUserExists()
    {
        return OrgUser::where([
            'organisation_id' => $this->organisation->id,
            'user_id' => $this->user->id,
        ])->count();
    }
}
