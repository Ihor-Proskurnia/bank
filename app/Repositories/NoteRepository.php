<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


/**
 *
 * @package App\Repositories
 */
class NoteRepository extends BaseRepository
{
  /**
   *
   * @param Note $model
   */
  public function __construct(Note $model)
  {
      $this->model = $model;
  }

  public function addNote($selectUser, $cash) {
    $note = $this->model;

    $currentUser = $note->create(
      [
        'user_id' => Auth::id(),
        'note' => 'Translated ' . $cash . ' to ' . $selectUser['user_name'],
        'date' => Carbon::now(),
      ]
    );
    
    $selectedUser = $note->create(
      [
        'user_id' => $selectUser['id'],
        'note' => 'Translated ' . $cash . ' from ' . Auth::user()->user_name,
        'date' => Carbon::now(),
      ]
    );

    return [$currentUser, $selectedUser];
  }

  public function getActions() {
    $notes = $this->model->where('user_id', Auth::id())->get();

    return $notes;
  }
}