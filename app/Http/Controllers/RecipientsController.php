<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecipientService;
use Illuminate\Support\Facades\Auth;

class RecipientsController
{
    /**
     * @var $noteService
     */
    public $recipientService;

    /**
     * Create a new controller instance.
     *
     * @param RecipientService $recipientsService
     *
     * @return void
     */
    public function __construct(RecipientService $recipientService) {
        $this->recipientService = $recipientService;
    }

    public function showAll()
    {
        return view('recipients');
    }

    public function addRecipient(Request $request)
    {
        return [response()->json(
            $this->recipientService->recipientRepository->addRecipient(
                $request->get('name'),
                $request->get('bank'),
                $request->get('cash'),
                $request->get('email'),
                $request->get('password')
            )
        )];
    }

    public function editRecipient($id, Request $request)
    {
        return response()->json(
            $this->recipientService->recipientRepository->editRecipient(
                $id,
                $request->get('name'),
                $request->get('bank'),
                $request->get('email'),
                $request->get('password')
            )
        );
    }

    public function getRecipientsByUserId()
    {
        return $this->recipientService->recipientRepository->getRecipientsByUserId();
    }

    public function deleteRecipient($id) 
    {
        return $this->recipientService->recipientRepository->deleteRecipient($id);
    }

    public function getCurrentUser() {
        return $this->recipientService->recipientRepository->getCurrentUser();
    }

    public function getUsers() 
    {
        return $this->recipientService->recipientRepository->getUsers();
    }

    public function sendTransfer(Request $request) 
    {
        return response()->json(
            $this->recipientService->sendTransfer(
                $request->get('selectUser'),
                $request->get('cash')
            )
        );
    }  
    
    public function getActions() 
    {
        return $this->recipientService->getActions();
    }
}