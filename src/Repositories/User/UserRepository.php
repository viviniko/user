<?php

namespace Viviniko\User\Repositories\User;

use Laravel\Socialite\Contracts\User as SocialUser;

interface UserRepository
{
    /**
     * Find user by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get user by email.
     *
     * @param $email
     * @return mixed
     */
    public function findByEmail($email);

    /**
     * Find user registered via social network.
     *
     * @param $provider Provider used for authentication.
     * @param $providerId Provider's unique identifier for authenticated user.
     * @return mixed
     */
    public function findBySocialId($provider, $providerId);

    /**
     * Associate account details returned from social network
     * to user with provided user id.
     *
     * @param $id
     * @param $provider
     * @param SocialUser $user
     * @return mixed
     */
    public function associateSocialAccount($id, $provider, SocialUser $user);

    /**
     * Update user social networks.
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function updateSocialNetworks($id, array $data);

    /**
     * Create new user.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update user specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete user with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}