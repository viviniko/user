<?php

namespace Viviniko\User\Repositories\User;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as SocialUser;
use Viviniko\Repository\SimpleRepository;

class EloquentUser extends SimpleRepository implements UserRepository
{
    /**
     * @var string
     */
    protected $modelConfigKey = 'user.user';

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return $this->findBy('email', $email)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findBySocialId($provider, $providerId)
    {
        $userTable = Config::get('user.users_table');
        $socialTable = Config::get('user.social_logins_table');

        return $this->createModel()->newQuery()->leftJoin($socialTable, "{$userTable}.id", '=', "{$socialTable}.user_id")
            ->select("{$userTable}.*")
            ->where("{$socialTable}.provider", $provider)
            ->where("{$socialTable}.provider_id", $providerId)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function associateSocialAccount($id, $provider, SocialUser $user)
    {
        return DB::table(Config::get('user.social_logins_table'))->insert([
            'user_id' => $id,
            'provider' => $provider,
            'provider_id' => $user->getId(),
            'avatar' => $user->getAvatar(),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSocialNetworks($id, array $data)
    {
        return $this->find($id)->socialNetworks()->updateOrCreate([], $data);
    }
}