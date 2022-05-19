<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 *
 * @package App\Repositories
 */
class RecipientRepository extends BaseRepository
{
  /**
   *
   * @param User $model
   */
  public function __construct(User $model)
  {
    $this->model = $model;
  }

  public function getRecipientsByUserId()
  {
    return $this->model->get();
  }

  public function deleteRecipient($id)
  {
    return $this->model->where('id', $id)->delete();
  }

  public function addRecipient($name, $bank, $cash, $email, $password)
  {
    $recipient = $this->model;

      return $recipient->create(
        [
          'user_name' => $name,
          'bank' => $bank,
          'bank_account' => $cash,
          'email' => $email,
          'password' => Hash::make($password)
        ]
      );
  }

  public function editRecipient($id, $name, $bank, $email, $password)
  {
    $recipient = $this->model;

      return $recipient->where('id', $id)->update(
        [
          'user_name' => $name,
          'bank' => $bank,
          'email' => $email,
          'password' => Hash::make($password)
        ]
      );
  }

  public function getCurrentUser() {
    $recipient = $this->model;
    return $recipient->where('id', Auth::id())->get();
  }

  public function getUsers() {
    $recipient = $this->model;
    return $recipient->whereNotIn('id', [Auth::id()])->get();
  }

  public function sendTransfer($selectUser, $cash) {

    $recipient = $this->model;

    $currentUser = $recipient->where('id', Auth::id())->get();

    $currentUserAction = $recipient->where('id', Auth::id())->update(
      [
        'bank_account' => $currentUser[0]->bank_account - $cash,
      ]
    );

    $selectUserAction = $recipient->where('id', $selectUser['id'])->update(
      [
        'bank_account' => $selectUser['bank_account'] + $cash,
      ]
    );

    return [$currentUserAction, $selectUserAction];
  }
}