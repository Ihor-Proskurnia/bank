<?php

namespace App\Services;

use App\Repositories\RecipientRepository;
use App\Repositories\NoteRepository;

class RecipientService
{
  public $recipientRepository;
  public $noteRepository;

  public function __construct(RecipientRepository $recipientRepository, NoteRepository $noteRepository)
  {
    $this->recipientRepository = $recipientRepository;
    $this->noteRepository = $noteRepository;
  }

  public function sendTransfer($selectUser, $cash)
  {
    $recipient = $this->recipientRepository->sendTransfer($selectUser, $cash);
    $note = $this->noteRepository->addNote($selectUser, $cash);
    return [$recipient, $note];
  }

  public function getActions()
  {
    return $this->noteRepository->getActions();
  }
}